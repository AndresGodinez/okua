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
mix.less(`${ASSETS_DIR}/styles/app/login/logout-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/home/home-index.less`, 'css');
<<<<<<< Updated upstream

// ---------------------------------------------------------------------------------------------------------------------
// --- catalogs

//users
mix.less(`${ASSETS_DIR}/styles/app/catalogs/users/catalogs-user-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/catalogs/users/catalogs-user-form.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/catalogs/users/catalogs-user-activity-form.less`, 'css');
//emitters
mix.less(`${ASSETS_DIR}/styles/app/catalogs/emitters/catalogs-emitters-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/catalogs/emitters/catalogs-emitter-form.less`, 'css');
//alert-email-responses
mix.less(`${ASSETS_DIR}/styles/app/catalogs/alert-email-responses/catalogs-alert-email-responses-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/catalogs/alert-email-responses/catalogs-alert-email-response-form.less`, 'css');

//filter emitter-response
mix.less(`${ASSETS_DIR}/styles/app/catalogs/filter-emitters/catalogs-filter-emitters-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/catalogs/filter-emitters/catalogs-filter-emitter-form.less`, 'css');

//filter receptors
mix.less(`${ASSETS_DIR}/styles/app/catalogs/filter-receptors/catalogs-filter-receptors-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/catalogs/filter-receptors/catalogs-filter-receptor-form.less`, 'css');

// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

=======
mix.less(`${ASSETS_DIR}/styles/app/catalogs/users/catalogs-user-index.less`, 'css');
>>>>>>> Stashed changes
mix.less(`${ASSETS_DIR}/styles/app/providers/home/home-index.less`, 'css/providers-home');
mix.less(`${ASSETS_DIR}/styles/app/bills/bills-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/movements-log/movements-log-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/warning/warning-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/app/error/error-index.less`, 'css');
mix.less(`${ASSETS_DIR}/styles/admin/config/admin-config-email-service-index.less`, 'css');

mix
  .js(`${ASSETS_DIR}/js/catalogs/users/user-index-content`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/users/user-form`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/users/user-activity-form`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/emitters/emitters-index-content`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/emitters/emitter-form`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/alert-email-responses/alert-email-responses-index`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/alert-email-responses/alert-email-response-form`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/filter-emitters/filter-emitters-index`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/filter-emitters/filter-emitter-form`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/filter-receptors/filter-receptors-index`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/filter-receptors/filter-receptor-form`, 'js');

mix
  .js(`${ASSETS_DIR}/js/app/providers/home/home-index`, 'js/providers-home')
  .js(`${ASSETS_DIR}/js/app/login/login-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/login/logout-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/home/home-index`, 'js')
  .js(`${ASSETS_DIR}/js/catalogs/users/user-index-content`, 'js')
  .js(`${ASSETS_DIR}/js/app/bills/bills-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/warning/warning-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/error/error-index`, 'js')
  .js(`${ASSETS_DIR}/js/app/movements-log/movements-log-index`, 'js')
  .js(`${ASSETS_DIR}/js/admin/config/email-service-index`, 'js/admin-config-email-service-index.js')
  .extract(["vue"], 'js/vendor')
;
