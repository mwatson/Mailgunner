Mailgunner
----

[![Build Status](https://travis-ci.org/mwatson/BoggleSolver.svg?branch=master)](https://travis-ci.org/mwatson/BoggleSolver)

Dead simple Mailgun sender. Requires cURL extension for PHP.

## Installing

If you use composer:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mwatson/Mailgunner.git"
        }
    ],
    "require": {
        "mwatson/BoggleSolver": "0.3.0"
    }
}
```

## Usage


## Tests

If you have composer and make installed, you can run the following:

```
composer install
make tests
```

The `make coverage` command will also build coverage maps in HTML. `make clean` 
will delete the coverage directory.

## License

&copy; Mike Watson

Released under the [MIT license](http://opensource.org/licenses/MIT). See the 
`LICENSE` file.
