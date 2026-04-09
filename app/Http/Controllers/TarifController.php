<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tarif = Tarif::all();
            return response()->json([
                'status' => true,
                'message' => "Data retrieved successfully",
                'data' => $tarif,
            ], 200);
        }
        return view('admin.tarif.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jenis_kendaraan' => 'required',
                'tarif_per_jam' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $tarif = Tarif::create($request->all());
            
            $this->logAktivitas("Menambahkan tarif kendaraan baru: " . $tarif->jenis_kendaraan);

            return response()->json([
                'status' => true,
                'message' => "Data created successfully",
                'data' => $tarif
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
    public function show($id_tarif)
    {
        $tarif = Tarif::find($id_tarif);

        if (!$tarif) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Data retrieved successfully",
            'data' => $tarif
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_tarif)
    {
        try {
            $data = $request->all();
            $tarif = Tarif::find($id_tarif);

            if (!$tarif) {
                return response()->json([
                    'status' => false,
                    'message' => "Data not found",
                ], 404);
            }

            $validator = Validator::make($data, [
                'jenis_kendaraan' => 'required',
                'tarif_per_jam' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $tarif->update($data);
            
            $this->logAktivitas("Mengubah tarif kendaraan: " . $tarif->jenis_kendaraan);

            return response()->json([
                'status' => true,
                'message' => "Data updated successfully",
                'data' => $tarif
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
    public function destroy($id_tarif)
    {
        $tarif = Tarif::find($id_tarif);

        if (!$tarif) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        $jenis = $tarif->jenis_kendaraan;
        $tarif->delete();
        
        $this->logAktivitas("Menghapus log tarif kendaraan: " . $jenis);

        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully'
        ], 200);
    }
}
