[![Build Status](https://travis-ci.com/drupalnorge/drupalno.svg?branch=master)](https://travis-ci.com/drupalnorge/drupalno)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg)](https://violinist.io)

# Drupal.no

## Installation

There is two different ways based on your development environment.

If you want a database dump, here is one: [http://dev.drupal.no/sanitized.db](http://dev.drupal.no/sanitized.db)

### a) Your own development environment
1. Clone this repository. For example with: `git clone git@github.com:drupalnorge/drupalno.git`

2. `cd` into the repository root. Install the composer dependencies. For example with: `composer install`

3. Install drupal. You can do this however you want. One way is to use drush: `drush site-install --db-url=mysql://USER:PASS@HOST/DATABASE`

### b) Using *Lando* as a development environment

We have a ready configuration file for _[Lando development environment](https://docs.devwithlando.io)_ for you. However, you can change the configuration `.lando.yml`-file you want.

1. Clone this repository. For example with: `git clone git@github.com:drupalnorge/drupalno.git`

2. `cd` into the repository root and start the development environment by `lando start && lando ssh`.

## Upgrading the site/modules
*Only for the maintainers*

1. Login via ssh.

2. Clone the git from the latest update from master

3. Make sure you have database backup in case trouble after step 4. 

4. Run command `composer import` to import the configurations.

5. You have to verify that GIT is cloned and Drupal Configurations are imported and executed without any error. If no error, please add the labels `Verified cloned` and `Verified composer imported` on the GitHub issue/PR.

## Maintainers
 - [Eirik Falster (falster)](https://www.drupal.org/u/falster)
 - [Eirik S. Morland (eiriksm)](https://www.drupal.org/u/eiriksm)
 - [Truls S. Yggeseth (truls1502)](https://drupal.org/u/truls1502)