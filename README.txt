=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://centerofthewest.org
Tags: 
Requires at least: 4.8
Tested up to: 4.8
Stable tag: 4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embed Buffalo Bill Center of the West virtual exhibits in your Wordpress site.

== Description ==

This simple plugin adds a shortcode to embed Virtual Exhibits from the Buffalo Bill Center of the West Online Collection into your Wordpress site.

== Installation ==

This section describes how to install the plugin and get it working.

1. Install and activate the plugin.
1. Create a Virtual Exhibit at https://collections.centerofthewest.org/ or browse the existing exhibits. The ID number is the the number after "exhibit" in the URL. So https://collections.centerofthewest.org/exhibit/20 has the ID `20`
1. Invoke the shortcode using, for example, `[BBCW-Virtual-Exhibit id=20]`
1. There are a few options, which should suit beginner to advanced users.
1. The base style container has a width of 100%, so you can make any size container you need.

-- options --
1. `id` put the id of the Virtual Exhibit you want to embed
1. `love_handle` this *supersedes* `id` and will display the list of loved items for the username supplied. For example `https://collections.centerofthewest.org/loved/sj3` the handle would be `sj3`
1. `tile_size` defaults to `180`. The size, in pixels, that you want the items to be.
1. `display_title` defaults to `1`. Set this to ANYTHING other than one and the title will not display.
1. `background_color` defaults to `#ede9e7`. This is the background color of the item boxes (since not all images are the same dimensions, this is necessary). Use any valid CSS color.
1. `limit` defaults to `25`. The number of items, max is 100.
1. `selector` defaults to `#bbcw_exhibit_row`. Use this to place the AJAX results in any element you want. Use a valid jQuery selector.
1. 



== Changelog ==

= 0.1 =
* This is the first release.
* Feedback is welcome, early adopters are cool!


