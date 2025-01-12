<x-app-layout>
    @if((!\App\Models\Pilot::isPilot() && Auth::user()->isSimpleUser()))
        <div class="container mx-auto py-8">
            <form method="POST" action="{{ route('register-pilot') }}">
                @csrf
                <div class="flex items-center space-x-4">
                    <label for="license_number" class="text-gray-300">Enter license number for pilot
                        verification</label>
                    <input
                        type="text"
                        name="license_number"
                        id="license_number"
                        maxlength="9"
                        pattern="^[A-Za-z]{3}\d+$"
                        required
                        class="px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-md"
                        placeholder=""
                    />
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    @endif
</x-app-layout>
