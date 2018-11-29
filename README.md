# ACF Image Size Select Field

This is an add-on for the [Advanced Custom Fields](http://advancedcustomfields.com/) WordPress plugin, that allows you to a field so a [WordPress custom image size](https://developer.wordpress.org/reference/functions/add_image_size/) can be selected.

## Compatibility

This add-on will work ACF 5 only.

## Installation

This add-on can be installed as a WordPress plugin.

### Install as Plugin

* Copy the 'advanced-custom-fields-image-size-select' folder into your plugins folder
* Activate the plugin via the Plugins admin page

## How to Use

Once activated, this plugin will create a *Image Size* field type in ACF.  This field type will list all registered field types as a drop down within the field group.

To use this field within your custom templates you will use the following code:

```
<?php
$my_image_id   = get_field('my_image_id');    // ACF Image return type set to ID for this demo
$my_image_size = get_field('my_image_size');  // The selected image size (eg. large)

echo wp_get_attachment_image( $my_image_id, $my_image_size );  // Output the image based on the ID, and the Image Size selected.
?>
```

*This plugin will not create or crop custom image sizes, it only allows the selection of a [predefined custom image sizes](https://developer.wordpress.org/reference/functions/add_image_size/).*

## Changelog

1.0.0
* Initial Release.