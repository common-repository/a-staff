=== a-staff - Team member showcase plugin for WordPress ===
Contributors: Arachnoidea
Tags: staff, member, team, staff member, team page, our team, team member, team showcase, staff list
Requires at least: 4.8
Tested up to: 5.0
Requires PHP: 5.6
Stable tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add staff member lists to your WordPress websites easily with this plugin.

== Description ==

Add staff member lists to your WordPress websites easily with this plugin.

= With **a-staff** you can easily: =

* Manage (add / remove / edit) your staff members on your Team page
* Insert the staff member boxes into any page using a shortcode or as a Gutenberg block
* Select 1 to 6 column layouts
* Easy-to-use social link manager with loads of icons
* Phone numbers for team members
* Sorting of team members by their names, the date they were added or using a custom order
* Built-in basic styles which can be turned off or extended if you want to use your own styles
* Responsive boxes that adapt to the look of your theme

= Since v1.2 we have a Pro version, too =

With the a-staff Pro version you can:

* Organize your team members into Departments
* Filter the member loop by departments (showing/hiding the selected departments)

You can find detailed documentation on the plugin's website:
[https://a-idea.studio/a-staff](https://a-idea.studio/a-staff)

== Installation ==

1. Go to your **WordPress Admin area** and sign in (e.g.: www.yourdomain.com/wp-admin)
1. Go to **Plugins » Add new**, then search for "a-staff"
1. Find "a-staff - Team member showcase plugin for WordPress" in the list then click on **Install Now** button.
1. *Activate* the plugin
1. A new menu item will appear in WP-Admin called *a-staff*. Here you can set up the plugin's global settings.
1. You can manage staff members in WP-Admin's *Staff Members* section

== Frequently asked questions ==

= How can I add staff members? =

Just go to **Staff Members » Add New**. It works in the same way as adding posts or pages.

= How can I add social network icons to the profiles? =

First you have to register them under **a-staff » Settings » Social**. With the Add Social Network button you can add new networks to the system.
You can specify the display name and the icon for each network here.
After you've set up the social networks, you can go to the Staff Members area and set the links to the profiles of each member.

= Where can I add the member's bio? =

The Excerpt is used as the member's bio text in the shortcode. It means that if you don't specify the excerpt then the auto-generated excerpt (based on The Content) will be used.
From v1.1 you can use formatted bio, which leaves some basic inline formatting in the excerpt, together with line breaks. In this case you can set the maximum length for the excerpt, too.

= Is a-staff compatible with Gutenberg / WordPress 5.0? =

Yes, we've done huge efforts while developing a-staff v1.2 to make it work seamlessly with the new WordPress editor.
When editing a Gutenberg-based page, you can find the *a-staff Team Member* and the *a-staff Loop* blocks under the Widgets tab.
The former is to be used when you want to add only 1 member's box to your page, the latter is when you want to include the full member loop.

= How can I upgrade to a-staff Pro? =

1. Install and Activate the free version of a-staff (see the *Installation* tab for details)
2. Click on *a-staff » Upgrade* in WP-Admin and follow the instructions there


== Screenshots ==

1. You can add unlimited number of social icons to the member boxes
2. Add staff members like you add posts in WP-Admin
3. Put the shortcode in the content of a page
4. This is how the shortcode looks like in the front end
5. a-staff Loop block for Gutenberg
6. a-staff single Team Member block for Gutenberg

== Changelog ==

= 1.2.2 (2018-12-07) =
* F: After switching to Font Awesome 5, some icons were not displaying correctly in the admin. Fixed.
* F: Blocks didn't appear correctly in newer versions of Gutenberg. Fixed.

= 1.2.1 (2018-10-29) =
* M: Renamed "Department" to "Departments" in admin menu.
* F: Same tab / new tab setting wasn't working for socail networks in v1.2. Now this is fixed.
* F: Some links on the plugin settings screen in admin were not working. Now fixed.

= 1.2 (2018-10-04) =
* A: Support for Gutenberg / WordPress 5.0
* A: [Gutenberg] a-staff Loop block
* A: [Gutenberg] a-staff Team Member block
* A: Pro version using the Freemius SDK (https://freemius.com/)
* A: [PRO] Now you can group your team members into Departments (suitable for bigger organizations)
* A: [PRO] Filtering members in the a-staff Loop by departments
* A: Setting for linking the boxes to single member pages or not
* A: Sorting options added to the shortcode: by Member Name, by Menu Order or by Date Added
* M: Framework update to TPL-FW 1.3.1 (https://github.com/ervind/tpl-fw)
* M: Updated the screenshots in the WP Plugin directory to be in line with the plugin's current UI
* M: Re-done the full templating system: now you have complete control over how the boxes and the single member pages look
* M: The Plugin Settings pages were moved into a top-level menu in WP-Admin
* M: Changed Yes/No options to checkboxes in Plugin Settings
* M: new plugin banner and icon
* M: Updated Font Awesome version from 4.7 to 5.2
* R: Removed obsolete code after this update

= 1.1.1 (2018-07-09) =
* Framework update to TPL-FW 1.3 (https://github.com/ervind/tpl-fw)

= 1.1 (2016-11-15) =
* A: Phone number field and {MEMBER_PHONE} shorttag for the templates
* A: Excerpts can now be formatted with line breaks and some inline tags
* F: Too big space issue when no social networks were added is now fixed

= 1.0 (2016-10-20) =
* Initial version
* A: [a-staff] shortcode
* A: Social network manager
* A: Hungarian translation