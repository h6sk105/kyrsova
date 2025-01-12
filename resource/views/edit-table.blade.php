<x-app-layout>
    <div class="container mx-auto py-8">
        @if(Auth::user()->email == 'admin@gmail.com')
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{ $table }}</h2>
            <x-edit-table :headers="${'headers_' . $table}" :rows="${'rows_' . $table}" :table="$table" :names="$names"/>
        @endif
    </div>
</x-app-layout>

