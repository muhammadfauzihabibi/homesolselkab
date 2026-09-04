<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CKeditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');

            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'pages',
                $filename,
                'public'
            );

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Upload gagal'
            ]
        ], 422);
    }
}
