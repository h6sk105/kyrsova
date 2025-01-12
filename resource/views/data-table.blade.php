<x-app-layout>
    <div class="container mx-auto py-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{$table}}</h2>
        <x-data-table :headers="${'headers_' . $table}" :rows="${'rows_' . $table}" :table="$table"/>
    </div>
</x-app-layout>
