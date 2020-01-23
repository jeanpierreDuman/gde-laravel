<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\File;

class FolderStepService
{
    public function manageErrorStep($folder, $status, $values, $request, $withFile = true)
    {
        $validator = Validator::make($values, [
            'saisi-achat' => 'required',
            'saisi-vente' => 'required',
            'saisi-facture' => 'required',
            'saisi-banque' => 'required',
            'saisi-divers' => 'required',
            'difference-achat' => 'required',
            'difference-vente' => 'required',
            'difference-facture' => 'required',
            'difference-banque' => 'required',
            'difference-divers' => 'required'
        ]);

        $data['errors'] = null;
        $data['fileTest'] = false;
        $data['upload'] = null;
        $data['step'] = false;
        $errorTypeFile = 0;

        if($validator->fails()) {
            foreach($validator->errors()->getMessages() as $key => $message) {
                $data['errors'][$key] = "* le champs est requis";
            }
        }

        if(intval($values['difference-achat']) !== 0) {
            $data['errors']['difference-achat'] = "* la différence doit être égal à 0";
        }

        if(intval($values['difference-vente']) !== 0) {
            $data['errors']['difference-vente'] = "* la différence doit être égal à 0";
        }

        if(intval($values['difference-facture']) !== 0) {
            $data['errors']['difference-facture'] = "* la différence doit être égal à 0";
        }

        if(intval($values['difference-banque']) !== 0) {
            $data['errors']['difference-banque'] = "* la différence doit être égal à 0";
        }

        if(intval($values['difference-divers']) !== 0) {
            $data['errors']['difference-divers'] = "* la différence doit être égal à 0";
        }

        if(null !== $request->request->get('filesTypeUpload')) {
            $filesTypeUpload = json_decode($request->request->get('filesTypeUpload'));
            $arrayType = json_decode($request->request->get('arrayType'));

            if($filesTypeUpload->numberFileAchat != $folder->achat) {
                $errorTypeFile++;
            }

            if($filesTypeUpload->numberFileVente != $folder->vente) {
                $errorTypeFile++;
            }

            if($filesTypeUpload->numberFileFacture != $folder->facture) {
                $errorTypeFile++;
            }

            if($filesTypeUpload->numberFileBanque != $folder->banque) {
                $errorTypeFile++;
            }

            if($filesTypeUpload->numberFileDivers != $folder->divers) {
                $errorTypeFile++;
            }
        }

        if($withFile === true && $data['errors'] === null) {
            $data['fileTest'] = true;
            $files = $request->files;

            if($folder->piece !== count($files)) {
                $data['upload'] = false;
                $data['errors']['error-piece-upload'] = "* le nombre de fichier à télécharger doit être égal au nombre de piece";
            } elseif ($errorTypeFile !== 0) {
                $data['upload'] = false;
                $data['errors']['content-type-file'] = "* Les types de documents ne correspondent pas au nombre saisi à la création du dossier";
            } else {

                $i = 0;
                foreach($files as $fileUpload) {
                    $file = new File();
                    $path = Storage::putFile('photos', new \Illuminate\Http\File($fileUpload));
                    $file->path = $path;
                    $file->name = $fileUpload->getClientOriginalName();
                    $file->type = $fileUpload->getMimeType();

                    if(null !== $request->request->get('filesTypeUpload')) {
                        $file->documentType = $arrayType[$i];
                    }

                    $file->created_at = new \DateTime();
                    $file->updated_at = new \DateTime();

                    $folder->files()->save($file);
                    $i++;
                }

                $data['upload'] = true;
            }
        }

        if($data['errors'] === null) {
            $data['step'] = true;
            $folder->status = $status;
            $folder->save();
        }

        return $data;
    }
}
