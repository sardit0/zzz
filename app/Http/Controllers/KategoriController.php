<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Daftar Kategori',
            'data' => $kategori,
        ];

        return response()->json($response, 200);
    }

  
    // public function create()
    // {
        
    // }

   
    public function store(Request $request)
    {
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        return response()->json([
            'success'=> true,
            'message'=> 'data berhasil disimpan'
        ], 201);
    }

    
    public function show($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            return response([
                'success' => true,
                'message' => 'Detail kategori disimpan',
                'data' => $kategori,
            ],200 );
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'data tidak ditemukan'
            ]);
        }
    }

    
    // public function edit(Kategori $kategori)
    // {
        
    // }

    
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
            return response([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $kategori,
            ],200 );
        } else {
            return response()->json([
                'success'=> false,
                'message'=> 'data gagal diperbarui'
            ]);
        }   
    }

    public function destroy(Kategori $id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'Data' . $kategori->nama_kategori . 'Berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan'
            ]);
        }
    }
}
