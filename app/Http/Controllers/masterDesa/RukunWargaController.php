<?php

namespace App\Http\Controllers\masterDesa;

use App\Models\Rw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RukunWargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rw = Rw::all();

        return response()->json([
            'success' => true,
            'message' => 'List Data Rukun Warga',
            'data' => $rw
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
            'nm_rw' => 'required',
            'no_hp' => 'max:12',
            'alamat' => 'required',
            'id_kampung' => 'required'
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
            $tujuan_upload = 'file_rw';
            $file->move($tujuan_upload,$nama_file);

            $rw = Rw::create([
                'nm_rw' => $request->input('nm_rw'),
                'no_hp' => $request->input('no_hp'),
                'alamat' => $request->input('alamat'),
                'id_kampung' => $request->input('id_kampung'),
                'foto' => $nama_file
            ]);

            if ($rw) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rukun warga Berhasil Disimpan!',
                    'data' => $rw
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Rukun warga Gagal Disimpan!',
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
        $Rw = Rw::find($id);

        if ($Rw) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Rukun Warga',
                'data' => $Rw
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Rukun Warga Tidak Ditemukan!',
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
            'nm_rw' => 'required',
            'no_hp' => 'max:12',
            'alamat' => 'required',
            'id_kampung' => 'required'
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
                $tujuan_upload = 'file_rw';
                $file->move($tujuan_upload,$nama_file);
            }

            $rw = Rw::whereId($id)->update([
                'nm_rw' => $request->input('nm_rw'),
                'no_hp' => $request->input('no_hp'),
                'alamat' => $request->input('alamat'),
                'id_kampung' => $request->input('id_kampung'),
                'foto' => $nama_file
            ]);

            if ($rw) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rukun warga Berhasil Dirubah!',
                    'data' => $rw
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Rukun warga Gagal Dirubah!',
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
        $rw = Rw::whereId($id)->first();
        $rw->delete();

        if($rw){
            return response()->json([
                'success' => true,
                'message' => 'Rukun Warga Berhasil Di Hapus!'
            ], 200);
        }
    }
}
