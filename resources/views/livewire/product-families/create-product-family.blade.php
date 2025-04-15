<!-- resources/views/livewire/product-families/create-product-family.blade.php -->
<div>
    <form wire:submit.prevent="create">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-6">{{ __('Nouvelle Famille de Produits') }}</h2>
                
                <!-- Code -->
                <div class="mb-4">
                    <label for="familyCode" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                    <input wire:model="familyCode" type="text" id="familyCode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('familyCode') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Nom -->
                <div class="mb-4">
                    <label for="familyName" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
                    <input wire:model="familyName" type="text" id="familyName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('familyName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <label for="familyDescription" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                    <textarea wire:model="familyDescription" id="familyDescription" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('familyDescription') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Active -->
                <div class="mb-4 flex items-center">
                    <input wire:model="familyActive" type="checkbox" id="familyActive" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="familyActive" class="ml-2 block text-sm text-gray-700">{{ __('Active') }}</label>
                </div>
                
                <!-- Buttons -->
                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('product-families.index') }}" 
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