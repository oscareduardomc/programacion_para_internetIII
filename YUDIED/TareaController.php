<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        return response()->json(Tarea::all());
    }

    public function store(Request $request)
    {
        $tarea = Tarea::create([
            'titulo' => $request->titulo
        ]);

        return response()->json($tarea);
    }

    public function destroy($id)
    {
        Tarea::destroy($id);

        return response()->json([
            'message' => 'Task deleted'
        ]);
    }
}