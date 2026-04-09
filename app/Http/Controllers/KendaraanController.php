<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kendaraan = Kendaraan::all();
            return response()->json([
                'status' => true,
                'message' => "Data retrieved successfully",
                'data' => $kendaraan,
            ], 200);
        }
        return view('admin.kendaraan.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'plat_nomor' => 'required',
                'jenis_kendaraan' => 'required',
                'warna' => 'required',
                'pemilik' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['id_user'] = Auth::id() ?? 1; // Fallback to 1 if testing without auth but usually handled by auth middleware

            $kendaraan = Kendaraan::create($data);
            
            $this->logAktivitas("Mendaftarkan kendaraan baru dengan plat: " . $kendaraan->plat_nomor);

            return response()->json([
                'status' => true,
                'message' => "Data created successfully",
                'data' => $kendaraan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "System error: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_kendaraan)
    {
        $kendaraan = Kendaraan::find($id_kendaraan);

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Data retrieved successfully",
            'data' => $kendaraan
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kendaraan)
    {
        try {
            $data = $request->all();
            $kendaraan = Kendaraan::find($id_kendaraan);

            if (!$kendaraan) {
                return response()->json([
                    'status' => false,
                    'message' => "Data not found",
                ], 404);
            }

            $validator = Validator::make($data, [
                'plat_nomor' => 'required',
                'jenis_kendaraan' => 'required',
                'warna' => 'required',
                'pemilik' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $kendaraan->update($data);
            
            $this->logAktivitas("Memperbarui data kendaraan: " . $kendaraan->plat_nomor);

            return response()->json([
                'status' => true,
                'message' => "Data updated successfully",
                'data' => $kendaraan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "System error: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kendaraan)
    {
        $kendaraan = Kendaraan::find($id_kendaraan);

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        $plat = $kendaraan->plat_nomor;
        $kendaraan->delete();
        
        $this->logAktivitas("Menghapus log kendaraan: " . $plat);

        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully'
        ], 200);
    }
}
