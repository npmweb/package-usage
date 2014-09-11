Package Usage
=============

Statistics on what Composer packages all of your webapps use.

Usage
=====

A command-line process, `php artisan usage:update`, connects to your Bitbucket account, checks out your repositories, and loads info on all their Composer dependencies. The calculated information is cached locally in a JSON file. When browsing the webapp, the data is displayed from that cached data. To keep it up-to-date, schedule a cron to run `php artisan usage:update` regularly.

Limitations
===========

This app is under development, and still has several limitations:

- It can only load webapps from a single Bitbucket repository, not other hosts or from multiple.
- It can only load dependencies from Packagist or Git repos, not svn.
- When loading dependencies from Git repos, it can only find them if the package name is in the repo URL; if they don't match, it won't be found.
- The entirety of each repo is stored locally indefinitely. Need to update this to only pull down the composer.json file.

Installation
============

Make sure the following are installed on your system:

1. [Node.js, NPM](http://nodejs.org/), and [Grunt](http://gruntjs.com/installing-grunt) for build script.
2. [Composer](https://getcomposer.org/doc/00-intro.md) for PHP dependencies.
3. [Sass](http://sass-lang.com/install) (look for the command-line section) for stylesheets.

Then:

1. Duplicate `.env.example.json` as `.env.json` and enter your Bitbucket username and OAuth connection info.
2. Run `sudo npm install` to install the grunt packages for this project.
3. Run `grunt`. This:
    - Installs PHP dependencies with `composer install`.
    - Creates symlinks for web assets with `symlink`.
    - Makes sure temp folders are writable with `chmod`.
    - Generates CSS from Sass.
    - Runs automated tests with `phpunit`
4. Set up MAMP to point `app/endpoints/frontend` to the web address you want it at.
5. Edit `endpoints/[backend and frontend]/.htaccess`, changing the RewriteBase line to the path your app is at
6. When you're ready to code, run `grunt watch` (it will keep running in that terminal window). It will run unit tests as code changes, and recompile CSS as Sass changes. You'll see an OS  notification pop up if there are any problems.
