<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="flex items-center min-h-screen bg-gray-800"> <!-- Background Gelap -->
            <div class="flex-1 h-full max-w-4xl mx-auto bg-gray-900 rounded-lg shadow-xl">
                <div class="flex flex-col md:flex-row">
                    <div class="h-32 md:h-auto md:w-1/2">
                        <img class="object-cover w-full h-full"
                            src="{{ asset('images/Restaurant.jpeg') }}" alt="img" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <h3 class="mb-4 text-xl font-bold text-yellow-400">Make Reservation</h3>

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
                                        <div class="step">2</div>
                                        <span class="text-xs mt-2 text-gray-500">Meja/Menu</span>
                                    </div>
                                    <div class="flex items-center w-1/4">
                                        <div class="flex-1 h-1 bg-gray-300"></div>
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

                            @if ($errors->any())
                                <div class="alert alert-danger bg-red-100 text-red-700 rounded p-3 mb-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('reservations.store.step-one') }}">
                                @csrf
                                <div class="sm:col-span-6">
                                    <label for="first_name" class="block text-sm font-medium text-gray-300"> First Name </label>
                                    <div class="mt-1">
                                        <input type="text" id="first_name" name="first_name"
                                            value="{{ $reservation->first_name ?? '' }}"
                                            class="block w-full appearance-none bg-gray-700 border border-gray-500 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('first_name')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="last_name" class="block text-sm font-medium text-gray-300"> Last Name </label>
                                    <div class="mt-1">
                                        <input type="text" id="last_name" name="last_name"
                                            value="{{ $reservation->last_name ?? '' }}"
                                            class="block w-full appearance-none bg-gray-700 border border-gray-500 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('last_name')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="email" class="block text-sm font-medium text-gray-300"> Email </label>
                                    <div class="mt-1">
                                        <input type="email" id="email" name="email"
                                            value="{{ $reservation->email ?? '' }}"
                                            class="block w-full appearance-none bg-gray-700 border border-gray-500 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('email')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="tel_number" class="block text-sm font-medium text-gray-300"> Phone Number </label>
                                    <div class="mt-1">
                                        <input type="text" id="tel_number" name="tel_number"
                                            value="{{ old('tel_number', $reservation->tel_number ?? '') }}"
                                            pattern="08[0-9]{8,13}" title="Nomor HP harus dimulai 08 dan 10-14 digit angka"
                                            required
                                            class="block w-full appearance-none bg-gray-700 border border-gray-500 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('tel_number')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="res_date" class="block text-sm font-medium text-gray-300"> Reservation Date </label>
                                    <div class="mt-1">
                                        <input type="datetime-local" id="res_date" name="res_date"
                                            min="{{ $min_date->format('Y-m-d\TH:i:s') }}"
                                            max="{{ $max_date->format('Y-m-d\TH:i:s') }}"
                                            value="{{ $reservation ? $reservation->res_date->format('Y-m-d\TH:i:s') : '' }}"
                                            class="block w-full appearance-none bg-gray-700 border border-gray-500 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    <span class="text-xs text-gray-400">Please choose the time between 17:00-23:00.</span>
                                    @error('res_date')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="guest_number" class="block text-sm font-medium text-gray-300"> Guest Number </label>
                                    <div class="mt-1">
                                        <input type="number" id="guest_number" name="guest_number"
                                            value="{{ $reservation->guest_number ?? '' }}"
                                            class="block w-full appearance-none bg-gray-700 border border-gray-500 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    @error('guest_number')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-6 p-4 flex justify-end">
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
        /* Global Styles */
body {
    background-color: #111; /* Latar belakang hitam pada seluruh halaman */
    color: #fff; /* Teks putih untuk seluruh halaman */
    font-family: 'Arial', sans-serif;
}

/* Container untuk Reservasi */
.container {
    background-color: #1f2937; /* Gelap dengan kontras terang untuk konten */
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    padding: 2rem;
}

/* Card di dalam step reservasi */
.card {
    background-color: #111; /* Dark background for the card */
    color: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

/* Header di dalam step reservasi */
.card h3 {
    font-size: 2rem;
    font-weight: bold;
    color: #fbbf24; /* Warna kuning cerah untuk judul */
}

/* Step Indicator */
.step-indicator .step {
    background-color: #2d3748; /* Dark background for step circle */
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
    background-color: #fbbf24; /* Active step color */
}

/* Form Input */
input[type="text"],
input[type="email"],
input[type="datetime-local"],
input[type="number"] {
    background-color: #2d3748; /* Dark background for inputs */
    color: #fff; /* Text color */
    border: 1px solid #444; /* Border color */
    border-radius: 0.5rem;
    padding: 1rem;
    width: 100%;
    margin-top: 0.5rem;
}

/* Button */
button[type="submit"] {
    background-color: #fbbf24; /* Orange for the button */
    color: #111;
    font-weight: bold;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    width: 100%;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #f59e0b; /* Darker orange on hover */
}

/* Error Messages */
.text-red-400 {
    color: #e53e3e; /* Red color for error messages */
}

.text-xs {
    font-size: 0.75rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .card {
        padding: 1rem;
    }
}

    </style>
</x-guest-layout>