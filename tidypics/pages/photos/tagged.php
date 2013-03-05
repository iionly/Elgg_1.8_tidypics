<?php
/**
 * Tidypics Tagged Listing
 *
 * List all photos tagged with a user
 */

// Get user guid
$guid = get_input('guid');

$user = get_entity($guid);

if ($user) {
	$title = sprintf(elgg_echo('tidypics:usertag'), $user->name);
} else {
	$title = elgg_echo('tidypics:usertag:nosuccess');
}

// create main column
$area2 = elgg_view_title($title);

elgg_set_context('search');
set_input('search_viewtype', 'gallery'); // need to force gallery view
$area2 .= elgg_list_entities_from_relationship(array('relationship' => 'phototag',
                                                     'relationship_guid' => $guid,
                                                     'inverse_relationship' => false,
                                                     'type' => 'object',
                                                     'subtype' => 'image',
                                                     'limit' => 10,
                                                     'full_view' => false));

$body = elgg_view('page/layouts/one_sidebar', array('content' => $area2, 'sidebar' => elgg_view('photos/sidebar', array('page' => 'all'))));

// Draw it
echo elgg_view_page($title, $body);
