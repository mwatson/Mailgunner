Mailgunner
----

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
        "mwatson/Mailgunner": "dev-master"
    }
}
```

## Usage

```php
$mgConfig = [
    'url'    => "https://api.mailgun.net/v3",
    'key'    => "YOUR_MAILGUN_API_KEY",
    'domain' => "your.mailgun.domain",
];

$sender = Mailgunner::create($mgConfig)
            ->to("someone@somewhere")
            ->from("me <me@my.domain>")
            ->subject("Sending an email!")
            ->html($htmlBody)
            ->text($textBody);

$result = $sender->send();
```

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
