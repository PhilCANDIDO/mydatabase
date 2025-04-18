<div>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Barre latérale des familles de produits -->
        <div class="w-full md:w-64 bg-white shadow-sm rounded-lg p-4">
            <h3 class="font-medium text-lg mb-3">{{ __('Familles de produits') }}</h3>
            <div class="space-y-2">
                @foreach($allFamilies as $fam)
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="family-{{ $fam->id }}" 
                               wire:model.live="selectedFamilies"
                               value="{{ $fam->id }}"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="family-{{ $fam->id }}" 
                               class="ml-2 py-2 block text-sm font-medium text-gray-900 cursor-pointer">
                            {{ $fam->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            @if($allFamilies->count() > 0)
                <div class="mt-6 border-t pt-4">
                    <h3 class="font-medium text-lg mb-3">{{ __('Actions') }}</h3>
                    <ul class="space-y-2">
                        @can('import data')
                        <li>
                            <button id="importDropdownButton" data-dropdown-toggle="importDropdown" class="flex items-center w-full py-2 px-3 rounded hover:bg-gray-100" type="button">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                {{ __('Importer') }}
                                <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="importDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="importDropdownButton">
                                    @foreach($allFamilies as $fam)
                                    <li>
                                        <a href="{{ route('products.import', $fam->code) }}" class="block px-4 py-2 hover:bg-gray-100">{{ $fam->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endcan
                        
                        @can('export data')
                        <li>
                            <button id="exportDropdownButton" data-dropdown-toggle="exportDropdown" class="flex items-center w-full py-2 px-3 rounded hover:bg-gray-100" type="button">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                {{ __('Exporter') }}
                                <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="exportDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="exportDropdownButton">
                                    @foreach($allFamilies as $fam)
                                    <li>
                                        <a href="{{ route('products.export', $fam->code) }}" class="block px-4 py-2 hover:bg-gray-100">{{ $fam->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endcan
                    </ul>
                </div>
            @endif
        </div>
        
        <!-- Contenu du tableau -->
        <div class="flex-grow bg-white shadow-sm rounded-lg p-0">
            <!-- En-tête de recherche et de filtrage -->
            <div class="p-4 border-b">
                <div class="flex flex-col lg:flex-row space-y-3 lg:space-y-0 lg:space-x-3">
                    <div class="flex-grow">
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Rechercher...') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div class="flex space-x-2">
                        <!-- Sélection du nombre d'éléments par page -->
                        <select wire:model.live="perPage" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        
                        <!-- Bouton pour afficher le sélecteur de colonnes -->
                        <button type="button" wire:click="toggleColumnSelector"
                                class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                {{ __('Colonnes') }}
                            </span>
                        </button>
                        
                        <!-- Bouton pour les filtres avancés -->
                        <button type="button" x-data="{}" x-on:click="$dispatch('open-modal', 'filter-modal')"
                                class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                {{ __('Filtres') }}
                            </span>
                        </button>
                    </div>
                </div>
                
                <!-- Information sur les familles sélectionnées -->
                @if(!empty($selectedFamilies))
                    <div class="mt-2 text-sm text-gray-500">
                        {{ __('Familles affichées') }}: 
                        @foreach($allFamilies->whereIn('id', $selectedFamilies) as $fam)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $fam->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                
                <!-- Sélecteur de colonnes -->
                @if($showColumnSelector)
                <div class="mt-3 p-3 bg-gray-50 rounded-md">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-medium text-gray-700">{{ __('Colonnes visibles') }}</h3>
                        <button wire:click="resetColumns" class="text-sm text-blue-600 hover:text-blue-800">
                            {{ __('Réinitialiser') }}
                        </button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                        <!-- Colonnes de base -->
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('type')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('type', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Type') }}</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('nom')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('nom', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Nom') }}</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('marque')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('marque', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Marque') }}</span>
                        </label>
                        
                        <!-- Colonnes produits spécifiques -->
                        @if(in_array('specific_attributes->application', $availableColumns))
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('specific_attributes->application')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('specific_attributes->application', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Application') }}</span>
                        </label>
                        @endif
                        
                        @if(in_array('date_sortie', $availableColumns))
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('date_sortie')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('date_sortie', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Année') }}</span>
                        </label>
                        @endif
                        
                        @if(in_array('zone_geographique', $availableColumns))
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('zone_geographique')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('zone_geographique', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Zone Géographique') }}</span>
                        </label>
                        @endif
                        
                        @if(in_array('famille_olfactive', $availableColumns))
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('famille_olfactive')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('famille_olfactive', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Famille Olfactive') }}</span>
                        </label>
                        @endif
                        
                        <!-- Notes olfactives -->
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('notes_tete_1')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('notes_tete_1', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Note de tête 1') }}</span>
                        </label>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('notes_tete_2')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('notes_tete_2', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Note de tête 2') }}</span>
                        </label>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('notes_coeur_1')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('notes_coeur_1', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Note de cœur 1') }}</span>
                        </label>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('notes_coeur_2')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('notes_coeur_2', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Note de cœur 2') }}</span>
                        </label>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('notes_fond_1')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('notes_fond_1', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Note de fond 1') }}</span>
                        </label>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('notes_fond_2')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('notes_fond_2', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Note de fond 2') }}</span>
                        </label>
                        
                        @if(in_array('unisex', $availableColumns))
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('unisex')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('unisex', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Unisex') }}</span>
                        </label>
                        @endif
                        
                        @if(in_array('specific_attributes->genre', $availableColumns))
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('specific_attributes->genre')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('specific_attributes->genre', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Genre') }}</span>
                        </label>
                        @endif
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                wire:click="toggleColumnVisibility('avatar')"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ in_array('avatar', $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ __('Avatar') }}</span>
                        </label>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Tableau des produits -->
            @if($products && $products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- En-têtes des colonnes visibles -->
                            @foreach($visibleColumns as $column)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('{{ $column }}')">
                                    <div class="flex items-center">
                                        {{ $columnLabels[$column] ?? $column }}
                                        @if($sortField === $column)
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                @if($sortDirection === 'asc')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                @endif
                                            </svg>
                                        @endif
                                    </div>
                                </th>
                            @endforeach
                            
                            <!-- Actions -->
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                            <tr>
                                <!-- Cellules pour les colonnes visibles -->
                                @foreach($visibleColumns as $column)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $column === 'type' ? 'font-medium text-gray-900' : 'text-gray-500' }}">
                                        @if($column === 'avatar' && $product->avatar)
                                            <img src="{{ Storage::url($product->avatar) }}" alt="{{ $product->nom }}" class="h-10 w-10 rounded-full object-cover">
                                        @elseif($column === 'unisex')
                                            {!! $product->unisex ? '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Oui</span>' : '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Non</span>' !!}
                                        @elseif(strpos($column, 'notes_tete_') === 0)
                                            @php 
                                                $position = 'tete';
                                                $order = substr($column, strlen('notes_tete_'));
                                                $note = $product->olfactiveNotes()
                                                        ->where('position', $position)
                                                        ->where('order', $order)
                                                        ->first();
                                            @endphp
                                            {{ $note ? $note->getFormattedLabel() : '' }}
                                        @elseif(strpos($column, 'notes_coeur_') === 0)
                                            @php 
                                                $position = 'coeur';
                                                $order = substr($column, strlen('notes_coeur_'));
                                                $note = $product->olfactiveNotes()
                                                        ->where('position', $position)
                                                        ->where('order', $order)
                                                        ->first();
                                            @endphp
                                            {{ $note ? $note->getFormattedLabel() : '' }}
                                        @elseif(strpos($column, 'notes_fond_') === 0)
                                            @php 
                                                $position = 'fond';
                                                $order = substr($column, strlen('notes_fond_'));
                                                $note = $product->olfactiveNotes()
                                                        ->where('position', $position)
                                                        ->where('order', $order)
                                                        ->first();
                                            @endphp
                                            {{ $note ? $note->getFormattedLabel() : '' }}
                                        @elseif(strpos($column, 'specific_attributes->') === 0)
                                            @php
                                                $attributeKey = str_replace('specific_attributes->', '', $column);
                                                $value = data_get($product->specific_attributes, $attributeKey);
                                            @endphp
                                            
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ $value ?? '' }}
                                            @endif
                                        @else
                                            @if(is_array($product->{$column} ?? null))
                                                {{ implode(', ', $product->{$column}) }}
                                            @else
                                                {{ $product->{$column} ?? '' }}
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                                
                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @php
                                        $productFamily = $allFamilies->firstWhere('id', $product->product_family_id);
                                        $familyCode = $productFamily ? $productFamily->code : '';
                                    @endphp
                                    
                                    @can('view data')
                                        <a href="{{ route('products.show', [$familyCode, $product->id]) }}" 
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            {{ __('Voir') }}
                                        </a>
                                    @endcan
                                    
                                    @can('edit data')
                                        <a href="{{ route('products.edit', [$familyCode, $product->id]) }}" 
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            {{ __('Éditer') }}
                                        </a>
                                    @endcan
                                    
                                    @can('delete data')
                                        <button wire:click="confirmDelete({{ $product->id }}, '{{ $product->nom }}')" 
                                                class="text-red-600 hover:text-red-900">
                                            {{ __('Supprimer') }}
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                
                <!-- Pagination -->
                <div class="px-4 py-3 border-t">
                    {{ $products->links() }}
                </div>
            @elseif(empty($selectedFamilies))
                <div class="p-6 flex justify-center items-center">
                    <p class="text-gray-500 text-lg">{{ __('Veuillez sélectionner au moins une famille de produits') }}</p>
                </div>
            @else
                <div class="p-6 flex justify-center items-center">
                    <p class="text-gray-500 text-lg">{{ __('Aucun produit trouvé') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>