<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        try {
            //pagination
            $perPage = $request->input('per_page', 10);
            $query = Anggota::query();

            // Search
            $search = $request->input('search');
            if ($search) {
                $query->where('nm_anggota', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('alamat', 'like', '%' . $search . '%')
                      ->orWhere('no_tlp', 'like', '%' . $search . '%')
                      ->orWhere('tgl_lahir', 'like', '%' . $search . '%')
                      ->orWhere('tgl_gabung', 'like', '%' . $search . '%');
            }
            // Pagination
            $anggotas = $query->paginate($perPage);

            return resJson(1,"success", $anggotas,200);

        } catch (\Exception $e) {
            return resjson(0,'error',$e,500);
        }
    }



    //create anggota
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nm_anggota' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'no_tlp' => 'required',
                'tgl_lahir' => 'required',
                'tgl_bergabung' => 'required',
                'id_divisi' => 'required',
                'id_jabatan' => 'required'
            ]);

            $anggotas = Anggota::create([
                'nm_anggota' => $request->input('nm_anggota'),
                'email' => $request->input('email'),
                'alamat' => $request->input('alamat'),
                'no_tlp' => $request->input('no_tlp'),
                'tgl_lahir' => $request->input('tgl_lahir'),
                'tgl_bergabung' => $request->input('tgl_bergabung'),
                'id_divisi' => $request->input('id_divisi'),
                'id_jabatan' => $request->input('id_jabatan'),
                
            ]);

            return resJson(1, "Berhasil menambahkan Anggota baru", $anggotas, 200);

        } catch (\Exception $e) {
            return resJson(0,'gagal menambahkan Anggota baru',$e,500);
        }
    }


    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nm_anggota' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'no_tlp' => 'required',
                'tgl_lahir' => 'required',
                'tgl_bergabung' => 'required',
                'id_divisi' => 'required',
                'id_jabatan' => 'required'
            ]);

            $anggotas = Anggota::findOrFail($id);
            $anggotas->update([
                'nm_divisi' => $request->nm_divisi,
                'nm_anggota' => $request->nm_anggota,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_tlp' => $request->no_tlp,
                'tgl_lahir' => $request->tgl_lahir,
                'tgl_bergabung' => $request->tgl_bergabung,
                'id_divisi' => $request->id_divisi,
                'id_jabatan' => $request->id_jabatan
            ]);

            return resJson(1, "Berhasil mengubah anggota", $anggotas, 200);
            
        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }


    public function show($id)
    {
        try {
            $anggotas = Anggota::findOrFail($id);
            return resJson(1, "success", $anggotas, 200);
        } catch (\Exception $e) {
            return resJson(0,' not found',$e,401);
        }
    }


    public function destroy($id)
    {
        try {
            $anggotas = Anggota::findOrFail($id);
            $anggotas->delete();

            return resJson(1, "Anggota berhasil dihapus", $anggotas, 200);

        } catch (\Exception $e) {
            return resJson(0,'not found',$e,500);
        }
    }   


    

}