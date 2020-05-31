const cssImport = require("postcss-import");
const cssNesting = require("postcss-nesting");
const mix = require("laravel-mix");
const path = require("path");
const purgecss = require("@fullhuman/postcss-purgecss");
const tailwindcss = require("tailwindcss");

// mix.copyDirectory("resources/fonts", "public/fonts");
mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css/app.css")
    .options({
        postCss: [
            cssImport(),
            cssNesting(),
            tailwindcss("tailwind.config.js"),
            ...(mix.inProduction()
                ? [
                      purgecss({
                          content: [
                              "./resources/views/**/*.blade.php",
                              "./resources/js/**/*.vue"
                          ],
                          defaultExtractor: content =>
                              content.match(/[\w-/:.]+(?<!:)/g) || [],
                          whitelistPatternsChildren: [/nprogress/]
                      })
                  ]
                : [])
        ]
    })
    .webpackConfig({
        output: { chunkFilename: "js/[name].js?id=[chunkhash]" },
        resolve: {
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
                "@": path.resolve("resources/js")
            }
        }
    })
    .version()
    .sourceMaps();
