<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use Illuminate\Support\Facades\Auth;

class ValidationStepController extends Controller
{
    public function validationScanner($id, Request $request)
    {
        $folder = Folder::find($id);

        if(Auth::user() === null) {
            return redirect('/login');
        }

        if($folder === null) {
            return redirect('/');
        }

        $folder->dateScan = new \DateTime();
        $folder->save();

        return redirect()->route('folder_list')
            ->with('success_next_step', route('folder_comptabiliser', ['id' => $id]));
    }

    public function validationCompta($id, Request $request)
    {
        $folder = Folder::find($id);

        if(Auth::user() === null) {
            return redirect('/login');
        }

        if($folder === null) {
            return redirect('/');
        }

        $folder->dateSaisi = new \DateTime();
        $folder->save();

        return redirect()->route('folder_list')
            ->with('success_next_step', route('folder_integrer', ['id' => $id]));
    }

    public function validationIntegrer($id, Request $request)
    {
        $folder = Folder::find($id);

        if(Auth::user() === null) {
            return redirect('/login');
        }

        if($folder === null) {
            return redirect('/');
        }

        $folder->dateIntegration = new \DateTime();
        $folder->save();

        return redirect()->route('folder_list')
            ->with('success_complete', "Le dossier " . $folder->numFolder . " est complet");
    }
}
