const mix = require('laravel-mix');

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
mix.webpackConfig({
    plugins: [
    ],
    externals: {//配置不打包的选项
        'vue': 'Vue',
        'element-ui': 'Element',
        'axios': 'axios',
        'vue-router': 'VueRouter',
        "echarts": 'echarts',
        'less': 'less',
    }
});
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
