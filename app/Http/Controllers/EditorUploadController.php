<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditorUploadController extends Controller
{
    /**
     * Upload Gambar dari Tiptap Editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Maks 5MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/editor/images
            $path = $file->storeAs('editor/images', $filename, 'public');

            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Gagal mengunggah gambar'], 400);
    }

    /**
     * Upload PDF dari Tiptap Editor
     */
    public function uploadPdf(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // Maks 10MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Bersihkan nama file asli
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = Str::slug($originalName);
            $filename = time() . '_' . $cleanName . '.pdf';
            
            // Simpan ke storage/app/public/editor/documents
            $path = $file->storeAs('editor/documents', $filename, 'public');

            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Gagal mengunggah PDF'], 400);
    }
}
