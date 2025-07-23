<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\HewanPeliharaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $periode;
    protected $jenisLayanan;
    protected $statusPembayaran;

    public function __construct($periode = 'month', $jenisLayanan = null, $statusPembayaran = null)
    {
        $this->periode = $periode;
        $this->jenisLayanan = $jenisLayanan;
        $this->statusPembayaran = $statusPembayaran;
    }

    public function collection()
    {
        $transaksiQuery = Transaksi::with(['pelanggan', 'hewan']);
        
        // Apply period filter
        switch ($this->periode) {
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
        if ($this->jenisLayanan) {
            $transaksiQuery->where('jenis_layanan', 'like', '%' . $this->jenisLayanan . '%');
        }
        
        // Apply payment status filter
        if ($this->statusPembayaran) {
            $transaksiQuery->where('status_pembayaran', $this->statusPembayaran);
        }
        
        return $transaksiQuery->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal Transaksi',
            'Nama Pelanggan',
            'Nama Hewan',
            'Jenis Hewan',
            'Layanan',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Total Harga',
            'Metode Pembayaran',
            'Status Pembayaran',
            'Jumlah Dibayar',
            'Sisa Pembayaran'
        ];
    }

    public function map($transaksi): array
    {
        $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
        $layananText = is_array($layanan) ? implode(', ', $layanan) : $transaksi->jenis_layanan;
        
        $sisaPembayaran = $transaksi->total_harga - ($transaksi->jumlah_dibayar ?? 0);
        
        return [
            $transaksi->id,
            $transaksi->created_at->format('d/m/Y H:i'),
            $transaksi->pelanggan->nama ?? '-',
            $transaksi->hewan->nama ?? '-',
            $transaksi->hewan->jenis ?? '-',
            $layananText,
            $transaksi->tanggal_masuk ? \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') : '-',
            $transaksi->tanggal_keluar ? \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d/m/Y') : '-',
            'Rp ' . number_format($transaksi->total_harga, 0, ',', '.'),
            ucfirst($transaksi->metode_pembayaran ?? '-'),
            ucfirst(str_replace('_', ' ', $transaksi->status_pembayaran ?? '-')),
            'Rp ' . number_format($transaksi->jumlah_dibayar ?? 0, 0, ',', '.'),
            'Rp ' . number_format($sisaPembayaran, 0, ',', '.')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 25,
            'D' => 20,
            'E' => 15,
            'F' => 30,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
        ];
    }
} 