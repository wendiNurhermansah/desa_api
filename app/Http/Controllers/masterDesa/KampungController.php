<?php

namespace App\Http\Controllers\masterDesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kampung;
use Illuminate\Support\Facades\Validator;

class KampungController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kampung = Kampung::all();

      

            return response()->json([
                'success' => true,
                'message' =>'List Data Kampung',
                'data'    => $kampung
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
                   'nm_kampung' => 'required',
                   'no_rw'  => 'required'
                ],
                [
                   'required' => 'data tidak boleh kosong' 
                ]);

                if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Semua Data Wajib Diisi!',
                    'data'   => $validator->errors()
                ],401);

                } else {

                   

                $kampung = Kampung::create([
                    'nm_kampung'     => $request->input('nm_kampung'),
                    'no_rw'   => $request->input('no_rw'),
                   
                ]);

                if ($kampung) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Kampung Berhasil Disimpan!',
                        'data' => $kampung
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kampung Gagal Disimpan!',
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
        $kampung = Kampung::find($id);

        if ($kampung) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Kampung',
                'data' => $kampung
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kampung Tidak Ditemukan!',
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
            'nm_kampung' => 'required',
            'no_rw'  => 'required'
         ],
         [
            'required' => 'data tidak boleh kosong' 
         ]);

        if ($validator->fails()) {

        return response()->json([
            'success' => false,
            'message' => 'Semua Data Wajib Diisi!',
            'data'   => $validator->errors()
        ],401);

        } else {
            $kampung = Kampung::whereId($id)->update([
                'nm_kampung'     => $request->input('nm_kampung'),
                'no_rw'   => $request->input('no_rw'),
            
        ]);

        if ($kampung) {
            return response()->json([
                'success' => true,
                'message' => 'Kampung Berhasil Di Update!',
                'data' => $kampung
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kampung Gagal Di Update!',
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
        $Kampung = Kampung::whereId($id)->first();
        $Kampung->delete();

        if($Kampung){
            return response()->json([
                'success' => true,
                'message' => 'Kampung Berhasil Di Hapus!.'
            ], 200);
        }
    }
}
