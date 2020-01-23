<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function showUpload($id)
    {
        $file = File::find($id);
        $path = $file->path;

        $contentFile = Storage::get($path);
        header('Content-Type: ' . $file->type);
        echo $contentFile;
    }

    public function deleteUpload($id, Request $request)
    {
        $file = File::find($id);
        $path = $file->path;

        Storage::delete($path);
        $file->delete();

        return redirect()->route('folder_get', ['id' => $file->folder->id]);
    }
}
