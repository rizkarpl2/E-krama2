<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasMasuk;
use Illuminate\Support\Facades\Auth;



class KasMasukController extends Controller
{
    //menampilkan data kas masuk
    public function index()
    {
        try {
            $kas_masuks = KasMasuk::all();
            return response()->json([
                'status' => 'success',
                'Kas masuk' => $kas_masuks
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch daftar pemasukan kas ' . $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'nm_pj' => 'required|string',
                'tgl_input' => 'required|date',
                'nominal' => 'required|string',
                'ket' => 'required|string',
            ]);

            // Mendapatkan ID pengguna yang saat ini terotentikasi
            $user_id = Auth::id();

            $kas_masuks = KasMasuk::create([
                'nm_pj' => $request->input('nm_pj'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
                'user_id' => $user_id, // Menyimpan user ID
            ]);

            return response()->json([
                'message' => 'Pemasukan kas berhasil ditambah', 
                'data' => $kas_masuks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambah pemasukan kas', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $kas_masuks = KasMasuk::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'Data' => $kas_masuks,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pemasukan kas not found: ' . $e->getMessage()
            ], 404);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nm_pj' => 'required|string',
                'tgl_input' => 'required|date',
                'nominal' => 'required|string',
                'ket' => 'required|string',
            ]);

            $kas_masuks = KasMasuk::findOrFail($id);

            // Update data dokumen
            $kas_masuks->update([
                'nm_pj' => $request->input('nm_pj'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
            ]);

            // Simpan perubahan
            $kas_masuks->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Pemasukan kas berhasil diubah',
                'data' => $kas_masuks
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Pemasukan Kas ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $kas_masuks = KasMasuk::findOrFail($id);
            $kas_masuks->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Pemasukan kas berhasil di hapus'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Pemasukan Kas: ' . $e->getMessage()
            ], 500);
        }
    }
}