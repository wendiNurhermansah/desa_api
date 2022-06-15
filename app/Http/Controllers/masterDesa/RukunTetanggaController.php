<?php

namespace App\Http\Controllers\masterDesa;

use App\Models\Rt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RukunTetanggaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Rt = Rt::all();

        return response()->json([
            'success' => true,
            'message' => 'List Data Rukun Tetangga',
            'data' => $Rt
        ],200);
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
        $validator = Validator::make($request->all(), [
            'nm_rt' => 'required',
            'no_hp' => 'max:12',
            'alamat' => 'required',
            'id_kampung' => 'required',
            'no_rt' => 'required'
        ], 
        [
            'required' => 'data tidak boleh kosong!',
            'max' => 'maksimal 12 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Data Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);
        } else {

            $file = $request->file('foto');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'file_Rt';
            $file->move($tujuan_upload,$nama_file);

            $Rt = Rt::create([
                'nm_rt' => $request->input('nm_rt'),
                'no_hp' => $request->input('no_hp'),
                'alamat' => $request->input('alamat'),
                'id_kampung' => $request->input('id_kampung'),
                'no_rt' => $request->input('no_rt'),
                'foto' => $nama_file
            ]);

            if ($Rt) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rukun Tetangga Berhasil Disimpan!',
                    'data' => $Rt
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Rukun Tetangga Gagal Disimpan!',
                ], 400);
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
        $Rt = Rt::find($id);

        if ($Rt) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Rukun Tetangga',
                'data' => $Rt
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Rukun Tetangga Tidak Ditemukan!',
            ], 404);
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
        $validator = Validator::make($request->all(), [
            'nm_rt' => 'required',
            'no_hp' => 'max:12',
            'alamat' => 'required',
            'id_kampung' => 'required',
            'no_rt' => 'required'
        ], 
        [
            'required' => 'data tidak boleh kosong!',
            'max' => 'maksimal 12 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Data Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);
        } else {

            if($request->hasFile('foto')) {
                $file = $request->file('foto');

                $nama_file = time()."_".$file->getClientOriginalName();

                        // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'file_Rt';
                $file->move($tujuan_upload,$nama_file);
            }

            $Rt = Rt::whereId($id)->update([
                'nm_rt' => $request->input('nm_rt'),
                'no_hp' => $request->input('no_hp'),
                'alamat' => $request->input('alamat'),
                'id_kampung' => $request->input('id_kampung'),
                'no_rt' => $request->input('no_rt'),
                'foto' => $nama_file
            ]);

            if ($Rt) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rukun Tetangga Berhasil Dirubah!',
                    'data' => $Rt
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Rukun Tetangga Gagal Dirubah!',
                ], 400);
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
        $Rt = Rt::whereId($id)->first();
        $Rt->delete();

        if($Rt){
            return response()->json([
                'success' => true,
                'message' => 'Rukun Tetangga Berhasil Di Hapus!'
            ], 200);
        }
    }
}
