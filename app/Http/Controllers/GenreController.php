<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genre = Genre::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Daftar genre',
            'data' => $genre,
        ];

        return response()->json($response, 200);
    }

  
    // public function create()
    // {
        
    // }

   
    public function store(Request $request)
    {
        $genre = new Genre();
        $genre->nama_genre = $request->nama_genre;
        $genre->save();
        return response()->json([
            'success'=> true,
            'message'=> 'data berhasil disimpan'
        ], 201);
    }

    
    public function show($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            return response([
                'success' => true,
                'message' => 'Detail genre disimpan',
                'data' => $genre,
            ],200 );
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'data tidak ditemukan'
            ]);
        }
    }

    
    // public function edit(genre $genre)
    // {
        
    // }

    
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
            return response([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $genre,
            ],200 );
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'data gagal diperbarui'
            ]);
        }   
    }

    public function destroy(genre $id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'Data' . $genre->nama_genre . 'Berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan'
            ]);
        }
    }
}
