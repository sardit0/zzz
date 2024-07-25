<?php
namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Storage;
use Validator;

class FilmController extends Controller
{
    public function index()
    {
        $film = Film::with(['genre', 'actor'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Film',
            'data' => $film,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|unique:film',
            'slug' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url_vidio' => 'required|string',
            'id_kategoris' => 'required|exists:kategoris,id',
            'genre' => 'required|array',
            'actor' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $path = $request->file('foto')->store('public/foto');

            $film = Film::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'foto' => $path,
                'url_vidio' => $request->url_vidio,
                'id_kategoris' => $request->id_kategoris,
                'slug' => $request->slug,
            ]);

            $film->genre()->sync($request->genre);
            $film->actor()->sync($request->actor);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $film,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $film = Film::with(['genre', 'actor'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail Film',
                'data' => $film,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|unique:film,judul,' . $id,
            'slug' => 'required|string,' . $id,
            'deskripsi' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url_vidio' => 'required|string',
            'id_kategoris' => 'required|exists:kategoris,id',
            'genre' => 'required|array',
            'actor' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            if ($request->hasFile('foto')) {
                // Delete old photo
                Storage::delete($film->foto);

                $path = $request->file('foto')->store('public/foto');
                $film->foto = $path;
            }

            $film->update($request->only(['judul', 'deskripsi', 'url_vidio', 'id_ss']));

            if ($request->has('genre')) {
                $film->genre()->sync($request->genre);
            }

            if ($request->has('actor')) {
                $film->actor()->sync($request->actor);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $film,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $film = Film::findOrFail($id);

            // Delete photo
            Storage::delete($film->foto);
            $film->genre()->detech();
            $film->actor()->detech();
            $film->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully',
                'data' => null,
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }
}
