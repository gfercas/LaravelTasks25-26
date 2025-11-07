<div>
    <!-- This is an example component -->
    <div
        class='flex min-h-screen items-center justify-center min-h-screen from-white-200 via-white-300 to-white-500 bg-gradient-to-br'>
        <div class="flex items-center justify-center min-h-[450px]">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">Título</th>
                                <th scope="col" class="py-3 px-6">Descripción</th>
                                <th scope="col" class="py-3 px-6"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-4 px-6">{{ $task->title }}</td>
                                    <td class="py-4 px-6">{{ $task->description }}</td>
                                    <td class="py-4 px-6"></td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
