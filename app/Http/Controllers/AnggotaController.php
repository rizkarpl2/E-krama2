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
            $perPage = $request->input('per_page', 10);
            $query = Anggota::orderBy('created_at', 'desc');

            // Menambahkan pencarian jika ada
            $search = $request->input('search');
            if ($search) {
                $query->where('nm_anggota', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('no_tlp', 'like', '%' . $search . '%')
                    ->orWhere('tgl_lahir', 'like', '%' . $search . '%')
                    ->orWhere('tgl_bergabung', 'like', '%' . $search . '%');
            }

            // Lakukan query untuk pagination setelah menerapkan pencarian dan urutan
            $anggotas = $query->paginate($perPage);

            return resJSON(1, "success", $anggotas, 200);

        } catch (\Exception $e) {
            return resJSON(0, 'not found', $e, 404);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
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

            return resJSON(1, "Berhasil menambahkan Anggota baru", $anggotas, 200);

        } catch (\Exception $e) {
            return resJSON(0,'gagal menambahkan Anggota baru',$e,500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
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

            return resJSON(1, "Berhasil mengubah anggota", $anggotas, 200);
            
        } catch (\Exception $e) {
            return resJSON(0,'error',$e,500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }


    public function show($id)
    {
        try {
            $anggotas = Anggota::findOrFail($id);
            return resJSON(1, "success", $anggotas, 200);
        } catch (\Exception $e) {
            return resJSON(0,' not found',$e,401);
        }
    }


    public function destroy($id)
    {
        try {
            $anggotas = Anggota::findOrFail($id);
            $anggotas->delete();

            return resJSON(1, "Anggota berhasil dihapus", $anggotas, 200);

        } catch (\Exception $e) {
            return resJSON(0,'not found',$e,401);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }       
}