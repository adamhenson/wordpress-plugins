=== Insertagram ===
Contributors: Hensonism
Tags: Instagram, Insertagram, Instagram photos, Instagram plugin, Instagram stream, Custom Instagram Feed, responsive Instagram, mobile Instagram, Instagram posts, Instagram wall, Instagram account
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 0.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display hand-picked images or a feed from an Instagram account with ease in a simple, elegant, responsive layout.

== Description ==

**The key ingredient (separation from all the other Instagram plugins) is the capability to choose photos to insert one at a time or by groups.** Within the Wordpress admin choose images from your Instagram account to show. You can also display a feed of your most recent posts to show in real time. The presentation includes up to date like count, comment count, caption, and profile pic.

See a demo [here](http://insertagram.hensonism.com "here").

= Features =
* Simple to setup and use. No Instagram developer account needed.
* Completely **responsive** - mobile friendly.
* Choose images individually or by a group to generate a shortcode and embed on any post or page.
* The clean and simple presentation shows only the images and on hover - the details, including like count, comment count, caption and profile pic.
* The option to hide the details and show only the images.
* Display most recent feed in real time with all info on hover state of user interaction.
* "More" button on feeds so users can browse through the entirety of the feed.

= Feedback or Support =
Please send an email to [Adam](mailto:adamhenson1979@gmail.com "Adam").

== Installation ==

1. Install the Instagram plugin either via the WordPress plugin directory, or by uploading the files to your web server (in the `/wp-content/plugins/` directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Insertagram' settings page to obtain your Instagram Access Token and User ID.
4. Create a custom shortcode by clicking on the 'Insertagram +' link in the left nav or use the shortcode `[insertagram feed=true]` to display a real-time feed of your recent Instagram posts - in any page or post.

= Shortcode Options =
* **id** - A unique ID generated when creating a custom shortcode via the 'Insertagram +' left nav link. This ID will be generated for you - after selecting image/s - Example: `[insertagram id=1234]`
* **feed** - If true - this option will display a real-time feed of most recent posts. This option should not exist with the `id` option - Example: `[insertagram feed=true]`
* **info** - If false - all info including comment count, like count, caption, and profile pic will be hidden. This is true by default. - Example: `[insertagram id=1234 info=false]`

== Screenshots ==

1. The Instagram image.
2. The Instagram image hover state.
3. The admin page to select image/s to generate a shortcode.
4. It's as easy as copying and pasting the shortcode.
