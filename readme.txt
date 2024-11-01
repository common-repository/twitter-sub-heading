=== Plugin Name ===
Contributors: Stewart Malik
Tags: description, twitter, subheading
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=VF3VY8U8JYAGG&lc=AU&item_name=Twitter%20Sub%2dHeading%20Developer&currency_code=AUD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Stable tag: trunk
requires at least: 2.0.0
tested up to: (only tested: 2.9.0)

This plugin will change the description of your blog (or subheading as I prefer) to your latest Twitter update.

== Description ==

This plugin will let you enter your twitter username and every 5 minutes will download your latest Twitter status 
and then show it as the blogs sub-heading. Please not that you must have a... `<?php bloginfo('description'); ?>` in 
your themes header file before this plugin will work.

This plugin is extremely simple, in fact the entire plugin itself is under 100 lines of code. Once you add the 
administration panel then the code lines goes up to about 200. This plugin is entirely secure as it gets no data 
from a any user of your blog. For example the only input that this plugin takes is the Twitter username that you 
want to get the latest status of. This plugin does  not need you password and so makes it even more secure. As I 
said above I did have to limit the amount of calls to the twitter API. You can of course change this from the 
administration panel, It is possible to put it to update every minute however in cases that the Twitter server 
load is high then they restrict the amount of API calls to sometimes as low as 30 per hour. If you leave it at 
5 then you are pretty much guarenteed that this plugin will be able to access this API 99.99% of the time (barring 
the situation that the Twitter server is down).

== Installation ==

1. Upload the entire zipped folder to the `/wp-content/plugins/` directory.
2. Extract the plugin.
3. Activate the plugin from WordPress' plugin menu.
4. Set the options in the Settings menu accessible from the admin panel.

== Screenshots ==

1. It's hard to see however the blogs sub-heading has been changed to my latest Twitter update.

== Frequently Asked Questions ==

None yet.

== Changelog ==

= 0.2 =
* Added support for PHP 4

= 0.1 =
* This is the first version.

== Upgrade Notice ==

= 0.2 =
This new feature allows compatability with PHP 4. It uses a third-party XML class to parse the XML 
from the Twitter API. Of course it first checks to see whether you're running PHP 4 before we load 
the extra file.
