<div class="overflow-x-auto">
    <table class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
        <thead>
        <tr class="bg-gray-200 dark:bg-gray-700">
            @foreach($headers as $header)
                <th class="px-6 py-3 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase text-center">
                    {{ $header }}
                </th>
            @endforeach
            <th class="px-6 py-3 text-xs font-medium text-gray-700 dark:text-gray-300 uppercase text-center">Actions
            </th>
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
                <td class="px-6 py-4 text-sm text-center items">
                    <div class="flex space-x-2 justify-center">
                        <form method="GET" action="{{ route("edit.$table", ['id' => $row[0]]) }}">
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-20">
                                Edit
                            </button>
                        </form>
                        <form method="POST" action="{{ route("delete.$table", ['id' => $row[0]]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 w-20 delete-btn"
                                    data-index="{{ $index }}">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<form method="POST" action="{{ route("add.$table") }}"
      class="mt-6 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
    @csrf
    <div class="grid grid-cols-{{ count($headers) }} gap-4">
        @foreach($headers as $key => $header)
            @if(strtolower($header) !== 'id' && strtolower($header) !== 'free space')
                <div>
                    <label for="{{ Str::snake($header) }}"
                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $header }}
                    </label>
                    <input type="text" id="{{ Str::snake($header) }}" name="{{ $names[$key] }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 dark:bg-gray-800"
                           required>
                </div>
            @endif
        @endforeach
    </div>
    <div class="mt-4 text-center">
        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600">
            Add {{ Str::singular($table) }}
        </button>
    </div>
</form>

