# __propz WordPress Tools Plugin__

![Made with PHP](https://img.shields.io/static/v1?label&message=PHP&color=777BB3&logo=php&logoColor=fff)
![Minimum PHP version: 8.0](https://img.shields.io/static/v1?label=PHP&message=>=8.0.0&color=777BB3)


## __Just a small collection of some handy WordPress functions and features.__

_Like it? I'd appreciate the support :)_

[![Watch on Twitch](https://img.shields.io/static/v1?label=Watch%20on&message=Twitch&color=bf94ff&logo=twitch&logoColor=fff)](https://propz.de/twitch/)
[![Join on Discord](https://img.shields.io/static/v1?label=Join%20on&message=Discord&color=7289da&logo=discord&logoColor=fff)](https://propz.de/discord/)
[![Donate on Ko-Fi](https://img.shields.io/static/v1?label=Donate%20on&message=Ko-Fi&color=ff5f5f&logo=kofi&logoColor=fff)](https://propz.de/kofi/)
[![Follow on Twitter](https://img.shields.io/static/v1?label=Follow%20on&message=Twitter&color=1DA1F2&logo=twitter&logoColor=fff)](https://propz.de/twitter/)

### __Description__

These are some basic functions and features that I use for my own WordPress websites. I don't want to redefine these functions again and again while developing custom themes, so that's what this plugin is for.

### __Instructions__

- Download the latest release
- Go to your wp-admin/plugins.php and install the plugin
- Have fun!

### __Functions overview__

```bash
# Added: Menu order for posts
# Added: HTML5 theme support > removes type="text/javascript" and type=”text/css” from enqueued scripts and styles.
# Removed: info about WordPress version from <head>
# Removed: Windows Live Writer manifest from <head>
# Removed: Current page shortlink
# Removed: Emojis from everywhere
# Removed: Auto-update email notifications
prpz_tools_init

# Removed: Tinymce emoji plugin.
prpz_disable_emojis_tinymce

# Removed: Some REST API Stuff
prpz_remove_api_stuff

# Added: REST API only for logged in users
prpz_rest_authentication_errors

# Removed: REST API endpoints for listing users
prpz_rest_endpoints

# Removed: All unneeded Dashboard Widgets
prpz_wp_dashboard_setup

# Removed: Duotone Filter in Gutenberg + loading of SVGs in body tag
prpz_remove_global_styles_render_svg_filters

# Added: Custom Mime types
prpz_upload_mimes

# Removed: X-PINGBACK header
prpz_wp_headers

# Removed: All notices for non-admins
prpz_hide_notices

# Removed: WP Comment IP logging
prpz_pre_comment_user_ip

# Added: Yoast - Custom separators
prpz_wpseo_separator_options

# Fuction: Write to default or custom log file
write_log

# Function: All in one CURL request
send_request_to_url

# Function: Get current year (function and shortcode)
get_year

# Plugin-Activity checks

# Is ACF active?
acf_activated

# Is WPML active?
wpml_activated

# Is WooCommerce active?
woocommerce_activated

# Is WooCommerce Germanized active?
woocommerce_germanized_activated

# Is Divi Theme active (parent or child)?
divi_theme_activated

# Is Divi Builder plugin active?
divi_builder_activated

# Is the user currently using the Divi Builder?
is_divi_builder_active
```

### __Found any Bugs?__

If you find any bugs/errors, feel free to [post an issue](https://github.com/pr0pz/propz-wordpress-tools/issues).


### __License__

![License: GPLv3](https://img.shields.io/static/v1?label=License&message=GNU&color=a32d2a&logo=gnu&logoColor=fff)

_That's it!_

___Be excellent to each other. And, Party on, dudes!___