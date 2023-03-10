<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{
    public function upload(ImageStoreRequest $request)
    {
        $file=$request->file('image');
        $name=Str::random(10);
        $url=Storage::putFileAs('images',$file,$name.'.'.$file->extension());
        return['url'=> env('APP_URL').'/'.$url];
    }
}
