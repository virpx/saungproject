<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $cards = [
                        [
                            'label' => 'Total Orders',
                            'value' => $ordersCount,
                            'icon' => 'shopping-cart',
                            'color' => 'from-green-400 to-teal-500',
                        ],
                        [
                            'label' => 'Total Menus',
                            'value' => $menusCount,
                            'icon' => 'collection',
                            'color' => 'from-blue-400 to-indigo-500',
                        ],
                        [
                            'label' => 'Total Tables',
                            'value' => $tablesCount,
                            'icon' => 'table',
                            'color' => 'from-yellow-400 to-orange-500',
                        ],
                        [
                            'label' => 'Total Reservations',
                            'value' => $reservationsCount,
                            'icon' => 'calendar',
                            'color' => 'from-pink-400 to-purple-500',
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div
                        class="bg-gradient-to-r {{ $card['color'] }} text-white shadow-lg rounded-2xl p-6 transform hover:scale-105 transition duration-300">
                        <div class="flex items-center">
                            <x-heroicon-o-{{ $card['icon'] }} class="h-8 w-8" />
                            <span class="ml-3 text-lg font-medium">{{ $card['label'] }}</span>
                        </div>
                        <div class="mt-4 text-4xl font-bold">{{ $card['value'] }}</div>
                    </div>
                @endforeach
            </div>
</x-admin-layout>
