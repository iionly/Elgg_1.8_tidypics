<?php
/**
 * Create a single river entry for every batch of uploaded photos
 *
 * @author Cash Costello, iionly
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$batch = get_entity($vars['item']->subject_guid);

// Count images in batch
$images_count = elgg_get_entities_from_relationship(array(
              'relationship' => 'belongs_to_batch',
              'relationship_guid' => $batch->getGUID(),
              'inverse_relationship' => true,
              'type' => 'object',
              'subtype' => 'image',
              'offset' => 0,
              'count' => true
));

// Get first image related to this batch
$image_batch = elgg_get_entities_from_relationship(array(
	'relationship' => 'belongs_to_batch',
	'relationship_guid' => $batch->getGUID(),
	'inverse_relationship' => true,
	'type' => 'object',
	'subtype' => 'image',
	'offset' => 0,
	'limit' => 1
));
$image = $image_batch[0];

$attachments = elgg_view_entity_icon($image, 'tiny');

$image_link = elgg_view('output/url', array(
        'href' => $image->getURL(),
        'text' => $image->getTitle(),
        'is_trusted' => true,
));

$album = $vars['item']->getObjectEntity();
if (!$album) {
	// something went quite wrong - this batch has no associated album
	return true;
}
$album_link = elgg_view('output/url', array(
	'href' => $album->getURL(),
	'text' => $album->getTitle(),
	'is_trusted' => true,
));

$subject = $album->getOwnerEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$vars['item']->subject_guid = $subject->getGUID();
if ($images_count > 1) {
        echo elgg_view('river/elements/layout', array(
                'item' => $vars['item'],
                'attachments' => $attachments,
                'summary' => elgg_echo('image:river:created_single_entry', array($subject_link, $image_link, $images_count-1, $album_link)),
        ));
} else {
        echo elgg_view('river/elements/layout', array(
                'item' => $vars['item'],
                'attachments' => $attachments,
                'summary' => elgg_echo('image:river:created', array($subject_link, $image_link, $album_link)),
        ));
}
