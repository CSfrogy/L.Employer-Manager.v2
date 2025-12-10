import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'  // Make sure this is included for Livewire
            ],
            refresh: true,
        }),
    ],
    // Add these optimizations for production builds
    build: {
        rollupOptions: {
            output: {
                // Better chunking for production
                manualChunks: undefined,
                entryFileNames: 'assets/[name].[hash].js',
                chunkFileNames: 'assets/[name].[hash].js',
                assetFileNames: 'assets/[name].[hash].[ext]'
            }
        },
        // Increase chunk size warning limit
        chunkSizeWarningLimit: 1600,
        // Ensure assets are built properly
        assetsDir: 'assets',
    },
    // Optimize for production
    server: {
        hmr: {
            host: 'localhost',
        },
    },
}); 