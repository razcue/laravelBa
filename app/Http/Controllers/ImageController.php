<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('null')) {
            $file = $request->file('null');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images'), $filename);
            return response()->json(['url' => asset('images/' . $filename)]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }
}

