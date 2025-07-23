<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminDataController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.admin', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:admins',
            'telepon' => 'required',
        ]);
        $data = $request->only(['nama', 'email', 'telepon']);
        $data['password'] = bcrypt('password123'); // password default
        Admin::create($data);
        return redirect()->route('admin.admin')->with('success', 'Data admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admin_edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:admins,email,' . $id,
            'telepon' => 'required',
        ]);
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());
        return redirect()->route('admin.admin')->with('success', 'Data admin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.admin')->with('success', 'Data admin berhasil dihapus');
    }
} 