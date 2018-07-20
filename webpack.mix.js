let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

const ASSETS_DIR = 'web-app/src';

//mix.setResourceRoot('public/');
mix.setPublicPath('public/');

mix.options({
  processCssUrls: true,
  imgLoaderOptions: {
    enabled: false,
  },
  postCss: [
    tailwindcss('./tailwind.js'),
  ],
});

// disable notification when building/compiling
//mix.disableNotifications();

mix.less(`${ASSETS_DIR}/styles/home/home-index.less`, 'css');

mix
  .js(`${ASSETS_DIR}/js/home/home-index`, 'js')
  .extract(["vue"], 'js/vendor')
;
