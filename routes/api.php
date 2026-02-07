<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Receta;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta para obtener los items de una receta
Route::get('/recetas/{receta}/items', function (Receta $receta) {
    $receta->load('items.producto');
    return response()->json([
        'items' => $receta->items,
        'costo_total' => $receta->costo_total
    ]);
});
