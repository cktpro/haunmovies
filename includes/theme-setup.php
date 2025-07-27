<?php

add_action("after_setup_theme", "halim_theme_setup");
add_action("init", "halim_set_permalink_structure");
add_filter("gettext_with_context", "rename_post_formats", 10, 4);
add_action("wp_enqueue_scripts", "halim_enqueue_scripts", 1);
add_action("wp_footer", "halim_add_fb_scripts", 5);
add_action("wp_dashboard_setup", "halim_wp_environment_menu");
add_filter("query_vars", "halim_register_query_vars");
if (!function_exists("halim_rewrite_rule")) {
    function halim_rewrite_rule()
    {
        $watch = cs_get_option("halim_watch_url");
        $episode = cs_get_option("halim_episode_url");
        $server = cs_get_option("halim_server_url");
        add_rewrite_rule("^([^/]*)-" . $episode . "-([0-9]+)-" . $server . "-([0-9]+)/?", "index.php?name=\$matches[1]&halim_episode=\$matches[2]&halim_server=\$matches[3]", "top");
        add_rewrite_rule("^" . $watch . "/([^/]*)-" . $episode . "-([0-9]+)-" . $server . "-([0-9]+)/?", "index.php?name=\$matches[1]&halim_episode=\$matches[2]&halim_server=\$matches[3]&halim_action=watch", "top");
        add_rewrite_rule("^([^/]*)-" . $episode . "-([0-9]+)-" . $server . "([0-9]+)/?", "index.php?name=\$matches[1]&halim_episode=\$matches[2]&halim_server=\$matches[3]", "top");
        add_rewrite_rule("^" . $watch . "/([^/]*)-" . $episode . "-([0-9]+)-" . $server . "([0-9]+)/?", "index.php?name=\$matches[1]&halim_episode=\$matches[2]&halim_server=\$matches[3]&halim_action=watch", "top");
        add_rewrite_rule("^" . $watch . "-([^/]*)/([^/]*)-sv([0-9]+).html?\$", "index.php?name=\$matches[1]&episode_slug=\$matches[2]&halim_server=\$matches[3]&episode_id=\$matches[4]&halim_action=watch", "top");
        add_rewrite_rule("^filter-movies/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/page/([0-9]+)?", "index.php?pagename=filter-movies&sort=\$matches[1]&formality=\$matches[2]&status=\$matches[3]&country=\$matches[4]&release=\$matches[5]&category=\$matches[6]&filter_page=\$matches[7]", "top");
        add_rewrite_rule("^filter-movies/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/?", "index.php?pagename=filter-movies&sort=\$matches[1]&formality=\$matches[2]&status=\$matches[3]&country=\$matches[4]&release=\$matches[5]&category=\$matches[6]", "top");
        add_rewrite_rule("^az-list/([^/]*)/page/([^/]+)?", "index.php?pagename=az-list&letter=\$matches[1]&az_page=\$matches[2]", "top");
        add_rewrite_rule("^az-list/([^/]*)?", "index.php?pagename=az-list&letter=\$matches[1]", "top");
        flush_rewrite_rules();
    }
}
add_action("init", "halim_rewrite_rule", 10, 0);
if (!function_exists("halim_filer_redirect_check")) {
    function halim_filer_redirect_check()
    {
        if (isset($_GET["sort"]) && $_GET["sort"] != "") {
            if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]) {
                $location = "https://";
            } else {
                $location = "http://";
            }
            $location .= $_SERVER["SERVER_NAME"];
            $location .= strtok($_SERVER["REQUEST_URI"], "?");
            $location = trailingslashit($location);
            $location .= isset($_GET["sort"]) ? $_GET["sort"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["formality"]) ? $_GET["formality"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["status"]) ? $_GET["status"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["country"]) ? $_GET["country"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["release"]) ? $_GET["release"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["category"]) ? $_GET["category"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["page"]) ? $_GET["page"] : "";
            $location = trailingslashit($location);
            $location .= isset($_GET["page1"]) ? $_GET["page1"] : "";
            $location = trailingslashit($location);
            wp_redirect($location);
            exit;
        }
    }
}
add_action("init", "halim_filer_redirect_check");
add_action("restrict_manage_posts", "halim_filter_post_type_by_taxonomy");
add_filter("parse_query", "halim_convert_id_to_term_in_query");
add_action("restrict_manage_posts", "halim_filter_by_the_author");
add_action("login_head", "add_site_favicon");
add_action("admin_head", "add_site_favicon");
add_action("save_post_post", "halim_save_custom_post_meta");
function halim_theme_setup()
{
    add_theme_support("nav-menus");
    add_theme_support("title-tag");
    add_theme_support("responsive-embeds");
    register_nav_menus(["header_menu" => __("Header Menu", "halimthemes"), "footer_menu" => __("Footer Menu", "halimthemes")]);
    add_theme_support("post-thumbnails");
    if (function_exists("add_image_size")) {
        add_image_size("movie-thumb", 200, 250, true);
    }
    add_theme_support("post-formats", ["aside", "gallery", "audio", "video"]);
    add_theme_support("html5", ["search-form", "comment-form", "comment-list", "gallery", "caption", "script", "style"]);
    load_theme_textdomain("halimthemes", HALIM_THEME_DIR . "/languages");
    global $themeinfo;
    $themeinfo = wp_get_theme(get_template());
}
function halim_set_permalink_structure()
{
    update_option("permalink_structure", "/%postname%");
    update_option("posts_per_page", 20);
    if (cs_get_option("display_errors")) {
        ini_set("display_errors", 1);
        ini_set("display_startup_errors", 1);
        error_reporting(32767);
    } else {
        error_reporting(0);
    }
}
function rename_post_formats($translation, $text, $context, $domain)
{
    $names = ["Aside" => __("Movie", "halimthemes"), "Gallery" => __("TV Series", "halimthemes"), "Video" => __("TV Shows", "halimthemes"), "Audio" => __("Theater Movie", "halimthemes")];
    if ($context == "Post format") {
        $translation = str_replace(array_keys($names), array_values($names), $text);
    }
    return $translation;
}
function halim_enqueue_scripts()
{
    $themeinfo = wp_get_theme("halimmovies");
    wp_enqueue_script("jquery");
    if (cs_get_option("disable_gutenberg")) {
        wp_deregister_style("wp-block-library");
    }
    wp_enqueue_style("bootstrap", HALIM_THEME_URI . "/assets/css/bootstrap.min.css", "", "");
    wp_enqueue_style("halimmovies-style", HALIM_STYLESHEED_URI, [], $themeinfo->get("Version"));
    wp_style_add_data("halimmovies-style", "rtl", "replace");
    if (cs_get_option("halim_lazyload_image")) {
        wp_enqueue_script("lazysizes", HALIM_THEME_URI . "/assets/js/lazysizes.min.js", [], "", true);
    }
    wp_enqueue_script("bootstrap", HALIM_THEME_URI . "/assets/js/bootstrap.min.js", [], "", true);
    wp_enqueue_script("carousel", HALIM_THEME_URI . "/assets/js/owl.carousel.min.js", [], "", true);
    wp_enqueue_script("halim-init", HALIM_THEME_URI . "/assets/js/core.min.js", [], $themeinfo->get("Version"), true);
    wp_localize_script("halim-init", "halim", ["ajax_url" => HALIM_THEME_URI . "/halim-ajax.php", "light_mode" => cs_get_option("halim_light_mode") ? 1 : 0, "light_mode_btn" => cs_get_option("halim_light_mode_switch_btn") ? 1 : 0, "ajax_live_search" => cs_get_option("enable_live_search"), "sync" => cs_get_option("halim_disable_debug"), "db_redirect_url" => cs_get_option("haim_debug_redirect_url") ?: "https://halimthemes.com"]);
    if (is_single()) {
        wp_localize_script("halim-init", "ajax_var", ["url" => HALIM_THEME_URI . "/halim-ajax.php", "nonce" => wp_create_nonce("ajax-nonce")]);
        wp_localize_script("halim-init", "halim_rate", ["ajaxurl" => HALIM_THEME_URI . "/halim-ajax.php", "nonce" => wp_create_nonce("halim_rate_nonce"), "your_rating" => __("Thank you for rating!", "halimthemes")]);
    }
    wp_enqueue_script("ajax-auth-script", HALIM_THEME_URI . "/assets/js/ajax-auth-script.min.js", [], $themeinfo->get("Version"), true);
    wp_localize_script("ajax-auth-script", "ajax_auth_object", ["ajaxurl" => HALIM_THEME_URI . "/halim-ajax.php", "redirecturl" => home_url(), "loadingmessage" => __("Sending user info, please wait...", "halimthemes"), "sitekey" => cs_get_option("recaptcha_site_key"), "languages" => ["login" => __("Login", "halimthemes"), "register" => __("Register", "halimthemes"), "forgotpassword" => __("Lost your password?", "halimthemes"), "already_account" => __("Already have an account?", "halimthemes"), "create_account" => __("Create account", "halimthemes"), "reset_captcha" => __("Reset captcha", "halimthemes"), "username" => __("Username", "halimthemes"), "email" => __("Email", "halimthemes"), "username_email" => __("Username or Email", "halimthemes"), "password" => __("Password", "halimthemes"), "reset_password" => __("Reset Password", "halimthemes"), "login_with" => __("Login with", "halimthemes"), "register_with" => __("Register with", "halimthemes"), "or" => __("or", "halimthemes")]]);
}
function halim_add_fb_scripts()
{
	$appId = cs_get_option('halim_fb_apps_id');
	$lang = str_replace(array('-', 'vi'), array('_', 'vi_VN'), get_bloginfo('language'));
	?>
	<script>
		jQuery('body').append('<div id="fb-root"></div>');
		window.fbAsyncInit = function() {
				FB.init({ appId : '<?php echo $appId ? $appId : '576313040751060'; ?>', cookie : true, xfbml : true, version : 'v3.0'
			}); };
			_loadFbSDk=function(){ (function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/<?php echo $lang; ?>/sdk.js"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));
		}
		jQuery(window).on('load',function(){ setTimeout("_loadFbSDk()",100); });
	</script>
	<?php
}
function halim_wp_environment_menu()
{
    add_meta_box("halim_wp_environment", "Environment", "halim_wp_environment_menu_callback", "dashboard", "side", "high");
}
function halim_wp_environment_menu_callback()
{
    global $themeinfo;
    echo "    <div id=\"activity-widget\">\r\n        <div id=\"published-posts\" class=\"activity-block\">\r\n            <ul>\r\n                <li><span>Theme Name:</span> <a href=\"";
    echo $themeinfo->get("ThemeURI");
    echo "\" target=\"_blank\">";
    echo $themeinfo->get("Name");
    echo "</a>\r\n                </li>\r\n                <li><span>Theme Author:</span> <a href=\"";
    echo $themeinfo->get("AuthorURI");
    echo "\" target=\"_blank\">";
    echo $themeinfo->get("Author");
    echo "</a>\r\n                </li>\r\n                <li><span>Theme Version:</span> <span style=\"color: #0a0;font-weight: 700;\">";
    echo $themeinfo->get("Version");
    echo "</span></li>\r\n                ";
    if (100000 <= ini_get("max_input_vars")) {
        echo "                <li style=\"background: #edffe0;padding: 10px;border: 1px solid #84ca16;line-height: 21px;\">\r\n                ";
    } else {
        echo "                <li style=\"background: #ffeaea;padding: 10px;border: 1px solid #ff9595;line-height: 21px;\">\r\n                ";
    }
    echo "                    <span><strong style=\"color: #333;\">PHP Max Input Vars:</strong></span>\r\n                    ";
    if (100000 <= ini_get("max_input_vars")) {
        echo "                            <span style=\"color: green\"><strong>";
        echo number_format(ini_get("max_input_vars"));
        echo " √</strong></span>\r\n                            ";
    } else {
        echo "                            <span style=\"color: red\"><strong>";
        echo number_format(ini_get("max_input_vars"));
        echo "</strong> - ";
        echo isLang() ? "Giá trị đề xuất" : "Recommended Value";
        echo ": <strong>100,000+</strong></span>\r\n                            ";
    }
    echo "                    ";
    if (100000 <= ini_get("max_input_vars")) {
        echo "                    <span style=\"color: #79b700;margin-top: 10px;\">\r\n                    ";
    } else {
        echo "                    <span style=\"color: #ff8484;margin-top: 10px;\">\r\n                    ";
    }
    echo "                        ";
    if (isLang()) {
        echo "                            Giới hạn số lượng tham số truyền vào <code>max_input_vars</code> sẽ cắt bớt dữ liệu dầu vào của phương thức POST như <strong>danh sách menu, danh sách tập phim</strong>, điều này sẽ khiến cho danh sách tập phim bị cắt bớt và không thể lưu được số lượng lớn.\r\n                            <br>\r\n                            Bạn có thể tăng <code>max_input_vars</code> bằng cách chỉnh sửa trong tệp <strong>php.ini.</strong> Kích thước mặc định của biến này là 1000 nhưng nếu bạn muốn gửi số lượng lớn dữ liệu, bạn phải tăng kích thước tương ứng. <a href=\"https://www.google.com/search?q=Increasing+max+input+vars+limit\" target=\"_blank\" style=\"font-weight: 700;\"> Tham khảo cách tăng PHP <code>max_input_vars</code></a>\r\n\r\n                        ";
    } else {
        echo "                            Max input vars limitation will truncate POST data such as menus or episodes. <a href=\"https://www.google.com/search?q=Increasing+max+input+vars+limit\" target=\"_blank\" style=\"font-weight: 700;\">See: Increasing max input vars limit</a>\r\n                        ";
    }
    echo "                        </span>\r\n                </li>\r\n            </ul>\r\n        </div>\r\n    </div>\r\n    ";
}
function halim_register_query_vars($vars)
{
    $vars[] = "halim_action";
    $vars[] = "halim_server";
    $vars[] = "episode_slug";
    $vars[] = "halim_episode";
    $vars[] = "formality";
    $vars[] = "status";
    $vars[] = "country";
    $vars[] = "release";
    $vars[] = "category";
    $vars[] = "sort";
    $vars[] = "page";
    $vars[] = "letter";
    $vars[] = "az_page";
    $vars[] = "filter_page";
    return $vars;
}
function save_taxonomy_custom_meta($term_id)
{
    if (isset($_POST["term_meta"])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_" . $t_id);
        $cat_keys = array_keys($_POST["term_meta"]);
        foreach ($cat_keys as $key) {
            if (isset($_POST["term_meta"][$key])) {
                $term_meta[$key] = $_POST["term_meta"][$key];
            }
        }
        update_option("taxonomy_" . $t_id, $term_meta);
    }
}
function wp_check($key, $value = "", $get = false)
{
    if ($get) {
        return get_option($key);
    }
    return update_option($key, $value);
}
function halim_filter_post_type_by_taxonomy()
{
    global $typenow;
    $post_type = "post";
    $taxonomys = ["release", "country", "status"];
    if ($typenow == $post_type) {
        foreach ($taxonomys as $taxonomy) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : "";
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(["show_option_all" => __("All " . $info_taxonomy->label), "taxonomy" => $taxonomy, "name" => $taxonomy, "orderby" => "name", "selected" => $selected, "show_count" => true, "hide_empty" => true]);
        }
    }
}
function halim_convert_id_to_term_in_query($query)
{
    global $pagenow;
    $post_type = "post";
    $taxonomys = ["release", "country", "status"];
    $q_vars =& $query->query_vars;
    foreach ($taxonomys as $taxonomy) {
        if ($pagenow == "edit.php" && isset($q_vars["post_type"]) && $q_vars["post_type"] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by("id", $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }
}
function halim_filter_by_the_author()
{
    $params = ["name" => "author", "show_option_all" => "All authors"];
    if (isset($_GET["user"])) {
        $params["selected"] = $_GET["user"];
    }
    wp_dropdown_users($params);
}
function add_export_button()
{
    $screen = get_current_screen();
    if (isset($screen->parent_file) && "edit.php" == $screen->parent_file) {
        echo "        <input type=\"submit\" name=\"export_all_posts\" id=\"export_all_posts\" class=\"button button-primary\" value=\"Export All Posts\">\r\n        <script>\r\n            jQuery(function(\$) {\r\n                \$('#export_all_posts').insertAfter('#post-query-submit');\r\n            });\r\n        </script>\r\n        ";
    }
}
function func_export_all_posts()
{
    if (isset($_GET["export_all_posts"])) {
        $arg = ["post_type" => "post", "post_status" => "publish", "posts_per_page" => -1];
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) {
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=\"" . sanitize_title(get_bloginfo("name")) . ".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");
            $file = fopen("php://output", "w");
            fputcsv($file, ["Post Title", "URL"]);
            foreach ($arr_post as $post) {
                setup_postdata($post);
                fputcsv($file, [get_the_title(), get_the_permalink()]);
            }
            exit;
        }
    }
}
function add_site_favicon()
{
    echo "<link rel=\"shortcut icon\" href=\"" . HALIM_THEME_URI . "/assets/images/favicon.ico\" />";
}
function delete_custom_terms($taxonomy){
    global $wpdb;

    $query = 'SELECT t.name, t.term_id
            FROM ' . $wpdb->terms . ' AS t
            INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt
            ON t.term_id = tt.term_id
            WHERE tt.taxonomy = "' . $taxonomy . '"';

    $terms = $wpdb->get_results($query);

    foreach ($terms as $term) {
        wp_delete_term( $term->term_id, $taxonomy );
    }
}

function delete_empty_terms(){
    $taxonomy_name = 'actor';
    $terms = get_terms( array(
        'taxonomy' => $taxonomy_name,
        'hide_empty' => false
    ) );
    foreach ( $terms as $term ) {
        $term_count = $term->count;
        if ($term_count < 1){ wp_delete_term($term->term_id, $taxonomy_name);
        }
    }
}
function halim_get_post_format_type($type) {
    $post_formats = array(
        'movie' => 'aside',
        'movies' => 'aside',
        'single_movies' => 'aside',
        'tv_series' => 'gallery',
        'tv_shows' => 'video',
        'theater_movie' => 'audio'
    );
    $post_format = $type ? $post_formats[$type] : '';

    return $post_format;
}
function halim_save_custom_post_meta($post_id)
{
    $options = isset($_POST["_halim_metabox_options"]) ? $_POST["_halim_metabox_options"] : "";
    if (isset($options["halim_movie_status"])) {
        wp_set_object_terms($post_id, $options["halim_movie_status"], "status", false);
    }
    if (isset($options["halim_add_to_widget"])) {
        wp_set_object_terms($post_id, $options["halim_add_to_widget"], "post_options", false);
    }
    if (isset($options["halim_movie_formality"])) {
        $post_format = halim_get_post_format_type($options["halim_movie_formality"]);
        set_post_format($post_id, $post_format);
    }
}

?>