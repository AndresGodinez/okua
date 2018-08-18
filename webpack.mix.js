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

mix.less(`${ASSETS_DIR}/styles/app/login/login-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/home/home-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/providers/home/home-index.less`, 'css/providers-home');
mix.less(`${ASSETS_DIR}/styles/app/bills/bills-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/movements-log/movements-log-index.less`, 'css');

mix
  .js(`${ASSETS_DIR}/js/app/login/login-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/home/home-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/bills/bills-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/movements-log/movements-log-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/providers/home/home-index`, 'js/providers-home')
  .extract(["vue"], 'js/vendor')
;
