=== jQuery Pin It Button for Images ===
Contributors: mrsztuczkens, redearthdesign, brocheafoin, robertark
Tags: pinterest, pin it, button, image, images, pinit, social media, hover, click, photo, photos
Requires at least: 3.3.0
Tested up to: 5.2.3
Stable tag: 3.0.5
License: GPLv2 or later

Highlights images on hover and adds a Pinterest "Pin It" button over them for easy pinning.

== Description ==
If you're looking for an easy way to pin images in your blog posts and pages, this plugin will help you with that. It highlights images and adds a "Pin it" button over them once the user hovers his mouse over an image. Once the user clicks the "Pin it" button, the plugin shows a pop-up window with the image and a description. Everything is ready for pinning, although the user can alter the description.

The plugin allows you to:

* choose from where the pin description should be taken 
* choose which pictures shouldn't show the "Pin it" button (using classes)
* choose which pictures should show the "Pin it" button (all images, post images, images with certain class(es))
* choose if you want to show the "Pin it" button on home page, single posts, single pages or category pages
* disable showing the button on certain posts and pages
* choose transparency level depending on your needs
* use your own Pinterest button design

Once you activate the plugin, it's ready to go with the default settings - button appears on all images within the body of your posts/pages that aren't marked with "nopin" or "wp-smiley" classes.

> <strong>jQuery Pin It Button For Images Pro</strong><br>
> jQuery Pin It Button For Images Pro is available with full support for touch devices. Check it out: https://highfiveplugins.com/downloads/jquery-pin-it-button-for-images-pro/

**Translators**
- Spanish (es_ES) -  Andrew Kurtis [WebHostingHub](http://www.webhostinghub.com/)

If you want to learn more about the plugin, visit its website: https://highfiveplugins.com/jpibfi/jquery-pin-it-button-for-images-documentation/

(This plugin is not related to or endorsed by Pinterest or its affiliates)

== Installation ==

1. Upload the folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configuration interface can be found under `Settings - jQuery Pin It Button For Images`. There's also a link to the plugin settings in the "Installed plugins" menu.

== Frequently Asked Questions ==

= Where can I change the plugins settings? =

Configuration interface can be found under `Settings - jQuery Pin It Button For Images`. There's also a link to the plugin settings in the "Installed plugins" menu.

= How do I add the button only to specific images? =
On the plugin settings page, there is a "Enabled classes" setting. Please enter there a class (or classes) that should show the "Pin it" button. Please note that images that don't contain any of the classes added in this setting won't show the "Pin it" button.

= How do I disable the button on specific images? =
Use the "Disabled classes" setting on the settings page - add there specific classes or use the "nopin" class.

= Can I use my own "Pin it" button design? =
 Yes. On the settings page, there's a section named "Custom Pit It button". You need to check the Use custom image checkbox and provide a URL address of the image, image's width and height.

 To upload you own image, you can use **Media Library** on your Wordpress installation or an image hosting service like **Photobucket**. Make sure you provide the proper address, width and height of the image. Otherwise, the button won't be displayed properly or won't be displayed at all.

= Where do I report bugs, improvements and suggestions? =
Please report them in the plugin's support forum on Wordpress.org.

== Screenshots ==

1. Base image in a blog post
2. Highlighted image and "Pin it" button on hover
3. Settings panel
4. Pinterest pop-up window

== Changelog ==

= 3.0.5 =
* Released 2019-09-15
* Improvements to how enabled and disabled classes work
* Fixed button sizing for Gutenberg galleries

= 3.0.4 =
* Released 2019-02-25
* Removed advertisement link

= 3.0.3 =
* Released 2018-11-25
* Fixed an issue with srcset attribute

= 3.0.2 =
* Released 2018-10-28
* Added support for data-pin-media and data-pin-url attributes.

= 3.0.1 =
* Released 2018-10-07
* Added the option to turn off pinning linked URLs.

= 3.0.0 =
* Released 2018-09-30
* Removed "Pin linked images" setting. It now automatically picks up linked images as the full-sized version of the image.
* If the image links to another URL, that URL goes to Pinterest instead of the current one.
* Reworked "Pin it" button sizing and cut the amount of CSS significantly
* [Pro] Added support for repinning images
* [Pro] Added support for scaling down the size of "Pin it" button for smaller screens
* [Pro] Added support for srcset attribute.

= 2.4.3 =
* Released 2018-05-13
* Added additional CSS clauses to prevent rendering errors on some themes

= 2.4.2 =
* Released 2018-03-16
* Added support for data-pin-description attribute
* Fixed pro version nag interval

= 2.4.0 =
* Released 2018-02-26
* Added support for custom showing and disabling the plugin on custom post types

= 2.3.4 =
* Released 2017-12-13
* Minor bug fix related to getting image source

= 2.3.3 =
* Released 2017-07-18
* Another Visual Tab Bug Fix

= 2.3.2 =
* Released 2017-07-12
* Visual Tab Bug Fix

= 2.3.1 =
* Released 2017-07-09
* Settings panel code rework
* Fixed issue with disabling review nag

= 2.3.0 =
* Released 2017-06-03
* Moved client script to footer
* Added warning if settings page does not work

= 2.2.10 =
* Released 2017-04-21
* Minor JavaScript improvements

= 2.2.9 =
* Released 2017-03-27
* Fixed one major JS bug

= 2.2.8 =
* Released 2017-03-26
* Fixed issue with JS error on client
* Fixed issue with using multiple enabled classes

= 2.2.7 =
* Released 2017-03-06
* Turned off minification of JS admin file to fix Cloudflare issues

= 2.2.6 =
* Released 2017-02-16
* Fixed conflict with other plugins that use angular

= 2.2.5 =
* Released 2017-01-31
* Fixed issue with updating the settings

= 2.2.4 =
* Released 2017-01-30
* Fix to support old versions of PHP

= 2.2.3 =
* Released 2017-01-29
* Minor cleanup
* Enhanced type checking to reduce errors caused by type mismatch even further

= 2.2.1 =
* Released 2017-01-22
* Fixed issue with saving custom images

= 2.2.0 =
* Released 2017-01-21
* Settings panel switched to saving via form submit instead of an Ajax request to avoid conflicts with security plugins
* Settings panel cleanup

= 2.1.3 =
* Released 2017-01-12
* Added ability to disable the plugin on certain filters and changing filters priority
* Added strong type checking in settings to reduce errors caused by type mismatch

= 2.1.2 =
* Released 2016-12-07
* Minor bug fixes

= 2.1.1 =
* Released 2016-11-11
* Fixed issue with double icons
* Disabled on and Enabled on settings now are not space-sensitive

= 2.1.0 =
* Released 2016-11-06
* Meta box to disable plugin on certain posts/pages added
* Added new icons

= 2.0.3 =
* Released 2016-10-08
* Fixed bug with removing image attributes
* Fixed issue with getting image description by URL

= 2.0.2 =
* Release 2016-10-05
* Another set of fixes for version 2.0.0

= 2.0.1 =
* Release 2016-10-04
* Fixes for version 2.0.0

= 2.00 =
* Release 2016-10-02
* Complete code rewrite
* Added support for featured image
* Plugin settings clean up

= 1.60 =
* Release 2016-07-04
* Added lightbox feature

= 1.52 =
* Release 2016-05-05
* Added import/export settings feature

= 1.51 =
* Release 2016-03-15
* Few minor fixes

= 1.50 =
* Release 2016-03-13
* Feature: Support for infinite scroll-like plugins
* Feature: Moved Pin Full Images from a separate plugin into jQuery Pin It Button For Images

= 1.42 =
* Release 2016-03-08
* Lots of backend enhancements

= 1.41 =
* Release 2016-02-12
* Syntax error for older versions of PHP fixed

= 1.40 =
* Release 2016-02-11
* Backend and frontend JavaScript rewritten

= 1.38 =
* Release 2014-09-16
* Fixed issue with positioning the button when Retina display active

= 1.37 =
* Release 2014-08-05
* Additional option in the description source setting
* Issue with saving checkboxes fixed

= 1.35 =
* Release 2014-06-20
* Static mode is now disabled

= 1.34 =
* Release 2014-06-16
* Added support for plugins lazy loading images

= 1.33 =
* Release 2014-05-18
* Minor changes

= 1.32 =
* Release 2014-05-04
* Minor fix

= 1.31 =
* Release 2014-03-13
* Important fix

= 1.30 =
* Release 2014-03-13
* PHP code redesign - plugin is much more extension friendly
* Deleted some of the compatibility-with-older-versions code

= 1.21 =
* Released 2014-02-22
* Fixed one issue from the previous release

= 1.20 =
* Released 2014-02-16
* Major JavaScript code redesign

= 1.17 =
* Released 2013-12-10
* Minor bug fix
* Added Spanish translation

= 1.16 =
* Released 2013-11-21
* Minor bug fix

= 1.15 =
* Released 2013-11-06
* Added 'Image description' option to 'Description source' option

= 1.14 =
* Released 2013-10-17
* Minor bug with linking images to posts fixed
* Plugin now supports Retina displays

= 1.13 =
* Released 2013-10-11
* Few minor code changes
* Plugin is translation-ready

= 1.12 =
* Released 2013-10-01
* One minor bug fixed

= 1.11 =
* Released 2013-08-25
* Two minor bugs fixed

= 1.10 =
* Released 2013-08-21
* Added dynamic mode that allows users to download the image and fixes many issues with the transparency layer
* Removed the ability to add custom css to the Pin It button, but added the ability to change margins

= 1.00 =
* Released 2013-08-09
* Major source code redesign
* Small changes in how the plugin works on client side
* WordPress-style settings panel
* Fixed a little glitch from previous version

= 0.0.99 =
* Released 2013-07-18
* Major changes in source code (mostly JavaScript), but little changes in features (few minor bugs/issues should be fixed)

= 0.9.95 =
* Released 2013-04-28
* Bug fixed: issue with pinning images with hashtags in their title/alt
* New feature: possibility to change the position of the "Pin it" button

= 0.9.9 =
* Released 2013-04-04
* Bug fixed: showing "Pin it" button on categories and archives even though they are unchecked in the settings
* New feature: possibility to set minimum image size that triggers the "Pin it" button to show up
* New feature: option to always link the image to its post/page url, instead of linking to the url the user is currently visiting
* Improvement: you now can set "Site title" as the default description of the pin

= 0.9.5 =
* Released 2013-03-04
* Fixed some issues with image sizing and responsive themes
* Code refactoring
* Added preview in the settings panel
* New feature: adding images using media library

= 0.9.2 =
* Released 2013-02-12
* It now works with jQuery versions older than 1.7

= 0.9.1 =
* Released 2013-02-12
* Bug fixed: resizing images when their dimensions are larger than the container they're in
* Bug fixed: plugin not working when jQuery added multiple times
* Bug fixed: wrong image url when images are lazy-loaded

= 0.9 =
* Released 2013-01-28
* Feature: Ability to use custom Pinterest button design

= 0.8 =
* Released 2013-01-12
* Feature: Ability to choose transparency level depending on one's needs
* Added support for default Wordpress align classes, so the plugin doesn't mess up the positioning of the images on screen (in typical cases)

= 0.7.1 =
* Released 2012-12-20
* Bug related to deleting and quick-editing posts fixed

= 0.7 =
* Released 2012-12-18
* Feature: Ability to show or hide the "Pin it" button on home page, single page, single post and categories (with archives)
* Feature: Ability to disable the "Pin it" button on certain post or page, works only on single post/page view
* Added security checks using Nonces

= 0.5 =
* Released 2012-12-9
* Feature: Pinterest window opens as a pop-up
* Feature: Ability to exclude certain classes from showing the "Pin it" button
* Feature: Ability to include only certain classes that will show the "Pin it" button
* Feature: Image is highlighted once hovered
* Feature: IE7 image highlight fix: using a transparent png instead of background-color

== Upgrade Notice ==

= 3.0.5 =
* Improvements to how enabled and disabled classes work and fFixed button sizing for Gutenberg galleries

= 3.0.4 =
* Remove advertisement link

= 3.0.3 =
* Fixed an issue with srcset attribute

= 3.0.2 =
* Added support for data-pin-media and data-pin-url attributes.

= 3.0.1 =
* Added the option to turn off pinning linked URLs.

= 3.0.0 =
Major code rework. Faster loading after cutting most of unneeded CSS. Images that link to an URL now create Pins with that URL too.

= 2.4.3 =
* Added additional CSS clauses to prevent rendering errors on some themes

= 2.4.2 =
* Support for data-pin-description and one more minor fix

= 2.4.0 =
* Added support for custom showing and disabling the plugin on custom post types

= 2.3.4 =
* Minor bug fix related to getting image source

= 2.3.3 =
* Another Visual Tab Bug Fix

= 2.3.2 =
* Visual Tab Bug Fix

= 2.3.1 =
* Minor code improvements, fixed bug with disabling review nag

= 2.3.0 =
* Moved client script to footer, added warning for settings page error

= 2.2.10 =
* Minor JavaScript improvements

= 2.2.9 =
* Fixed one major JS bug

= 2.2.8 =
* Two minor bug fixes

= 2.2.7 =
* Turned off minification of JS admin file to fix Cloudflare issues

= 2.2.6 =
* Fixed conflict with other plugins that use angular

= 2.2.5 =
* Fixed issue with updating the settings

= 2.2.4 =
* Fix to support old versions of PHP

= 2.2.3 =
* Code cleanup * enhancements to using settings

= 2.2.1 =
* Fixed issue with saving custom images

= 2.2.0 =
* Changed how settings are saved to avoid conflicts with security plugins

= 2.1.3 =
* Added ability to manipulate filters the plugin uses and added additional validation to settings.

= 2.1.2 =
* Minor bug fixes

= 2.1.1 =
* Minor bug fixes

= 2.1.0 =
* Meta box to disable plugin on certain posts/pages added
* New icons available

= 2.0.3 =
* Fixed bug with removing image attributes
* Fixed issue with getting image description by URL

= 2.0.2 =
* Another set of fixes for version 2.0.0

= 2.0.1 =
* Fixes for version 2.0.0

= 2.00 =
* Complete rewrite plus some changes in settings.

= 1.60 =
* Added lightbox feature

= 1.52 =
* Added import/export settings feature

= 1.51 =
* Few minor fixes

= 1.50 =
Added support for infinite scroll-like plugins and merged Pin Full Images into the plugin.

= 1.42 =
Minor code improvements.

= 1.41 =
Syntax error for older versions of PHP fixed.

= 1.40 =
Minor code improvements.

= 1.38 =
Fixed issue with positioning the button when Retina display active.

= 1.37 =
Additional setting in the description source setting. Small bug fix.

= 1.35 =
Static mode is now disabled.

= 1.34 =
Minor update.

= 1.33 =
Minor addition.

= 1.32 =
Minor fix.

= 1.31 =
Important fix.

= 1.30 =
PHP code redesign.

= 1.21 =
Fixed one issue from the previous release.

= 1.20 =
Just code redesign.

= 1.17 =
Minor bug fix and Spanish translation added.

= 1.16 =
Minor bug fix.

= 1.15 =
Adds 'Image description' option to 'Description source' option.

= 1.14 =
Minor bug fix plus support for Retina displays added.

= 1.13 =
Minor code changes, plus plugin is now translation-ready.

= 1.12 =
One minor bug fix.

= 1.11 =
Two minor bug fixes, that's all.

= 1.10 =
This update is recommended for people who had issues with version 1.00 but version 0.99 worked flawlessly. It adds a new mode that allows users to download images and fixes those issues related to version 1.00.

= 1.00 =
Major source code redesign, new settings panel and fix to a little glitch from previous version of the plugin.

= 0.9.99 =
Major source code changes with almost no changes in terms of features. This version can be considered a "test" one. After fixing bugs (if there are any - please report) version 1.0.0 will be published.

= 0.9.95 =
Minor bug fixed and one new feature (setting the position of the "Pin it" button) added.

= 0.9.9 =
A minor bug fixed and two new features (minimum image size among them) added.

= 0.9.5 =
Few minor bug fixes and tweaks

= 0.9.3 =
Fixed bugs with image sizing and responsive themes

= 0.9.2 =
Small update - plugin now works with jQuery versions older than 1.7.

= 0.9.1 =
Few bugs reported by users got fixed.

= 0.9 =
New feature: using custom Pinterest button design

= 0.8 =
Additional feature and added support for basic image positioning.

= 0.7.1 =
Critical bug fix, please update.

= 0.7 =
Additional features and some security enhancements.

= 0.5 =
First version of the plugin.