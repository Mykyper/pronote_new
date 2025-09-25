<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
class UserController extends Controller
{
    public function index(){
        return view("add_user");
    }
   public function all(): JsonResponse
    {
        $users = User::all(['id', 'nom', 'prenom', 'email', 'role']);

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:coordinateur,enseignant',
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$user->role} ajouté avec succès !",
            'data' => $user,
        ], 201); // 201 = Created
    }
    
}
