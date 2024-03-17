<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kaskeluar;
use Illuminate\Support\Facades\Validator;

class KasKeluarController extends Controller
{
    // Menampilkan data kas masuk dengan paginasi dan pencarian
    public function index(Request $request)
    {
        try {
            // Mendapatkan jumlah item per halaman dari permintaan
            $perPage = $request->input('per_page', 10); // Default 10 jika tidak disediakan
            
            // Validasi permintaan
            $validator = Validator::make($request->all(), [
                'per_page' => 'integer|min:1', // Pastikan per_page adalah bilangan bulat positif
                'search' => 'string', // Pastikan search adalah string
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422); // Kode status 422: Unprocessable Entity
            }

            // Query untuk pencarian
            $query = KasKeluar::query();

            // Jika ada query pencarian, tambahkan kondisi pencarian ke query
            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->where('nama', 'LIKE', "%$searchTerm%")
                      ->orWhere('keterangan', 'LIKE', "%$searchTerm%");
            }

            // Mengambil data dengan paginasi
            $kas_masuks = $query->paginate($perPage);

            // Mengembalikan respons JSON
            return response()->json([
                'status' => 'success',
                'kas_masuks' => $kas_masuks,
            ], 200); // Kode status 200: OK
        } catch (\Exception $e) {
            // Menangani kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil daftar pemasukan kas. ' . $e->getMessage()
            ], 500); // Kode status 500: Internal Server Error
        }
    }


        //create pemasukan kas
        public function store(Request $request)
        {
            try {
                $request->validate([
                    'nm_pj_klr' => 'required|string',
                    'tgl_input' => 'required|date',
                    'nominal' => 'required|string',
                    'ket' => 'required|string',
                    'file' => 'required|file',
                ]);
    
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('dokumen', $fileName);
    
                $kas_keluars = KasKeluar::create([
                    'nm_pj_klr' => $request->input('nm_pj_klr'),
                    'tgl_input' => $request->input('tgl_input'),
                    'nominal' => $request->input('nominal'),
                    'ket' => $request->input('ket'),
                    'file' => $filePath,
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
}