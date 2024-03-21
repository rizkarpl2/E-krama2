<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasMasuk;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Input;



class KasMasukController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $query = KasMasuk::query();

             $query->orderBy('created_at', 'desc');

             $query->join('users', 'kas_masuks.user_id', '=', 'users.id');
             $query->select('kas_masuks.*', 'users.name as name');

            // Search
            $search = $request->input('search');
            if ($search) {
                $query->where('nm_pj', 'like', '%' . $search . '%')
                      ->orWhere('tgl_input', 'like', '%' . $search . '%')
                      ->orWhere('nominal', 'like', '%' . $search . '%')
                      ->orWhere('ket', 'like', '%' . $search . '%');
            }
            // Pagination
            $kas_masuks = $query->paginate($perPage);

            return resJson(1, "success", $kas_masuks, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
        
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nm_pj' => 'required|string',
                'tgl_input' => 'required|date',
                'nominal' => 'required|string',
                'ket' => 'required|string',
            ]);

           

            // // Mendapatkan ID pengguna yang saat ini terotentikasi
            // $user_id = Auth::id();

            $kas_masuks = KasMasuk::create([
                'nm_pj' => $request->input('nm_pj'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
                // 'user_id' => $user_id, // Menyimpan user ID
            ]);

            return resJson(1, "success created new pemasukan ", $kas_masuks, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }

    public function show($id)
    {
        try {
            $kas_masuks = KasMasuk::findOrFail($id);
            
            return resJson(1, "success", $kas_masuks, 200);
            
        } catch (\Exception $e) {
           
            return resJson(0,'Kas masuk not found',$e,401);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nm_pj' => 'required|string',
                'tgl_input' => 'required|date',
                'nominal' => 'required|string',
                'ket' => 'required|string',
            ]);

            $kas_masuks = KasMasuk::findOrFail($id);
            $kas_masuks->update([
                'nm_pj' => $request->input('nm_pj'),
                'tgl_input' => $request->input('tgl_input'),
                'nominal' => $request->input('nominal'),
                'ket' => $request->input('ket'),
            ]);

            return resJson(1, "success", $kas_masuks, 200);
            
        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }

    public function destroy($id)
    {
        try {
            $kas_masuks = KasMasuk::findOrFail($id);
            $kas_masuks->delete();

            return resJson(1, "pemasukan berhasil dihapus", $kas_masuks, 200);

        } catch (\Exception $e) {
            return resJson(0,'error',$e,500);
        }
    }
}