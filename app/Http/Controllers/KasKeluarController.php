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
            //pagination
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

            return resJson(1,"success", $kas_keluars,200);

        } catch (\Exception $e) {
            return resjson(0,'error',$e,500);
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

            return resJson(1,"Berhasil menambahkan pengeluaran kas", $kas_keluars,200);

        } catch (\Exception $e) {
            return resjson(0,'error',$e,500);
        }
    }

    public function show($id)
    {
        try {
            $kas_keluars = KasKeluar::findOrFail($id);
            return resJson(1,"success", $kas_keluars,200);

        } catch (\Exception $e) {
            return resjson(0,'error',$e,500);
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
            return resJson(1,"Pemasukan kas berhasil diubah", $kas_keluars,200);

        } catch (\Exception $e) {
            return resjson(0,'error',$e,500);
        }
    }

    public function destroy($id)
    {
        try {
            $kas_keluars = KasKeluar::findOrFail($id);
            $kas_keluars->delete();

            return resJson(1,"Pemasukan kas berhasil dihapus", $kas_keluars,200);
            
        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }
}