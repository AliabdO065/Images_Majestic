<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    
    public function index(){
        return view('image.index');
    }

    public function create(){
        return view('image.create');
    }

    public function store(Request $request)
        {
            // $image = $request->file('image');
            // $filename = time() . '.' . $image->getClientOriginalExtension();            
            // $compressedImage = Image::make($image)->encode('jpg', 80); 
            // $compressedImage->save(public_path('images/' . $filename));
            
            // ImageOptimizer::optimize($pathToImage, $pathToOptimizedImage);
     
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($request->file('image')) {
                $image = $request->file('image');
                $filename = 'images\\' . Str::uuid() . $image->getClientOriginalName();
                switch (strtolower($image->getClientOriginalExtension())) {
                    case 'jpg':
                    case 'jpeg':
                        $compressedImage = imagecreatefromjpeg($image->path());
                        imagejpeg($compressedImage, public_path($filename), 80); 
                        break;
    
                    case 'png':
                        $compressedImage = imagecreatefrompng($image->path());
                        imagepng($compressedImage, public_path($filename), 9);
                        break;
    
                    case 'gif':
                        $compressedImage = imagecreatefromgif($image->path());
                        imagegif($compressedImage, public_path($filename));
                        break;    
                    default:
                        return 'The image format is not supported.  ';
                    }
                    return redirect()->route('image');
    }
}
}
