<?php

/**
 * Most recently voted images - world view only
 *
 */

global $CONFIG;
$prefix = $CONFIG->dbprefix;

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:recentlyvoted'));

$prefix = $CONFIG->dbprefix;
$max_limit = 200; //get extra because you'll have multiple views per image in the result set
$max = 20; //controls how many actually show on screen

$sql = "SELECT ent.guid, u2.name AS owner, u.name AS voter, ms2.string as vote
             FROM " . $prefix . "entities ent
             INNER JOIN " . $prefix . "entity_subtypes sub ON ent.subtype = sub.id
             AND sub.subtype = 'image'
             INNER JOIN " . $prefix . "annotations ann1 ON ann1.entity_guid = ent.guid
             INNER JOIN " . $prefix . "metastrings ms ON ms.id = ann1.name_id
             AND ms.string = 'fivestar'
             INNER JOIN " . $prefix . "metastrings ms2 ON ms2.id = ann1.value_id
             INNER JOIN " . $prefix . "users_entity u ON ann1.owner_guid = u.guid
             INNER JOIN " . $prefix . "users_entity u2 ON ent.owner_guid = u2.guid
             ORDER BY ann1.time_created DESC
             LIMIT $max_limit";

$result = get_data($sql);

$entities = array();
foreach ($result as $entity) {
        if (!$entities[$entity->guid]) {
                $entities[$entity->guid] = get_entity($entity->guid);
        }
        if (count($entities) >= $max) {
                break;
        }
}

$title = elgg_echo('tidypics:recentlyvoted');

elgg_load_js('lightbox');
elgg_load_css('lightbox');
$owner_guid = elgg_get_logged_in_user_guid();
elgg_register_menu_item('title', array('name' => 'addphotos',
                                       'href' => "ajax/view/photos/selectalbum/?owner_guid=$owner_guid",
                                       'text' => elgg_echo("photos:addphotos"),
                                       'class' => 'elgg-lightbox',
                                       'link_class' => 'elgg-button elgg-button-action'));

if (!empty($result)) {
        $area2 = elgg_view_entity_list($entities, array('limit' => $max,
                                                        'offset' => 0,
                                                        'full_view' => false,
                                                        'pagination' => false,
                                                        'list_type' => 'gallery',
                                                        'gallery_class' => 'tidypics-gallery'
                                                       ));
} else {
        $area2 = elgg_echo('tidypics:recentlyvoted:nosuccess');
}
$body = elgg_view_layout('content', array(
        'filter_override' => '',
        'content' => $area2,
        'title' => $title,
        'sidebar' => elgg_view('photos/sidebar', array('page' => 'all')),
));

// Draw it
echo elgg_view_page(elgg_echo('tidypics:recentlyvoted'), $body);
