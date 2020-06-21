[![Build Status](https://travis-ci.com/drupalnorge/drupalno.svg?branch=master)](https://travis-ci.com/drupalnorge/drupalno)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg)](https://violinist.io)
[![Codeship Status for drupalnorge/drupalno](https://app.codeship.com/projects/6ff02ba0-602c-0137-b932-3e71eeafec30/status?branch=master)](https://app.codeship.com/projects/343995)

# Drupal.no

## Installation

There is two different ways based on your development environment.

If you want a database dump, here is one: [http://dev.drupal.no/sanitized.db](http://dev.drupal.no/sanitized.db)

### a) Your own development environment
1. Clone this repository. For example with: `git clone git@github.com:drupalnorge/drupalno.git`

2. `cd` into the repository root. Install the composer dependencies. For example with: `composer install`

3. Install drupal. You can do this however you want. One way is to use drush: `drush site-install --db-url=mysql://USER:PASS@HOST/DATABASE`

### b) Using *DDEV* as a development environment

We have a ready configuration file for _[DDEV development environment](https://ddev.readthedocs.io)_ for you. However, you can modify the DDEV-configuration on `.ddev/.config.yaml`-file.

```bash
git clone git clone git@github.com:drupalnorge/drupalno.git drupalno
cd drupalno
ddev auth ssh && ddev start && ddev composer install
```

# Copy database or files from the production environment.
*Only for the maintainers*
- Database: `drush sql-sync @prod @self -y` or use the sanitized database above. 
- Files: `drush rsync @prod:%files @self:%files -y`

Or you can spin up as a new one by Drush: `ddev drush site-install -y`

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