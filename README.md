# ZF2 Trip Advisor Reviews Module

[![Build Status](https://travis-ci.org/netglue/ZF2-TripAdvisor-Module.svg?branch=master)](https://travis-ci.org/netglue/ZF2-TripAdvisor-Module)
[![Coverage Status](https://img.shields.io/coveralls/netglue/ZF2-TripAdvisor-Module.svg)](https://coveralls.io/r/netglue/ZF2-TripAdvisor-Module)


## Install

The only supported method of installation is with composer:
    
    $ composer require netglue/zf2-tripadvisor-module

Once installed, activate the module by adding `NetglueTripAdvisor` to your application config and copy the `config/module.config.php.dist` to your autoload directory as something like `tripadvisor.global.php` and customise the options to suit your needs.

## How it works

There is a simple scraper that loads the remote TA reviews page selected and traverses the DOM to extract the reviews from the page.

**This is susceptible to breaking if Trip Advisor alter their markup**

## Future Plans

If I get the time, I might consider persisting the reviews so that if/when TA do alter their markup, at least we'll be able to continue to present the old reviews.

## Tests

The module has a test suite you can run. `phpunit` has not been declared as a dev dependency so it must be installed separately if not.
    
    $ cd path/to/vendor/zf2-tripadvisor-module
    $ composer install
    $ phpunit

## Contributing & Reporting Bugs

Please feel free to report issues but without a pull request, I'm unlikely to be able to fix things in a timely manner. Please also include tests along with any changes.

If you're using this module, it'd be nice to know, so drop me a line on gsteel at gmail

