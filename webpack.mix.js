const mix = require('laravel-mix');
require('vuetifyjs-mix-extension')

mix.webpackConfig(webpack => {
    return {

        resolve: {
            alias: { jquery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js') }
        },

        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
            })
        ]
    };
});

mix
    .js('resources/js/frontend/app.js', 'public/js/frontend')
    .sass('resources/sass/frontend/styles.scss', 'public/css/frontend/styles.min.css').options({
    processCssUrls: false
});

mix
    .js('resources/js/frontend/account/app.js', 'public/js/frontend/account').vuetify(
    'vuetify-loader',
    'resources/sass/frontend/account/styles.scss'
)
    .sass('resources/sass/frontend/account/styles.scss', 'public/css/frontend/account/styles.min.css');

mix
    .js('resources/js/admin/app.js', 'public/js/admin')
    .sass('resources/sass/admin/styles.scss', 'public/css/admin/styles.min.css')

//mix.copy( 'resources/assets/images', 'public/images', false );
//mix.copy( 'resources/assets/static', 'public/static', false );

//mix.version(['public/images/**/*.*']);

if (mix.inProduction()) {
    mix.version();
}
