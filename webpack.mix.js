const path = require('path')
const mix = require('laravel-mix')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

mix
  .js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')

  .sourceMaps()
  .disableNotifications()

if (mix.inProduction()) {
  mix.version()

  mix.extract([
    '@fortawesome/fontawesome-free',
    '@tinymce/tinymce-vue',
    'axios',
    'bootstrap',
    'jquery',
    'js-cookie',
    'jspdf',
    'lodash',
    'moment',
    'popper.js',
    'tinymce',
    'vform',
    'vue',
    'vue-carousel',
    'vue-html2canvas',
    'vue-i18n',
    'vue-material',
    'vue-meta',
    'vue-picture-input',
    'vue-recaptcha',
    'vue-router',
    'vue-tinymce',
    'vuetify',
    'vuex',
    'vuex-router-sync'
  ])
}

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin()
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/assets/js')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/'
  }
})
