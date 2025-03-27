import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',   // agar Vite mendengarkan pada semua alamat
        cors: true,        // mengaktifkan header CORS
        hmr: {
            host: '192.168.18.152', // ganti dengan IP lokal kamu agar HMR berjalan dengan benar di jaringan
        },
    },
});
