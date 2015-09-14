=== Instagram Insertagram - Custom Select Photos and Feeds to Display ===
Contributors: Hensonism
Tags: instagram, photo, photos, pic, gallery, instagram plugin, instagram stream, instagram feed, responsive, custom, mobile, instagram posts, instagram wall, instagram account
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 0.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display hand-picked images or feeds from an Instagram account with ease in a simple, elegant, responsive layout.

== Description ==

**Why Use Insertagram?**
The key ingredient (separation from all the other **Instagram** plugins) is the capability to choose photos to insert one at a time or by groups. Within the Wordpress admin choose images from your **Instagram** account to show. You can also display a feed of your most recent posts to show in real time.

**How Does it Look?**
The image display is simple, crisp, elegant, and responsive. In viewing the embedded **Instagram** photos on posts and pages, the user can hover over and see the **Instagram** profile pic, caption, like count, comment count... and click to open the **Instagram** page in a new tab of the browser.

**How Do I Manage It?**
Use the 'Insertagram +' link in the left nav to generate shortcodes by selecting the images you'd like to post. This admin page allows you to browse and choose images in an **Instagram** account to display.

See a demo [here](http://insertagram.hensonism.com "here").

= Features =
* Simple to setup and use. No **Instagram** developer account needed.
* Completely **responsive** - mobile friendly.
* Choose images individually or by a group to generate a shortcode and embed on any post or page.
* The clean and simple presentation shows only the images and on hover - the details, including like count, comment count, caption and profile pic.
* The option to hide the details and show only the images.
* Display most recent feed in real time with all info on hover state of user interaction.
* "More" button on feeds so users can browse through the entirety of the feed.

= Feedback or Support =
Please send an email to [Adam](mailto:adamhenson1979@gmail.com "Adam").

== Installation ==

1. Install the **Instagram** plugin either via the WordPress plugin directory, or by uploading the files to your web server (in the `/wp-content/plugins/` directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Insertagram' settings page to obtain your **Instagram** Access Token and User ID.
4. Create custom shortcodes by clicking on the 'Insertagram +' link in the left nav or use the shortcode `[insertagram feed=true]` to display a real-time feed of your recent **Instagram** posts - in any page or post.

= Shortcode Options =
* **id** - A unique ID generated when creating a custom shortcode via the 'Insertagram +' left nav link. This ID will be generated for you - after selecting image/s - Example: `[insertagram id=1234]`
* **feed** - If true - this option will display a real-time feed of most recent posts. This option should not exist with the `id` option - Example: `[insertagram feed=true]`
* **info** - If false - all info including comment count, like count, caption, and profile pic will be hidden. This is true by default. - Example: `[insertagram id=1234 info=false]`

== Screenshots ==

1. **Instagram image** - This is how it looks from a visitor perspective in the Twenty Fifteen theme.
2. **Instagram image hover state** - And the hover state in the Twenty Fifteen theme.
3. **Admin page** - select image/s to generate a shortcode.
4. **Admin page success** - It's as easy as copying and pasting the shortcode generated in the success message.
