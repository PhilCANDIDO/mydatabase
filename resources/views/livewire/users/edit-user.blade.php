<!-- resources/views/livewire/users/edit-user.blade.php -->
<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-6">{{ __('Modifier l\'utilisateur') }}</h2>
    
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif
    
    <form wire:submit.prevent="update">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
            <input wire:model="name" id="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <input wire:model="email" id="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Nouveau mot de passe') }} <span class="text-gray-400 text-xs">({{ __('Laisser vide pour conserver le mot de passe actuel') }})</span></label>
            <input wire:model="password" id="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirmation du nouveau mot de passe') }}</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Rôle') }}</label>
            <select wire:model="selectedRole" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">{{ __('Sélectionnez un rôle') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('selectedRole') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex items-center justify-end mt-6 space-x-3">
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition">
                {{ __('Annuler') }}
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition">
                {{ __('ENREGISTRER') }}
            </button>
        </div>
    </form>
</div>