
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeitoController;

Route::post('/leitos/{id}/ocupar',[LeitoController::class,'ocupar']);
Route::post('/leitos/{id}/desocupar',[LeitoController::class,'desocupar']);
Route::post('/transferencias',[LeitoController::class,'transferir']);
Route::get('/pacientes/{cpf}/leito',[LeitoController::class,'buscarPorCpf']);
Route::get('/leitos/{id}/status',[LeitoController::class,'status']);
Route::get('/leitos',[LeitoController::class,'index']);
