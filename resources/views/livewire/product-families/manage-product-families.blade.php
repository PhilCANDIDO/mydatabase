<div>
    <!-- En-tête avec titre et bouton d'ajout -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">{{ __('Gestion des Familles de Produits') }}</h2>
        <button 
            wire:click="openCreateModal" 
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
        >
            {{ __('Nouvelle Famille') }}
        </button>
    </div>

    <!-- Messages flash -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Barre de recherche et contrôles -->
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="w-full sm:w-1/2">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="{{ __('Rechercher...') }}" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <div class="flex items-center space-x-4">
            <label for="perPage" class="text-sm text-gray-700">{{ __('Par page:') }}</label>
            <select 
                id="perPage" 
                wire:model.live="perPage" 
                class="border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <!-- Tableau des familles de produits -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('code')">
                        <div class="flex items-center">
                            {{ __('Code') }}
                            @if ($sortField === 'code')
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                        <div class="flex items-center">
                            {{ __('Nom') }}
                            @if ($sortField === 'name')
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Description') }}
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('active')">
                        <div class="flex items-center">
                            {{ __('Statut') }}
                            @if ($sortField === 'active')
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($families as $family)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $family->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $family->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-md truncate">
                            {{ $family->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $family->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $family->active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $family->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                {{ __('Éditer') }}
                            </button>
                            <button wire:click="openDeleteModal({{ $family->id }})" class="text-red-600 hover:text-red-900">
                                {{ __('Supprimer') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('Aucune famille de produits trouvée.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $families->links() }}
    </div>

    <!-- Modal -->
    <x-modal name="family-modal" :show="$isModalOpen" maxWidth="md">
        <div class="p-6">
            @if ($modalMode === 'create')
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Ajouter une famille de produits') }}</h2>
                <form wire:submit.prevent="create">
                    <!-- Code -->
                    <div class="mb-4">
                        <label for="familyCode" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                        <input wire:model="familyCode" type="text" id="familyCode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('familyCode') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="familyName" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
                        <input wire:model="familyName" type="text" id="familyName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('familyName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="familyDescription" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                        <textarea wire:model="familyDescription" id="familyDescription" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('familyDescription') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Active -->
                    <div class="mb-4 flex items-center">
                        <input wire:model="familyActive" type="checkbox" id="familyActive" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="familyActive" class="ml-2 block text-sm text-gray-700">{{ __('Active') }}</label>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-end mt-6 space-x-3">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400"
                        >
                            {{ __('Annuler') }}
                        </button>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                        >
                            {{ __('Créer') }}
                        </button>
                    </div>
                </form>
            @elseif ($modalMode === 'edit')
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Modifier la famille de produits') }}</h2>
                <form wire:submit.prevent="update">
                    <!-- Code (Disabled) -->
                    <div class="mb-4">
                        <label for="familyCode" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                        <input wire:model="familyCode" type="text" id="familyCode" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" disabled>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Le code ne peut pas être modifié') }}</p>
                    </div>
                    
                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="familyName" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
                        <input wire:model="familyName" type="text" id="familyName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('familyName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="familyDescription" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                        <textarea wire:model="familyDescription" id="familyDescription" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('familyDescription') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Active -->
                    <div class="mb-4 flex items-center">
                        <input wire:model="familyActive" type="checkbox" id="familyActive" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="familyActive" class="ml-2 block text-sm text-gray-700">{{ __('Active') }}</label>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-end mt-6 space-x-3">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400"
                        >
                            {{ __('Annuler') }}
                        </button>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                        >
                            {{ __('Enregistrer') }}
                        </button>
                    </div>
                </form>
            @elseif ($modalMode === 'delete')
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Supprimer la famille de produits') }}</h2>
                <p class="mb-4 text-sm text-gray-600">
                    {{ __('Êtes-vous sûr de vouloir supprimer cette famille de produits ?') }} 
                    <strong>{{ $selectedFamily->name }}</strong>
                </p>
                <p class="mb-4 text-sm text-red-600">
                    {{ __('Cette action est irréversible.') }}
                </p>
                
                <!-- Buttons -->
                <div class="flex justify-end mt-6 space-x-3">
                    <button 
                        type="button" 
                        wire:click="closeModal" 
                        class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400"
                    >
                        {{ __('Annuler') }}
                    </button>
                    <button 
                        type="button" 
                        wire:click="delete" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                    >
                        {{ __('Supprimer') }}
                    </button>
                </div>
            @endif
        </div>
    </x-modal>
</div>