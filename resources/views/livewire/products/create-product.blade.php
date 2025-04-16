<!-- resources/views/livewire/products/create-product.blade.php -->
<div>
    <form wire:submit.prevent="create">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Nouveau produit') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('Famille') }}: {{ $family->name }}</p>
            </div>
            
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <!-- Champs communs à toutes les familles -->
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="nom" class="block text-sm font-medium text-gray-700">{{ __('Nom') }} *</label>
                        <div class="mt-1">
                            <input type="text" wire:model="product.nom" id="nom" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('product.nom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="marque" class="block text-sm font-medium text-gray-700">{{ __('Marque') }}</label>
                        <div class="mt-1">
                            <input type="text" wire:model="product.marque" id="marque" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('product.marque') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Champs spécifiques selon la famille -->
                    @if($family->code != 'W')
                        <div class="sm:col-span-3">
                            <label for="zone_geographique" class="block text-sm font-medium text-gray-700">{{ __('Zone Géographique') }}</label>
                            <div class="mt-1">
                                <select wire:model="product.zone_geographique" id="zone_geographique" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">{{ __('Sélectionner...') }}</option>
                                    @foreach($referenceData['zone_geographique'] as $zone)
                                        <option value="{{ $zone->value }}">{{ $zone->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product.zone_geographique') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="famille_olfactive" class="block text-sm font-medium text-gray-700">{{ __('Famille Olfactive') }}</label>
                            <div class="mt-1">
                                <select wire:model="product.famille_olfactive" id="famille_olfactive" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">{{ __('Sélectionner...') }}</option>
                                    @foreach($referenceData['famille_olfactive'] as $famille)
                                        <option value="{{ $famille->value }}">{{ $famille->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product.famille_olfactive') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Notes de tête -->
                        <div class="sm:col-span-3">
                            <label for="description_olfactive_tete_1" class="block text-sm font-medium text-gray-700">{{ __('Note de tête 1') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="product.description_olfactive_tete_1" id="description_olfactive_tete_1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.description_olfactive_tete_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="description_olfactive_tete_2" class="block text-sm font-medium text-gray-700">{{ __('Note de tête 2') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="product.description_olfactive_tete_2" id="description_olfactive_tete_2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.description_olfactive_tete_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Notes de cœur -->
                        <div class="sm:col-span-3">
                            <label for="description_olfactive_coeur_1" class="block text-sm font-medium text-gray-700">{{ __('Note de cœur 1') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="product.description_olfactive_coeur_1" id="description_olfactive_coeur_1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.description_olfactive_coeur_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="description_olfactive_coeur_2" class="block text-sm font-medium text-gray-700">{{ __('Note de cœur 2') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="product.description_olfactive_coeur_2" id="description_olfactive_coeur_2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.description_olfactive_coeur_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Notes de fond -->
                        <div class="sm:col-span-3">
                            <label for="description_olfactive_fond_1" class="block text-sm font-medium text-gray-700">{{ __('Note de fond 1') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="product.description_olfactive_fond_1" id="description_olfactive_fond_1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.description_olfactive_fond_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="description_olfactive_fond_2" class="block text-sm font-medium text-gray-700">{{ __('Note de fond 2') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="product.description_olfactive_fond_2" id="description_olfactive_fond_2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.description_olfactive_fond_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    
                    <!-- Champs spécifiques à certaines familles -->
                    @if(in_array($family->code, ['D', 'M', 'U']))
                        <div class="sm:col-span-3">
                            <label for="date_sortie" class="block text-sm font-medium text-gray-700">{{ __('Année de sortie') }}</label>
                            <div class="mt-1">
                                <input type="number" wire:model="product.date_sortie" id="date_sortie" min="1900" max="{{ date('Y') + 1 }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('product.date_sortie') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    
                    @if($family->code == 'PM')
                        <div class="sm:col-span-3">
                            <label for="application" class="block text-sm font-medium text-gray-700">{{ __('Application') }}</label>
                            <div class="mt-1">
                                <select wire:model="specific_attributes.application" id="application" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">{{ __('Sélectionner...') }}</option>
                                    @foreach($referenceData['application'] as $app)
                                        <option value="{{ $app->value }}">{{ $app->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('specific_attributes.application') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    
                    @if($family->code == 'U')
                        <div class="sm:col-span-3">
                            <label for="genre" class="block text-sm font-medium text-gray-700">{{ __('Genre') }}</label>
                            <div class="mt-1">
                                <select wire:model="specific_attributes.genre" id="genre" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">{{ __('Sélectionner...') }}</option>
                                    <option value="Masculin">{{ __('Masculin') }}</option>
                                    <option value="Féminin">{{ __('Féminin') }}</option>
                                </select>
                            </div>
                            @error('specific_attributes.genre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    
                    @if(in_array($family->code, ['D', 'M']))
                        <div class="sm:col-span-3">
                            <div class="flex items-start mt-6">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" wire:model="product.unisex" id="unisex" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="unisex" class="font-medium text-gray-700">{{ __('Unisex') }}</label>
                                </div>
                            </div>
                            @error('product.unisex') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    
                    <!-- Image du produit -->
                    <div class="sm:col-span-6">
                        <label for="avatar" class="block text-sm font-medium text-gray-700">{{ __('Image du produit') }}</label>
                        <div class="mt-1">
                            <input type="file" wire:model="avatar" id="avatar" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300">
                        </div>
                        @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('products.family.index', $family->code) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                    {{ __('Annuler') }}
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Enregistrer') }}
                </button>
            </div>
        </div>
    </form>
</div>