import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',        // ← Escucha en todas las interfaces (Docker)
        port: 5174,
        strictPort: true,       // ← Falla si el puerto está ocupado
        hmr: {
            host: 'localhost',  // ← El navegador conecta a localhost
            port: 5174,
        },
        watch: {
            usePolling: true,   // ← Necesario para que funcione en Docker
        },
    },
});
