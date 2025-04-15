<div>
    <form wire:submit.prevent="create">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-6">{{ __('Nouvelle Donnée de Référence') }}</h2>
                
                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                <!-- Sélection du type -->
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <input wire:model="isNewType" wire:change="updatedIsNewType" type="checkbox" id="isNewType" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="isNewType" class="ml-2 block text-sm text-gray-700">{{ __('Créer un nouveau type') }}</label>
                    </div>
                    
                    @if($isNewType)
                        <div>
                            <label for="newType" class="block text-sm font-medium text-gray-700">{{ __('Nouveau Type') }}</label>
                            <input wire:model="newType" type="text" id="newType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('newType') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                            <select wire:model="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('Sélectionner un type') }}</option>
                                @foreach($types as $typeOption)
                                    <option value="{{ $typeOption }}">{{ $typeOption }}</option>
                                @endforeach
                            </select>
                            @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
                
                <!-- Valeur -->
                <div class="mb-4">
                    <label for="value" class="block text-sm font-medium text-gray-700">{{ __('Valeur') }}</label>
                    <input wire:model="value" type="text" id="value" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('value') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Libellé -->
                <div class="mb-4">
                    <label for="label" class="block text-sm font-medium text-gray-700">{{ __('Libellé') }}</label>
                    <input wire:model="label" type="text" id="label" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('label') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                    <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Ordre -->
                <div class="mb-4">
                    <label for="order" class="block text-sm font-medium text-gray-700">{{ __('Ordre') }}</label>
                    <input wire:model="order" type="number" id="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('order') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Actif -->
                <div class="mb-4 flex items-center">
                    <input wire:model="active" type="checkbox" id="active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="active" class="ml-2 block text-sm text-gray-700">{{ __('Actif') }}</label>
                </div>
                
                <!-- Sélection multiple -->
                <div class="mb-4 flex items-center">
                    <input wire:model="is_multiple" type="checkbox" id="is_multiple" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="is_multiple" class="ml-2 block text-sm text-gray-700">{{ __('Permettre la sélection multiple') }}</label>
                </div>
                
                <!-- Buttons -->
                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('reference-data.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                        {{ __('Annuler') }}
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        {{ __('Créer') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>