<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMCEUploadController extends Controller
{
    /**
     * Tangani upload gambar dari TinyMCE editor.
     * Mengembalikan response JSON {"location": "URL_GAMBAR"}
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $ext  = $file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg');
            $name = 'tinymce_' . time() . '_' . Str::random(10) . '.' . strtolower($ext);

            // Simpan gambar ke storage/app/public/tinymce
            $path = $file->storeAs('tinymce', $name, 'public');

            // Format URL lengkap gambar
            $url = asset('storage/' . $path);

            return response()->json([
                'location' => $url
            ]);
        }

        return response()->json([
            'error' => 'File tidak valid atau gagal diunggah.'
        ], 400);
    }
}
