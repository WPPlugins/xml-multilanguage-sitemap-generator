=== XML Multilanguage Sitemap Generator ===
Contributors: gianemi2, mariacristinacozzolino
Tags: sitemap, multilanguage, xml, polylang, wpml, google friendly, gianemi2
Donate link: https://www.paypal.me/gianemi2
Requires at least: 3.7
Tested up to: 4.8
Stable tag: 1.4.7
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create a wonderful sitemap in the root of the website with all the alternative languages too, if available. Follow the [latest Google guide for XML Sitemap.](https://support.google.com/webmasters/answer/2620865?hl=en "Use a sitemap to indicate alternate language pages")

== Description ==


**XML Multilanguage Sitemap Generator** creates for you a wonderful sitemap which follow all the instructions of Google. Here is the [Google instructions](https://support.google.com/webmasters/answer/2620865?hl=it "Use a sitemap to indicate alternate language pages")

**!!!IMPORTANT UPDATE!!! Adjust a problem which causes a lot of page load. !!!IMPORTANT UPDATE!!! **

**IMPORTANT NOTE**: Just after the installation of the plugin, go to **XML SITEMAP** and check the Post type you want to see inside your sitemap.

Is your site available for users of lot of languages? This is the plugin you have to install!

Thanks to [Marco Fatticcioni](https://www.behance.net/marcofatticcioni "Marco Fatticcioni Behance link") for logo design. 


**Minimum Requirements**

Requires at least WordPress 3.8 for working safe. Requires *Polylang* or *WPML* for the alternative language in the sitemap.


**How it works**

By default it creates a sitemap with all your post type.
So for example if you have:
1. Pages
2. Post
3. Portfolio
4. Products
You have to go to *XML SITEMAP* in the WordPress sidenav and check the post type you want to include. You can also name your sitemap. If you leave it blank the name will be *xml_mg_sitemap.xml*. When you have set all the options simply click on *Click here for see your sitemap*.
The plugin will creates a sitemap with all of them posts and all of them translations. 


**The options**

You can choose from these fantastic options:
1. Create an *index sitemap*, like more famous plugin. The documentation of the index sitemap is [available here](https://support.google.com/webmasters/answer/75712?hl=en "Simplify multiple sitemap management")
2. Change the name of your sitemap. *The default name is xml_mg_sitemap*. If you have choosen the index sitemap *the default name will be xml_mg_sitemap-index*.
3. Remove an entire POST TYPE from the sitemap.
4. Remove just some posts from the sitemap.
5. Set manually the *changefreq* and the *priority* values.
6. Add images from your post page inside your sitemap.

**Are there something in progress?**

Obviosly! In the near future there will be some useful update. Some of these are:
1. Manually set the changefreq directly in the post or by post type. (**DONE**)
2. Set the priority directly in the post or by post type. (**DONE**)
3. Insert images inside your sitemap from your post page. (**DONE**)
4. Create x sitemaps as many post types you have. (**DONE**)


**Epilogue**

If this plugin helps you, feel free to [donate me a coffee](https://www.paypal.me/gianemi2 "Donate a coffee to Marco Giannini :]") (*coffee's never enough*) or [leave me a feedback](https://wordpress.org/support/plugin/xml-multilanguage-sitemap-generator/reviews/ "Leave a feedback for my plugin if it helps you").

If you have some suggestions for extra options or for something new, feel free to [mail me at info@marcogiannini.net](mailto:info@marcogiannini.net "Send a mail to marcogiannini.net").

For any problem I [ask you to open a support topic](https://wordpress.org/support/plugin/xml-multilanguage-sitemap-generator/ "Write a support topic in support page").

Follow me on [Facebook](http://www.facebook.com/marcogiannini.net "Facebook profile of Marco Giannini") and on my [Website](http://www.marcogiannini.net/ "Website of Marco Giannini").


== Installation ==


1. Download and activate this plugin. You can download it [directly from WordPress plugin page](https://wordpress.org/plugins/xml-multilanguage-sitemap-generator/) and then upload it on your website, or search it directly from the plugin section of your website, searching **XML MULTILANGUAGE SITEMAP**.
2. Go to *XML SITEMAP*.
3. Choose if you want the index-sitemap or the simple sitemap.
4. Set the name of your sitemap. If you choose an index-sitemap the name of the sitemap will always have *-index* at the end of the name.
5. Check the *post type* you want to see inside your sitemap. press *save options*.
6. If you want to hide some **posts** from sitemap, check the title of the posts you want to hide.
7. If you want to add some images inside your sitemap, go to the post which you want to add the images. Under the container where you put the content of your page, there will be a *block* named *Images configurator for XML SITEMAP GENERATOR*. Write on it, the URL of the image. Check the FAQs for know how to get the URL. **Every URL must be separated from the next one by a COMMA**.
8. **IMPORTANT** - If you have a plugin which *creates cache*, flush it.
9. Click on the option page of the plugin su *Click here for see your sitemap*.
10. **If your site respond with a 404 simply refresh the page.**


==FAQ==


=Why should I use this plugin instead of the more famous SEO plugins?=

Hi Captain :) You should use this plugin because it follows perfectly the linear guides of Google. Is better to have Google as friend. And coooome on you can create a sitemap with just a *CLICK* :)

=What if I want to include some extra post type in your sitemap?=

That's not an issue! You just have to go on your WordPress dashboard, under *XML SITEMAP* and check the post type you want to include. Check the [installation guide](https://wordpress.org/plugins/xml-multilanguage-sitemap-generator/#installation "Installation tab of XML multilanguage sitemap generator") for more informations.

=What if I want to exclude some Post from my sitemap?=

Again, no issues. Go on your WordPress dashboard, under *XML SITEMAP* and set the post type you want in your sitemap. Right after save the settings the list of posts will appear in the settings. Check the [installation guide](https://wordpress.org/plugins/xml-multilanguage-sitemap-generator/#installation "Installation tab of XML multilanguage sitemap generator") for more informations.

= How can I get the URL of the images I've loaded on the website? =

It's very easy, simply *right-click* on the image you want to insert on the sitemap and click on *COPY THE URL OF THE IMAGE*. 

= Why, after paste the URL copied before, the system doesn't recognize the image? =

Check the end of the URL you have pasted before. If the URL is something like this "../name_of_image-150x150.jpg" simply remove -150x150. The new URL should be something like "../name_of_image.jpg". This is the problem, the -150x150 is a self generated thumbnail by WordPress. It's not the real media.

== Screenshots ==

1. Option page of the plugin.
2. Generated sitemap with images.
3. Generated multilanguage sitemap.
4. Index-sitemap generated.

== Changelog ==

== 1.4.7 ==

* Adjust a problem which causes a lot of page load. IMPORTANT UPDATE! 

== 1.4.6 ==

* Solved a bug with Avada

== 1.4.2 ==

* Solved UX bugs

== 1.4 ==

* UX for option page improved.
* Added support for changefreq and priority. Now they can be set up inside the options page. There's a bulk choice or a single choice for every post type.

== 1.3.1 ==

* Solved multilanguage bug with WPML.
* Solved multilanguage bugs.

== 1.3 ==

* Solved minor bug.
* Now is available the INDEX-SITEMAP.

== 1.2.1 ==

* Solved a conflict bug with WordPress.

== 1.2 ==

* Better user interface.
* Added auto-creation of the sitemap.

== 1.1.1 ==

* Solved minor bug of the media inside sitemap.

== 1.1 ==

* First major update
* Solved a Alternate URL bug with WPML.
* Added image support inside the sitemap.
* Solved minor bug.

== 1.0.5 ==

* Solved minor bug.

== 1.0.4 ==

* Solved minor bug.

== 1.0.3 ==

* Hard bug fixes. Please update this plugin.

== 1.0.2 ==

* Some bug fixes.

== 1.0.1 ==
* Changed the Logo. Thanks to [Marco Fatticcioni](https://www.behance.net/marcofatticcioni "Marco Fatticcioni Behance link") for logo design.
* Setted a default name for the sitemap generated.