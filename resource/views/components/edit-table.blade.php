<div class="overflow-x-auto">
    <form method="POST" action="{{ route("update.$table") }}">
        @csrf
        <table
            class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
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
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 text-center">
                            <input type="text"
                                   class="w-30 px-2 py-1 border rounded-md text-gray-700 dark:text-gray-300 dark:bg-gray-800 text-center"
                                   value="{{ $cell }}"
                                   name="{{ $names[$key] }}"/>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-center mb-4">
            <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 w-40">
                Update
            </button>
        </div>
    </form>
</div>
