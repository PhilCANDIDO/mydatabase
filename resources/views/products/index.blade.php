<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Produits') }}
            </h2>
            @can('add data')
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ __('Nouveau Produit') }}
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            @if (session('message') || session('success'))
                <x-auto-dismiss-alert 
                    type="success" 
                    :message="session('message') ?? session('success')" 
                    :auto-dismiss="true"
                    :dismiss-after="15000"
                />
            @endif

            @if (session('error'))
                <x-auto-dismiss-alert 
                    type="error" 
                    :message="session('error')" 
                    :auto-dismiss="false"
                />
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <livewire:products.product-list />
        </div>
    </div>
</x-app-layout>