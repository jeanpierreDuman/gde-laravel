<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use Illuminate\Support\Facades\Auth;

class PageStepController extends Controller
{
    public function scannerFolder($id)
    {
        $folder = Folder::find($id);

        if($folder !== null && $folder->status !== 'to_scan') {
            return redirect('/');
        }

        return view('folder.scanner', [
            'folder' => $folder
        ]);
    }

    public function comptabiliserFolder($id)
    {
        $folder = Folder::find($id);

        if($folder === null) {
            return redirect('/');
        }

        if($folder !== null && $folder->status !== 'to_compta') {
            return redirect('/');
        }

        return view('folder.compta', [
            'folder' => $folder
        ]);
    }

    public function integrerFolder($id)
    {
        $folder = Folder::find($id);

        if($folder !== null && $folder->status !== 'to_integrer') {
            return redirect('/');
        }

        return view('folder.integrer', [
            'folder' => $folder
        ]);
    }
}
