import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //         host: '192.168.1.68' || 'localhost',
    //     },
    // server: {
    //     host: '10.174.1.200' || 'localhost',
    // },

    // server: {
    //     host: '192.168.1.75' || 'localhost',
    // },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
