<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Imagick;
class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048' // Validation rules for upload
        ]);

        $image = $request->file('image');
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension(); // Generate unique filename
        $path = $image->storeAs('uploads', $fileName); // Store the original image

        // (Optional) Using Intervention Image to create a thumbnail
        $thumbnailPath = 'thumbnails/' . $fileName;
        $intervention = Image::make($image->getRealPath());
        $intervention->fit(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/' . $thumbnailPath));

        // (Alternative) Using pure Imagick to create a thumbnail
        // $imagick = new Imagick(storage_path('app/uploads/' . $fileName));
        // $imagick->resizeImage(200, 200, Imagick::FILTER_TRIANGLE, 1);
        // $imagick->writeImage(storage_path('app/thumbnails/' . $fileName));

        // You can update your Image model here to store original and thumbnail paths (if applicable)

        return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully');
    }
}
