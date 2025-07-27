		<div class="wrap child-theme-wrap">
			<?php
			/*
			 * only show child theme instructions if halim is the active theme
			 */
			$halim_parent = wp_get_theme();
			if ( $halim_parent->get( 'Name' ) === 'HaLimMovie' ) {
				?>
				<h2 class="headline"><?php echo sprintf( __( 'How to Create a Child Theme for %1$s?', 'halimthemes' ), HALIMMOVIE_NAME ); ?></h2>
				<ol>
					<li><?php _e( 'Through FTP, navigate to <code>your_website/wp-content/themes/</code> and in that directory, create a new folder as the name of your child theme. Something like <code>halimmovie-child</code> is perfect.', 'halimthemes' ); ?></li>
					<li><?php _e( 'Inside of your new folder, create a file called <code>style.css</code> (the name is NOT optional).', 'halimthemes' ); ?></li>
					<li><?php _e( 'Inside of your new <code>style.css</code> file, add the following CSS:', 'halimthemes' ); ?>

<pre class="halimmovie-pre">
/*
Theme Name: HaLimMovie Child
Author: HaLim
Author URI: http://yoursite.com
Description: Child theme for HaLimMovie
Template: halimmovies
*/

/* ----- Theme customization starts here ----- */
</pre>

					</li>
					<li><?php printf( __( 'You may edit all of what you pasted EXCEPT for the <code>Template: halimmovies</code> line. Leave that line alone or the child theme will not attach itself to %s.', 'halimthemes' ), HALIMMOVIE_NAME ); ?></li>
					<li><?php _e( 'Also inside of your folder, create another file called <code>functions.php</code> (the name is NOT optional).', 'halimthemes' ); ?></li>
					<li><?php _e( 'Inside of your new, blank <code>functions.php</code> file, add the following PHP:', 'halimthemes' ); ?>

<pre class="halimmovie-pre">
&lt;?php
/**
 * HaLimMovie Child Theme Functions
 */

function halimmovie_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'halimmovie_child_enqueue_styles' );
</pre>
					</li>
					<li><?php _e( 'With your new child theme folder in place, the above CSS pasted inside of your <code>style.css</code> file, and the above PHP pasted inside of your <code>functions.php</code> file, go back to your WordPress dashboard and navigate to "Appearance -> Themes" and locate your new theme (you\'ll see the name you chose). Activate your theme.', 'halimthemes' ); ?></li>
					<li><?php _e( 'With your child theme activated, you can edit its stylesheet all you like. You may also add custom functions to your new functions file.', 'halimthemes' ); ?></li>
					<li><?php _e( 'Enjoy!', 'halimthemes' ); ?></li>
				</ol>
				<?php
			} else {
				echo sprintf( '<h3>' . __( 'You are currently using a child theme for %s.', 'halimthemes' ) . '</h3>', HALIMMOVIE_NAME );
			}
			?>
		</div>