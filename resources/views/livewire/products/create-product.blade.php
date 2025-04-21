<div class="p-6 bg-white border-b border-gray-200">
    <form wire:submit="create">
        <!-- Section Famille du produit -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations de base') }}</h3>
            
            <div class="mb-4">
                <label for="selectedFamily" class="block text-sm font-medium text-gray-700">{{ __('Famille de produit') }} *</label>
                <select id="selectedFamily" wire:model.live="selectedFamily" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('Sélectionner une famille') }}</option>
                    @foreach($productFamilies as $family)
                        <option value="{{ $family->id }}">{{ $family->product_family_name }} ({{ $family->product_family_code }})</option>
                    @endforeach
                </select>
                @error('selectedFamily') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            @if($selectedFamily)
                <div class="mb-4">
                    <label for="product_type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                    <input type="text" id="product_type" wire:model="product_type" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                    <p class="mt-1 text-xs text-gray-500">{{ __('Le type est généré automatiquement.') }}</p>
                </div>
                
                <div class="mb-4">
                    <label for="product_name" class="block text-sm font-medium text-gray-700">{{ __('Nom') }} *</label>
                    <input type="text" id="product_name" wire:model="product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('product_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="product_marque" class="block text-sm font-medium text-gray-700">{{ __('Marque') }}</label>
                    <input type="text" id="product_marque" wire:model="product_marque" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('product_marque') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <!-- Champs conditionnels selon le type de famille -->
                @if($selectedFamilyCode === 'PM')
                    <div class="mb-4">
                        <label for="application_id" class="block text-sm font-medium text-gray-700">{{ __('Application') }} *</label>
                        <select id="application_id" wire:model="application_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">{{ __('Sélectionner une application') }}</option>
                            @foreach($applications as $application)
                                <option value="{{ $application->id }}">{{ $application->application_name }}</option>
                            @endforeach
                        </select>
                        @error('application_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                @endif
                
                @if(in_array($selectedFamilyCode, ['D', 'M', 'U']))
                    <div class="mb-4">
                        <label for="product_annee_sortie" class="block text-sm font-medium text-gray-700">{{ __('Année de sortie') }}</label>
                        <input type="number" id="product_annee_sortie" wire:model="product_annee_sortie" min="1900" max="{{ date('Y') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('product_annee_sortie') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                @endif
                
                @if(in_array($selectedFamilyCode, ['D', 'M']))
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="product_unisex" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Unisex') }}</span>
                        </label>
                        @error('product_unisex') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                @endif
                
                @if($selectedFamilyCode === 'U')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Genre') }} *</label>
                        <div class="mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="product_genre" value="M" class="form-radio text-indigo-600">
                                <span class="ml-2">{{ __('Masculin') }}</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="product_genre" value="F" class="form-radio text-indigo-600">
                                <span class="ml-2">{{ __('Féminin') }}</span>
                            </label>
                        </div>
                        @error('product_genre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                @endif
                
                <!-- Upload de l'avatar -->
                <div class="mb-4">
                    <label for="product_avatar" class="block text-sm font-medium text-gray-700">{{ __('Avatar du produit') }}</label>
                    <input type="file" id="product_avatar" wire:model="product_avatar" class="mt-1 block w-full" accept="image/*">
                    @error('product_avatar') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    
                    @if($product_avatar)
                        <div class="mt-2">
                            <img src="{{ $product_avatar->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg shadow">
                        </div>
                    @endif
                </div>
                
                <!-- Sections additionnelles pour les familles autres que Solinote (W) -->
                @if($selectedFamilyCode !== 'W')
                    <!-- Section Zones Géographiques -->
                    <div class="mt-8 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Zones Géographiques') }}</h3>
                        
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                            @foreach($zoneGeos as $zone)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" value="{{ $zone->id }}" wire:model="selectedZoneGeos" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ $zone->zone_geo_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Section Familles Olfactives -->
                    <div class="mt-8 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Familles Olfactives') }}</h3>
                        
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                            @foreach($olfactiveFamilies as $family)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" value="{{ $family->id }}" wire:model="selectedOlfactiveFamilies" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ $family->olfactive_family_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                   <!-- Section Notes Olfactives avec dropdown-list recherchable -->
                    <div class="mt-8 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Notes Olfactives') }}</h3>
                        
                        <!-- Notes de tête -->
                        <div class="mb-6">
                            <h4 class="text-base font-medium text-gray-800 mb-3">{{ __('Notes de tête') }}</h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @foreach($headNotes as $index => $note)
                                    <div>
                                        <x-filter-dropdown 
                                            id="head-note-{{ $index }}"
                                            label="{{ __('Note') }} {{ $index + 1 }}"
                                            :options="$olfactiveNotes"
                                            placeholder="{{ __('Rechercher une note de tête...') }}"
                                            :selected="$headNotes[$index]['id']"
                                            displayKey="olfactive_note_name"
                                            valueKey="id"
                                            wireModel="headNotes.{{ $index }}.id"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Notes de cœur -->
                        <div class="mb-6">
                            <h4 class="text-base font-medium text-gray-800 mb-3">{{ __('Notes de cœur') }}</h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @foreach($heartNotes as $index => $note)
                                    <div>
                                        <x-filter-dropdown 
                                            id="heart-note-{{ $index }}"
                                            label="{{ __('Note') }} {{ $index + 1 }}"
                                            :options="$olfactiveNotes"
                                            placeholder="{{ __('Rechercher une note de cœur...') }}"
                                            :selected="$heartNotes[$index]['id']"
                                            displayKey="olfactive_note_name"
                                            valueKey="id"
                                            wireModel="heartNotes.{{ $index }}.id"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Notes de fond -->
                        <div>
                            <h4 class="text-base font-medium text-gray-800 mb-3">{{ __('Notes de fond') }}</h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @foreach($baseNotes as $index => $note)
                                    <div>
                                        <x-filter-dropdown 
                                            id="base-note-{{ $index }}"
                                            label="{{ __('Note') }} {{ $index + 1 }}"
                                            :options="$olfactiveNotes"
                                            placeholder="{{ __('Rechercher une note de fond...') }}"
                                            :selected="$baseNotes[$index]['id']"
                                            displayKey="olfactive_note_name"
                                            valueKey="id"
                                            wireModel="baseNotes.{{ $index }}.id"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        
        <div class="flex items-center justify-end mt-6 space-x-3">
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Annuler') }}
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo disabled:opacity-25 transition ease-in-out duration-150"
                    @if(!$selectedFamily) disabled @endif>
                {{ __('Créer') }}
            </button>
        </div>
    </form>
</div>