<div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Colonne de gauche: Familles de produits & Actions -->
        <div class="lg:col-span-1">
            <!-- Section Familles de produits -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="p-4 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">{{ __('Familles de produits') }}</h3>
                    <div class="space-y-2">
                        @foreach($productFamilies as $family)
                            <div class="flex items-center">
                                <input type="checkbox" id="family-{{ $family->id }}" 
                                    wire:model.live="selectedFamilies" 
                                    value="{{ $family->id }}"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="family-{{ $family->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $family->product_family_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Section Actions -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">{{ __('Actions') }}</h3>
                    <div class="space-y-3">
                        @can('import data')
                        <button type="button" class="w-full flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                            {{ __('Importer') }}
                        </button>
                        @endcan

                        @can('export data')
                        <button type="button" class="w-full flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            {{ __('Exporter') }}
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite: Tableau des produits avec ses outils -->
        <div class="lg:col-span-3">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Barre d'outils du tableau -->
                    <div class="flex flex-col sm:flex-row justify-between mb-4 space-y-3 sm:space-y-0 sm:space-x-4">
                        <div class="w-full sm:w-1/2">
                            <input wire:model.live.debounce.300ms="search" type="text" 
                                placeholder="{{ __('Rechercher par type, nom ou marque...') }}" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <select wire:model.live="perPage" class="rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            
                            <!-- Bouton Colonnes -->
                            <button wire:click="toggleColumnsPanel" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                </svg>
                                <span class="ml-1">{{ __('Colonnes') }}</span>
                            </button>
                            
                            <!-- Bouton Filtres -->
                            <button wire:click="toggleFiltersPanel" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                <span class="ml-1">{{ __('Filtres') }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Affichage des familles sélectionnées -->
                    <div class="mb-4">
                        <div class="flex flex-wrap items-center mb-2">
                            <span class="text-sm text-gray-700 mr-2">{{ __('Familles affichées:') }}</span>
                            @foreach($displayedFamilies as $family)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 mr-2 mb-1">
                                    {{ $family->product_family_name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Panneau de sélection des colonnes -->
                    @if($showColumnsPanel)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-700">{{ __('Colonnes visibles') }}</h3>
                            <button wire:click="resetColumns" class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ __('Réinitialiser') }}
                            </button>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="col-type" wire:model.live="visibleColumns.product_type" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-type" class="ml-2 text-sm text-gray-700">{{ __('Type') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-name" wire:model.live="visibleColumns.product_name" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-name" class="ml-2 text-sm text-gray-700">{{ __('Nom') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-marque" wire:model.live="visibleColumns.product_marque" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-marque" class="ml-2 text-sm text-gray-700">{{ __('Marque') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-application" wire:model.live="visibleColumns.application_id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-application" class="ml-2 text-sm text-gray-700">{{ __('Application') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-annee" wire:model.live="visibleColumns.product_annee_sortie" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-annee" class="ml-2 text-sm text-gray-700">{{ __('Année de sortie') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-zone" wire:model.live="visibleColumns.zone_geo" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-zone" class="ml-2 text-sm text-gray-700">{{ __('Zone Géographique') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-olfactive" wire:model.live="visibleColumns.olfactive_family" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-olfactive" class="ml-2 text-sm text-gray-700">{{ __('Famille Olfactive') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-unisex" wire:model.live="visibleColumns.product_unisex" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-unisex" class="ml-2 text-sm text-gray-700">{{ __('Unisex') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-avatar" wire:model.live="visibleColumns.product_avatar" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-avatar" class="ml-2 text-sm text-gray-700">{{ __('Avatar') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-genre" wire:model.live="visibleColumns.product_genre" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-genre" class="ml-2 text-sm text-gray-700">{{ __('Genre') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-head1" wire:model.live="visibleColumns.head_note_1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-head1" class="ml-2 text-sm text-gray-700">{{ __('Note de tête 1') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-head2" wire:model.live="visibleColumns.head_note_2" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-head2" class="ml-2 text-sm text-gray-700">{{ __('Note de tête 2') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-heart1" wire:model.live="visibleColumns.heart_note_1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-heart1" class="ml-2 text-sm text-gray-700">{{ __('Note de cœur 1') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-heart2" wire:model.live="visibleColumns.heart_note_2" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-heart2" class="ml-2 text-sm text-gray-700">{{ __('Note de cœur 2') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-base1" wire:model.live="visibleColumns.base_note_1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-base1" class="ml-2 text-sm text-gray-700">{{ __('Note de fond 1') }}</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="col-base2" wire:model.live="visibleColumns.base_note_2" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="col-base2" class="ml-2 text-sm text-gray-700">{{ __('Note de fond 2') }}</label>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Panneau de filtres avancés -->
                    @if($showFiltersPanel)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-700">{{ __('Filtres avancés') }}</h3>
                            <button wire:click="resetFilters" class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ __('Réinitialiser') }}
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Application -->
                            <div>
                                <label for="filter-application" class="block text-sm font-medium text-gray-700">{{ __('Application') }}</label>
                                <select id="filter-application" wire:model.live="filters.application_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Toutes les applications') }}</option>
                                    @foreach($applications as $application)
                                        <option value="{{ $application->id }}">{{ $application->application_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Année de sortie -->
                            <div>
                                <label for="filter-annee" class="block text-sm font-medium text-gray-700">{{ __('Année de sortie') }}</label>
                                <input type="number" id="filter-annee" wire:model.live="filters.product_annee_sortie" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ __('Année...') }}">
                            </div>
                            
                            <!-- Zone Géographique -->
                            <div>
                                <label for="filter-zone" class="block text-sm font-medium text-gray-700">{{ __('Zone Géographique') }}</label>
                                <select id="filter-zone" wire:model.live="filters.zone_geo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Toutes les zones') }}</option>
                                    @foreach($zoneGeos as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->zone_geo_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Famille Olfactive -->
                            <div>
                                <label for="filter-olfactive" class="block text-sm font-medium text-gray-700">{{ __('Famille Olfactive') }}</label>
                                <select id="filter-olfactive" wire:model.live="filters.olfactive_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Toutes les familles') }}</option>
                                    @foreach($olfactiveFamilies as $family)
                                        <option value="{{ $family->id }}">{{ $family->olfactive_family_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Unisex -->
                            <div>
                                <label for="filter-unisex" class="block text-sm font-medium text-gray-700">{{ __('Unisex') }}</label>
                                <select id="filter-unisex" wire:model.live="filters.product_unisex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Tous') }}</option>
                                    <option value="1">{{ __('Oui') }}</option>
                                    <option value="0">{{ __('Non') }}</option>
                                </select>
                            </div>
                            
                            <!-- Genre -->
                            <div>
                                <label for="filter-genre" class="block text-sm font-medium text-gray-700">{{ __('Genre') }}</label>
                                <select id="filter-genre" wire:model.live="filters.product_genre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Tous') }}</option>
                                    <option value="M">{{ __('Masculin') }}</option>
                                    <option value="F">{{ __('Féminin') }}</option>
                                </select>
                            </div>
                            
                            <!-- Notes Olfactives -->
                            <div>
                                <label for="filter-head-note" class="block text-sm font-medium text-gray-700">{{ __('Note de tête') }}</label>
                                <select id="filter-head-note" wire:model.live="filters.head_note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Toutes') }}</option>
                                    @foreach($olfactiveNotes as $note)
                                        <option value="{{ $note->id }}">{{ $note->olfactive_note_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="filter-heart-note" class="block text-sm font-medium text-gray-700">{{ __('Note de cœur') }}</label>
                                <select id="filter-heart-note" wire:model.live="filters.heart_note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Toutes') }}</option>
                                    @foreach($olfactiveNotes as $note)
                                        <option value="{{ $note->id }}">{{ $note->olfactive_note_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="filter-base-note" class="block text-sm font-medium text-gray-700">{{ __('Note de fond') }}</label>
                                <select id="filter-base-note" wire:model.live="filters.base_note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">{{ __('Toutes') }}</option>
                                    @foreach($olfactiveNotes as $note)
                                        <option value="{{ $note->id }}">{{ $note->olfactive_note_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Tableau des produits -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if($visibleColumns['product_type'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_type')">
                                        {{ __('Type') }}
                                        @if($sortField === 'product_type')
                                            <span>
                                                @if($sortDirection === 'asc')
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['product_name'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_name')">
                                        {{ __('Nom') }}
                                        @if($sortField === 'product_name')
                                            <span>
                                                @if($sortDirection === 'asc')
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['product_marque'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_marque')">
                                        {{ __('Marque') }}
                                        @if($sortField === 'product_marque')
                                            <span>
                                                @if($sortDirection === 'asc')
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['zone_geo'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Zone Géographique') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['olfactive_family'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Famille Olfactive') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['product_annee_sortie'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_annee_sortie')">
                                        {{ __('Année') }}
                                        @if($sortField === 'product_annee_sortie')
                                            <span>
                                                @if($sortDirection === 'asc')
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['product_unisex'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Unisex') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['product_genre'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Genre') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['head_note_1'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Note de tête 1') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['head_note_2'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Note de tête 2') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['heart_note_1'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Note de cœur 1') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['heart_note_2'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Note de cœur 2') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['base_note_1'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Note de fond 1') }}
                                    </th>
                                    @endif
                                    
                                    @if($visibleColumns['base_note_2'])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Note de fond 2') }}
                                    </th>
                                    @endif
                                    
                                    <!-- Actions -->
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($products as $product)
                                    <tr>
                                        @if($visibleColumns['product_type'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 cursor-pointer hover:text-blue-600" wire:click="copyToClipboard('{{ $product->product_type }}')">
                                                {{ $product->product_type }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['product_name'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->product_name }}</div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['product_marque'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->product_marque }}</div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['zone_geo'])
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                @foreach($product->zoneGeos as $zone)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                                        {{ $zone->zone_geo_name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['olfactive_family'])
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                @foreach($product->olfactiveFamilies as $family)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-1">
                                                        {{ $family->olfactive_family_name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['product_annee_sortie'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->product_annee_sortie }}</div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['product_unisex'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->product_unisex)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ __('Oui') }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ __('Non') }}
                                                </span>
                                            @endif
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['product_genre'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($product->product_genre === 'M')
                                                    {{ __('Masculin') }}
                                                @elseif($product->product_genre === 'F')
                                                    {{ __('Féminin') }}
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                        
                                        <!-- Notes olfactives -->
                                        @php
                                            $headNotes = $product->olfactiveNotes()->where('olfactive_note_position', 'head')->orderBy('olfactive_note_order')->get();
                                            $heartNotes = $product->olfactiveNotes()->where('olfactive_note_position', 'heart')->orderBy('olfactive_note_order')->get();
                                            $baseNotes = $product->olfactiveNotes()->where('olfactive_note_position', 'base')->orderBy('olfactive_note_order')->get();
                                        @endphp
                                        
                                        @if($visibleColumns['head_note_1'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $headNotes->isNotEmpty() && isset($headNotes[0]) ? $headNotes[0]->olfactive_note_name : '' }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['head_note_2'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $headNotes->isNotEmpty() && isset($headNotes[1]) ? $headNotes[1]->olfactive_note_name : '' }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['heart_note_1'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $heartNotes->isNotEmpty() && isset($heartNotes[0]) ? $heartNotes[0]->olfactive_note_name : '' }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['heart_note_2'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $heartNotes->isNotEmpty() && isset($heartNotes[1]) ? $heartNotes[1]->olfactive_note_name : '' }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['base_note_1'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $baseNotes->isNotEmpty() && isset($baseNotes[0]) ? $baseNotes[0]->olfactive_note_name : '' }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        @if($visibleColumns['base_note_2'])
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $baseNotes->isNotEmpty() && isset($baseNotes[1]) ? $baseNotes[1]->olfactive_note_name : '' }}
                                            </div>
                                        </td>
                                        @endif
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                {{ __('Voir') }}
                                            </a>
                                            
                                            @can('edit data')
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                {{ __('Modifier') }}
                                            </a>
                                            @endcan
                                            
                                            @can('delete data')
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce produit ?') }}')">
                                                    {{ __('Supprimer') }}
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="20" class="px-6 py-4 text-center text-sm text-gray-500">
                                            {{ __('Aucun produit trouvé.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                {{ __('Showing') }} {{ $products->firstItem() ?? 0 }} {{ __('to') }} {{ $products->lastItem() ?? 0 }} {{ __('of') }} {{ $products->total() }} {{ __('results') }}
                            </div>
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript pour la fonctionnalité de copie dans le presse-papiers -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('copy-to-clipboard', ({ text }) => {
                navigator.clipboard.writeText(text)
                    .then(() => {
                        // Montrer une notification de succès
                        const notification = document.createElement('div');
                        notification.classList.add('fixed', 'bottom-4', 'right-4', 'bg-green-500', 'text-white', 'px-4', 'py-2', 'rounded', 'shadow-lg', 'z-50');
                        notification.textContent = '{{ __("Copié dans le presse-papiers !") }}';
                        document.body.appendChild(notification);
                        
                        // Supprimer la notification après 2 secondes
                        setTimeout(() => {
                            notification.remove();
                        }, 2000);
                    })
                    .catch(err => {
                        console.error('Erreur lors de la copie: ', err);
                    });
            });
        });
    </script>
</div>