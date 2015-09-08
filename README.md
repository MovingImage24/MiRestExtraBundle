# Mi RestExtraBundle

[![Build Status](https://travis-ci.org/MovingImage24/MiRestExtraBundle.svg?branch=master)](https://travis-ci.org/MovingImage24/MiRestExtraBundle)
[![Latest Stable Version](https://poser.pugx.org/mi/rest-extra-bundle/v/stable)](https://packagist.org/packages/mi/rest-extra-bundle)
[![Latest Unstable Version](https://poser.pugx.org/mi/rest-extra-bundle/v/unstable)](https://packagist.org/packages/mi/rest-extra-bundle)
[![Total Downloads](https://poser.pugx.org/mi/rest-extra-bundle/downloads)](https://packagist.org/packages/mi/rest-extra-bundle)
[![License](https://poser.pugx.org/mi/rest-extra-bundle/license)](https://packagist.org/packages/mi/rest-extra-bundle)

## Overview

...

## Installation

1. Add this bundle to your project as a composer dependency:

  ```bash
  composer require mi/rest-extra-bundle
  ```

2. Add this bundle in your application kernel:

    ```php
    // app/AppKernel.php
    public function registerBundles()
    {
        // ...
        $bundles[] = new \Mi\Bundle\RestExtraBundle\MiRestExtraBundle();

        return $bundles;
    }
    ```

## Usage

...

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

# License

This library is under the [MIT license](https://github.com/MovingImage24/MiRestExtraBundle/blob/master/LICENSE).