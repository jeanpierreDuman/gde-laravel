<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use Illuminate\Support\Facades\Auth;
use App\Services\FolderStepService;
use App\Services\GlobalService;

class CheckStepController extends Controller
{
    private $folderStepService;

    private $globalService;

    public function __construct()
    {
        $this->folderStepService = new FolderStepService();
        $this->globalService = new GlobalService();
    }

    public function scannerFolderPost($id, Request $request)
    {
        $folder = Folder::find($id);

        if(Auth::user() === null) {
            return redirect('/login');
        }

        $user = Auth::user();

        $formData = $request->request->get('formData');
        $values = $this->globalService->unserializeForm($formData);

        return $this->folderStepService->manageErrorStep($folder, 'to_compta', $values, $request);
    }

    public function comptaFolderPost($id, Request $request)
    {
        $folder = Folder::find($id);

        if(Auth::user() === null) {
            return redirect('/login');
        }

        $user = Auth::user();

        $formData = $request->request->get('formData');
        $values = $this->globalService->unserializeForm($formData);

        return $this->folderStepService->manageErrorStep($folder, 'to_integrer', $values, $request, false);
    }

    public function integrerFolderPost($id, Request $request)
    {
        $folder = Folder::find($id);

        if(Auth::user() === null) {
            return redirect('/login');
        }

        $user = Auth::user();

        $formData = $request->request->get('formData');
        $values = $this->globalService->unserializeForm($formData);

        return $this->folderStepService->manageErrorStep($folder, 'complete', $values, $request, false);
    }
}
