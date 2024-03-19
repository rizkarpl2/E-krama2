<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json([
                'status' => 'success',
                'roles' => $roles
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch roles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_name' => 'required|unique:roles|max:255',
            ]);
            
            $role = Role::create([
                'role_name' => $request->role_name,
            ]);

            return response()->json([
                'status' => 'success',
                'role' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create role ' . $e->getMessage()
            ], 500);
        }
    }
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    try {
        // Ubah pencarian berdasarkan nama kunci utama
        $role = Role::find($id);

        // Periksa apakah peran ditemukan
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'role' => $role
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch role: ' . $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_name' => 'required',
            ]);

            $role = Role::findOrFail($id);
            $role->update([
                'role_name' => $request->role_name,
            ]);

            return response()->json([
                'status' => 'success',
                'role' => $role
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete role: ' . $e->getMessage()
            ], 500);
        }
    }
  
}
