=== Plugin Name ===
Contributors: esjay
Donate link: https://centerofthewest.org
Tags: museum,
Requires at least: 4.8
Tested up to: 4.8
Stable tag: 4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embed Buffalo Bill Center of the West Virtual Exhibits in your Wordpress site.

== Description ==

This simple plugin adds a shortcode to embed Virtual Exhibits from the Buffalo Bill Center of the West Online Collection into your Wordpress site. Create a Virtual Exhibit or a collection of items you love at https://collections.centerofthewest.org and then use this plugin to embed it in your Wordpress site. This plugin is designed to be lightweight and simple.

== Installation ==


1. Install and activate the plugin.
1. Create a Virtual Exhibit at https://collections.centerofthewest.org/ or browse the existing exhibits. The ID number is the the number after "exhibit" in the URL. So https://collections.centerofthewest.org/exhibit/20 has the ID `20`
1. Invoke the shortcode using, for example, `[BBCW-Virtual-Exhibit id=20]`
1. There are a few options, which should suit beginners to advanced users.
1. The base style container has a width of 100%, so you can make any size container you need.
1. *Note* This plugin will generate links back to the Center of the West Online Collection record for each item in the gallery. Use the `new_window` option if you want them to open in a new window.
1. Use the Element inspector to check out available CSS classes.

-- Options --
1. `id` put the id of the Virtual Exhibit you want to embed
1. `love_handle` this *supersedes* `id` and will display the list of loved items for the username supplied. For example `https://collections.centerofthewest.org/loved/sj3` the love_handle would be `sj3`
1. `layout` defaults to `grid`. Try `list` for a full-width list style.
1. `tile_size` defaults to `180`. The size, in pixels, that you want the items to be.
1. `margin` defaults to `12`. The margin around each item in pixels.
1. `show_title` defaults to `1`. Set this to ANYTHING other than `1` and the title will not display.
1. `background_color` defaults to `#ede9e7`. This is the background color of the item boxes (since not all images are the same dimensions, this is necessary). Use any valid CSS color.
1. `limit` defaults to `25`. The number of items, max is 100.
1. `new_window` defaults to `false`. Set a value (any value) to open links in a new window.
1. `show_footer` defaults to `false`. Set a value (any value) to show an appreciative footer with a link back to our Online Collection.
1. `selector` defaults to `#bbcw_exhibit_row`. Use this to place the AJAX results in any element you want. Use a valid jQuery selector.
1. `method` defaults to `append`. Use `replace` will overwrite the contents of the selector rather than appending.
1. `load_css` defaults to `1`. Use this only if you want to prevent the default CSS stylesheet from loading. Set to any value other than 1.
1. `debug` defaults to `false`. Set this to any value to have the shortcode options displayed.
1. Example with most options: `[BBCW-Virtual-Exhibit love_handle=sj3 tile_size=100 margin=5 show_title=0 background_color=green limit=3 new_window=1 show_footer=1 selector=#recent-posts-2 method=replace]`


-- Notes --
1. Questions, comments or feedback? We would love to hear from you. You can contact the developer using in the Wordpress forum, on the about page of https://collections.centerofthewest.org, or at the GitHub repo for this plugin.
1. If you are interested in contributing, we could especially use some new layout ideas. Check the plugin source for how [simple] the API works. The repo page is currently at https://github.com/sethjohnson1/center-of-the-west-virtual-exhibitor
1. The license for this plugin applies only to the code for the plugin itself, not the content it fetches. Images and data from the Buffalo Bill Center of the West Online Collection API are subject to Copyright. This plugin is for educational purposes only.


== Changelog ==

= 0.1 =
* This is the first release.
* Feedback is welcome, early adopters are cool!


