<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="flex items-center min-h-screen bg-gray-800">
            <div class="flex-1 h-full max-w-4xl mx-auto bg-gray-900 rounded-lg shadow-xl">
                <div class="flex flex-col md:flex-row">
                    <div class="h-32 md:h-auto md:w-1/2">
                        <img class="object-cover w-full h-full" src="{{ asset('images/Restaurant.jpeg') }}" alt="img" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <h3 class="mb-4 text-xl font-bold text-yellow-400">Step Two: Select Table</h3>

                            <div class="w-full flex items-center justify-between mb-8 step-indicator">
                                <div class="flex w-full">
                                    <div class="flex flex-col items-center w-1/4">
                                        <div class="step step-active">1</div>
                                        <span class="text-xs mt-2 text-yellow-400 font-bold">Data Diri</span>
                                    </div>
                                    <div class="flex items-center w-1/4">
                                        <div class="flex-1 h-1 bg-yellow-400"></div>
                                    </div>
                                    <div class="flex flex-col items-center w-1/4">
                                        <div class="step step-active">2</div>
                                        <span class="text-xs mt-2 text-yellow-400 font-bold">Meja/Menu</span>
                                    </div>
                                    <div class="flex items-center w-1/4">
                                        <div class="flex-1 h-1 bg-yellow-400"></div>
                                    </div>
                                    <div class="flex flex-col items-center w-1/4">
                                        <div class="step">3</div>
                                        <span class="text-xs mt-2 text-gray-500">Menu</span>
                                    </div>
                                    <div class="flex items-center w-1/4">
                                        <div class="flex-1 h-1 bg-gray-300"></div>
                                    </div>
                                    <div class="flex flex-col items-center w-1/4">
                                        <div class="step">4</div>
                                        <span class="text-xs mt-2 text-gray-500">Pembayaran</span>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('reservations.store.step-two') }}">
                                @csrf                                  
                                <!-- Memilih Meja -->
                                <div class="sm:col-span-6 pt-5">
                                    <label for="table_id" class="block text-sm font-medium text-gray-300">Select Table</label>
                                    <div class="mt-1">
                                        <select id="table_id" name="table_id" class="form-multiselect block w-full text-black mt-1">
                                            @foreach ($tables as $table)
                                                <option value="{{ $table->id }}">{{ $table->name }} ({{ $table->guest_number }} Guests)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('table_id')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Checkbox for ordering menu -->
                                <div class="sm:col-span-6 pt-5">
                                    <label for="order_menu" class="block text-sm font-medium text-gray-300">Would you like to order menu items?</label>
                                    <div class="mt-1">
                                        <input type="checkbox" id="order_menu" name="order_menu" value="1" class="form-checkbox text-indigo-600 h-5 w-5">
                                    </div>
                                    @error('order_menu')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-6 p-4 flex justify-between">
                                    <a href="{{ route('reservations.step-one') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Previous</a>
                                    <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Add margin and padding to avoid overlap with guest layout */
        .container {
            margin-top: 20px; /* Adjust top margin to avoid overlap */
            padding-bottom: 20px; /* Add bottom padding */
        }

        /* General Form and Page Styling */
        body {
            background-color: #111;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }
        
        .step-indicator .step {
            background-color: #2d3748;
            color: #fff;
            font-weight: bold;
            padding: 0.5rem;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .step-indicator .step-active {
            background-color: #fbbf24;
        }

        /* Additional Custom Styles to avoid overlap */
        .flex-1 {
            flex: 1 1 auto; /* Ensure the layout elements are not overlapping */
        }

        .step-indicator {
            margin-bottom: 15px; /* Give some spacing around step indicator */
        }
    </style>
</x-guest-layout>
