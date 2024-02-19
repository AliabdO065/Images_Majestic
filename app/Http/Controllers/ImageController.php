<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    
    public function index(){
        return view('image.index');
    }

    public function create(){
        return view('image.create');
    }

    public function store(Request $request){
        {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();            
            $compressedImage = Image::make($image)->encode('jpg', 80); 
            $compressedImage->save(public_path('images/' . $filename));
            
            // ...
        }
    }
}
