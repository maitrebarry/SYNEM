<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        // Appliquer le middleware auth
        $this->middleware('auth');
        
        // Vérifier que l'utilisateur est admin ou superadmin
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user || (! in_array($user->role, ['superadmin', 'admin']))) {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $currentUserId = Auth::id();
        $currentUser = Auth::user();

        // Si superadmin -> voir tous les administrateurs (sauf soi-même)
        if ($currentUser && $currentUser->role === 'superadmin') {
            $users = User::admins()
                ->where('id', '!=', $currentUserId)
                ->latest()
                ->get();
        } else {
            // Si simple admin -> ne voir que son propre compte
            $users = User::where('id', $currentUserId)->get();
        }

        // Retourner la vue paramètres pour le sous-menu utilisateurs
        return view('administration.parametres.index', [
            'section_active' => 'utilisateurs',
            'contenu' => 'administration.parametres.sections.utilisateurs',
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,superadmin'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('administration.parametres.utilisateurs')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function update(Request $request, string $id)
    {
        $user = User::admins()->findOrFail($id);
        $currentUserId = Auth::id();
        
        // Empêche de modifier le superadmin si ce n'est pas soi-même
        if ($user->role === 'superadmin' && $user->id !== $currentUserId) {
            abort(403, 'Accès non autorisé.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'in:admin,superadmin'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('administration.parametres.utilisateurs')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(string $id)
    {
        $user = User::admins()->findOrFail($id);
        
        // Empêche de supprimer le superadmin
        if ($user->role === 'superadmin') {
            abort(403, 'Impossible de supprimer un superadmin.');
        }

        $user->delete();

        return redirect()->route('administration.parametres.utilisateurs')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function toggleStatus(string $id)
    {
        $user = User::admins()->findOrFail($id);
        
        // Empêche de désactiver le superadmin
        if ($user->role === 'superadmin') {
            abort(403, 'Impossible de désactiver un superadmin.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $message = $user->is_active ? 'activé' : 'désactivé';

        return back()->with('success', "Utilisateur {$message} avec succès.");
    }
}