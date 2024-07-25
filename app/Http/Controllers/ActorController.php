<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function index()
    {
        $actor = actor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Daftar actor',
            'data' => $actor,
        ];

        return response()->json($response, 200);
    }

  
    // public function create()
    // {
        
    // }

   
    public function store(Request $request)
    {
        $actor = new actor();
        $actor->nama_aktor = $request->nama_aktor;
        $actor->bio = $request->bio;
        $actor->save();
        return response()->json([
            'success'=> true,
            'message'=> 'data berhasil disimpan'
        ], 201);
    }

    
    public function show($id)
    {
        $actor = actor::find($id);
        if ($actor) {
            return response([
                'success' => true,
                'message' => 'Detail actor disimpan',
                'data' => $actor,
            ],200 );
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'data tidak ditemukan'
            ]);
        }
    }

    
    // public function edit(actor $actor)
    // {
        
    // }

    
    public function update(Request $request, $id)
    {
        $actor = actor::find($id);
        if ($actor) {
            $actor->nama_aktor = $request->nama_aktor;
            $actor->bio = $request->bio;
            $actor->save();
            return response([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $actor,
            ],200 );
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'data gagal diperbarui'
            ]);
        }   
    }

    public function destroy(actor $id)
    {
        $actor = actor::find($id);
        if ($actor) {
            $actor->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'Data' . $actor->nama_aktor . 'Berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan'
            ]);
        }
    }
}
