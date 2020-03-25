'use strict'
const { VueLoaderPlugin } = require('vue-loader')
const { CssLoader } = require('css-loader')
module.exports = {
  mode: 'development',
  entry: [
    './src/app.js'
  ],
  watch: true,
  resolve: {
    alias: {
      vue$: 'vue/dist/vue.runtime.esm.js'
    }
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader'
      },
      {
        test: /\.css$/,
        use: ['vue-style-loader', 'css-loader']
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin()
  ]
}