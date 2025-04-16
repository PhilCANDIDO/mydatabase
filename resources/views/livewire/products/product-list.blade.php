<!-- resources/views/livewire/products/product-list.blade.php -->
<div>
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
        
        <!-- Sélecteur de colonnes (affiché quand showColumnSelector est true) -->
        @if($showColumnSelector)
            <div class="mt-3 p-3 bg-gray-50 rounded-md">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-medium text-gray-700">{{ __('Colonnes visibles') }}</h3>
                    <button wire:click="resetColumns" class="text-sm text-blue-600 hover:text-blue-800">
                        {{ __('Réinitialiser') }}
                    </button>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                    @foreach($availableColumns as $column)
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   wire:click="toggleColumnVisibility('{{ $column }}')"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   {{ in_array($column, $visibleColumns) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ $columnLabels[$column] ?? $column }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    <!-- Modal de filtres (reste inchangé) -->
    <x-modal name="filter-modal" :show="false">
        <!-- Contenu du modal existant -->
    </x-modal>
    
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
                                    @if(strpos($column, 'specific_attributes->') === 0)
                                        {{ data_get($product->specific_attributes, str_replace('specific_attributes->', '', $column)) }}
                                    @else
                                        {{ $product->{$column} }}
                                    @endif
                                </td>
                            @endforeach
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @can('view data')
                                    <a href="#" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3"
                                       x-data="{}"
                                       x-on:click.prevent="$dispatch('open-modal', {id: 'view-product-modal', productId: {{ $product->id }}})">
                                        {{ __('Voir') }}
                                    </a>
                                @endcan
                                
                                @can('edit data')
                                    <a href="{{ route('products.edit', [$family->code, $product->id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        {{ __('Éditer') }}
                                    </a>
                                @endcan
                                
                                @can('delete data')
                                    <button wire:click="$dispatch('openModal', {component: 'products.delete-product-modal', arguments: {productId: {{ $product->id }}, productName: '{{ $product->nom }}'}})" 
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
    @else
        <div class="p-6 flex justify-center items-center">
            <p class="text-gray-500 text-lg">{{ __('Aucun produit trouvé') }}</p>
        </div>
    @endif
</div>