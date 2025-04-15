<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if($family)
                    {{ __('Produits') }} - {{ $family->name }}
                @else
                    {{ __('Produits') }}
                @endif
            </h2>
            
            @if($family && auth()->user()->can('add data'))
                <a href="{{ route('products.create', $family->code) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ __('Nouveau Produit') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Barre latérale des familles de produits -->
                <div class="w-full md:w-64 bg-white shadow-sm rounded-lg p-4">
                    <h3 class="font-medium text-lg mb-3">{{ __('Familles de produits') }}</h3>
                    <ul class="space-y-2">
                        @foreach($families as $fam)
                            <li>
                                <a href="{{ route('products.index', $fam->code) }}" 
                                   class="block py-2 px-3 rounded @if($family && $family->id === $fam->id) bg-blue-100 text-blue-800 font-medium @else hover:bg-gray-100 @endif">
                                    {{ $fam->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    @if($family)
                        <div class="mt-6 border-t pt-4">
                            <h3 class="font-medium text-lg mb-3">{{ __('Actions') }}</h3>
                            <ul class="space-y-2">
                                @can('import data')
                                <li>
                                    <a href="{{ route('products.import', $family->code) }}" class="flex items-center py-2 px-3 rounded hover:bg-gray-100">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                        {{ __('Importer') }}
                                    </a>
                                </li>
                                @endcan
                                
                                @can('export data')
                                <li>
                                    <a href="{{ route('products.export', $family->code) }}" class="flex items-center py-2 px-3 rounded hover:bg-gray-100">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        {{ __('Exporter') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Contenu principal -->
                <div class="flex-grow bg-white shadow-sm rounded-lg p-0">
                    @if($family)
                        <livewire:products.product-list :family="$family" />
                    @else
                        <div class="p-6 flex justify-center items-center h-64">
                            <p class="text-gray-500 text-lg">{{ __('Sélectionnez une famille de produits pour commencer') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>