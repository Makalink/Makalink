=== GamiPress - bbPress integration ===
Contributors: gamipress, tsunoa, rubengc, eneribs
Tags: bbpress, forums, gamipress, gamification, points, achievements, badges, awards, rewards, credits, engagement, topics, reply, bbp
Requires at least: 4.4
Tested up to: 6.2
Stable tag: 1.2.7
License: GNU AGPLv3
License URI: http://www.gnu.org/licenses/agpl-3.0.html

Connect GamiPress with bbPress

== Description ==

Gamify your [bbPress](http://wordpress.org/plugins/bbpress/ "bbPress") forum thanks to the powerful gamification plugin, [GamiPress](https://wordpress.org/plugins/gamipress/ "GamiPress")!

This plugin automatically connects GamiPress with bbPress adding new activity events and features.

= New Events =

* New forum: When a user creates a new forum.
* New topic: When a user creates a new topic.
* New topic on a specific forum: When a user creates a new topic on a specific forum.
* Reply to any topic: When a user replies on a topic.
* Reply to a specific topic: When a user replies on a specific topic.
* Reply to any topic of a specific forum: When a user replies on a topic of a specific forum.
* Get a reply in any topic: When a topic author receives a reply in a topic.
* Get a reply in a specific topic: When a topic author receives a reply in a specific topic.
* Get a reply in any topic of a specific forum: When a topic author receives a reply in a topic of a specific forum.
* Favorite a topic: When a user favorites a topic.
* Favorite a specific topic: When a user favorites a specific topic.
* Favorite any topic on a specific forum: When a user favorites a topic of a specific forum.
* Get favorite on a topic: When a topic author gets a new favorite on a topic.
* Unfavorite a topic: When a user unfavorites a topic.
* Unfavorite a specific topic: When a user unfavorites a specific topic.
* Unfavorite any topic on a specific forum: When a user unfavorites a topic of a specific forum.
* Lose a favorite on a topic: When a topic author loses a favorite on a topic.
* Delete a forum: When a user deletes a forum.
* Delete a topic: When a user deletes a topic.
* Delete a reply: When a user deletes a reply.

= New Features =

* Drag and drop settings to select which points types, achievement types and/or rank types should be displayed on frontend reply author details and in what order.

= For BuddyBoss users =

For BuddyBoss, there is a specific [integration for BuddyBoss](https://wordpress.org/plugins/gamipress-buddyboss-integration/) with support to all features from our BuddyPress and bbPress integrations and with full backward compatibility to keep your old setup working exactly equal with the BuddyBoss integration.

== Installation ==

= From WordPress backend =

1. Navigate to Plugins -> Add new.
2. Click the button "Upload Plugin" next to "Add plugins" title.
3. Upload the downloaded zip file and activate it.

= Direct upload =

1. Upload the downloaded zip file into your `wp-content/plugins/` folder.
2. Unzip the uploaded zip file.
3. Navigate to Plugins menu on your WordPress admin area.
4. Activate this plugin.

== Frequently Asked Questions ==

= How can setup elements to be displayed at frontend on reply author details? =

After installing GamiPress - bbPress integration, you will find the plugin settings on your WordPress admin area navigating to the GamiPress menu -> Settings -> Add-ons tab at box named "bbPress".

Just choose the points types, achievement types and/or rank types to be displayed at frontend, setup the display options you want and click the "Save Settings" button.

== Screenshots ==

1. Show user points, achievements and ranks on replies

== Changelog ==

= 1.2.7 =

* **Bug Fixes**
* Fixed arguments for "Get a reply in any topic of a specific forum" event

= 1.2.6 =

* **Improvements**
* Display the points label in the position configured from the points type (before or after the points amount).

= 1.2.5 =

* **New Features**
* New event: Get a reply in any topic.
* New event: Get a reply in a specific topic.
* New event: Get a reply in any topic of a specific forum.

= 1.2.4 =

* **Improvements**
* Correctly apply the award/deduct to the reply, topic or forum author when deleting any of those elements.

= 1.2.3 =

* **New Features**
* New event: Unfavorite a topic.
* New event: Unfavorite a specific topic.
* New event: Unfavorite any topic on a specific forum.
* New event: Lose a favorite on a topic.

= 1.2.2 =

* **Improvements**
* Apply points format on reply author details.

= 1.2.1 =

* **Improvements**
* Prevent to trigger favorite topic event if author favorites himself.
* Prevent to display empty HTML on reply author details.

= 1.2.0 =

* **New Features**
* Added settings to show/hide the achievement and rank types label.

= 1.1.9 =

* **Bug Fixes**
* Fixed recount activity process for forum activities.

= 1.1.8 =

* **Improvements**
* Improved security by applying the WordPress security standards (sanitization and escaping).

= 1.1.7 =

* **Improvements**
* Added an explanatory text about the possibility of reorder type by dragging and dropping them.

= 1.1.6 =

* **Improvements**
* Avoid to grant access to any event on duplicity checks.

= 1.1.5 =

* **New Features**
* New event: Reply to any topic of a specific forum.
* New event: Favorite any topic on a specific forum.

= 1.1.4 =

* **Improvements**
* Updated bbPress filters to display user details on main topic (not only on replies).

= 1.1.3 =

* **Bug Fixes**
* Make new achievements limit setting visible under achievements tab.

= 1.1.2 =

* **New Features**
* Added the ability to setup the number of achievements to display.

= 1.1.1 =

* **New Features**
* Added events for delete a forum, a topic and a reply.

= 1.1.0 =

* **Bug Fixes**
* Checks on multisite when GamiPress is network wide active and bbPress is active just on a subsite.
* **Improvements**
* Make changelog notes more clear.
* **Developer Notes**
* Reset public changelog (moved old changelog to changelog.txt file).