=== Advanced Custom Fields: Image Size Select Field ===
Contributors: jeremyrwross
Tags: Advanced Custom Fields, ACF, Image Size
Requires at least: 3.6.0
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Field to select registered image sizes within the WordPress dashboard.

== Description ==

Field to select registered image sizes within the WordPress dashboard.

== Compatibility ==

This ACF field type is compatible with:
* ACF 5

== Installation ==

1. Copy the `acf-image-size-select` folder into your `wp-content/plugins` folder
2. Activate the Image Size Select plugin via the plugins admin page
3. Create a new field via ACF and select the Image Size Select type

== How to Use ==

Once activated, this plugin will create a *Image Size* field type in ACF.  This field type will list all registered field types as a drop down within the field group.

To use this field within your custom templates you will use the following code:

~~~
$my_image_id   = get_field('my_image_id');    // ACF Image return type set to ID for this demo
$my_image_size = get_field('my_image_size');  // The selected image size (eg. large)

echo wp_get_attachment_image( $my_image_id, $my_image_size );  // Output the image based on the ID, and the Image Size selected.
~~~

== Changelog

= 1.0.3 =
* Add Github Action for Releases
* Update Tested version to 6.3

= 1.0.2 =
* Added medium_large to list of WordPress images to check
* Removed automated github to SVN sync

= 1.0.1 =
* Updated line formatting
* Added github to SVN sync

= 1.0.0 =
* Initial Release.
