<?php

namespace App\Http\Controllers;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{

    //menampilkan semua data jabatan
    public function index()
    {
        try {
            $jabatans = Jabatan::all();
            return resJson(1, "success", $jabatans, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }

    //create jabatan
    public function store(Request $request)
    {
        try {
            $request->validate([
                'jenis_jabatan' => 'required|unique:jabatans,jenis_jabatan',
            ]);

            $jabatans = Jabatan::create([
                'jenis_jabatan' => $request->jenis_jabatan,
            ]);

            return resJson(1, "Berhasil menambahkan jabatan baru", $jabatans, 200);
        } catch (\Exception $e) {
            return resJson(0,'gagal menambahkan jabatan baru',$e,500);
        }
    }

    //menampilkan detail
    public function show($id)
    {
        try {
            $jabatans = Jabatan::findOrFail($id);
            return resJson(1, "success", $jabatans, 200);
        } catch (\Exception $e) {
            return resJson(0,'Jabatan not found',$e,401);
        }
    }

    //mengubah data jabatan
    public function update(Request $request, $id)
    {
        try {
            $jabatans = Jabatan::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'jenis_jabatan' => 'required|unique:jabatans,jenis_jabatan,' . $id . ',id_jabatan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $jabatans->update([
                'jenis_jabatan' => $request->jenis_jabatan,
            ]);

            return resJson(1, "Jabatan berhasil diubah", $jabatans, 200);
        } catch (\Exception $e) {
            return resJson(0, "Gagal mengubah jabatan", $jabatans, 500);
        }
    }

    //menghapus data jabatan
    public function destroy($id)
    {
        try {
            $jabatans = Jabatan::findOrFail($id);
            $jabatans->delete();

            return resJson(1, "Jabatan berhasil dihapus", $jabatans, 200);
        } catch (\Exception $e) {
            return resJson(0,'not found',$e,500);
        }
    }   
}