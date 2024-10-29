=== academa ===
Contributors: ankitgupta2801
Tags: bibtex, academic
Requires at least: 4.7
Tested up to: 4.7
Requires PHP: 5.0
Stable tag: trunk
License: MIT
License URI: https://opensource.org/licenses/MIT
Donate Link: https://www.patreon.com/ankitgupta

Plugin to add a bibtex-based publication post type

== Description ==
This plugin adds a new post type called Publication. The Publication requires a bibtex for the publication, which the plugin displays in a standard citation format.


== Frequently Asked Questions ==
* Why did the plugin stop working after I added a new publication bibtex?
The current version does not validate the bibtex entry when adding a new publication. Therefore, the problem might be that the new bibtex you added has some errors. Validate your bibtex before you add it. Check [this](https://tex.stackexchange.com/questions/173621/how-to-validate-check-a-biblatex-bib-file) TexExchange question to validate your bibtex entry externally. That said, I plan to add bibtex validation in the next release.

* How can I add my publications to my Wordpress site?
After you install the academa plugin, you will see a new post type called "Publication" in your admin dashboard. You can add publications similar to adding posts. When adding a publication, you can add a title and a corresponding bibtex. The title is never shown on the website. The title is only present to allow you to differentiate between publications when looking at the list of Publications in the dashboard. The bibtex is parsed in the front-end to create a bibliography.

* How can I add a page containing all my publications?
You can add a link to the Publication archive page either in the Primary/Top menu of your website or any other Wordpress menu. The academa plugin will show a complete bibliography when displaying the Publication archive.
