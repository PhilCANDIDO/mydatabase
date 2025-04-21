<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $product->product_name }}</h2>
            <div class="flex space-x-2">
                @can('edit data')
                <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    {{ __('Modifier') }}
                </a>
                @endcan
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                    {{ __('Retour') }}
                </a>
            </div>
        </div>

        <!-- Informations de base -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ __('Informations générales') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Type') }}</p>
                    <p class="mt-1">{{ $product->product_type }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Famille de produit') }}</p>
                    <p class="mt-1">{{ $product->productFamily->product_family_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Marque') }}</p>
                    <p class="mt-1">{{ $product->product_marque ?? '-' }}</p>
                </div>
                
                @if($product->application)
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Application') }}</p>
                    <p class="mt-1">{{ $product->application->application_name }}</p>
                </div>
                @endif
                
                @if($product->product_annee_sortie)
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Année de sortie') }}</p>
                    <p class="mt-1">{{ $product->product_annee_sortie }}</p>
                </div>
                @endif
                
                @if($product->productFamily->product_family_code == 'U')
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Genre') }}</p>
                    <p class="mt-1">{{ $product->product_genre === 'M' ? __('Masculin') : __('Féminin') }}</p>
                </div>
                @endif
                
                @if(in_array($product->productFamily->product_family_code, ['D', 'M']))
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Unisex') }}</p>
                    <p class="mt-1">{{ $product->product_unisex ? __('Oui') : __('Non') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Avatar du produit s'il existe -->
        @if($product->product_avatar)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ __('Avatar') }}</h3>
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->product_avatar) }}" alt="{{ $product->product_name }}" 
                     class="h-48 w-48 object-cover rounded-lg shadow-md">
            </div>
        </div>
        @endif

        @if($product->productFamily->product_family_code != 'W')
            <!-- Zones géographiques -->
            @if($product->zoneGeos->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ __('Zones Géographiques') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->zoneGeos as $zone)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $zone->zone_geo_name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Familles olfactives -->
            @if($product->olfactiveFamilies->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ __('Familles Olfactives') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->olfactiveFamilies as $family)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            {{ $family->olfactive_family_name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Notes olfactives -->
            @if($headNotes->isNotEmpty() || $heartNotes->isNotEmpty() || $baseNotes->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ __('Notes Olfactives') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Notes de tête -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-2">{{ __('Notes de tête') }}</h4>
                        @if($headNotes->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach($headNotes as $note)
                                    <li class="flex items-center">
                                        <span class="w-6 h-6 flex items-center justify-center bg-yellow-100 text-yellow-800 rounded-full text-xs mr-2">
                                            {{ $note->pivot->olfactive_note_order }}
                                        </span>
                                        <span>{{ $note->olfactive_note_name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic">{{ __('Aucune note de tête') }}</p>
                        @endif
                    </div>
                    
                    <!-- Notes de cœur -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-2">{{ __('Notes de cœur') }}</h4>
                        @if($heartNotes->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach($heartNotes as $note)
                                    <li class="flex items-center">
                                        <span class="w-6 h-6 flex items-center justify-center bg-pink-100 text-pink-800 rounded-full text-xs mr-2">
                                            {{ $note->pivot->olfactive_note_order }}
                                        </span>
                                        <span>{{ $note->olfactive_note_name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic">{{ __('Aucune note de cœur') }}</p>
                        @endif
                    </div>
                    
                    <!-- Notes de fond -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-2">{{ __('Notes de fond') }}</h4>
                        @if($baseNotes->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach($baseNotes as $note)
                                    <li class="flex items-center">
                                        <span class="w-6 h-6 flex items-center justify-center bg-purple-100 text-purple-800 rounded-full text-xs mr-2">
                                            {{ $note->pivot->olfactive_note_order }}
                                        </span>
                                        <span>{{ $note->olfactive_note_name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic">{{ __('Aucune note de fond') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>