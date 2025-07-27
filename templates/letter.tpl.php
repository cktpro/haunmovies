<?php

$letter_query = sanitize_text_field(get_query_var('letter'));
?>

<div class="text-center letter-filter" id="letter-filter">
 <span class="toggle-pagination"><i class="hl-menu"></i> <?php _e('A-Z list', 'halimthemes'); ?></span>
  <ul class="pagination list-letter pagination-lg">
	<li><span data-href="<?php echo home_url('/az-list/0'); ?>" class="<?php echo __active($letter_query, '0'); ?>" data-text="All"></span></li>
	<?php
		foreach (range('A', 'Z') as $letter) {
		    echo '<li><span data-href="'.home_url('/az-list/'.$letter).'" class="letter-item '.__active($letter_query, $letter).'" data-text="'.$letter.'"></span></li>';
		}
	?>
  </ul>
</div>
<div class="clearfix"></div>
