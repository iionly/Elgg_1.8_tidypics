<?php
/**
 * Display the latest photos uploaded by an individual
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$owner = elgg_get_page_owner_entity();

echo elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'image',
	'limit' => $vars['entity']->num_display,
	'owner_guid' => $owner->guid,
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => false,
	'pagination' => false,
	'gallery_class' => 'tidypics-gallery-widget',
));

echo elgg_view('output/url', array(
        'href' => "/photos/siteimagesowner/" . $owner->guid,
        'text' => elgg_echo('link:view:all'),
        'is_trusted' => true,
));
