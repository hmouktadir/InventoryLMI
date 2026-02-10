<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog; // <--- TRÈS IMPORTANT

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return back()->with('success', 'Nouveau technicien ajouté avec succès !');
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email; 
        $user->role = $request->role;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        return back()->with('success', 'Modifications enregistrées !');
    }

        // Changer le statut (Activer/Désactiver)
    public function toggleStatus($id)
    {
        // dd(\App\Models\ActivityLog::all());
        
        $user = User::findOrFail($id);
        
        // Sécurité : ne pas se désactiver soi-même
        if($user->id === auth()->id()) {
            return back()->with('error', 'Action impossible : vous ne pouvez pas modifier votre propre statut.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        // --- AJOUT DE LA TRAÇABILITÉ (LOGS) ---
        \App\Models\ActivityLog::create([
            'admin_id'    => auth()->id(),
            'action'      => $user->is_active ? 'Réactivation' : 'Bannissement',
            'target_user' => $user->name,
            'details'     => "Le compte de {$user->email} a été " . ($user->is_active ? 'rétabli' : 'suspendu') . " par l'administrateur."
        ]);

        $statusMessage = $user->is_active ? 'Utilisateur réactivé avec succès.' : 'Utilisateur banni du système.';
        return back()->with('success', $statusMessage);
    }

    // Supprimer définitivement
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Sécurité : ne pas se supprimer soi-même
        if($user->id === auth()->id()) return back()->with('error', 'Action impossible.');

        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}