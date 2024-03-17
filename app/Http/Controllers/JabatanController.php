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
            return response()->json([
                'status' => 'success',
                'jabatan' => $jabatans
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch divisi: ' . $e->getMessage()
            ], 500);
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

            return response()->json([
                'status' => 'success',
                'jabatan' => $jabatans,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create jabatan: ' . $e->getMessage()
            ], 500);
        }
    }

    //menampilkan detail
    public function show($id)
    {
        try {
            $jabatans = Jabatan::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'jabatan' => $jabatans,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jabatan not found: ' . $e->getMessage()
            ], 404);
        }
    }

    //mengubah data jabatan
    public function updatejabatan(Request $request, $id)
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

            return response()->json([
                'status' => 'success',
                'message' => 'jabatan updated successfully',
                'jabatan' => $jabatans,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update jabatan: ' . $e->getMessage()
            ], 500);
        }
    }

    //menghapus data jabatan
    public function destroyjabatan($id)
    {
        try {
            $jabatans = Jabatan::findOrFail($id);
            $jabatans->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'jabatan deleted successfully'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete jabatan: ' . $e->getMessage()
            ], 500);
        }
    }   
}