<?php
    get_header();
	$halim_action    = get_query_var('halim_action');
	$episode         = get_query_var('halim_episode');
	$server          = get_query_var('halim_server');
	$meta            = get_post_meta($post->ID, '_halim_metabox_options', true );
	$player_options  = cs_get_option('halim_jw_player_options');
	$player_autonext = isset($player_options['jw_player_autonext']) ?
	$player_options['jw_player_autonext'] : false;
	$is_adult 		 = isset($meta['is_adult']) ? $meta['is_adult'] : '';
	$post_slug       = basename(get_permalink($post->ID));
	$type_slug       = cs_get_option('halim_url_type');
	$watch_slug      = cs_get_option('halim_watch_url');
	$episode_slug    = cs_get_option('halim_episode_url');
	$server_slug     = cs_get_option('halim_server_url');
	$single_tpl      = cs_get_option('single_template');
    $link = home_url('/'.$watch_slug.'-'.$post_slug);
	$episode_display = cs_get_option('halim_episode_display');
	$first_episode = '';
    $post_meta = get_post_meta($post->ID, '_halimmovies', true);
    $data = json_decode(stripslashes($post_meta), true);
    if($data) {
    	$first_episode = key($data[0]['halimmovies_server_data']);
    }
	$ep_slug = get_query_var('episode_slug');
	$config = [
			'act'               => $halim_action,
			'post_url'          => $link,
			'ajax_url'          => HALIM_THEME_URI.'/halim-ajax.php',
			'player_url'        => HALIM_THEME_URI.'/player.php',
			'loading_img'       => HALIM_THEME_URI .'/assets/images/ajax-loader.gif',
			'eps_slug'          => $episode_slug,
			'server_slug'       => $server_slug,
			'type_slug'         => $type_slug,
			'post_title'        => $post->post_title,
			'post_id'           => $post->ID,
			'episode_slug'      => $ep_slug ? $ep_slug : str_replace('_', '-', $first_episode),
			'server'            => $server ? $server : cs_get_option('episode_server_default'),
			'custom_var'		=> isset($_GET['custom_var']) ? sanitize_text_field($_GET['custom_var']) : '',
			'player_error_detect' => cs_get_option('player_error_detect') ? cs_get_option('player_error_detect') : 'display_modal',
			'paging_episode'    => isEpisodePagenav($meta) ? 'true' : 'false',
			'episode_display'   => $episode_display != '' ? $episode_display : 'none',
			'episode_nav_num'   => (int)cs_get_option('episode_pagination'),
			'auto_reset_cache'  => cs_get_option('auto_reset_cache'),
			'resume_playback'   => cs_get_option('resume_playback'),
			'resume_text'       => __('Automatically resumes your videos from where you played them last at', 'halimthemes'),
			'resume_text_2'     => __('Playback from the beginning?', 'halimthemes'),
			'playback'          => __('Playback', 'halimthemes'),
			'continue_watching' => __('Continue watching', 'halimthemes'),
			'player_reload'     => __('Reload Player', 'halimthemes'),
			'jw_error_msg_0'    => __('We are unable to find the video you are looking for. There could be several reasons for this, for example it got removed by the owner!', 'halimthemes'),
			'jw_error_msg_1'    => __('This video file cannot be played.', 'halimthemes'),
			'jw_error_msg_2'    => __('To continue watching, please click on the "Reload Player" button', 'halimthemes'),
			'jw_error_msg_3'    => __('or click on the buttons below', 'halimthemes'),
			'light_on'          => __('Light On', 'halimthemes'),
			'light_off'         => __('Light Off', 'halimthemes'),
			'expand'            => __('Expand', 'halimthemes'),
			'collapse'          => __('Collapse', 'halimthemes'),
			'player_loading'    => __('Loading player, please wait...', 'halimthemes'),
			'player_autonext'   => __('Autoplay next episode, please wait...', 'halimthemes'),
			'is_adult'          => $is_adult,
			'adult_title'       => cs_get_option('adult_content_title'),
			'adult_content'     => cs_get_option('adult_content_info_text'),
			'show_only_once'    => __('Don\'t show again', 'halimthemes'),
			'exit_btn'          => __('EXIT', 'halimthemes'),
			'is_18plus'         => __('18+ ENTER', 'halimthemes'),
				// 'report_lng'        => [
				// 	'title'             => get_the_title($post->ID),
				// 	'alert'             => __('Your name and message is required (*)', 'halimthemes'),
				// 	'msg'               => __('Your message', 'halimthemes'),
				// 	'msg_success'       => __('Thank you for sending error messages. We will fix the problem in the shortest time possible.', 'halimthemes'),
				// 	'loading_img'       => plugins_url( 'halim-movie-report/loading.gif' ),
				// 	'report_btn'        => __('Report', 'halimthemes'),
				// 	'name_or_email'     => __('Name or Email', 'halimthemes'),
				// 	'close'             => __('Close', 'halimthemes')
			// ]
	];

	// Chuyển đổi link ảnh tuyệt đối bằng link tương đối
	// Link tuyệt đối -> http://halimmovie.wp/wp-content/uploads/2019/12/first-dates-season-13-68691-thumbnail.jpg
	// Link tương đối -> /wp-content/uploads/2019/12/first-dates-season-13-68691-thumbnail.jpg
	// Tính năng hữu ích cho các site thường xuyên thay đổi domain do vi phạm bản quyền
    if(isset($meta['halim_thumb_url']) && $meta['halim_thumb_url']) {
    	if(strpos($meta['halim_thumb_url'], home_url()) !== false) {
	        $meta['halim_thumb_url'] = halim_make_url_relative($meta['halim_thumb_url']);
	        $meta['halim_thumb_url'] = $meta['halim_thumb_url'];
	        update_post_meta($post->ID, '_halim_metabox_options', $meta);
    	}
    }

    $single_tpl = cs_get_option('single_template');
	if($single_tpl == NULL || $halim_action) {
		do_action('halim_player_fullwidth', $meta);
	}
?>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
    <section id="content">
        <div class="clearfix wrap-content">
	        <script>var halim_cfg = <?php echo json_encode($config, JSON_UNESCAPED_UNICODE); ?></script>
        	<?php
	            if($single_tpl !== NULL) {
	            	$layout_dir = $single_tpl == 'template-1' ? 'single-layout-1' : 'single-layout-2';
	            	($halim_action) ? get_template_part('templates/'.$layout_dir.'/single.watch') : get_template_part('templates/'.$layout_dir.'/single.info');
	            } else {
	            	get_template_part('templates/single.full');
	            }
            ?>
        </div>
    </section>

    <section class="related-movies">
        <?php dynamic_sidebar('related-video'); ?>
    </section>
    <?php
		$posttags = get_the_tags();
		if ($posttags) {
			echo '<div class="the_tag_list">';
	  		foreach($posttags as $tag)
		  		echo '<a href="'.esc_url(get_tag_link($tag->term_id)).'" title="'.esc_html($tag->name).'" rel="tag">'.esc_html($tag->name).'</a>';
	  		echo '</div>';
		}
	?>
</main>
<?php get_sidebar(); get_footer(); ?>