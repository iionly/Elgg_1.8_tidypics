<?php
/**
 * List albums in a widget
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$owner = elgg_get_page_owner_entity();

$options = array(
	'type' => 'object',
	'subtype' => 'album',
	'container_guid' => $owner->guid,
	'limit' => $vars['entity']->num_display,
	'full_view' => false,
	'pagination' => false,
);
echo elgg_list_entities($options);

echo elgg_view('output/url', array(
        'href' => "/photos/owner/" . $owner->username,
        'text' => elgg_echo('link:view:all'),
        'is_trusted' => true,
));
