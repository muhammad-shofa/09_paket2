<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::all();
            return response()->json([
                'status' => true,
                'message' => "Data retrieved successfully",
                'data' => $user,
            ], 200);
        }
        return view('admin.user.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'required',
                'username' => 'required|unique:tb_user,username',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,petugas,owner',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $this->logAktivitas("Menambahkan pengguna baru: " . $user->username);

            return response()->json([
                'status' => true,
                'message' => "Data created successfully",
                'data' => $user
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
    public function show($id_user)
    {
        $user = User::find($id_user);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Data retrieved successfully",
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_user)
    {
        try {
            $data = $request->all();
            $user = User::find($id_user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => "Data not found",
                ], 404);
            }

            $validator = Validator::make($data, [
                'nama_lengkap' => 'required',
                'username' => 'required|unique:tb_user,username,'.$id_user.',id_user',
                'role' => 'required|in:admin,petugas,owner',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation failed",
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            $this->logAktivitas("Memperbarui data pengguna: " . $user->username);

            return response()->json([
                'status' => true,
                'message' => "Data updated successfully",
                'data' => $user
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
    public function destroy($id_user)
    {
        $user = User::find($id_user);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "Data not found",
            ], 404);
        }

        $username = $user->username;
        $user->delete();

        $this->logAktivitas("Menghapus pengguna: " . $username);

        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully'
        ], 200);
    }
}
