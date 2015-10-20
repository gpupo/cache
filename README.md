[![Build Status](https://secure.travis-ci.org/gpupo/cache.png?branch=master)](http://travis-ci.org/gpupo/cache)
[![Code Climate](https://codeclimate.com/github/gpupo/cache/badges/gpa.svg)](https://codeclimate.com/github/gpupo/cache)
[![Test Coverage](https://codeclimate.com/github/gpupo/cache/badges/coverage.svg)](https://codeclimate.com/github/gpupo/cache/coverage)

This is a Caching library that implements PSR-6.

[PSR-6](https://github.com/php-fig/fig-standards/blob/master/proposed/cache.md) is (still) not accepted, hence this lib does not only contains a null-caching PSR-6 implementation,
it also contains a copy of the current (2014-09-24) PSR interface, and has this set as a composer "replace"
relation.

Current Driver Support:

* Filesystem
* APC
* Memached


## Install

    composer require gpupo/cache

## Contributors

- [@gpupo](https://github.com/gpupo)
- [All Contributors](https://github.com/gpupo/cache/contributors)

## License

MIT, see LICENSE.

## Links

* [Composer Package](https://packagist.org/packages/gpupo/cache) on packagist.org
