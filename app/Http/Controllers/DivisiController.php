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
            return response()->json([
                'status' => 'success',
                'divisi' => $divisis
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
                'nm_divisi' => 'required|unique:divisis,nm_divisi',
                'id_jabatan' => 'required'
            ]);

            $divisis = Divisi::create([
                'nm_divisi' => $request->nm_divisi,
                'id_jabatan' => $request->id_jabatan
            ]);

            return response()->json([
                'status' => 'success',
                'divisi' => $divisis,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create divisi: ' . $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $divisis = Divisi::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'Divisi' => $divisis,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'divisi not found: ' . $e->getMessage()
            ], 404);
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

            return response()->json([
                'status' => 'success',
                'divisi' => $divisis,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update divisi: ' . $e->getMessage()
            ], 500);
        }
    }

    //menghapus data divisi
    public function destroydivisi($id)
    {
        try {
            $divisis = Divisi::findOrFail($id);
            $divisis->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'divisi deleted successfully'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete divisi ' . $e->getMessage()
            ], 500);
        }
    }   
}