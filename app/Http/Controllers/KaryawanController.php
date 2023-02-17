<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $karyawan = Karyawan::get();
            return response()->json([
                'status' => [
                    'code'      => 200,
                    'message'   => 'OK'
                ],
                'items' => [
                    'count' => count($karyawan),
                    'data'  => $karyawan
                ]
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code'      => 500,
                    'message'   => 'Something when wrong!'
                ],'detail' => $th
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKaryawanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request, $user_id)
    {
        $karyawan = Karyawan::where('id_user', $user_id)->first();
        if ($karyawan == null){
            $karyawan = Karyawan::create([
                'nama' => $request->name,
                'id_user' => $user_id
            ]);
        }
        return $karyawan->id_karyawan;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan $karyawan, $id)
    {
        try {
            $data = $karyawan->find($id);
            return response()->json([
                'status' => [
                    'code'      => 200,
                    'message'   => 'OK'
                ],
                'data'  => $data
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code'      => 500,
                    'message'   => 'Something when wrong!'
                ],'detail' => $th
            ],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKaryawanRequest  $request
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, $id_karyawan)
    {
        try {
            $karyawan = Karyawan::find($id_karyawan);
            if ($karyawan != null){
                $karyawan->update([
                    'name' => $request->name,
                    'no_ktp' => $request->no_ktp,
                    'ttl' => $request->ttl,
                    'jk' => $request->jk,
                    'agama' => $request->agama,
                    'gol_darah' => $request->gol_darah,
                    'alamat' => $request->alamat,
                    'no_telp' => $request->no_telp,
                ]);
            }

            return $karyawan;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan, $id)
    {
        try {
            $karyawan = $karyawan->find($id);
            if ($karyawan != null){
                $user = User::where('id_karyawan', $karyawan->id_karyawan)->first();
                if($user != null){
                    $user->delete();
                }
                $karyawan->delete();

                return response()->json([
                    'status' => [
                        'code' => 200,
                        'message' => 'Delete Success',
                    ],
                ],200);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 404,
                        'message' => 'Data Not Found',
                    ],
                ],404);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'message' => 'Delete Failed',
                ],
                'detail' => $th,
            ], 500);
        }
    }
}
