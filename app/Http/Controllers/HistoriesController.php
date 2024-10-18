<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HistoriesController extends Controller{
    function edit(Request $request): JsonResponse{
        $history = History::findOrFail($request->id);
        $history->fill($request->all());
        $history->save();

        return response()->json([
            'status' => 200,
            'data' => 'Historial actualizado con exito',
        ], Response::HTTP_OK);
    }
}
