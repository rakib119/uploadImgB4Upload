<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CropImageController extends Controller
{
    public function index(){
        return view('cromImage');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'thumbnail' => 'required|string',
        ]);

        $imageData = $request->input('thumbnail');

        // Extract the image extension and data
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
            $extension = $matches[1];
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);

            // Generate a unique filename
            $filename = Str::random(25) . '.' . $extension;

            // Save image to public folder
            $path = base_path('public/uploads/' . $filename);
            file_put_contents($path, $imageData);
            // return $filename;

            // Save image path to the database
            $image = new Image();
            $image->photo = $filename;
            $image->save();
            // return 'success';
            return response()->json(['message' => 'Image uploaded successfully', 'path' => $path], 200);
        }

        return response()->json(['message' => 'Invalid image data'], 400);
    }
}

