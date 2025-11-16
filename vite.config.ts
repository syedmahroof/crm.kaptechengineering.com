import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    esbuild: {
        jsx: 'automatic',
    },
    resolve: {
        alias: {
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
            '@': resolve(__dirname, 'resources/js'),
        },
    },
    optimizeDeps: {
        include: [
            'react-quill', // Include the library itself
            'react-quill/dist/quill.snow.css' // Explicitly include the CSS asset
        ]
    },
    server: {
        host: '0.0.0.0', // Allow external connections (for mobile devices)
        hmr: {
            host: 'localhost', // Use localhost for HMR, but allow external connections for assets
        },
    },
    build: {
        rollupOptions: {
            output: {
                // Ensure consistent asset URLs
                assetFileNames: 'assets/[name].[ext]',
            },
        },
    },
});
