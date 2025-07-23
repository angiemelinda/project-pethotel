<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\HewanPeliharaan;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $periode = $request->input('periode', 'month');
        $jenisLayanan = $request->input('jenis_layanan');
        $statusPembayaran = $request->input('status_pembayaran');
        
        $filename = 'laporan_transaksi_' . $periode . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new LaporanExport($periode, $jenisLayanan, $statusPembayaran), $filename);
    }

    public function exportPdf(Request $request)
    {
        $periode = $request->input('periode', 'month');
        $jenisLayanan = $request->input('jenis_layanan');
        $statusPembayaran = $request->input('status_pembayaran');
        
        // Get filtered transactions
        $transaksiQuery = Transaksi::with(['pelanggan', 'hewan']);
        
        // Apply period filter
        switch ($periode) {
            case 'today':
                $transaksiQuery->whereDate('created_at', today());
                break;
            case 'week':
                $transaksiQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $transaksiQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                break;
            case 'quarter':
                $transaksiQuery->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]);
                break;
            case 'year':
                $transaksiQuery->whereYear('created_at', now()->year);
                break;
        }
        
        // Apply service filter
        if ($jenisLayanan) {
            $transaksiQuery->where('jenis_layanan', 'like', '%' . $jenisLayanan . '%');
        }
        
        // Apply payment status filter
        if ($statusPembayaran) {
            $transaksiQuery->where('status_pembayaran', $statusPembayaran);
        }
        
        $transaksis = $transaksiQuery->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics
        $totalIncome = $transaksis->sum('total_harga');
        $totalTransactions = $transaksis->count();
        
        // Service-based income calculations
        $penitipanIncome = $transaksis->filter(function($transaksi) {
            $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
            return is_array($layanan) && in_array('penitipan', $layanan);
        })->sum('total_harga');
        
        $groomingIncome = $transaksis->filter(function($transaksi) {
            $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
            return is_array($layanan) && in_array('grooming', $layanan);
        })->sum('total_harga');
        
        $vaksinasiIncome = $transaksis->filter(function($transaksi) {
            $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
            return is_array($layanan) && in_array('vaksinasi', $layanan);
        })->sum('total_harga');
        
        $checkupIncome = $transaksis->filter(function($transaksi) {
            $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
            return is_array($layanan) && in_array('checkup', $layanan);
        })->sum('total_harga');
        
        $data = [
            'transaksis' => $transaksis,
            'totalIncome' => $totalIncome,
            'totalTransactions' => $totalTransactions,
            'penitipanIncome' => $penitipanIncome,
            'groomingIncome' => $groomingIncome,
            'vaksinasiIncome' => $vaksinasiIncome,
            'checkupIncome' => $checkupIncome,
            'periode' => $periode,
            'jenisLayanan' => $jenisLayanan,
            'statusPembayaran' => $statusPembayaran,
        ];
        
        $pdf = Pdf::loadView('admin.laporan_pdf', $data);
        $filename = 'laporan_transaksi_' . $periode . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
} 