module.exports = function(grunt) {
  grunt.initConfig({
    postcss: {
      options: {
        // map: true, // inline sourcemaps

        // or
        map: {
            inline: false, // save all sourcemaps as separate files...
            annotation: 'dist/css/maps/' // ...to the specified directory
        },

        processors: [
          require('autoprefixer-core')({browsers: 'last 2 versions'}), // add vendor prefixes
          // require('cssnano')() // minify the result
        ]
      },
      dist: {
        src: 'public/css/*.css'
      }
    }
  });

  grunt.loadNpmTasks('grunt-postcss');

  grunt.registerTask('default', ['postcss']);
};