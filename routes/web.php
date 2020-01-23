<?php

Route::get('/client/creation', 'ClientController@createClient')->name('client_create');

Route::get('/', 'FolderController@list')->name('folder_list');

Route::post('/client/datatable/liste', 'ClientController@datatableClientList')->name('client_datatable_list');
Route::get('/client/{id}', 'ClientController@show')->name('client_show');

Route::post('/dossier/post', 'FolderController@store')->name('folder_post');

Route::post('/upload/folder/{id}', 'UploadController@upload')->name('upload');
Route::get('/upload/show/{id}', 'UploadController@showUpload')->name('show_upload');
Route::get('/upload/delete/{id}', 'UploadController@deleteUpload')->name('delete_upload');

Route::post('/dossier/datatable/liste', 'FolderController@datatableFolderList')->name('folder_datatable_list');
Route::get('/dossier/creation', 'FolderController@create')->name('folder_create');
Route::get('/dossier/{id}', 'FolderController@show')->name('folder_get');

Route::get('/dossier/{id}/scanner', 'PageStepController@scannerFolder')->name('folder_scanner');
Route::post('/dossier/{id}/validation/scanner', 'ValidationStepController@validationScanner')->name('folder_validation_scanner');
Route::post('/dossier/{id}/scanner/post', 'CheckStepController@scannerFolderPost')->name('folder_scanner_post');

Route::get('/dossier/{id}/comptabiliser', 'PageStepController@comptabiliserFolder')->name('folder_comptabiliser');
Route::post('/dossier/{id}/validation/compta', 'ValidationStepController@validationCompta')->name('folder_validation_compta');
Route::post('/dossier/{id}/compta/post', 'CheckStepController@comptaFolderPost')->name('folder_compta_post');

Route::get('/dossier/{id}/integrer', 'PageStepController@integrerFolder')->name('folder_integrer');
Route::post('/dossier/{id}/validation/integrer', 'ValidationStepController@validationIntegrer')->name('folder_validation_integrer');
Route::post('/dossier/{id}/integrer/post', 'CheckStepController@integrerFolderPost')->name('folder_integrer_post');

Route::post('/client/post', 'ClientController@store')->name('client_post');
Route::post('/client/post/search', 'ClientController@search')->name('client_post_search');

Route::get('/clients', 'ClientController@list')->name('client_list');

Auth::routes();
