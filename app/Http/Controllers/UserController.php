<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = User::get();
            return response()->json([
                'status' => [
                    'code'      => 200,
                    'message'   => 'OK'
                ],
                'items' => [
                    'count' => count($data),
                    'data'  => $data
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'id_karyawan' => $request->id_karyawan ? $request->id_karyawan : null,
                'id_role' => $request->id_role ? $request->id_role : null,
                'status' => 0,
            ]);

            $id_karyawan = KaryawanController::store($request, $user->id);

            $user = User::find($user->id);
            $user->id_karyawan = $id_karyawan;
            $user->save();

            return response()->json([
                'status' => [
                    'code' => 200,
                    'message' => 'Register Success',
                ],
                'data' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 406,
                    'message' => 'Register Failed',
                ],
                'detail' => $th,
            ], 406);
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
            $data = User::find($id);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if ($user != null){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => isset($request->password) ? bcrypt($request->password) : $user->password,
                    'id_role' => isset($request->id_role) ? $request->id_role : $user->id_role,
                    'status' => isset($request->status) ? $request->status : 1,
                ]);

                if($request->header('update_karyawan')){
                    KaryawanController::update($request, $user->id_karyawan);
                }

                return response()->json([
                    'status' => [
                        'code' => 200,
                        'message' => 'Update Success',
                    ],
                    'data' => $user,
                ], 200);
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
                    'code' => 406,
                    'message' => 'Update Failed',
                ],
                'detail' => $th,
            ], 406);
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
            $user = User::find($id);
            if ($user != null){
                $karyawan = User::where('id_karyawan', $user->id_karyawan)->first();
                if($karyawan != null){
                    $karyawan->delete();
                }
                $user->delete();

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
