Tidypics plugin for Elgg 1.8
Latest Version: 1.8.1beta3
Released: 2013-03-17
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (c) iionly 2013, (C) Cash Costello 2011-2013



This is a slightly improved version of the Tidypics plugin for Elgg 1.8.

ATTENTION:

CURRENTLY STILL IN BETA!!!

I would advice you to use the basic uploader and NOT the flash uploader for now. I had no time yet to try fixing / improving the flash uploader. You can try the Flash uploader and when it works for you it's surely great but I can't promise that yet.



Known issues:

- watermarking not fully tested / not fully working,
- slightshow not yet fully tested,
- tagging is not yet feature complete (as compared to pre-Elgg 1.8, e.g. tagging users) and what is implemented might still not fully work,



Installation and configuration:

1. copy the tidypics plugin folder into the mod folder on your server,
2. enable the plugin in the admin section of your site,
3. configure the plugin settings.



Changelog:

Changes for release 1.8.1beta3 (by iionly):

- River entries fixed (note: commenting on existing "batch" river entries does not work. It will only work for river entries created after upgrading to 1.8.1beta3!)


Changes for release 1.8.1beta2 (by iionly):

- Fixed quota support,
- Fixed issue with image entries (without images available) getting created on failed image uploads,
- Fixed an issue introduced in beta1 that resulted in (harmless but many) log entries getting created,
- Fixed Highest vote counts page,
- Display of Elggx Fivestar rating widget defined via Elggx Fivestar default view (requires version 1.8.3 of Elggx Fivestar plugin).


Changes for release 1.8.1beta1 (by iionly):

- removal of option to set access level for images. Images always get the same access level as the album they are uploaded to. On changing the access level of an album all its images get assigned the same access level, too.
- new plugin navigation / pages: more centered on (recent) images than albums,
- support of Widget Manager index page and groups' pages widgets,
- Elggx Fivestar voting widget included on detailed image views,
- some code-cleanup.


Changes since 1.8.0 Release Candidate 1:

- Pull requests made on github included. These PR were made by
    * Cash Costello
    * Brett Profitt
    * Kevin Kardine
    * Sem (sembrestels)
    * Steve Clay
    * Luciano Lima
