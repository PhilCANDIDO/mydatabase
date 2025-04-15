<div>
    <!-- En-tête de recherche et de filtrage -->
    <div class="p-4 border-b">
        <div class="flex flex-col lg:flex-row space-y-3 lg:space-y-0 lg:space-x-3">
            <div class="flex-grow">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Rechercher...') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            
            <div class="flex space-x-2">
                <select wire:model.live="perPage" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                
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
    </div>
    
    <!-- Modal de filtres -->
    <x-modal name="filter-modal" :show="false">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Filtres avancés') }}</h3>
            
            <div class="space-y-4">
                @if(!empty($referenceData['zone_geographique']))
                <div>
                    <label for="zone_geo_filter" class="block text-sm font-medium text-gray-700">{{ __('Zone géographique') }}</label>
                    <select id="zone_geo_filter" wire:model.live="filters.zone_geographique" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">{{ __('Toutes') }}</option>
                        @foreach($referenceData['zone_geographique'] as $zone)
                            <option value="{{ $zone->value }}">{{ $zone->label }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                
                @if(!empty($referenceData['famille_olfactive']))
                <div>
                    <label for="famille_filter" class="block text-sm font-medium text-gray-700">{{ __('Famille olfactive') }}</label>
                    <select id="famille_filter" wire:model.live="filters.famille_olfactive" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">{{ __('Toutes') }}</option>
                        @foreach($referenceData['famille_olfactive'] as $famille)
                            <option value="{{ $famille->value }}">{{ $famille->label }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                
                @if(!empty($referenceData['application']))
                <div>
                    <label for="application_filter" class="block text-sm font-medium text-gray-700">{{ __('Application') }}</label>
                    <select id="application_filter" wire:model.live="filters.specific_attributes->application" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">{{ __('Toutes') }}</option>
                        @foreach($referenceData['application'] as $app)
                            <option value="{{ $app->value }}">{{ $app->label }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                
                @if($family && in_array($family->code, ['D', 'M', 'U']))
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700">{{ __('Année de sortie') }}</label>
                    <input type="number" id="date_filter" wire:model.live="filters.date_sortie" min="1900" max="{{ date('Y') }}" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                @endif
                
                @if($family && in_array($family->code, ['D', 'M']))
                <div class="flex items-center">
                    <input type="checkbox" id="unisex_filter" wire:model.live="filters.unisex" class="rounded border-gray-300 text-indigo-600">
                    <label for="unisex_filter" class="ml-2 block text-sm text-gray-700">{{ __('Uniquement les produits unisex') }}</label>
                </div>
                @endif
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" wire:click="$set('filters', [])"
                        class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Réinitialiser') }}
                </button>
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ __('Appliquer') }}
                </button>
            </div>
        </div>
    </x-modal>
    
    <!-- Tableau des produits -->
    @if($products && $products->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <!-- En-tête Type avec tri -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('type')">
                            <div class="flex items-center">
                                {{ __('Type') }}
                                @if($sortField === 'type')
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
                        
                        <!-- En-tête Nom avec tri -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('nom')">
                            <div class="flex items-center">
                                {{ __('Nom') }}
                                @if($sortField === 'nom')
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
                        
                        @if($family && $family->code !== 'W')
                            <!-- En-tête Marque avec tri -->
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('marque')">
                                <div class="flex items-center">
                                    {{ __('Marque') }}
                                    @if($sortField === 'marque')
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
                            
                            <!-- Autres en-têtes spécifiques à la famille -->
                            @if($family->code === 'PM')
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Application') }}
                                </th>
                            @endif
                            
                            @if(in_array($family->code, ['D', 'M', 'U']))
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Année') }}
                                </th>
                            @endif
                        @endif
                        
                        <!-- Actions -->
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $product->type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->nom }}
                            </td>
                            
                            @if($family && $family->code !== 'W')
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->marque }}
                                </td>
                                
                                @if($family->code === 'PM')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->getApplicationAttribute() }}
                                    </td>
                                @endif
                                
                                @if(in_array($family->code, ['D', 'M', 'U']))
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->date_sortie }}
                                    </td>
                                @endif
                            @endif
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
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