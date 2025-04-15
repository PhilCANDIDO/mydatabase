<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($validated['role']);

        return redirect()->route('users.index')
            ->with('success', __("User created successfully."));        
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|exists:roles,name',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        //Mettre à jour le rôle de l'utilisateur
        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')
            ->with('success', __("User updated successfully."));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Empêcher un utilisateur de se supprimer lui-même
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', __("Vous ne pouvez pas supprimer votre propre compte."));
        }

        try {
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', __("L'utilisateur a été supprimé avec succès."));
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', __("Erreur lors de la suppression: ") . $e->getMessage());
        }
    }
}
