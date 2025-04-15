<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRole = '';
    
    public function mount()
    {
        // Définir le rôle par défaut sur "Reader" s'il existe
        $readerRole = Role::where('name', 'Reader')->first();
        if ($readerRole) {
            $this->selectedRole = $readerRole->name;
        }
    }
    
    public function create()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'selectedRole' => ['required', 'string', 'exists:roles,name'],
        ]);
        
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            
            // Assigner le rôle sélectionné
            $user->assignRole($this->selectedRole);
            
            // Réinitialiser le formulaire
            $this->reset(['name', 'email', 'password', 'password_confirmation']);
            
            // Message de succès
            session()->flash('message', __('Utilisateur créé avec succès.'));
            
            // Rediriger vers la liste des utilisateurs
            return redirect()->route('users.index');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création de l\'utilisateur: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.users.create-user', [
            'roles' => Role::all(),
        ]);
    }
}