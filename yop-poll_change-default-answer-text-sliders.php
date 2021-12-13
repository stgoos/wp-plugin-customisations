<?php

/** 
 * Change the default answer of YOP-POLL text-sliders
 * by stgoos ( https://github.com/stgoos/wp-plugin-customisations/yop-poll_change-default-answer-text-sliders.php ) 
 * v2021.12.1302
 * Simply include this code in your child themes functions.php.
 */

add_action( 'wp_head', function () { ?>
<script type='text/javascript'>
jQuery(document).ready(function($){
	$(window).load(function() { 	
	
	// Collect the data-id of all text-sliders 
	var ids = $('div[data-question-type="text-slider"]').map(function(){
		return $(this).attr('data-id');
	}).get();

	// Loop through all the text-sliders
	$.each(ids, function(key, value) {
		// Get the slider data-ticks array
		var dataticks = $('div[data-id="' + value + '"]').attr('data-ticks');
		var dataticks_arr = dataticks.split(",");
		var dataticks_len = dataticks_arr.length;
		// Set the default answer to the middle data-tick (obviously an odd number of data-ticks works best for this, otherwise it's the one to the left of the middle!)
		// ...or to a defined data-tick value. Just comment out the one you don't want to use.
		var answer = dataticks_arr[ Math.ceil( dataticks_len / 2 ) - 1 ]; // -1 as the array keys start at 0, duh!
		// var answer = 5;
		
		// Get length of the slideroptions array and reduce by 1 to get the divider to calculate the percentages
		var divider = dataticks_len - 1;
		// Percentage from the left
		var perc = (100 / divider) * (answer - 1);
		// Percentage from the right
		var perc_flip = 100 - perc;	
		
		// Update the attributes
		$('#text-slider-' + value).css('background-color', 'gold !important');
		$('#text-slider-' + value + ' div.slider-selection.tick-slider-selection').css('width', perc + '%');
		$('#text-slider-' + value + ' div.slider-track-high').css('width', perc_flip + '%');
		$('#text-slider-' + value + ' div.tooltip.tooltip-main.top').css('left', perc + '%');
		$('#text-slider-' + value + ' div.tooltip.tooltip-main.top div.tooltip-inner').text(answer);
		/*
		div #text-slider-123
			div.slider-tick-label-container		... don't seem to be needed when you don't show the tick containers
			div.slider-tick-container			... don't seem to be needed when you don't show the tick containers
		*/
		$('#text-slider-' + value + ' div.slider-handle.min-slider-handle').css('left', perc + '%');
		$('#text-slider-' + value + ' div.slider-handle.min-slider-handle').attr('aria-valuenow', answer).css('left', perc + '%');
		$('input #poll-element-' + value).attr('data-value', answer).val(answer);
	});
  });
});
</script>
<?php } );
