<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fans = Fan::with('klub')->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Fans Sepak Bola',
            'data' => $fans,
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_fan' => 'required',
            'id_klub' => 'required|array',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $fan = new Fan;
            $fan->nama_fan = $request->nama_fan;
            $fan->save();

            $fan->klub()->attach($request->klub);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dibuat',
                'data' => $fan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
        public function show($id)
    {
        try {
            $fan = Fan::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail fan',
                'data' => $fan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ada',
                'errors' => $e->getMessage(),
            ], 404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_fan' => 'required',
            'id_klub' => 'required|array',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $fan = Fan::findOrFail($id);
            $fan->nama_fan = $request->nama_fan;
            $fan->save();

            $fan->klub()->sync($request->klub);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dibuat',
                'data' => $fan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $fan = Fan::findOrFail($id);
            $fan->klub()->detach();
            $fan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
