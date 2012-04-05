sfGaufrettePlugin
=================

include Gaufrette in a symfony project.

first define your filesystem occurences :

``` yaml
# app.yml
all:
  gaufrette:
    path:
    autoload: true
    my_filesystem:
      adapter:
        class:  \Gaufrette\Adapter\Local
        param:
          destination: %SF_UPLOAD_DIR%
      cache:
        class:  \Gaufrette\Adapter\Local
        param:
          destination: %SF_CACHE_DIR%/gaufrette/cache
        ttl:    3600
      url_resolver:
        class:  sfPrefixUrlResolver
        param:
          prefix: %SF_WEB_DIR%/uploads
```

* The path option allow you to specify a different path for the gaufrette vendor.
* The autoload option allow you to use your own autoloader instead of the plugin one.


and access it through context :

``` php
<?php
// myAction.class.php
$myFilesystem = $this->getContext()->getGaufrette('my_filesystem');

$url = $myFilesystem->getUrl('my_ressource_key');
$content = $myFilesystem->read('my/file.ext');
$myFilesystem->write('my/file.ext.bck', $content);
```

Installation
------------

``` php
```
