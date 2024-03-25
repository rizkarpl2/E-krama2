<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        try {
            //pagination
            $perPage = $request->input('per_page', 10);
    
            // Search
            $search = $request->input('search');
            if ($search) {
                $query->where('nm_dokumen', 'like', '%' . $search . '%')
                      ->orWhere('tgl_input', 'like', '%' . $search . '%')
                      ->orWhere('penulis', 'like', '%' . $search . '%')
                      ->orWhere('ket', 'like', '%' . $search . '%')
                      ->orWhere('file', 'like', '%' . $search . '%');
            }
            // Pagination
            $m_dokumens = $query->paginate($perPage);

            return resJson(1, "success", $m_dokumens, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }

    public function uploadDokumen(Request $request)
    {
        try {
            $request->validate([
                'nm_dokumen' => 'required|string',
                'tgl_input' => 'required|date',
                'penulis' => 'required|string',
                'ket' => 'required|string',
                'file' => 'required|file',
            ]);

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen', $fileName);

            $m_dokumens = M_dokumen::create([
                'nm_dokumen' => $request->input('nm_dokumen'),
                'tgl_input' => $request->input('tgl_input'),
                'penulis' => $request->input('penulis'),
                'ket' => $request->input('ket'),
                'file' => $filePath,
            ]);

            return resJson(1, "Dokumen berhasil diupload", $m_dokumens, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }

    public function downloadDokumen($id)
    {
        try {
            $m_dokumens = M_dokumen::findOrFail($id);
            $filePath = $m_dokumens->file;

            return Storage::download($filePath);
            return resJson(1, "Dokumen berhasil didownload", $m_dokumens, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }

    public function showdokumen($id)
    {
        try {
            $m_dokumens = M_dokumen::findOrFail($id);
            return resJson(1, "success", $m_dokumens, 200);
        } catch (\Exception $e) {
            return resJson(0,'not found',$e,401);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }

    public function updatedokumen(Request $request, $id)
    {
        try {
            $request->validate([
                'nm_dokumen' => 'required|string',
                'tgl_input' => 'required|date',
                'penulis' => 'required|string',
                'ket' => 'required|string',
                'file' => 'file,id_dokumen'.$id
            ]);

            $m_dokumens = M_dokumen::findOrFail($id);

            // Update data dokumen
            $m_dokumens->update([
                'nm_dokumen' => $request->input('nm_dokumen'),
                'tgl_input' => $request->input('tgl_input'),
                'penulis' => $request->input('penulis'),
                'ket' => $request->input('ket'),
            ]);

            // Jika ada file yang diunggah, simpan file yang baru
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('dokumen', $fileName);
                $m_dokumens->file = $filePath;
            }

            // Simpan perubahan
            $m_dokumens->save();

            return resJson(1, "success", $m_dokumens, 200);
        } catch (\Exception $e) {
            return resJson(0,'not found',$e,401);
        }
        catch(\Throwable $th){
            return resJSON(0,
                'error',
                $th->getMessage(),
                500
            );
        }
    }

    public function destroy($id)
    {
        try {
            $m_dokumens = M_dokumen::findOrFail($id);
            $m_dokumens->delete();

            return resJson(1, "success", $m_dokumens, 200);

        } catch (\Exception $e) {
            return resJson(0,'not found',$e,401);

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