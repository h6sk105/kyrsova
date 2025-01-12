<div class="overflow-x-auto">
    <table class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
        <thead>
        <tr class="bg-gray-200 dark:bg-gray-700">
            @foreach($headers as $header)
                <th class="px-6 py-3 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase text-center">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $index => $row)
            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                id="row-{{ $index }}">
                @foreach($row as $key => $cell)
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 text-center max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap">
                        <span class="cell-value" title="{{ $cell }}">{{ $cell }}</span>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if(request()->routeIs('data-table-flights'))

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-center mt-6 space-x-6">

        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md p-6 max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Place Order</h3>
            <form action="{{ route('place-order') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="flight_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Flight
                        ID</label>
                    <input type="number" id="flight_id" name="flightid" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="email" name="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="number_of_seats" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number
                        of Seats</label>
                    <input type="number" id="seat-count" name="seatcount" required min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Take Order
                    </button>
                </div>
            </form>
        </div>
        @if(\App\Models\Pilot::isPilot())
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md p-6 max-w-md w-full">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Take a Flight</h3>
                <form action="{{ route('take-flight') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="aircraft_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Aircraft
                            ID</label>
                        <input type="number" id="aircraft_id" name="aircraftid" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="departure_city_id"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departure City
                            ID</label>
                        <input type="number" id="departure_city_id" name="departurecityid" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="arrival_city_id"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival City
                            ID</label>
                        <input type="number" id="arrival_city_id" name="arrivalcityid" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="departure_date"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departure Date</label>
                        <input type="date" id="departure_date" name="departuredate" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="arrival_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival
                            Date</label>
                        <input type="date" id="arrival_date" name="arrivaldate" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="price"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <input type="number" id="price" name="price" required min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Take Flight
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endif

