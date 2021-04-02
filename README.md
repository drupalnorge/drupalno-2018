[![Build Status](https://www.travis-ci.com/drupalnorge/drupalno.svg?branch=develop)](https://www.travis-ci.com/drupalnorge/drupalno)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg)](https://violinist.io)

# Drupal.no

## Installation with *DDEV* as a development environment

We have a ready configuration file for _[DDEV development environment](https://ddev.readthedocs.io)_ for you. However, you can modify the DDEV-configuration on `.ddev/.config.yaml`-file.

```bash
git clone git clone git@github.com:drupalnorge/drupalno.git drupalno
cd drupalno
ddev auth ssh && ddev start && ddev composer install
pushd web/themes/drupal_nl && chmod +x ./build.sh && ./build.sh && popd
pushd web/sites/default && ln -s settings.local.php.example settings.local.php && popd
```

# Copy database or files from the production environment.
- Database: `drush sql-sync @prod @self -y` or use the sanitized database above.
- Files: `drush sfp-en`

Or you can spin up as a new one by Drush: `ddev drush site-install -y`

## Maintainers
 - [Eirik S. Morland (eiriksm)](https://www.drupal.org/u/eiriksm)
 - [Sven Berg Ryen (svenryen)](https://www.drupal.org/u/svenryen)
 - [Truls S. Yggeseth (truls1502)](https://drupal.org/u/truls1502)
