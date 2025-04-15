<!-- resources/views/reference-data/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Référentiel de données') }}
            </h2>
            <a href="{{ route('reference-data.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ __('Nouvelle Donnée') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(count($types) > 0)
                        <div class="mb-6">
                            <div class="mb-4">
                                <label for="type-filter" class="block text-sm font-medium text-gray-700">{{ __('Filtrer par type') }}</label>
                                <select id="type-filter" onchange="filterByType(this.value)" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                                    <option value="all">{{ __('Tous les types') }}</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @foreach($referenceData as $type => $items)
                            <div class="type-section" data-type="{{ $type }}">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">{{ $type }}</h3>
                                <table class="min-w-full divide-y divide-gray-200 mb-8">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Valeur') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Libellé') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Ordre') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Statut') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->value }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->label }}</td>
                                                <td class="px-6 py-4">{{ $item->description }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->order }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $item->active ? __('Active') : __('Inactive') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('reference-data.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        {{ __('Éditer') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">{{ __('Aucune donnée de référence trouvée.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterByType(type) {
            const sections = document.querySelectorAll('.type-section');
            
            if (type === 'all') {
                sections.forEach(section => {
                    section.style.display = 'block';
                });
            } else {
                sections.forEach(section => {
                    if (section.dataset.type === type) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }
        }
    </script>
</x-app-layout>