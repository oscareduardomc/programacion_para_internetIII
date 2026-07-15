<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(DB::table('tareas')->get());
    }

    public function store(Request $request)
    {
        $request->validate(['titulo' => 'required']);

        DB::table('tareas')->insert([
            'titulo' => $request->titulo,
        ]);

        return response()->json(DB::table('tareas')->get(), 201);
    }

    public function destroy($id)
    {
        DB::table('tareas')->where('id', $id)->delete();

        return response()->json(['message' => 'Tarea eliminada']);
    }
}
