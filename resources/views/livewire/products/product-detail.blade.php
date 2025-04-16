<!-- resources/views/livewire/products/product-detail.blade.php -->
<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Détails du produit') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $product->type }} - {{ $product->nom }}</p>
            </div>
            <div class="flex space-x-3">
                @can('edit data')
                <a href="{{ route('products.edit', [$family->code, $product->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    {{ __('Éditer') }}
                </a>
                @endcan
                
                <a href="{{ route('products.family.index', $family->code) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                    {{ __('Retour') }}
                </a>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">{{ __('Type') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->type }}</dd>
                </div>
                
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">{{ __('Nom') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->nom }}</dd>
                </div>
                
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">{{ __('Marque') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->marque }}</dd>
                </div>
                
                @if($family->code != 'W')
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Zone Géographique') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->zone_geographique }}</dd>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Famille Olfactive') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->famille_olfactive }}</dd>
                    </div>
                    
                    @if(in_array($family->code, ['D', 'M', 'U']))
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Année de sortie') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->date_sortie }}</dd>
                        </div>
                    @endif
                    
                    <!-- Notes olfactives -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Notes de tête') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $product->description_olfactive_tete_1 }}
                            @if($product->description_olfactive_tete_2)
                                , {{ $product->description_olfactive_tete_2 }}
                            @endif
                        </dd>
                    </div>
                    
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Notes de cœur') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $product->description_olfactive_coeur_1 }}
                            @if($product->description_olfactive_coeur_2)
                                , {{ $product->description_olfactive_coeur_2 }}
                            @endif
                        </dd>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Notes de fond') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $product->description_olfactive_fond_1 }}
                            @if($product->description_olfactive_fond_2)
                                , {{ $product->description_olfactive_fond_2 }}
                            @endif
                        </dd>
                    </div>
                @endif
                
                <!-- Attributs spécifiques selon la famille -->
                @if($family->code == 'PM' && isset($product->specific_attributes['application']))
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Application') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $product->specific_attributes['application'] }}
                        </dd>
                    </div>
                @endif
                
                @if($family->code == 'U' && isset($product->specific_attributes['genre']))
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Genre') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $product->specific_attributes['genre'] }}
                        </dd>
                    </div>
                @endif
                
                @if(in_array($family->code, ['D', 'M']) && isset($product->unisex))
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Unisex') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $product->unisex ? __('Oui') : __('Non') }}
                        </dd>
                    </div>
                @endif
                
                @if($product->avatar)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Image') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <img src="{{ Storage::url($product->avatar) }}" alt="{{ $product->nom }}" class="max-w-md rounded-md">
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>