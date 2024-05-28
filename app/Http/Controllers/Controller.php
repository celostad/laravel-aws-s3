<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Controller
{
    public function index()
    {
        // $arrFiles = Storage::disk('s3')->allFiles('');
        $arrS3Files = Storage::disk('s3')->files();
        foreach ($arrS3Files as $file) {
            $arrFiles[] = array(
                'size' => $this->sizeFilter(Storage::disk('s3')->size($file)),
                'strFile' => $file,
                'tipo' => pathinfo($file, PATHINFO_EXTENSION),
            );
        }

        return view('index', compact('arrFiles'));
    }    

    public function sizeFilter($bytes)
    {
        $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++);
        return (round($bytes, 2) . " " . $label[$i]);
    }
}
