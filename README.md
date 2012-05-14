sfGaufrettePlugin
=================

The sfGaufrettePlugin integrates [Gaufrette](https://github.com/KnpLabs/Gaufrette/)
in a symfony project.

[![Build Status](https://secure.travis-ci.org/Carpe-Hora/sfGaufrettePlugin.png?branch=master)](http://travis-ci.org/Carpe-Hora/sfGaufrettePlugin)

What's cool with this plugin?
-----------------------------

First, it uses a cool project. Then, it's cool because it allows you to define
"gaufrettes" directly from the `config/gaufrettes.yml` configuration file and use them easily
everywhere in your applications.

It also provides a way to map filesystem resources (files) to their URL.


Exemples
-----


### Gaufrettes definition

``` yaml
# config/gaufrettes.yml
all:                                    # the environment
  my_filesystem:
    adapter:                            # create a ftp filesystem
      class:  \Gaufrette\Adapter\Ftp
      param:
        path:     /home/joe
        host:     foo.com
        username: joe
        password: joe
    cache:                              # cache it locally
      class:  \Gaufrette\Adapter\Local
      param:
        destination: %SF_CACHE_DIR%/gaufrette/cache
      ttl:    3600
    url_resolver:                       # and define the URL resolver
      class:  sfPrefixUrlResolver
      param:
        prefix: /uploads/
```

### Gaufrette usage

The previous configuration creates a gaufrette named _my_filesystem_ and exposes it
through the context:

``` php
<?php
// myAction.class.php
$myFilesystem = $this->getContext()->getGaufrette('my_filesystem');

$url = $myFilesystem->getUrl('my_resource_key');
$content = $myFilesystem->read('my/file.ext');
$myFilesystem->write('my/file.ext.bck', $content);
```

Once you have retrieved the gaufrette, you can use it as described in the
[Gaufrette README](https://github.com/KnpLabs/Gaufrette/blob/master/README.markdown).

### The URL resolvers

The URL resolvers are the entities that map files to URL. There are currently
two of them included in the plugin:

  * `sfPrefixUrlResolver`: the url is the concatenation of a prefix and a filename
  * ̀`sfAmazonS3UrlResolver`: turns informations of a bucket and a filename into
    a public url

### Form integration

We provide a validator to use instead of the `sfValidatorFile` to ease the
integration in forms. See the
[`sfGaufretteFileValidator`](https://github.com/Carpe-Hora/sfGaufrettePlugin/blob/master/lib/validator/plugin/PluginSfGaufretteFileValidator.class.php)
class for more information.

Installation
------------

Install the behavior in your plugins directory:

```
git submodule add git://github.com/Carpe-Hora/sfGaufrettePlugin.git
git submodule update --init --recursive
```

As [Gaufrette](https://github.com/KnpLabs/Gaufrette/) is bundled with the
plugin, you have to initialize the submodules, at least for the
sfGaufrettePlugin.

And now, enable the plugin in your project's configuration.

``` php
<?php
// config/ProjectConfiguration.class.php

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array(
      // ...
      'sfGaufrettePlugin',
      // ...
    ));
  }
}
```


Licence
-------

sfGaufrettePlugin is released under the MIT License. See the bundled LICENSE file for
details.
