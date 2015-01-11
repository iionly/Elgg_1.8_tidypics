<?php
/**
 * Tidypics Batch Thumbnail Re-sizing
 */
?>

elgg.provide('elgg.tidypics.resizethumbnails');

// The already displayed messages are saved here
elgg.tidypics.resizethumbnails.errorMessages = [];

elgg.tidypics.resizethumbnails.init = function () {
	$('#tidypics-resizethumbnails-run').click(elgg.tidypics.resizethumbnails.run);
};

/**
 * Initializes the XHR upgrade feature
 *
 * @param {Object} e Event object
 */
elgg.tidypics.resizethumbnails.run = function(e) {
	e.preventDefault();

	// The total amount of images to be processed
	var total = $('#tidypics-resizethumbnails-total').text();

	// Initialize progressbar
	$('.tidypics-progressbar').progressbar({
		value: 0,
		max: total
	});

	// Replace button with spinner when processing starts
	$('#tidypics-resizethumbnails-run').addClass('hidden');
	$('#tidypics-resizethumbnails-spinner').removeClass('hidden');

	// Start processing from offset 0
	elgg.tidypics.resizethumbnails.upgradeBatch(0);
};

/**
 * Fires the ajax action to process a batch of images.
 *
 * @param {Number} offset  The next process offset
 */
elgg.tidypics.resizethumbnails.upgradeBatch = function(offset) {
	var options = {
		data: {
			offset: offset
		},
		dataType: 'json'
	};

	options.data = elgg.security.addToken(options.data);

	var upgradeCount = $('#tidypics-resizethumbnails-count');
	var action = $('#tidypics-resizethumbnails-run').attr('href');

	options.success = function(json) {
		// Append possible errors after the progressbar
		if (json.system_messages.error.length) {
			// Display only the errors that haven't already been shown
			$(json.system_messages.error).each(function(key, message) {
				if (jQuery.inArray(message, elgg.tidypics.resizethumbnails.errorMessages) === -1) {
					var msg = '<li class="elgg-message elgg-state-error">' + message + '</li>';
					$('#tidypics-resizethumbnails-messages').append(msg);

					// Add this error to the displayed errors
					elgg.tidypics.resizethumbnails.errorMessages.push(message);
				}
			});
		}

		// Increase success statistics
		var numSuccess = $('#tidypics-resizethumbnails-success-count');
		var successCount = parseInt(numSuccess.text()) + json.output.numSuccess;
		numSuccess.text(successCount);

		// Increase error statistics
		var numErrorsInvalidImage = $('#tidypics-resizethumbnails-error-invalid-image-count');
		var errorCountInvalidImage = parseInt(numErrorsInvalidImage.text()) + json.output.numErrorsInvalidImage;
		numErrorsInvalidImage.text(errorCountInvalidImage);

		var numErrorsRecreateFailed = $('#tidypics-resizethumbnails-error-recreate-failed-count');
		var errorCountRecreateFailed = parseInt(numErrorsRecreateFailed.text()) + json.output.numErrorsRecreateFailed;
		numErrorsRecreateFailed.text(errorCountRecreateFailed);

		var errorCount = errorCountInvalidImage + errorCountRecreateFailed;

		// Increase total amount of processed images
		var numProcessed = successCount + errorCount;
		upgradeCount.text(numProcessed);

		// Increase the progress bar
		$('.tidypics-progressbar').progressbar({ value: numProcessed });
		var total = $('#tidypics-resizethumbnails-total').text();

		if (numProcessed < total) {
			var percent = parseInt(numProcessed * 100 / total);

			/**
			 * Start next upgrade call. Offset is the total amount of images processed so far.
			 */
			elgg.tidypics.resizethumbnails.upgradeBatch(numProcessed);
		} else {
			$('#tidypics-resizethumbnails-spinner').addClass('hidden');
			percent = '100';

			if (errorCount > 0) {
				// Upgrade finished with errors. Give instructions on how to proceed.
				elgg.register_error(elgg.echo('tidypics:resize_thumbnails:finished_with_errors', [errorCountInvalidImage, errorCountRecreateFailed]));
			} else {
				// Upgrade is finished. Make one more call to mark it complete.
				elgg.system_message(elgg.echo('tidypics:resize_thumbnails:finished', [successCount]));
			}
		}

		// Increase percentage
		$('#tidypics-resizethumbnails-counter').text(percent + '%');
	};

	// We use post() instead of action() so we can catch error messages
	// and display them manually underneath the process view.
	return elgg.post(action, options);
};

elgg.register_hook_handler('init', 'system', elgg.tidypics.resizethumbnails.init);
