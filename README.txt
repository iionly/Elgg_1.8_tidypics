Tidypics plugin for Elgg 1.8
Latest Version: 1.8.1beta1
Released: 2013-03-05
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (c) iionly 2013, (C) Cash Costello 2011-2013



This is a slightly improved version of the Tidypics plugin for Elgg 1.8.

ATTENTION:

CURRENTLY STILL IN BETA!!!

I would advice you to use the basic uploader and NOT the flash uploader - I had no time yet to try fixing / improving the flash uploader.



Known issues:

- Suggestion for Elggx Userpoints plugin version 1.8.3 is not a mistake. I'm currently working on that version to be released soon to support complete userpoint handling of Tidypics plugin.
- watermarking not fully tested / not fully working,
- quota not working,
- slightshow not yet fully tested,
- tagging is not yet feature complete (as compared to pre-Elgg 1.8, e.g. tagging users) and what is implemented might still not fully work,
- Highest vote counts page is not yet working (no results),
- I'm still not fully happy about the river entries (and the corresponding plugin settings) generated on album creation and image uploads,
- most likely other bugs still included, too.




Installation and configuration:

1. copy the tidypics plugin folder into the mod folder on your server,
2. enable the plugin in the admin section of your site,
3. configure the plugin settings.



Changelog:

Changes for release 1.8.1beta1 (by iionly)

- removal of option to set access level for images. Images always get the same access level as the album they are uploaded to. On changing the access level of an album all its images get assigned the same access level, too.
- new plugin navigation / pages: more centered on (recent) images than albums,
- support of Widget Manager index page and groups' pages widgets,
- Fivestar voting widget included on detailed image views,
- some code-cleanup.


Changes since 1.8.0 Release Candidate 1:

- Pull requests made on github included. These PR were made by
    * Cash Costello
    * Brett Profitt
    * Kevin Kardine
    * Sem (sembrestels)
    * Steve Clay
    * Luciano Lima
