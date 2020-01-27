const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('postcss-nesting'),
  ])
  .purgeCss()
  .version()
