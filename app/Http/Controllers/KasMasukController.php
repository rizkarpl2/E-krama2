<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasMasuk;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Input;


class KasMasukController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $query = KasMasuk::query();

            // Search
            $search = $request->input('search');
            if ($search) {
                $query->where('nm_pj', 'like', '%' . $search . '%')
                      ->orWhere('tgl_input', 'like', '%' . $search . '%')
                      ->orWhere('nominal', 'like', '%' . $search . '%')
                      ->orWhere('ket', 'like', '%' . $search . '%');
            }
            // Pagination
            $kas_masuks = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'Data' => $kas_masuks
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
                'message' => 'Terjadi kesalahan silahkan cek kembali', 
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
                'message' => 'not found' . $e->getMessage()
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
            $kas_masuks->update([
                'nm_pj' => $request->input('nm_pj'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pemasukan kas berhasil diubah',
                'data' => $kas_masuks
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengubah pemasukan Kas ' . $e->getMessage()
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
                'message' => 'Gagal menghapus pemasukan Kas' . $e->getMessage()
            ], 500);
        }
    }
}