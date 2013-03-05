<?php

/**
 * Most commented images of last month
 *
 */

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:mostcommentedlastmonth'));

$max = 20;

$start = strtotime("-1 months", mktime(0,0,0, date("m"), 1, date("Y")));
$end = mktime(0,0,0,date("m"), 0, date("Y"));

$options = array(
        'types' => 'object',
        'subtypes' => 'image',
        'limit' => $max,
        'annotation_name' => 'generic_comment',
        'calculation' => 'count',
        'annotation_created_time_lower' => $start,
        'annotation_created_time_upper' => $end,
        'order_by' => 'annotation_calculation desc',
        'full_view' => false,
        'pagination' => false,
        'list_type' => 'gallery',
        'gallery_class' => 'tidypics-gallery'
);

$result = elgg_list_entities_from_annotation_calculation($options);

$title = elgg_echo('tidypics:mostcommentedlastmonth');

elgg_load_js('lightbox');
elgg_load_css('lightbox');
$owner_guid = elgg_get_logged_in_user_guid();
elgg_register_menu_item('title', array('name' => 'addphotos',
                                       'href' => "ajax/view/photos/selectalbum/?owner_guid=$owner_guid",
                                       'text' => elgg_echo("photos:addphotos"),
                                       'class' => 'elgg-lightbox',
                                       'link_class' => 'elgg-button elgg-button-action'));

if (!empty($result)) {
        $area2 = $result;
} else {
        $area2 = elgg_echo('tidypics:mostcommentedlastmonth:nosuccess');
}
$body = elgg_view_layout('content', array(
        'filter_override' => '',
        'content' => $area2,
        'title' => $title,
        'sidebar' => elgg_view('photos/sidebar', array('page' => 'all')),
));

// Draw it
echo elgg_view_page(elgg_echo('tidypics:mostcommentedlastmonth'), $body);
