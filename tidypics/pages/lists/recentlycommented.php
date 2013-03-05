<?php

/**
  * Images recently commented on - world view only
 *
 */

global $CONFIG;
$prefix = $CONFIG->dbprefix;

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:recentlycommented'));

$prefix = $CONFIG->dbprefix;
$max_limit = 200; //get extra because you'll have multiple views per image in the result set
$max = 20; //controls how many actually show on screen

$sql = "SELECT distinct (ent.guid), ann1.time_created
                        FROM " . $prefix . "entities ent
                        INNER JOIN " . $prefix . "entity_subtypes sub ON ent.subtype = sub.id
                        AND sub.subtype = 'image'
                        INNER JOIN " . $prefix . "annotations ann1 ON ann1.entity_guid = ent.guid
                        INNER JOIN " . $prefix . "metastrings ms ON ms.id = ann1.name_id
                        AND ms.string = 'generic_comment'
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

$title = elgg_echo('tidypics:recentlycommented');

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
        $area2 = elgg_echo('tidypics:recentlycommented:nosuccess');
}
$body = elgg_view_layout('content', array(
        'filter_override' => '',
        'content' => $area2,
        'title' => $title,
        'sidebar' => elgg_view('photos/sidebar', array('page' => 'all')),
));

// Draw it
echo elgg_view_page(elgg_echo('tidypics:recentlycommented'), $body);
