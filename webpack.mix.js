let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js').sourceMaps()
   .sass('resources/assets/sass/app.scss', 'public/css')
   .options({
       processCssUrls: false,
       imgLoaderOptions: {
           enabled: false
       },
   });

mix.webpackConfig({
    resolve: {
        modules: [
            'node_modules',
            path.resolve(__dirname, 'resources/assets/js'),
            path.resolve(__dirname, 'resources/assets/images/svg')
        ]
    }
});

// Make Laravel Mix ignore .svgs
Mix.listen('configReady', function (config) {
    const rules = config.module.rules;
    const targetRegex = /(\.(png|jpe?g|gif)$|^((?!font).)*\.svg$)/;

    for (let rule of rules) {
        if (rule.test.toString() == targetRegex.toString()) {
            rule.exclude = /\.svg$/;
            break;
        }
    }
});

// Handle .svgs with html-loader instead
mix.webpackConfig({
    module: {
        rules: [{
            test: /\.svg$/,
            use: [{
                loader: 'html-loader',
                options: {
                    minimize: true
                }
            }]
        }]
    }
});

if (mix.inProduction()) {
    mix.version();
}
