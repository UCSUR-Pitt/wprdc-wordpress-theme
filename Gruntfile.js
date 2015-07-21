module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            options: {
                outputStyle: 'compressed',
                includePaths: ['bower_components/foundation/scss']
            },
            dist: {
                files: {
                    'dist/style.css': 'scss/app.scss'
                }
            }
        },

        sync: {
            main: {
                files: [
                    {
                        expand: true,
                        flatten: true,
                        src: [
                            'bower_components/foundation/js/foundation.min.js',
                            'bower_components/foundation/js/vendor/modernizr.js'
                        ],
                        dest: 'dist/assets/js'
                    }
                ],
                verbose: true
            },
            wordpress: {
                files: [
                    {
                        cwd: 'dist/',
                        expand: true,
                        src: ['**/*'],
                        dest: 'public/wp-content/themes/<%= pkg.domain %>'
                    }
                ]
            }
        },

        watch: {
            sass: {
                files: ['scss/**/*.scss','bower_components/foundation/scss/**/*.scss'],
                tasks: ['sass']
            },
            wordpress: {
                files: ['dist/**/*'],
                tasks: ['sync:wordpress']
            }
        }
    });

    require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });
    require('time-grunt')(grunt);
  
    grunt.registerTask('default', ['sync:main','watch']);
    grunt.registerTask('build', ['sync:main','sass','sync:wordpress']);
};