<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::all();

        return response()->json([
            'success' => true,
            'message' =>'List Data Pegawai',
            'data'    => $pegawai
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
                $validator = Validator::make($request->all(), [
                    'nm_pegawai' => 'required',
                    'no_hp' => 'required|max: 12',
                    'id_jabatan' => 'required',
                    'alamat' => 'required',
                    'foto' => 'required|mimes:jpeg,png,jpg',
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
                    $tujuan_upload = 'file_pegawai';
                    $file->move($tujuan_upload,$nama_file);

                $pegawai = Pegawai::create([
                    'nm_pegawai'     => $request->input('nm_pegawai'),
                    'no_hp'   => $request->input('no_hp'),
                    'id_jabatan'   => $request->input('id_jabatan'),
                    'alamat'   => $request->input('alamat'),
                    'foto'   => $nama_file,
                ]);

                if ($pegawai) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Pegawai Berhasil Disimpan!',
                        'data' => $pegawai
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pegawai Gagal Disimpan!',
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
        $pegawai = Pegawai::find($id);

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Pegawai',
                'data' => $pegawai
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai Tidak Ditemukan!',
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
            'nm_pegawai' => 'required',
            'no_hp' => 'required|max: 12',
            'id_jabatan' => 'required',
            'alamat' => 'required',
            'foto' => 'required|mimes:jpeg,png,jpg',
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
                $tujuan_upload = 'file_pegawai';
                $file->move($tujuan_upload,$nama_file);
            }

            $pegawai = Pegawai::whereId($id)->update([
            'nm_pegawai'     => $request->input('nm_pegawai'),
            'no_hp'   => $request->input('no_hp'),
            'id_jabatan'   => $request->input('id_jabatan'),
            'alamat'   => $request->input('alamat'),
            'foto'   => $nama_file,
        ]);

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'message' => 'Pegawai Berhasil Di Update!',
                'data' => $pegawai
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai Gagal Di Update!',
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
        $pegawai = Pegawai::whereId($id)->first();
        $pegawai->delete();

        if($pegawai){
            return response()->json([
                'success' => true,
                'message' => 'Pegawai Berhasil Di Hapus!.'
            ], 200);
        }
    }
}
