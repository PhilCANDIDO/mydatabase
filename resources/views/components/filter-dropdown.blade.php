@props([
    'id',
    'label',
    'options' => [],
    'placeholder' => 'Rechercher...',
    'selected' => null,
    'displayKey' => 'name',
    'valueKey' => 'id',
    'wireModel' => null
])

<div x-data="{ 
    open: false,
    search: '',
    selected: @js($selected),
    displayValue: '',
    init() {
        this.updateDisplayValue();
        this.$watch('selected', () => this.updateDisplayValue());
        
        // Écouter les changements de valeur du modèle Livewire
        if ('{{ $wireModel }}') {
            this.$wire.$watch('{{ $wireModel }}', (value) => {
                if (this.selected !== value) {
                    this.selected = value;
                    this.updateDisplayValue();
                }
            });
        }
    },
    updateDisplayValue() {
        if (this.selected) {
            const option = {{ json_encode($options) }}.find(opt => opt.{{ $valueKey }} == this.selected);
            this.displayValue = option ? option.{{ $displayKey }} : '';
        } else {
            this.displayValue = '';
        }
    },
    get filteredOptions() {
        return {{ json_encode($options) }}.filter(
            option => option.{{ $displayKey }}.toLowerCase().includes(this.search.toLowerCase())
        );
    },
    selectOption(optionValue) {
        this.selected = optionValue;
        this.open = false;
        @if($wireModel)
        // Utilisez $wire pour accéder directement au composant Livewire parent
        $wire.set('{{ $wireModel }}', optionValue);
        @endif
    }
}" class="relative w-full">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    
    <!-- Dropdown toggle button -->
    <button @click="open = !open" 
            type="button" 
            id="{{ $id }}" 
            class="flex items-center justify-between w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <span x-text="displayValue || '{{ __('Tous') }}'"></span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <!-- Dropdown menu -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95" 
         class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
        
        <!-- Search input -->
        <div class="p-2 sticky top-0 bg-white border-b border-gray-200">
            <input 
                type="text" 
                x-model="search" 
                placeholder="{{ $placeholder }}" 
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                @click.stop
            >
        </div>
        
        <!-- Options list -->
        <ul class="py-1 overflow-y-auto">
            <li class="px-2">
                <button 
                    type="button" 
                    @click="selectOption(null)" 
                    class="w-full px-3 py-2 text-sm text-left hover:bg-gray-100 rounded-md"
                >
                    {{ __('Tous') }}
                </button>
            </li>
            <template x-for="option in filteredOptions" :key="option.{{ $valueKey }}">
                <li class="px-2">
                    <button 
                        type="button" 
                        x-text="option.{{ $displayKey }}" 
                        @click="selectOption(option.{{ $valueKey }})" 
                        :class="{'bg-blue-100': selected == option.{{ $valueKey }}}" 
                        class="w-full px-3 py-2 text-sm text-left hover:bg-gray-100 rounded-md"
                    ></button>
                </li>
            </template>
            <li x-show="filteredOptions.length === 0" class="px-4 py-2 text-sm text-gray-500">
                {{ __('Aucun résultat trouvé') }}
            </li>
        </ul>
    </div>
</div>