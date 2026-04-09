<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $area = AreaParkir::all();
            return response()->json([
                'status' => true,
                'message' => "Data retrieved successfully",
                'data' => $area,
            ], 200);
        }
        return view('admin.area.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_area' => 'required',
                'kapasitas' => 'required|numeric',
                'terisi' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $area = AreaParkir::create($request->all());
            
            $this->logAktivitas("Menambahkan area parkir baru: " . $area->nama_area);

            return response()->json([
                'status' => true,
                'message' => "Data created successfully",
                'data' => $area
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
    public function show($id_area)
    {
        $area = AreaParkir::find($id_area);

        if (!$area) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Data retrieved successfully",
            'data' => $area
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_area)
    {
        try {
            $data = $request->all();
            $area = AreaParkir::find($id_area);

            if (!$area) {
                return response()->json([
                    'status' => false,
                    'message' => "Data not found",
                ], 404);
            }

            $validator = Validator::make($data, [
                'nama_area' => 'required',
                'kapasitas' => 'required|numeric',
                'terisi' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $area->update($data);
            
            $this->logAktivitas("Memperbarui data area parkir: " . $area->nama_area);

            return response()->json([
                'status' => true,
                'message' => "Data updated successfully",
                'data' => $area
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
    public function destroy($id_area)
    {
        $area = AreaParkir::find($id_area);

        if (!$area) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        $nama = $area->nama_area;
        $area->delete();
        
        $this->logAktivitas("Menghapus area parkir: " . $nama);

        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully'
        ], 200);
    }
}
