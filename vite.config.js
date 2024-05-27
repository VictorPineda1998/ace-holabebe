import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //         host: '192.168.1.69' || 'localhost',
    //     },
    // server: {
    //     host: '10.174.1.200' || 'localhost',
    // },
    // server: {
    //     host: '192.168.1.75' || 'localhost',
    // },
    // server: {
    //     host: '192.168.1.123' || 'localhost',
    // },
    // server: {
    //         host: '192.168.216.149' || 'localhost',
    //     },
    // server: {
    //             host: '10.135.1.201' || 'localhost',
    //         },
    // server: {
    //             host: '10.25.1.201' || 'localhost',
    //         },

            
    
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
