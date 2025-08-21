<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class HaLim_Schedule_Widget extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'halim-schedule-widget',
			__('HaLim Schedule Widget', 'halimthemes'),
			array(
				'classname'   => 'halim-schedule-widget',
				'description' => __('Widget hiển thị bài đăng dựa trên lịch chiếu phim.Để sử dụng widget này vui lòng chỉnh sửa bài đăng của bạn và ngày chiếu vào lịch chiếu phim (Thứ 2,Thứ 3...Chủ Nhật)', 'halimthemes')
			)
		);
	}


	public function widget($args, $instance)
	{

		extract($args);
		extract($instance);
		echo $before_widget;
		ob_start();
?>
		<section id="<?php echo $widget_id; ?>">
			<h4 class="section-heading">
				<a href="<?php echo ($categories == 'all') ? $url : get_category_link($categories);  ?>" title="<?php echo $title;  ?>">
					<span class="h-text"><?php echo $title; ?></span>
				</a>

			</h4>
			<?php
			$day_of_week = array(
				array(
					'id' => 1,
					'name' => 'Thứ 2',
					'value' => 'Monday',
					'slug' => 'thu-2'
				),
				array(
					'id' => 2,
					'name' => 'Thứ 3',
					'value' => 'Tuesday',
					'slug' => 'thu-3'
				),
				array(
					'id' => 3,
					'name' => 'Thứ 4',
					'value' => 'Wednesday',
					'slug' => 'thu-4'
				),
				array(
					'id' => 4,
					'name' => 'Thứ 5',
					'value' => 'Thursday',
					'slug' => 'thu-5'
				),
				array(
					'id' => 5,
					'name' => 'Thứ 6',
					'value' => 'Friday',
					'slug' => 'thu-6'
				),
				array(
					'id' => 6,
					'name' => 'Thứ 7',
					'value' => 'Saturday',
					'slug' => 'thu-7'
				),
				array(
					'id' => 7,
					'name' => 'Chủ Nhật',
					'value' => 'Sunday',
					'slug' => 'chu-nhat'
				),
			);

			echo '<ul   class="nav nav-pills nav-justified halim-schedule-block">';
			
			foreach ($day_of_week as $day) {
				$shortDay = substr($day['value'], 0, 3);
				if ($day['value'] == date('l')) {
					echo '<li  class="halim_ajax_get_schedule active" data-catid="' . $day['value'] . '" data-showpost="' . $postnum . '" data-widgetid="' . $args['widget_id'] . '" data-layout="' . $instance['layout'] . ' " data-day="' . $day['slug'] . '"><a href="#'.$day['slug'].'"  role="tab" data-toggle="tab" aria-expanded="true" ><span style="font-weight: 600;font-size: 16px;line-height: 1em;">'.$shortDay.'</br></span>' . $day['name'] . '</a></li>';
				} else
					echo '<li  class="halim_ajax_get_schedule" data-catid="' . $day['value'] . '" data-showpost="' . $postnum . '" data-widgetid="' . $args['widget_id'] . '" data-layout="' . $instance['layout'] . ' " data-day="' . $day['slug'] . '"><a href="#'.$day['slug'].'"  role="tab" data-toggle="tab" aria-expanded="true"><span style="font-weight: 600;font-size: 16px;line-height: 1em;">'.$shortDay.'</br></span>' . $day['name'] . '</a></li>';
			}

			echo '</ul>';
			?>
			<div id="<?php echo $args['widget_id']; ?>" class="halim_box">
				<div class="tab-content">
					<?php
					$phim=[];
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $postnum,
						
					);
					if($rand==1){
						$args['tax_query'] = array(array(
							'taxonomy' => 'status',
							'field' => 'slug',
							'terms' => 'ongoing',
							'operator' => 'IN'
						));
					};
					if($type == 'popular'){
						$args['orderby'] = 'meta_value_num';
						$args['meta_query'] =  array(
								array(
									'key' => 'halim_view_post_all'
								),
							);
					}
					elseif($type == 'completed') {
						$args['tax_query'] = array(array(
							'taxonomy' => 'status',
							'field' => 'slug',
							'terms' => 'completed',
							'operator' => 'IN'
						));
	
					} elseif($type == 'lastupdate') {
						$args['orderby'] = 'modified';
					};
					foreach ($day_of_week as $index=> $day) {
						$args['meta_query'] = array(
							array(
								'key' => '_halim_metabox_options',
								'value' => $day['name'],
								'compare' => 'LIKE'
							)
							);
						$query = new WP_Query($args);
						$phim[$index]=$query ;
						if ($day['value'] == date('l')) {
							echo '<div role="tabpanel" class="tab-pane tab-schedule active"  id="' . $day['slug'] . '">';
							if ($phim[$index]->have_posts()) : while ($phim[$index]->have_posts()) : $phim[$index]->the_post();
									HaLimCore::display_post_items($layout);
								endwhile;
								wp_reset_postdata();
							endif;
							echo '</div>';
						} else {
							echo '<div role="tabpanel" class="tab-pane tab-schedule"  id="' . $day['slug'] . '">';
							if ($phim[$index]->have_posts()) : while ($phim[$index]->have_posts()) : $phim[$index]->the_post();
									HaLimCore::display_post_items($layout);
								endwhile;
								wp_reset_postdata();
							endif;
							echo '</div>';
						}
					}	
					?>
					<div class="clearfix"></div>
				</div>

			</div>
		</section>
		<div class="clearfix"></div>
	<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}


	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title']  	= strip_tags($new_instance['title']);
		$instance['url'] 		= $new_instance['url'];
		$instance['tabs'] 		= $new_instance['tabs'];
		$instance['type'] 		= $new_instance['type'];
		$instance['rand'] 		= $new_instance['rand'];
		$instance['categories'] = $new_instance['categories'];
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['layout'] 	= $new_instance['layout'];
		return $instance;
	}

	public function form($instance)
	{

		$instance = wp_parse_args((array) $instance, array(
			'title'      => __('Title', 'halimthemes'),
			'layout'     => '4col',
			'postnum'    => 8,
			'item'       => 5,
			'type'       => 'latest',
			'url'        => '',
			'rand'       => '',
			'tabs'		=> '',
			'categories' => 'all'
		));
		extract($instance); ?>
		<div class="hl_options_form">
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

			<!-- <p>
				<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('View more URL', 'halimthemes') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" placeholder="http://play.halimthemes.com/phim-moi/" />
			</p> -->
			<p style="display: inline-block;">
				<label><?php _e('Display posts by', 'halimthemes') ?></label>
				<br>
				<label for="<?php echo $this->get_field_id("type"); ?>_latest" style="float: left;margin: 5px;display: inline-block;width: 45%;">
					<input id="<?php echo $this->get_field_id("type"); ?>_latest" class="latest" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="latest" checked /> <?php _e('Latest', 'halimthemes') ?>
				</label>
				<?php
				$f = array(
					// 'categories' 	=> __('Category', 'halimthemes'),
					// 'completed'		=> __('Completed', 'halimthemes'),
					'lastupdate'	=> __('Last update', 'halimthemes'),
					'popular' 		=> __('Most viewed', 'halimthemes'),
					// 'tvseries'		=> __('TV Series', 'halimthemes'),
					// 'movies'		=> __('Movies', 'halimthemes'),
					// 'tv_shows'		=> __('TV Shows', 'halimthemes'),
					// 'theater_movie'		=> __(' Theater movie', 'halimthemes')
				);
				foreach ($f as $x => $n) { ?>
					<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" style="float: left;margin: 5px;display: inline-block;width: 45%;">
						<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x == 'categories' ? $x . ' cat' : $x; ?>" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) {
																																																															checked($x, $type, true);
																																																														} ?> /> <?php echo $n ?>
					</label>
				<?php } ?>
			</p>
			<!-- <script>
				jQuery(document).on('click', function(e) {
					var $this = jQuery(e.target);
					var $form = $this.closest('.hl_options_form');

					// if ($this.is('.categories')) {
					// 	var $halim = $form.find('.category');
					// 	var val = $this.is(':checked');
					// 	if (val) {
					// 		$halim.slideDown();
					// 	}
					// } else if ($this.is('.popular, .latest, .tvseries, .movies, .lastupdate, .completed')) {
					// 	var $halim = $form.find('.category');
					// 	var val = $this.is(':checked');
					// 	if (val) {
					// 		$halim.slideUp();
					// 	}
					// }

					// if ($this.is('.lastupdate')) {
					// 	var $halim = $form.find('.random');
					// 	var val = $this.is(':checked');
					// 	if (val) {
					// 		$halim.slideUp();
					// 	}
					// } else if ($this.is('.popular, .latest, .tvseries, .movies, .lastupdate, .completed')) {
					// 	var $halim = $form.find('.random');
					// 	var val = $this.is(':checked');
					// 	if (val) {
					// 		$halim.slideDown();
					// 	}
					// }

				});

				jQuery(document).ready(function($) {
					// if ($("input.lastupdate").is(':checked')) {
					// 	if ($('input.lastupdate:checked').val() == 'lastupdate') {
					// 		$('.random').slideUp();
					// 	}
					// }

					// if ($("input.cat").is(':checked')) {
					// 	if ($('input.cat:checked').val() == 'categories') {
					// 		$('.category').slideDown();
					// 	}
					// }
				});
			</script> -->
			<br />
			<p class="hide_completed" style="clear: both; display:block;">
				<label for="<?php echo $this->get_field_id("rand"); ?>_rand">
					<input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand" name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($rand)) {
																																												checked($rand, 1);
																																											} ?> /> <?php  echo 'Ẩn phim đã hoàn thành'; ?>
				</label>
			</p>

			<p style="clear: both;">
				<label for="<?php echo $this->get_field_id('layout'); ?>">
					<?php _e('Layout', 'halimthemes') ?>
					<br />
					<select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" class="widefat">
						<?php
						$vl = array('4col' => __('4 item/row', 'halimthemes'), '6col' => __('6 item/row', 'halimthemes'));
						foreach ($vl as $layout_id => $layout_name) { ?>
							<option value="<?php echo $layout_id ?>" <?php selected($layout_id, $instance['layout'], true); ?>>
								<?php echo $layout_name ?>
							</option>
						<?php } ?>
					</select>
				</label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
				<br />
				<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
			</p>
		</div>
<?php
	}
}
function _HaLim_Schedule_Widget()
{
	register_widget('HaLim_Schedule_Widget');
}
add_action('widgets_init', '_HaLim_Schedule_Widget');
