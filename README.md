blockify-wordpress-helper
=========================

Helper functions for WordPress when using Blockify.

This block will automatically add ```blockify_css()``` and ```blockify_js()``` to the ```wp_head and wp_footer()``` actions respectively.

## Available Functions

```bwp_get_nav_menu_items()``` -- gets nav_menu items for use with header-simple. Also tidies up the default WordPress menu output

```bwp_get_the_content()``` -- applies the_content filters to get_the_content and returns it. Required for any situation where you want to use the return value of the_content.

```bwp_get_the_post_thumbnail_src()``` returns the URL of the current posts featured image. Useful for when you're using images in a block.
