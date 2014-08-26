/**
 * Creates symlinks for the multiple endpoints
 *
 * Requires npm, which is part of node.js <http://nodejs.org/>
 * To run:
 *   npm install
 *   grunt
 */
module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    paths: {
      shared: 'endpoints/shared',
      frontend: 'endpoints/frontend',
      backend: 'endpoints/backend',
      sass: 'includes/scss',
      css: 'includes/css',
      src: 'app/src',
      tests: 'app/tests',
      views: 'app/views',
      routes: 'app/routes.php',
      config: 'app/config'
    },

    clean: {
      symlink: [
        '<%= paths.frontend %>/includes/shared',
        '<%= paths.backend %>/includes/shared',
      ],
      sass: [
        '<%= paths.backend %>/<%= paths.css %>/main.css'
      ]
    },
    symlink: {
      includes: {
        files: [
            {
              src: '<%= paths.shared %>',
              dest: '<%= paths.frontend %>/includes/shared'
            },
            {
              src: '<%= paths.shared %>',
              dest: '<%= paths.backend %>/includes/shared'
            }
        ]
      }
    },
    chmod: {
        options: {
          mode: '777'
        },
        logs: {
          src: [
            'app/storage/',
            'app/storage/cache/',
            'app/storage/logs/',
            'app/storage/meta/',
            'app/storage/sessions/',
            'app/storage/views/',
            'vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer'
          ]
        }
    },
    phpunit: {
      classes: {
        dir: '<%= paths.tests %>'
      },
      options: {
        colors: true
      }
    },
    shell: {
      migrate: {
        command: function(env) {
          return [
            'php artisan migrate --env=backend-'+env,
          ].join(';');
        }
      },
      dbseed: {
        command: function(env) {
          return [
            'php artisan db:seed --env=backend-'+env,
          ].join(';');
        }
      }
    },
    sass: {
      backend: {
        options: {
          style: 'compressed'
        },
        files: {
          '<%= paths.backend %>/<%= paths.css %>/main.css':
            '<%= paths.backend %>/<%= paths.sass %>/main.scss'
        }
      },
      frontend: {
        options: {
          style: 'compressed'
        },
        files: {
          '<%= paths.frontend %>/<%= paths.css %>/main.css':
            '<%= paths.frontend %>/<%= paths.sass %>/main.scss'
        }
      }
    },
    watch: {
      tests: {
        files: [
          '<%= paths.tests %>/**/*.php',
          '<%= paths.src %>/**/*.php',
          '<%= paths.views %>/**/*.php',
          '<%= paths.config %>/**/*.php',
          '<%= paths.routes %>'
        ],
        tasks: ['phpunit','notify:phpunit']
      },
      sass: {
        files: [
          '<%= paths.backend %>/<%= paths.sass %>/**/*.scss',
          '<%= paths.frontend %>/<%= paths.sass %>/**/*.scss'
        ],
        tasks: ['sass','notify:sass']
      }
    },
    notify: {
      phpunit: {
        options: {
          title: 'PHPUnit',
          message: 'All tests passed.'
        }
      },
      sass: {
        options: {
          title: 'Sass',
          message: 'CSS updated.'
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-chmod');
  grunt.loadNpmTasks('grunt-composer');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-symlink');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks('grunt-shell');

  grunt.registerTask('default', [
    'composer:install',
    'symlink',
    'chmod',
    'sass',
    'migrate:local',
    'dbseed:local',
    'phpunit'
  ]);
  grunt.registerTask('migrate', function(env) {
    grunt.task.run('shell:migrate:'+env);
  });
  grunt.registerTask('dbseed', function(env) {
    grunt.task.run('shell:dbseed:'+env);
  });
}
