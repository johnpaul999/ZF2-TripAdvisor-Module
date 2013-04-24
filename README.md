# Netglue Trip Advisor Feed ZF2 Module

Helpful tools and utilities for consuming and rendering feeds from Trip Advisor.

This module is not hugely flexible and doesn't perform any wondrous magic. It's basically a wrapper around Zend's Feed Reader that does a couple of bits and bobs to help get better information out of a trip advisor RSS feed. The feed instance will allow you to specify the number of reviews returned _(Bearing in mind that TA only provides the 10 most recent, this has limited appeal!)_ and the returned array, rather than Feed Entries are instances of `NetglueTripAdvisor\Model\Review`'s... The review instance provides the star rating as an integer _(out of a possible 5, so 0-5)_ strips the rating information from the review excerpt and provides just the review body.

The module ships with some configuration help with caching - read the config files for comments.

There's also a ready to go view helper you can call with `$this->ngTripAdvisorFeed()` which simply renders a partial that is configured using the `template_map` settings in `view_manager` configuration so it can be easily overridden.

## Install...
... with composer... blah, blah. Composer key is `netglue/zf2-tripadvisor-module` and the module name for main config is `NetglueTripAdvisor` - There's nothing special about this module - it just needs ZF 2.

## Contribute...
Yes please, it's all on Bitbucket at: [https://bitbucket.org/netglue/zf2-tripadvisor-module](https://bitbucket.org/netglue/zf2-tripadvisor-module)

## Todo
Tests ... though it's not likely I'll find time to do this unless it becomes very important to others...



