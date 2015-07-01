module.exports = function(grunt) {
  grunt.initConfig({
    postcss: {
      options: {
        // map: true, // inline sourcemaps

        // or
        map: {
            inline: false, // save all sourcemaps as separate files...
            annotation: 'public/maps/css/' // ...to the specified directory
        },

        processors: [
          require('autoprefixer-core')({browsers: 'last 2 versions'}), // add vendor prefixes
          require('cssnano')() // minify the result
        ]
      },
      dist: {
        src: 'public/css/main.css',
        dest: 'public/css/main.min.css'
      }
    },
    uglify: {
      my_target: {
        options: {
          sourceMap: true,
          sourceMapName: 'public/maps/js/main.js.map'
        },
        files: {
          'public/js/main.min.js': ['public/js/main.js']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-contrib-uglify');


  grunt.registerTask('default', ['postcss', "uglify"]);
};