<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRole = '';
    
    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'selectedRole' => ['required', 'string', 'exists:roles,name'],
    ];
    
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first() ? $user->roles->first()->name : '';
    }
    
    public function update()
    {
        // Ajout de la règle de validation unique pour l'email (excepté l'utilisateur actuel)
        $this->rules['email'][] = Rule::unique('users')->ignore($this->user->id);
        
        $this->validate();
        
        // Validation conditionnelle du mot de passe s'il est fourni
        if ($this->password) {
            $this->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
        
        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            
            // Mise à jour du mot de passe si fourni
            if ($this->password) {
                $this->user->update([
                    'password' => Hash::make($this->password),
                ]);
            }
            
            // Mise à jour du rôle si changé
            $currentRole = $this->user->roles->first() ? $this->user->roles->first()->name : null;
            if ($currentRole !== $this->selectedRole) {
                // Supprimer tous les rôles actuels
                $this->user->syncRoles([]);
                // Assigner le nouveau rôle
                $this->user->assignRole($this->selectedRole);
            }
            
            // Réinitialiser les champs de mot de passe
            $this->reset(['password', 'password_confirmation']);
            
            // Message de succès
            session()->flash('message', "L'utilisateur a été mis à jour avec succès.");
            
            // Rediriger vers la liste des utilisateurs
            return redirect()->route('users.index');
            
        } catch (\Exception $e) {
            session()->flash('error', "Erreur lors de la mise à jour de l'utilisateur: " . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.users.edit-user', [
            'roles' => Role::all(),
        ]);
    }
}