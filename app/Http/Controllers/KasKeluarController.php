<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kaskeluar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;



class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $query = KasKeluar::query();

            // Search
            $search = $request->input('search');
            if ($search) {
                $query->where('nm_pj_klr', 'like', '%' . $search . '%')
                      ->orWhere('tgl_input', 'like', '%' . $search . '%')
                      ->orWhere('nominal', 'like', '%' . $search . '%')
                      ->orWhere('ket', 'like', '%' . $search . '%');
            }
            // Pagination
            $kas_keluars = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'Data' => $kas_keluars
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil daftar pemasukan kas ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nm_pj_klr' => 'required|string',
                'tgl_input' => 'required|date',
                'nominal' => 'required|string',
                'ket' => 'required|string',
            ]);

            // Mendapatkan ID pengguna yang saat ini terotentikasi
            $user_id = Auth::id();

            $kas_keluars = KasKeluar::create([
                'nm_pj_klr' => $request->input('nm_pj_klr'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
                'user_id' => $user_id, // Menyimpan user ID
            ]);

            return response()->json([
                'message' => 'Pengeluaran kas berhasil ditambah', 
                'data' => $kas_keluars
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambah pengeluaran kas', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $kas_keluars = KasKeluar::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'Data' => $kas_keluars,
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
                'nm_pj_klr' => 'required|string',
                'tgl_input' => 'required|date',
                'nominal' => 'required|string',
                'ket' => 'required|string',
            ]);

            $kas_keluars = KasKeluar::findOrFail($id);

            // Update data dokumen
            $kas_keluars->update([
                'nm_pj_klr' => $request->input('nm_pj_klr'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pemasukan kas berhasil diubah',
                'data' => $kas_keluars
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
            $kas_keluars = KasKeluar::findOrFail($id);
            $kas_keluars->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Pengeluaran kas berhasil di hapus'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Pengeluaran Kas: ' . $e->getMessage()
            ], 500);
        }
    }
}