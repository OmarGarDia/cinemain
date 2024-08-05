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
            <a href="{{ route('series') }}" class="hover:text-blue-500 w-full text-lg">Series TV</a>
        </li>
        <li
            class="flex items-center border-t border-gray-200 dark:border-gray-700 border-b hover:bg-gray-200 dark:hover:bg-gray-700 p-4 w-full transition duration-300">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 2c2.761 0 5 2.239 5 5s-2.239 5-5 5-5-2.239-5-5 2.239-5 5-5zM12 14c3.314 0 6 1.79 6 4v2H6v-2c0-2.21 2.686-4 6-4z">
                </path>
            </svg>

            <a href="{{ route('directores') }}" class="hover:text-blue-500 w-full text-lg">Directores</a>
        </li>
        <li
            class="flex items-center border-t border-gray-200 dark:border-gray-700 border-b hover:bg-gray-200 dark:hover:bg-gray-700 p-4 w-full transition duration-300">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 10c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zM17 12c-3.314 0-6 1.79-6 4v2h12v-2c0-2.21-2.686-4-6-4z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 10c2.761 0 5-2.239 5-5S9.761 0 7 0 2 2.239 2 5s2.239 5 5 5zM7 12c-3.314 0-6 1.79-6 4v2h12v-2c0-2.21-2.686-4-6-4z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 22c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zM12 24c-3.314 0-6-1.79-6-4v-2h12v2c0 2.21-2.686 4-6 4z">
                </path>
            </svg>


            <a href="{{ route('actores') }}" class="hover:text-blue-500 w-full text-lg">Actores/Actrices</a>
        </li>
    </ul>
</aside>
