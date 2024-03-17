<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_dokumen;
use Illuminate\Support\Facades\Storage;



//search belum
//pagination belum
class FileUploadController extends Controller
{

    public function index()
    {
        try {
            $m_dokumens = M_dokumen::all();
            return response()->json([
                'status' => 'success',
                'm_dokumens' => $m_dokumens
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch dokumen: ' . $e->getMessage()
            ], 500);
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

            return response()->json([
                'message' => 'Dokumen berhasil diupload', 
                'data' => $m_dokumens
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengunggah dokumen', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadDokumen($id)
    {
        try {
            $m_dokumens = M_dokumen::findOrFail($id);
            $filePath = $m_dokumens->file;

            return Storage::download($filePath);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengunduh dokumen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showdokumen($id)
    {
        try {
            $m_dokumens = M_dokumen::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'M_dokumen' => $m_dokumens
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'dokumen not found: ' . $e->getMessage()
            ], 404);
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

            return response()->json([
                'status' => 'success',
                'dokumen' => $m_dokumens
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $m_dokumens = M_dokumen::findOrFail($id);
            $m_dokumens->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'dokumen deleted successfully'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

}