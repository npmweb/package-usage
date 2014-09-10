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
      ],
      sass: [
        '<%= paths.frontend %>/<%= paths.css %>/main.css'
      ]
    },
    symlink: {
      includes: {
        files: [
            {
              src: '<%= paths.shared %>',
              dest: '<%= paths.frontend %>/includes/shared'
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
      },
      composer: {
        options: {
          title: 'Composer',
          message: 'Update finished.'
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
  grunt.registerTask('composer-update', function(env) {
    grunt.task.run(['composer:update','notify:composer']);
  });
}
