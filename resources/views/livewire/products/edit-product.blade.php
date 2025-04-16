<div>
    <div class="max-w-7xl mx-auto">
        <form wire:submit.prevent="update">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- En-tête du formulaire -->
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Modifier le produit') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('Famille') }}: {{ $family->name }} | {{ __('Type') }}: {{ $product->type }}</p>
                </div>
                
                <!-- Contenu du formulaire -->
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Champs communs à toutes les familles -->
                        <div class="sm:col-span-3">
                            <label for="nom" class="block text-sm font-medium text-gray-700">{{ __('Nom') }} *</label>
                            <div class="mt-1">
                                <input type="text" wire:model="productData.nom" id="nom" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('productData.nom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-3">
                            <label for="marque" class="block text-sm font-medium text-gray-700">{{ __('Marque') }}</label>
                            <div class="mt-1">
                                <input type="text" wire:model="productData.marque" id="marque" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('productData.marque') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Champs spécifiques selon la famille -->
                        @if($family->code != 'W')
                            <!-- Zone Géographique -->
                            <div class="sm:col-span-6">
                                <label for="zone_geographique" class="block text-sm font-medium text-gray-700">{{ __('Zone Géographique') }}</label>
                                <div class="mt-1">
                                    <select wire:model="zoneGeos" id="zone_geographique" multiple class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        @foreach($referenceData['zone_geographique'] as $zone)
                                            <option value="{{ $zone->value }}">{{ $zone->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ __('Utilisez Ctrl+Clic pour sélectionner plusieurs zones') }}</p>
                                @error('zoneGeos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- Famille Olfactive -->
                            <div class="sm:col-span-6">
                                <label for="famille_olfactive" class="block text-sm font-medium text-gray-700">{{ __('Famille Olfactive') }}</label>
                                <div class="mt-1">
                                    <select wire:model="olfactiveFamilies" id="famille_olfactive" multiple class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        @foreach($referenceData['famille_olfactive'] as $famille)
                                            <option value="{{ $famille->value }}">{{ $famille->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ __('Utilisez Ctrl+Clic pour sélectionner plusieurs familles') }}</p>
                                @error('olfactiveFamilies') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- Notes olfactives - section -->
                            <div class="sm:col-span-6 pt-4">
                                <h4 class="text-md font-medium text-gray-900 mb-3">{{ __('Notes olfactives') }}</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Notes de tête -->
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('Notes de tête') }}</h5>
                                        
                                        <div class="mb-3">
                                            <label for="note_tete_1" class="block text-sm font-medium text-gray-700">{{ __('Note 1') }}</label>
                                            <select wire:model="olfactiveNotes.tete.1" id="note_tete_1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                <option value="">{{ __('Sélectionner...') }}</option>
                                                @foreach($referenceData['description_olfactive'] as $note)
                                                    <option value="{{ $note->value }}">{{ $note->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="note_tete_2" class="block text-sm font-medium text-gray-700">{{ __('Note 2') }}</label>
                                            <select wire:model="olfactiveNotes.tete.2" id="note_tete_2" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                <option value="">{{ __('Sélectionner...') }}</option>
                                                @foreach($referenceData['description_olfactive'] as $note)
                                                    <option value="{{ $note->value }}">{{ $note->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Notes de cœur -->
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('Notes de cœur') }}</h5>
                                        
                                        <div class="mb-3">
                                            <label for="note_coeur_1" class="block text-sm font-medium text-gray-700">{{ __('Note 1') }}</label>
                                            <select wire:model="olfactiveNotes.coeur.1" id="note_coeur_1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                <option value="">{{ __('Sélectionner...') }}</option>
                                                @foreach($referenceData['description_olfactive'] as $note)
                                                    <option value="{{ $note->value }}">{{ $note->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="note_coeur_2" class="block text-sm font-medium text-gray-700">{{ __('Note 2') }}</label>
                                            <select wire:model="olfactiveNotes.coeur.2" id="note_coeur_2" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                <option value="">{{ __('Sélectionner...') }}</option>
                                                @foreach($referenceData['description_olfactive'] as $note)
                                                    <option value="{{ $note->value }}">{{ $note->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Notes de fond -->
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('Notes de fond') }}</h5>
                                        
                                        <div class="mb-3">
                                            <label for="note_fond_1" class="block text-sm font-medium text-gray-700">{{ __('Note 1') }}</label>
                                            <select wire:model="olfactiveNotes.fond.1" id="note_fond_1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                <option value="">{{ __('Sélectionner...') }}</option>
                                                @foreach($referenceData['description_olfactive'] as $note)
                                                    <option value="{{ $note->value }}">{{ $note->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="note_fond_2" class="block text-sm font-medium text-gray-700">{{ __('Note 2') }}</label>
                                            <select wire:model="olfactiveNotes.fond.2" id="note_fond_2" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                <option value="">{{ __('Sélectionner...') }}</option>
                                                @foreach($referenceData['description_olfactive'] as $note)
                                                    <option value="{{ $note->value }}">{{ $note->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Champs spécifiques à certaines familles -->
                        @if(in_array($family->code, ['D', 'M', 'U']))
                            <div class="sm:col-span-3">
                                <label for="date_sortie" class="block text-sm font-medium text-gray-700">{{ __('Année de sortie') }}</label>
                                <div class="mt-1">
                                    <input type="number" wire:model="productData.date_sortie" id="date_sortie" min="1900" max="{{ date('Y') + 1 }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @error('productData.date_sortie') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        
                        @if($family->code == 'PM')
                            <div class="sm:col-span-3">
                                <label for="application" class="block text-sm font-medium text-gray-700">{{ __('Application') }} *</label>
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
                                <label for="genre" class="block text-sm font-medium text-gray-700">{{ __('Genre') }} *</label>
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
                                        <input type="checkbox" wire:model="productData.unisex" id="unisex" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="unisex" class="font-medium text-gray-700">{{ __('Unisex') }}</label>
                                        <p class="text-gray-500">{{ __('Cochez cette case si ce parfum peut être utilisé par les hommes et les femmes') }}</p>
                                    </div>
                                </div>
                                @error('productData.unisex') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        
                        <!-- Image du produit -->
                        <div class="sm:col-span-6">
                            <label for="newAvatar" class="block text-sm font-medium text-gray-700">{{ __('Image du produit') }}</label>
                            @if($product->avatar)
                                <div class="mt-2 mb-4">
                                    <span class="block text-sm text-gray-500 mb-1">{{ __('Image actuelle') }}:</span>
                                    <img src="{{ Storage::url($product->avatar) }}" alt="{{ $product->nom }}" class="h-24 w-auto object-cover rounded-md">
                                </div>
                            @endif
                            
                            <div class="mt-1 flex items-center">
                                <input type="file" wire:model="newAvatar" id="newAvatar" accept="image/*" class="sr-only">
                                <label for="newAvatar" class="relative cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span>{{ $product->avatar ? __('Changer l\'image') : __('Ajouter une image') }}</span>
                                </label>
                                @if ($newAvatar)
                                    <span class="ml-4 text-sm text-gray-500">{{ $newAvatar->getClientOriginalName() }}</span>
                                @endif
                            </div>
                            @error('newAvatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            
                            @if ($newAvatar)
                                <div class="mt-2">
                                    <span class="block text-sm text-gray-500 mb-1">{{ __('Nouvelle image') }}:</span>
                                    <img src="{{ $newAvatar->temporaryUrl() }}" class="h-24 w-auto object-cover rounded-md">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'action -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
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
</div>