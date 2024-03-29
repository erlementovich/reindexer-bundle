<p align="center">
  <a href="https://sentry.io/?utm_source=github&utm_medium=logo" target="_blank">
    <img src="https://i.ibb.co/r2JSLGm/reindexer.png" alt="pik-reindexer" width="300" height="107">
  </a>
</p>

_Reindexer is an embeddable, in-memory, document-oriented database with a high-level Query builder interface. Reindexer's goal is to provide fast search with complex queries. We at Restream weren't happy with Elasticsearch and created Reindexer as a more performant alternative. The core is written in C++ and the application level API is in Go._

# Reindexer SDK for Symfony

[![Latest Stable Version](http://poser.pugx.org/erlementovich/reindexer-bundle/v)](https://packagist.org/packages/erlementovich/reindexer-bundle)
[![Total Downloads](http://poser.pugx.org/erlementovich/reindexer-bundle/downloads)](https://packagist.org/packages/erlementovich/reindexer-bundle)
[![Latest Unstable Version](http://poser.pugx.org/erlementovich/reindexer-bundle/v/unstable)](https://packagist.org/packages/erlementovich/reindexer-bundle)
[![License](http://poser.pugx.org/erlementovich/reindexer-bundle/license)](https://packagist.org/packages/erlementovich/reindexer-bundle)
[![PHP Version Require](http://poser.pugx.org/erlementovich/reindexer-bundle/require/php)](https://packagist.org/packages/erlementovich/reindexer-bundle)

This is the Symfony SDK for [Reindexer](https://github.com/Restream/reindexer).

### Install

To install the SDK you will need to be using [Composer]([https://getcomposer.org/)
in your project. To install it please see the [docs](https://getcomposer.org/download/).

```bash
composer require erlementovich/reindexer-bundle
```

If your project does *not* use Symfony Flex the following needs to be added to `config/bundles.php` manually:

```php
<?php

return [
    // other bundles here
    Pik\\Bundle\\ReindexerBundle\\ReindexerBundle::class => ['all' => true],
];
```
### Configuration

Reindexer clients can be configured in `config/packages/pik_reindexer.yaml`.

```yaml
pik_reindexer:
    clients:
        first:
            url: 'http://url'
            dbname: 'firstdbname'
            auth:
                user: example_user
                password: 12345
            api_class: App\Reindexer\Api
        second:
            url: 'http://url'
            dbname: 'seconddbname'
        # More clients here
```
