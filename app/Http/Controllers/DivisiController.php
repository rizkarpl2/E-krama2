<?php

namespace App\Http\Controllers;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisiController extends Controller
{
    //menampilkan data divisi
    public function index() 
    {
        try {
            $divisis = Divisi::all();
            return resJson(1, "success", $divisis, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }

    //create jabatan
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nm_divisi' => 'required|unique:divisis,nm_divisi',
                'id_jabatan' => 'required'
            ]);

            $divisis = Divisi::create([
                'nm_divisi' => $request->nm_divisi,
                'id_jabatan' => $request->id_jabatan
            ]);

            return resJson(1, "Berhasil menambahkan divisi baru", $divisis, 200);

        } catch (\Exception $e) {
            return resJson(0,'gagal menambahkan divisi baru',$e,500);
        }
    }


    public function show($id)
    {
        try {
            $divisis = Divisi::findOrFail($id);
            return resJson(1, "success", $divisis, 200);
        } catch (\Exception $e) {
            return resJson(0,'Divisi not found',$e,401);
        }
    }


    public function updatedivisi(Request $request, $id)
    {
        try {
            $request->validate([
                'nm_divisi' => 'required',
            ]);

            $divisis = Divisi::findOrFail($id);
            $divisis->update([
                'nm_divisi' => $request->nm_divisi,
            ]);

            return resJson(1, "Berhasil mengubah divisi", $divisis, 200);
            
        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }

    //menghapus data divisi
    public function destroydivisi($id)
    {
        try {
            $divisis = Divisi::findOrFail($id);
            $divisis->delete();

            return resJson(1, "Divisi berhasil dihapus", $divisis, 200);

        } catch (\Exception $e) {
            return resJson(0,'not found',$e,500);
        }
    }   
}