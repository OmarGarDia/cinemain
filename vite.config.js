import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                // "resources/js/misFunciones.js",
                // "resources/js/buscadorActores.js",
                // "resources/js/buscadorDirectores.js",
                // "resources/js/buscadorPeliculas.js",
                // "resources/js/buscadorSeries.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        sourcemap: true,
    },
});
