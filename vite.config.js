import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            publicDirectory: 'public',
            buildDirectory: 'build',
            copyAssets: [
                'resources/assets/fonts'
            ],
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            // Aliases para facilitar importações
            '@': '/resources/js',
            '@css': '/resources/css',
            '@assets': '/resources/assets',
        },
    },
    server: {
        cors: {
            origin: '*',
            methods: ['GET', 'HEAD', 'PUT', 'PATCH', 'POST', 'DELETE'],
            credentials: true
        }
    }
});
