# iMW Woocommerce Custom Add-to-cart Button

[![Build status](https://img.shields.io/github/workflow/status/Triex/iMW-woocommerce-custom-add-to-cart-button)](https://github.com/Triex/iMW-woocommerce-custom-add-to-cart-button/actions)
[![GitHub release](https://img.shields.io/github/release/Triex/iMW-woocommerce-custom-add-to-cart-button.svg)](https://github.com/Triex/iMW-woocommerce-custom-add-to-cart-button/releases)
[![GitHub issues](https://img.shields.io/github/issues/Triex/iMW-woocommerce-custom-add-to-cart-button.svg)](https://github.com/Triex/iMW-woocommerce-custom-add-to-cart-button/issues)
[![GitHub license](https://img.shields.io/badge/license-GPLv2-blue.svg)](https://raw.githubusercontent.com/Triex/iMW-woocommerce-custom-add-to-cart-button/master/LICENSE)

A WordPress plugin that adds a custom button to WooCommerce products which can replace the default add-to-cart button or be added as a second button.

Made for use with Odrin Theme, but could work with others (not tested).

_Note: The default styles are designed to match the site it was intended for._

# Development

All code is in the `/iMW-woocommerce-custom-add-to-cart-button` directory.

[iMW-woocommerce-custom-add-to-cart-button.php](iMW-woocommerce-custom-add-to-cart-button/iMW-woocommerce-custom-add-to-cart-button.php) is the main and only plugin file.

The [`/woocommerce/single-product/add-to-cart/simple.php`](https://github.com/Triex/iMW-woocommerce-custom-add-to-cart-button/blob/master/wp-content/themes/odrin-child/woocommerce/single-product/add-to-cart/simple.php) file has been edited via child-theme to add the `imw_custom_button_action` action, and `replace_add_to_cart_toggle` option.

## Requirements

- WordPress


During dev you can symlink the plugin directory to your WordPress plugins directory:

```
ln -s /path/to/iMW-woocommerce-custom-add-to-cart-button /path/to/wordpress/wp-content/plugins/iMW-woocommerce-custom-add-to-cart-button
```

# Contribution

I created this plugin as I needed the functionality, and people charge a premium for such basic expected features.

Feel free to expand on it, but if you use this code - it would be appreciated if you contribute anything of value - rather than just downloading the zip and creating your own version. (Help benefit everyone!)

## Building

We use `--all` to push all branches and tags:

```
git push --all
```

## Creating Releases

Set the version (git tag):

```
git tag v0.3.5
```

```
git push --tags
```

When a tag is pushed, the release will be zipped and uploaded to the [releases page](https://github.com/Triex/iMW-woocommerce-custom-add-to-cart-button/releases).

-----

## Licence

The contents of this repo are licensed under GPLv2. See [LICENCE](LICENSE).

-----

Copyright © 2023 Alex Zarov | [iMakeWebsites.co](https://iMakeWebsites.co)
