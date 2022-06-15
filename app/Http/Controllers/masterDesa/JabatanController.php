<?php

namespace App\Http\Controllers\masterDesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Validator;


class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Jabatan::all();

        
            return response()->json([
                'success' => true,
                'message' => 'List Data Jabatan',
                'data' => $jabatan
            ], 200);
           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nm_jabatan' => 'required'
        ],
        [
            'required' => 'data tidak boleh kosong'
        ]
    
        );

        if($validator->fails()){

            return response()->json([
                'success' => false,
                'message' => 'Semua Data Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        }else{

            $jabatan = Jabatan::create([
                'nm_jabatan' => $request->nm_jabatan
            ]);

            if($jabatan){
                return response()->json([
                    'success' => true,
                    'message' => 'Jabatan Berhasil Disimpan!',
                    'data'   => $jabatan
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Jabatan Gagal Disimpan!',
                   
                ],400);
            }

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
        $jabatan = Jabatan::find($id);

        if($jabatan){
            return response()->json([
                'success' => true,
                'message' => 'Detail Jabatan!',
                'data'   => $jabatan
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Jabatan Tidak Ditemukan!',
                
            ],404);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(),[
            'nm_jabatan' => 'required'
        ],
        [
            'required' => 'data tidak boleh kosong'
        ]
    
        );

        if($validator->fails()){

            return response()->json([
                'success' => false,
                'message' => 'Semua Data Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        }else{

            $jabatan = Jabatan::whereId($id)->update([
                'nm_jabatan' => $request->nm_jabatan
            ]);

            if($jabatan){
                return response()->json([
                    'success' => true,
                    'message' => 'Jabatan Berhasil Dirubah!',
                    'data'   => $jabatan
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Jabatan Gagal Dirubah!',
                   
                ],401);
            }

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
        $jabatan = Jabatan::whereId($id)->first();
        $jabatan->delete();

        if($jabatan){
            return response()->json([
                'success' => true,
                'message' => 'Jabatan Berhasil Di Hapus!'
            ], 200);
        }
    }
}
