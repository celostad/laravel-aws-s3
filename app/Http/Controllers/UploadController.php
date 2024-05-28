<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class UploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }
 
    public function store(Request $request)
    { 
        $imageName = $request->image->getClientOriginalName();
        $imagePath = '/' . $imageName; // sua pasta aqui
        $options = array(
            'ACL'          => 'public-read',
            'StorageClass' => 'STANDARD'
        );
 
        $path = Storage::disk('s3')->put($imagePath, file_get_contents($request->image),$options);
        $path = Storage::disk('s3')->url($path);
 
        return back()->with('success','Arquivo carregado com sucesso!');
    }

    public function fileDelete(Request $request)
    {
        $fileDelete = Storage::disk('s3')->delete($request['key']);
        
        if($fileDelete)
        return back()->with('success','Arquivo deletado com sucesso!');
        
    }
}
