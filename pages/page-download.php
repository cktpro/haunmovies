<?php
/**
 * Template Name: Page Download
 */
$url = isset($_GET['url']) ? HaLimCrypt::decrypt(sanitize_text_field($_GET['url'])) : null;
$post_id = isset($_GET['id']) ? absint($_GET['id']) : null;
$countdown_time = cs_get_option('dl_ads_countdown_time') ? cs_get_option('dl_ads_countdown_time') : 10;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php _e('Download', 'halimthemes'); ?> <?php echo $post_id ? get_the_title($post_id) : ''; ?></title>
	<meta name="robots" content="noindex, nofollow" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style>
		body {
			background-color: #f5f7fa;
			margin: 0 auto;
		}
		a, a:hover {
			text-decoration: none
		}
		@media (min-width: 1200px) {
			.container {
			    width: 650px;
			}
		}

		.download-container {
		    background: #fff;
		    padding: 30px;
		    border-radius: 5px;
		    box-shadow: 1px 0px 15px 9px rgb(173 173 173 / 15%);
		    text-align: center;
		    overflow: hidden;
		    margin-top: 85px;
		}
		#counter span {
		    color: #ff9d0b;
		    width: 100px;
		    height: 100px;
		    line-height: 100px;
		    display: block;
		    margin: 0 auto;
		    font-size: 30px;
		    font-weight: 500;
		    border-radius: 50%;
		    border: solid 1px #ebeff3;
		    border: solid 2px #ff9d0b;
		    text-align: center;
		}

		.text {
		    font-size: 14px;
		    padding: 10px;
		    display: block;
		    color: #8a8a8a
		}
		p.txt {
		    color: #888;
		    padding: 10px;
		}

		.text-center .txt {
		    padding: 30px;
		    display: block;
		    font-size: 18px;
		}


		#dl-button {
		    padding: 12px 15px;
		    background-color: #007bfc;
		    border-color: #007bfc;
		    box-shadow: 1px 0px 12px 2px rgb(113 113 113 / 18%);
		}
		#dl-button:hover {
		    background-color: #8fcf14;
		    border-color: #8fcf14;
		}
		a span.text {
		    color: #46aaff;
		    font-size: 16px;
		}

		span.text i.glyphicon.glyphicon-link {
		    font-size: 12px;
		    color: #b3b2b2;
		}
	</style>

</head>
<body>
	<div class="container bg-faded">
		<div class="download-container">
			<?php if(cs_get_option('dl_top_ads')) : ?>
			    <div class="row">
			        <div class="col-xs-12">
			        	<?php echo cs_get_option('dl_top_ads'); ?>
			        </div>
			    </div>
			    <hr>
			<?php endif; ?>
		    <div class="row">
		        <div class="col-xs-6 col-xs-offset-3">

					<span id="counter">
						<span><?php echo $countdown_time; ?></span>
						<p class="txt"><?php _e('Please wait until the time runs out', 'halimthemes'); ?></p>
					</span>


		            <a href="<?php echo esc_url($url); ?>" class="btn btn-primary btn-block" id="dl-button" style="display: none;" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> <?php _e('Download', 'halimthemes'); ?></a>

					<span class="text" style="display: none;"><?php _e('Click on the button to continue', 'halimthemes'); ?></span>

		            <a href="<?php echo get_the_permalink($post_id); ?>"><span class="text" style="display: none;"><i class="glyphicon glyphicon-link"></i> <?php echo get_the_title($post_id); ?></span></a>

		        </div>
		    </div>
		    <?php if(cs_get_option('dl_bottom_ads')) : ?>
			    <hr>
			    <div class="row">
			        <div class="col-xs-12">
			        	<?php echo cs_get_option('dl_bottom_ads'); ?>
			        </div>
			    </div>
			<?php endif; ?>

		</div>
		<div class="text-center">
			<span class="txt"><?php _e('Are you going to', 'halimthemes'); ?> <strong><?php echo get_root_domain($url); ?></strong></span>
		</div>
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


	<script>
	    var timeout, interval
	    var threshold = <?php echo ($countdown_time * 1000); ?>;
	    var secondsleft = threshold;

	    window.onload = function() {
	        startschedule();
	    }

	    function startChecking()
	    {
	        secondsleft -= 1000;
	        $("#counter span").html(Math.abs((secondsleft / 1000)));
	        if(secondsleft == 0)
	        {
	            clearInterval(interval);
	            $("#counter span, #counter .txt").hide();
	            $("#dl-button, .text").show();
	        }
	    }

	    function startschedule()
	    {
          	clearInterval(interval);
          	secondsleft = threshold;
          	$("#counter span").html(Math.abs((secondsleft / 1000)));
           	interval = setInterval(function() {
               	startChecking();
           	}, 1000)
	   }
	</script>
</body>
</html>