<aside
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 text-gray-800 dark:text-white border-r font-sans">
    <!-- Aquí va el contenido del aside -->
    <ul>
        <li
            class="flex items-center border-t border-gray-200 dark:border-gray-700 border-b hover:bg-gray-200 dark:hover:bg-gray-700 p-4 w-full transition duration-300">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 10c0-7-7-7-7-7s-7 0-7 7v10a3 3 0 003 3h8a3 3 0 003-3V10z"></path>
            </svg>
            <a href="{{ route('peliculas') }}" class="hover:text-blue-500 w-full text-lg">Películas</a>
        </li>
        <li
            class="flex items-center border-b border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 p-4 w-full transition duration-300">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 11a1 1 0 011-1h12a1 1 0 110 2H6a1 1 0 01-1-1z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 6a1 1 0 011-1h12a1 1 0 110 2H6a1 1 0 01-1-1z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 16a1 1 0 011-1h12a1 1 0 110 2H6a1 1 0 01-1-1z"></path>
            </svg>
            <a href="#" class="hover:text-blue-500 w-full text-lg">Series TV</a>
        </li>
        <li
            class="flex items-center border-b border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-700 p-4 w-full transition duration-300">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 17v-5l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <a href="#" class="hover:text-blue-500 w-full text-lg">Documentales</a>
        </li>
    </ul>
</aside>
