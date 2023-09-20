=== GamiPress - BuddyPress integration ===
Contributors: gamipress, tsunoa, rubengc, eneribs
Tags: gamipress, gamification, gamify, point, achievement, badge, award, reward, credit, engagement, ajax, buddypress, bp, social networking, activity, profile, messaging, friend, group, forum, notification, settings, social, community, network, networking
Requires at least: 4.4
Tested up to: 6.2
Stable tag: 1.6.1
License: GNU AGPLv3
License URI:  http://www.gnu.org/licenses/agpl-3.0.html

Connect GamiPress with BuddyPress

== Description ==

Gamify your [BuddyPress](http://wordpress.org/plugins/buddypress/ "BuddyPress") community thanks to the powerful gamification plugin, [GamiPress](https://wordpress.org/plugins/gamipress/ "GamiPress")!

This plugin automatically connects GamiPress with BuddyPress adding new activity events and features.

= New Events =

* Account activation: When a user account get activated.
* Get assigned to a specific profile type: When a user gets assigned to a specific profile type.
* Profile updates: When a user changes their profile information (avatar, cover image and/or just the profile information).
* Update profile field with any value: When a user changes a profile field with any value.
* Update profile field with specific value: When a user changes a profile field with specific value.

= Friendship Events =

* Send friendship request: When a user request to another to become friends.
* Accept a friendship request: When a user accepts the friendship request from another one.
* Get a friendship request accepted: When a user gets a friendship request accepted from another one.
* Reject a friendship request: When a user rejects the friendship request from another one.
* Get a friendship request rejected: When a user gets a friendship request rejected from another one.
* Remove a friendship: When a user removes a friendship.
* Get a friendship removed: When a user gets a friendship removed.

= Message Events =

* Send/Reply private messages: When a user sends or replies to private messages.

= Activity Stream Events =

* Publish an activity post: When a user publishes an activity post.
* Remove an activity post: When a user removes an activity post.
* Reply activity post: When a user replies to an activity post.
* Get a reply on an activity post: When a user gets a reply on an activity post.
* Delete a reply activity post: When a user deletes a reply from an activity post.
* Favorite activity post: When a user favorites an activity post.
* Remove a favorite on an activity stream item: When a user removes a favorite on an activity post.
* Get a favorite on an activity stream item: When a user gets a new favorite on an activity post.
* Get a favorite removed from an activity stream item: When a user gets a favorite removed on an activity post.

= Group Events =

* Publish an activity post in a group: When a user publishes an activity post in a group.
* Publish an activity post in a specific group: When a user publishes an activity post in a specific group.
* Remove an activity post from a group: When a user removes an activity post from a group.
* Remove an activity post from a specific group: When a user removes an activity post from a specific group.
* Create a group: When a user creates a new group.
* Join a group: When a user joins a group.
* Join a specific group: When a user joins a specific group.
* Leave a group: When a user leaves a group.
* Leave a specific group: When a user leaves a specific group.
* Request to join a private group: When a user requests to join a private group.
* Request to join a specific private group: When a user requests to join a specific private group.
* Get accepted on a private group: When a user gets accepted on a private group.
* Get accepted on a specific private group: When a user gets accepted on a specific private group.
* Invites someone to join a group: When a user invites someone to join a group.
* Invites someone to join a specific group: When a user invites someone to join a specific group.
* Get promoted as moderator/administrator in a group: When a user get promoted as moderator/administrator in a group.
* Get promoted as moderator/administrator in a specific group: When a user get promoted as moderator/administrator in a specific group.
* Promotes another member as moderator/administrator in a group: When a user promotes another member as moderator/administrator in a group.
* Promotes another member as moderator/administrator in a specific group: When a user promotes another member as moderator/administrator in a specific group.

= New Features =

* Ability to block users by profile type to earn anything from GamiPress. (Like [Block Users](https://wordpress.org/plugins/gamipress-block-users/ "Block Users") add-on, but with BuddyPress profile types)
* Drag and drop settings to select which points types, achievement types and/or rank types should be displayed at frontend profiles, activities and listings and in what order.
* Setting to select which elements should be displayed in activity streams.

There are more add-ons that improves your experience with GamiPress and BuddyPress:

* [BuddyPress Group Leaderboard](https://wordpress.org/plugins/gamipress-buddypress-group-leaderboard/)

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

= How can I display GamiPress elements on profile, listing or activities? =

You will find all the settings to manage the tabs displayed by navigating to GamiPress > Settings > Add-ons > "BuddyPress" and "BuddyPress Profile Tab" boxes.

= How can I display user earnings on BuddyPress activity feed? =

On each type edit screen (points type, achievement type and rank type) you will find setting to manage which elements display on BuddyPress activity feed.

= How can I display the GamiPress email settings on the user email preferences screen? =

You will find all the settings to manage the email settings display navigating to GamiPress > Settings > Add-ons > BuddyPress > Email Settings.

== Screenshots ==

1. Show user points, achievements and ranks on frontend profile

== Changelog ==

= 1.6.1 =

* **New Features**
* New event: Get a reply on an activity post.
* **Bug Fixes**
* Fixed events for replies to avoid auto-replies

= 1.6.0 =

* **Bug Fixes**
* Fixed events for likes to avoid auto-likes

= 1.5.9 =

* **Improvements**
* Added new checks on settings options to prevent errors in case of corrupted data.

= 1.5.8 =

* **Bug Fixes**
* Fixed profile fields pagination in the dropdown selector.

= 1.5.7 =

* **New Features**
* New event: Update profile field with any value.
* New event: Update profile field with specific value.

= 1.5.6 =

* **Bug Fixes**
* Fixed thumbnails display on profile in multisite installs.

= 1.5.5 =

* **Bug Fixes**
* Fixed elements display on profile in multisite installs.

= 1.5.4 =

* **New Features**
* New event: Delete a reply from an activity post.

= 1.5.3 =

* **New Features**
* New event: Reject a friendship request.
* New event: Get a friendship request rejected.

= 1.5.2 =

* **New Features**
* New settings to display the GamiPress Email Settings on the member's account Email Preferences.

= 1.5.1 =

* **Improvements**
* Display the points label in the position configured from the points type (before or after the points amount).

= 1.5.0 =

* **Improvements**
* Added required parameters in the 'get_the_excerpt' filter to avoid compatibility issues.

= 1.4.9 =

* **Improvements**
* Prevent duplicated rank display on themes who use the Nouveau templates.

= 1.4.8 =

* **New Features**
* New event: Request to join a private group.
* New event: Request to join a specific private group.

= 1.4.7 =

* **Improvements**
* Prevent to add any HTML if there is no user details to display.

= 1.4.6 =

* **New Features**
* New specific group events.
* **Improvements**
* Fallback to post content if post does not have an excerpt on activities.
* Renamed all "Write an activity stream message" to "Publish an activity post".
* **Developer Notes**
* New hooks to override the output of the user details.

= 1.4.5 =

* **Bud Fixes**
* Prevent to show deleted elements on achievements lists.

= 1.4.4 =

* **Bud Fixes**
* Fixed conflict on members listings.

= 1.4.3 =

* **Improvements**
* Prevent PHP warnings if settings are not properly updated.

= 1.4.2 =

* **New Features**
* Added settings to display user earnings on members listing.
* Added settings to display user earnings on activities.
* Added settings to block users by member type to earn anything from GamiPress.
* **Improvements**
* Redistributed the add-on settings to make them more easy to configure.
* Fully reworked the add-on settings separating in one box the settings to display on profile top, activity and listing and in other the elements to display on the profile tabs.
* **Bug Fixes**
* Fixed the "Join a private group" listener.
* **Developer Notes**
* Centralization of the top, activity and listing display in one single function.
* Filters to override the top, activity and listing display options.

= 1.4.1 =

* **Improvements**
* Added extra checks to meet if member types modules is active.

= 1.4.0 =

* **Improvements**
* Apply points format on user profile points.
* Prevent to display empty HTML on user profile.
* Moved old changelog to changelog.txt file.
