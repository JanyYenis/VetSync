import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                'resources/css/datatable-gijac.css',
                'resources/css/datatables.css',
                'resources/js/jquery-validator.init.js',

                'resources/css/dashboard.css',
                'resources/css/landing.css',
                'resources/css/login.css',
                'resources/css/registro.css',
                'resources/css/perfil.css',
                'resources/css/historial.css',
                'resources/css/prescripciones.css',
                'resources/css/precios.css',
                'resources/css/planes.css',
                'resources/css/checkout.css',
                'resources/css/clinicas.css',

                'resources/js/sistema.js',
                'resources/js/dashboard.js',
                'resources/js/data.js',
                'resources/js/landing.js',
                'resources/js/auth/login.js',
                'resources/js/auth/registro.js',
                'resources/js/perfil.js',
                'resources/js/historial.js',
                'resources/js/prescripciones.js',
                'resources/js/precios.js',
                'resources/js/planes.js',
                'resources/js/checkout.js',
                'resources/js/clinicas.js',

                // Clientes
                'resources/js/clientes/principal.js',

                // Mascotas
                'resources/js/mascotas/principal.js',

                // Historial clinico
                'resources/js/historiales/principal.js',

                // Prescripciones
                'resources/js/prescripciones/principal.js',
                'resources/js/prescripciones/crear.js',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/img/*',
                    dest: 'img',
                }
            ]
        })
    ],
});
