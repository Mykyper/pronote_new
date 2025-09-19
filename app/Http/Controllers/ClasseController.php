<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\JsonResponse;

class ClasseController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = Classe::all();
        return response()->json($classes);
    }
}
