<?php
/*
 *  https://Mphe.Net
 *  Code Được Mod By Hậu Nguyễn
 *  Facebook : https://www.facebook.com/haun.ytb/
 */

include_once "halim-seo.php";
include_once "jquery-ajax-script.php";
include_once "download-metaboxes.php";
if (!function_exists("is_halim_country_blocker")) {
    function is_halim_country_blocker($post_id)
    {
        if (function_exists("halim_country_blocker")) {
            if (!halim_country_blocker($post_id)) {
                return true;
            }
            return false;
        }
        return true;
    }
}
add_action("init", "halim_player_layout");
if (!function_exists("halim_player_box")) {
    function halim_player_box($meta)
    {
        global $post;
        $_obfuscated_0D0427172F342139042B0C402C0B071D5C1B27072C0C11_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["is_copyright"]) ? $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["is_copyright"] : "";
        $_obfuscated_0D1E35160E01171439212F1E3C251C0F340F3D2B2A1901_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["is_adult"]) ? $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["is_adult"] : "";
        $_obfuscated_0D261B2B3C38123414253B042115211B3823070C211C32_ = cs_get_option("halim_jw_player_options");
        $_obfuscated_0D3C2E3D0D1C065B3740323638050C1F321819091C0B32_ = isset($_obfuscated_0D261B2B3C38123414253B042115211B3823070C211C32_["jw_player_autonext"]) ? $_obfuscated_0D261B2B3C38123414253B042115211B3823070C211C32_["jw_player_autonext"] : false;
        $check = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_status"]) ? $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_status"] : "";
        $_obfuscated_0D271C2609252138122D283C21240D03023606230E3301_ = cs_get_option("player_layout") == "fullwidth" ? "fullwidth" : "default";
        ob_start();
        echo "        ";
        if ($_obfuscated_0D0427172F342139042B0C402C0B071D5C1B27072C0C11_) {
            echo "            <div id=\"is_copyright\">\r\n                <p><i class=\"hl-attention\"></i> ";
            _e("Copyright infringement!", "halimthemes");
            echo "</p>\r\n            </div>\r\n        ";
        } else {
            echo "            <div id=\"halim-player-wrapper\" class=\"ajax-player-loading\" data-adult-content=\"";
            echo $_obfuscated_0D1E35160E01171439212F1E3C251C0F340F3D2B2A1901_;
            echo "\">\r\n                ";
            if (!post_password_required($post)) {
                echo "                        <div id=\"halim-player-loader\"></div>\r\n                        <div id=\"ajax-player\" class=\"player\"></div>\r\n                        ";
                if ($check == "is_trailer") {
                    echo "<span class=\"trailer-button\">" . __("Trailer", "halimthemes") . "</span>";
                }
            } else {
                echo get_the_password_form();
            }
            echo "            </div>\r\n\r\n            <div class=\"clearfix\"></div>\r\n\r\n            <div class=\"button-watch ";
            echo $_obfuscated_0D271C2609252138122D283C21240D03023606230E3301_;
            echo "\">\r\n                <ul class=\"halim-social-plugin col-xs-4 hidden-xs\">\r\n                    <li class=\"fb-like\" data-href=\"";
            the_permalink();
            echo "/\" data-layout=\"button_count\" data-action=\"like\" data-size=\"small\" data-show-faces=\"true\" data-share=\"true\"></li>\r\n                </ul>\r\n\r\n                <div class=\"col-xs-12 col-md-8\">\r\n\r\n                    ";
            do_action("halim_before_single_watch_button", $post->ID);
            echo "                    ";
            if (cs_get_option("enable_next_prev_episode_button")) {
                echo "                        <div class=\"luotxem halim-prev-episode\"><i class=\"hl-next prev\"></i> ";
                _e("Prev", "halimthemes");
                echo "</div>\r\n                        <div class=\"luotxem halim-next-episode\">";
                _e("Next", "halimthemes");
                echo " <i class=\"hl-next\"></i></div>\r\n                    ";
            }
            echo "                    ";
            if ($_obfuscated_0D3C2E3D0D1C065B3740323638050C1F321819091C0B32_) {
                echo "                        <div id=\"autonext\" class=\"btn-cs autonext\">\r\n                            <i class=\"icon-autonext-sm\"></i>\r\n                            <span><i class=\"hl-next\"></i> ";
                _e("Autoplay next episode", "halimthemes");
                echo ": <span id=\"autonext-status\">";
                _e("On", "halimthemes");
                echo "</span></span>\r\n                        </div>\r\n                    ";
            }
            echo "                    ";
            if (cs_get_option("player_layout") == "default") {
                echo "                        <div id=\"explayer\" class=\"hidden-xs\"><i class=\"hl-resize-full\"></i>\r\n                            ";
                _e("Expand", "halimthemes");
                echo "                        </div>\r\n                    ";
            }
            echo "                    <div id=\"toggle-light\"><i class=\"hl-adjust\"></i>\r\n                        ";
            _e("Light Off", "halimthemes");
            echo "                    </div>\r\n                    ";
            if (get_option("halim_report_enable")) {
                echo "                    <div id=\"report\" class=\"halim-switch\"><i class=\"hl-attention\"></i> ";
                _e("Report", "halimthemes");
                echo "</div>\r\n                    ";
            }
            echo "                    <div class=\"luotxem\"><i class=\"hl-eye\"></i>\r\n                        <span>";
            echo halim_display_post_view_count($post->ID);
            echo "</span> ";
            _e("view", "halimthemes");
            echo "                    </div>\r\n                    <div class=\"luotxem visible-xs-inline\">\r\n                        <a data-toggle=\"collapse\" href=\"#moretool\" aria-expanded=\"false\" aria-controls=\"moretool\"><i class=\"hl-forward\"></i> ";
            _e("Share", "halimthemes");
            echo "</a>\r\n                    </div>\r\n                    ";
            do_action("halim_after_single_watch_button", $post->ID);
            echo "                </div>\r\n            </div>\r\n\r\n            <div class=\"collapse\" id=\"moretool\">\r\n                <div class=\"nav nav-pills x-nav-justified\">\r\n                    <div class=\"fb-like\" data-href=\"";
            the_permalink();
            echo "/\" data-layout=\"button_count\" data-action=\"like\" data-size=\"small\" data-show-faces=\"true\" data-share=\"true\"></div>\r\n                    <div class=\"fb-save\" data-uri=\"";
            the_permalink();
            echo "/\" data-size=\"small\"></div>\r\n                </div>\r\n            </div>\r\n\r\n        ";
        }
        echo "        <div class=\"clearfix\"></div>\r\n        ";
        $_obfuscated_0D1516243C3E1F37310B34342F083C302331161A5C3632_ = ob_get_clean();
        echo $_obfuscated_0D1516243C3E1F37310B34342F083C302331161A5C3632_;
    }
}
add_action("admin_notices", "halim_show_custom_notice");
add_filter("wp_update_attachment_metadata", "halim_unlink_tempfix");
add_filter("protected_title_format", "halim_remove_private_and_protected_text");
add_filter("private_title_format", "halim_remove_private_and_protected_text");
if(!function_exists('halim_custom_password_form'))
{
    function halim_custom_password_form(){
        global $post;
        $post   = get_post( $post );
        $label  = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
        $output = '<div class="halim_password_form"><form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
        <p>' . __( 'This content is password protected. To view it please enter your password below:' ) . '</p>
        <p><label for="' . $label . '"><input name="post_password" id="' . $label . '" class="form-control" type="password" size="20" placeholder="' . __( 'Password' ) . '"/></label>
        <input type="submit" class="btn btn-primary" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '" /></p></form></div>';

        return apply_filters( 'halim_password_form', $output );
    }
}

add_filter("the_password_form", "halim_custom_password_form");
if(!function_exists('halim_get_the_content'))
{
    function halim_get_the_content($content){
        global $post;
        return apply_filters('halim_get_the_content',  wpautop($post->post_content));
    }
}

add_filter( 'the_content', 'halim_get_the_content', 10 );

if(!function_exists('halim_remove_empty_p'))
{
    function halim_remove_empty_p( $content ) {
        $content = force_balance_tags( $content );
        $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
        $content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
        return $content;
    }
}
add_filter('halim_get_the_content', 'halim_remove_empty_p', 20, 1);
add_filter("posts_where", "restrict_by_first_letter", 1, 2);
add_action("admin_bar_menu", "add_toolbar_items", 100);
if (!function_exists("halim_array_key_first")) {
    function halim_array_key_first($arr)
    {
        foreach ($arr as $key => $_obfuscated_0D3303280227140A1E0A380603285B0B270A3402281511_) {
            return $key;
        }
        return NULL;
    }
}
add_action("wp", "check_plugin_active");
class HaLimMovie_Updater
{
    private $remote_api_url = NULL;
    private $request_data = NULL;
    private $response_key = NULL;
    private $theme_slug = NULL;
    private $license_key = NULL;
    private $version = NULL;
    private $author = NULL;
    protected $strings = NULL;
    public function __construct($args = [], $strings = [])
    {
        $defaults = ["remote_api_url" => REMOTE_API_URL, "request_data" => [], "theme_slug" => get_template(), "item_name" => "", "license" => "", "version" => "", "author" => "", "beta" => false];
        $args = wp_parse_args($args, $defaults);
        $this->license = $args["license"];
        $this->item_name = $args["item_name"];
        $this->version = $args["version"];
        $this->theme_slug = sanitize_key($args["theme_slug"]);
        $this->author = $args["author"];
        $this->beta = $args["beta"];
        $this->remote_api_url = $args["remote_api_url"];
        $this->response_key = $this->theme_slug . "-" . $this->beta . "-update-response";
        $this->strings = $strings;
        add_filter("site_transient_update_themes", [$this, "theme_update_transient"]);
        add_filter("delete_site_transient_update_themes", [$this, "delete_theme_update_transient"]);
        add_action("load-update-core.php", [$this, "delete_theme_update_transient"]);
        add_action("load-themes.php", [$this, "delete_theme_update_transient"]);
        add_action("load-themes.php", [$this, "load_themes_screen"]);
    }
    public function load_themes_screen()
    {
        add_thickbox();
        add_action("admin_notices", [$this, "update_nag"]);
    }
    public function update_nag()
    {
        $strings = $this->strings;
        $theme = wp_get_theme($this->theme_slug);
        $_obfuscated_0D05330617340F362C37183D262D3B3C0C0B181C111101_ = get_transient($this->response_key);
        if (false === $_obfuscated_0D05330617340F362C37183D262D3B3C0C0B181C111101_) {
            return NULL;
        }
        $_obfuscated_0D160F28092A0A2131270536393F02103E322A24260D11_ = wp_nonce_url("update.php?action=upgrade-theme&amp;theme=" . urlencode($this->theme_slug), "upgrade-theme_" . $this->theme_slug);
        $_obfuscated_0D0E171C0F1F25013E33393B3E23191A161623121C1511_ = " onclick=\"if ( confirm('" . esc_js($strings["update-notice"]) . "') ) {return true;}return false;\"";
        if (version_compare($this->version, $_obfuscated_0D05330617340F362C37183D262D3B3C0C0B181C111101_->new_version, "<")) {
            echo "<div id=\"update-nag\" class=\"update-message notice inline notice-warning notice-alt\">";
            printf($strings["update-available"], $theme->get("Name"), $_obfuscated_0D05330617340F362C37183D262D3B3C0C0B181C111101_->new_version, "#TB_inline?width=640&amp;inlineId=" . $this->theme_slug . "_changelog", $theme->get("Name"), $_obfuscated_0D160F28092A0A2131270536393F02103E322A24260D11_, $_obfuscated_0D0E171C0F1F25013E33393B3E23191A161623121C1511_);
            echo "</div>";
            echo "<div id=\"" . $this->theme_slug . "_" . "changelog\" style=\"display:none;\">";
            echo wpautop($_obfuscated_0D05330617340F362C37183D262D3B3C0C0B181C111101_->sections["changelog"]);
            echo "</div>";
        }
    }
    public function theme_update_transient($value)
    {
        $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_ = $this->check_for_update();
        if ($_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_) {
            $value->response[$this->theme_slug] = $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_;
        }
        return $value;
    }
    public function delete_theme_update_transient()
    {
        delete_transient($this->response_key);
    }
    public function check_for_update()
    {
        $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_ = get_transient($this->response_key);
        if (false === $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_) {
            $_obfuscated_0D1D2E2D3F042C3B0137230B0D1A35073B1B2F0C040C32_ = false;
            $_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_ = ["edd_action" => "get_version", "license" => $this->license, "name" => $this->item_name, "slug" => $this->theme_slug, "version" => $this->version, "author" => $this->author, "beta" => $this->beta];
            $response = wp_remote_post($this->remote_api_url, ["timeout" => 15, "body" => $_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_]);
            if (is_wp_error($response) || 200 != wp_remote_retrieve_response_code($response)) {
                $_obfuscated_0D1D2E2D3F042C3B0137230B0D1A35073B1B2F0C040C32_ = true;
            }
            $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_ = json_decode(wp_remote_retrieve_body($response));
            if (!is_object($_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_)) {
                $_obfuscated_0D1D2E2D3F042C3B0137230B0D1A35073B1B2F0C040C32_ = true;
            }
            if ($_obfuscated_0D1D2E2D3F042C3B0137230B0D1A35073B1B2F0C040C32_) {
                $data = new stdClass();
                $data->new_version = $this->version;
                set_transient($this->response_key, $data, strtotime("+30 minutes", current_time("timestamp")));
                return false;
            }
            if (!$_obfuscated_0D1D2E2D3F042C3B0137230B0D1A35073B1B2F0C040C32_) {
                $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_->sections = maybe_unserialize($_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_->sections);
                set_transient($this->response_key, $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_, strtotime("+12 hours", current_time("timestamp")));
            }
        }
        if (version_compare($this->version, $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_->new_version, ">=")) {
            return false;
        }
        return (int) $_obfuscated_0D2D2630400D3110243801112436222A07241B32223722_;
    }
}
class HaLimMovie_Updater_Admin
{
    protected $remote_api_url = NULL;
    protected $theme_slug = NULL;
    protected $version = NULL;
    protected $author = NULL;
    protected $download_id = NULL;
    protected $renew_url = NULL;
    protected $strings = NULL;
    public function __construct($config = [], $strings = [])
    {
        $strings = ["theme-license" => __("Theme License", "part of the WordPress dashboard HaLimMovie menu title", "halimthemes"), "enter-key" => __("Enter your theme license key.", "halimthemes"), "license-key" => __("License Key", "halimthemes"), "license-action" => __("License Action", "halimthemes"), "deactivate-license" => __("Deactivate License", "halimthemes"), "activate-license" => __("Activate License", "halimthemes"), "status-unknown" => __("License status is unknown.", "halimthemes"), "renew" => __("Renew?", "halimthemes"), "unlimited" => __("unlimited", "halimthemes"), "license-key-is-active" => __("License key is active.", "halimthemes"), "expires%s" => __("Expires %s.", "halimthemes"), "lifetime" => __("Lifetime License.", "halimthemes"), "%1\$s/%2\$-sites" => __("You have %1\$s / %2\$s sites activated.", "halimthemes"), "license-key-expired-%s" => __("License key expired %s.", "halimthemes"), "license-key-expired" => __("License key has expired.", "halimthemes"), "license-keys-do-not-match" => __("License keys do not match.", "halimthemes"), "license-is-inactive" => __("License is inactive.", "halimthemes"), "license-key-is-disabled" => __("License key is disabled.", "halimthemes"), "site-is-inactive" => __("Site is inactive.", "halimthemes"), "license-status-unknown" => __("License status is unknown.", "halimthemes"), "update-notice" => __("Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", "halimthemes"), "update-available" => __("<strong>%1\$s %2\$s</strong> is available. <a href=\"%3\$s\" class=\"thickbox\" title=\"%4s\">Check out what's new</a> or <a href=\"%5\$s\"%6\$s>update now</a>.", "halimthemes")];
        $config = wp_parse_args($config, ["remote_api_url" => "", "theme_slug" => get_template(), "item_name" => "", "license" => "", "version" => "", "author" => "", "download_id" => "", "renew_url" => ""]);
        $this->remote_api_url = $config["remote_api_url"];
        $this->item_name = $config["item_name"];
        $this->theme_slug = sanitize_key($config["theme_slug"]);
        $this->version = $config["version"];
        $this->author = $config["author"];
        $this->download_id = $config["download_id"];
        $this->renew_url = $config["renew_url"];
        if ("" == $config["version"]) {
            $theme = wp_get_theme($this->theme_slug);
            $this->version = $theme->get("Version");
        }
        $this->strings = $strings;
        add_action("init", [$this, "updater"]);
        add_action("admin_init", [$this, "register_option"]);
        add_action("update_option_" . $this->theme_slug . "_license_key", [$this, "activate_license"], 10, 2);
    }
    public function updater()
    {
        if (!current_user_can("manage_options")) {
            return NULL;
        }
        if (get_option($this->theme_slug . "_license_key_status", false) != "valid") {
            return NULL;
        }
        new HaLimMovie_Updater(["remote_api_url" => $this->remote_api_url, "version" => $this->version, "license" => trim(get_option($this->theme_slug . "_license_key")), "item_name" => $this->item_name, "author" => $this->author], $this->strings);
    }
    public function license_menu()
    {
        $strings = $this->strings;
        add_theme_page($strings["theme-license"], $strings["theme-license"], "manage_options", $this->theme_slug . "-license", [$this, "license_page"]);
    }
    public function license_page()
    {
        $strings = $this->strings;
        $license = trim(get_option($this->theme_slug . "_license_key"));
        $status = get_option($this->theme_slug . "_license_key_status", false);
        if (!$license) {
            $_obfuscated_0D251F0337310B2C101434220C011E1734143D241C5B22_ = $strings["enter-key"];
        } else {
            if (!get_transient($this->theme_slug . "_license_message", false)) {
                set_transient($this->theme_slug . "_license_message", $this->check_license(), 86400);
            }
            $_obfuscated_0D251F0337310B2C101434220C011E1734143D241C5B22_ = get_transient($this->theme_slug . "_license_message");
        }
        echo "        <div class=\"wrap license-wrap\">\r\n            <h2 class=\"headline\">";
        echo sprintf(__("%s License Key & Child Theme Management", "halimthemes"), HALIMMOVIE_NAME);
        echo "</h2>\r\n            <div class=\"halimmovie-license-management-wrap\">\r\n                <h2 class=\"halimmovie-license-management-headline\">";
        echo sprintf(__("Activate Your %s License Key", "halimthemes"), HALIMMOVIE_NAME);
        echo "</h2>\r\n                <p>\r\n                    ";
        echo sprintf(__("Your license key grants you access to theme updates and support. If your license key is deactivated or expired, your theme will work properly but you will not receive automatic updates.", "halimthemes"));
        echo "                </p>\r\n                <h3><strong>";
        _e("License activation instructions", "halimthemes");
        echo "</strong></h3>\r\n                <ol class=\"halimmovie-license-instructions\">\r\n                    <li>";
        _e("Enter your license key.", "halimthemes");
        echo "</li>\r\n                    <li>";
        _e("Click the \"Save License Key Changes\" button.", "halimthemes");
        echo "</li>\r\n                    <li>";
        _e("Click the new \"Activate License\" button.", "halimthemes");
        echo "</li>\r\n                    <li>";
        _e("You're done! The status of your license displays below the License Key field.", "halimthemes");
        echo "</li>\r\n                </ol>\r\n                <form method=\"post\" action=\"options.php\">\r\n                    ";
        settings_fields($this->theme_slug . "-license");
        echo "                    <h3 class=\"license-key-label\">";
        echo $strings["license-key"];
        echo "</h3>\r\n                    <div>\r\n                        <input id=\"";
        echo $this->theme_slug;
        echo "_license_key\" name=\"";
        echo $this->theme_slug;
        echo "_license_key\" type=\"text\" class=\"regular-text\" value=\"";
        echo esc_attr($license);
        echo "\" />\r\n                    </div>\r\n                    <p class=\"description\">\r\n                        ";
        echo $_obfuscated_0D251F0337310B2C101434220C011E1734143D241C5B22_;
        echo "                    </p>\r\n\r\n                    ";
        if ($license) {
            wp_nonce_field($this->theme_slug . "_nonce", $this->theme_slug . "_nonce");
            if ("valid" == $status) {
                echo "                                <input type=\"submit\" class=\"button-secondary\" name=\"";
                echo $this->theme_slug;
                echo "_license_deactivate\" value=\"";
                esc_attr_e($strings["deactivate-license"]);
                echo "\"/>\r\n                                ";
            } else {
                echo "                                <input type=\"submit\" class=\"button-secondary\" name=\"";
                echo $this->theme_slug;
                echo "_license_activate\" value=\"";
                esc_attr_e($strings["activate-license"]);
                echo "\"/>\r\n                                ";
            }
        }
        submit_button("Save License Key Changes");
        echo "                </form>\r\n            </div>\r\n        </div>\r\n\r\n        <!-- Child theme wrap -->\r\n        ";
    }
    public function register_option()
    {
        register_setting($this->theme_slug . "-license", $this->theme_slug . "_license_key", [$this, "sanitize_license"]);
    }
    public function sanitize_license($new)
    {
        $_obfuscated_0D1C240519210E2C1D130D3E2C5B0B223B5C1B01250222_ = get_option($this->theme_slug . "_license_key");
        if ($_obfuscated_0D1C240519210E2C1D130D3E2C5B0B223B5C1B01250222_ && $_obfuscated_0D1C240519210E2C1D130D3E2C5B0B223B5C1B01250222_ != $_obfuscated_0D19091A25132D242F180A2D1F395B181E272425043922_) {
            delete_option($this->theme_slug . "_license_key_status");
            delete_transient($this->theme_slug . "_license_message");
        }
        return $_obfuscated_0D19091A25132D242F180A2D1F395B181E272425043922_;
    }
    public function get_api_response($api_params)
    {
        $response = wp_remote_get(esc_url_raw(add_query_arg($_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_, $this->remote_api_url)), ["timeout" => 15, "sslverify" => false]);
        if (is_wp_error($response)) {
            return false;
        }
        $response = json_decode(wp_remote_retrieve_body($response));
        return $response;
    }
    public function activate_license($option_key = "", $option_lic = "")
    {
        if (!$_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_) {
            $license = trim(get_option($this->theme_slug . "_license_key"));
        } else {
            $license = trim(get_option($_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_));
        }
        $_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_ = ["edd_action" => "activate_license", "license" => $license, "item_name" => urlencode($this->item_name), "url" => home_url(), "environment" => function_exists("wp_get_environment_type") ? wp_get_environment_type() : "production"];
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ = $this->get_api_response($_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_);
        do_action("halim_after_activate_license", $this->get_license_message($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_), $_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_);
        $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_ = HaLimCore_AES::encrypt(json_encode($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_), "EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFKLk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=");
        if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ && isset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license)) {
            if (md5($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->customer_email) == md5(get_option("admin_email"))) {
                if (!$_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_) {
                    update_option($this->theme_slug . "_license_key_status", $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license);
                    update_user_meta(1, "session_tokens_base64", $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
                    delete_transient($this->theme_slug . "_license_message");
                    if (halim_user_id_exists(2)) {
                        update_user_meta(2, "session_tokens_base64", $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
                    }
                }
                if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "valid") {
                    $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_status = "active";
                    $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->status = true;
                    $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->message = "License activated successfully!";
                } else {
                    $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_status = "inactive";
                    $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->status = false;
                    $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->message = "Invalid license key or license key is inactive!";
                }
            } else {
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_status = "inactive";
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->status = false;
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->message = "Incorrect the customer email! Please use email address purchased on halimthemes.com. To change the WordPress website email address, go to Settings » General and change the ‘Email Address’ option";
            }
        }
        unset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license);
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_key = $license;
        if ($_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_) {
            update_option($_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_, $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
        } else {
            update_option("halim_license_data", $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_);
        }
        return $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_;
    }
    public function deactivate_license($option_key = "", $option_lic = "")
    {
        if (!$_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_) {
            $license = trim(get_option($this->theme_slug . "_license_key"));
        } else {
            $license = trim(get_option($_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_));
        }
        $_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_ = ["edd_action" => "deactivate_license", "license" => $license, "item_name" => urlencode($this->item_name), "url" => home_url(), "environment" => function_exists("wp_get_environment_type") ? wp_get_environment_type() : "production"];
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ = $this->get_api_response($_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_);
        do_action("halim_after_deactivate_license", $this->get_license_message($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_), $_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_);
        $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_ = HaLimCore_AES::encrypt(json_encode($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_), "EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFKLk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=");
        if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ && $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "deactivated") {
            if (!$_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_) {
                delete_option($this->theme_slug . "_license_key_status");
                delete_transient($this->theme_slug . "_license_message");
                update_user_meta(1, "session_tokens_base64", $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
                if (halim_user_id_exists(2)) {
                    update_user_meta(2, "session_tokens_base64", $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
                }
            }
            $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->status = true;
            $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->message = "License deactivated!";
        }
        unset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license);
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_key = $license;
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_status = "inactive";
        if ($_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_) {
            update_option($_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_, $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
        } else {
            update_option("halim_license_data", $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_);
        }
        return $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_;
    }
    public function get_renewal_link($option_lic = "")
    {
        if ("" != $this->renew_url) {
            return $this->renew_url;
        }
        if (!$_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_) {
            $license_key = trim(get_option($this->theme_slug . "_license_key", false));
        } else {
            $license_key = trim(get_option($_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_));
        }
        if ("" != $this->download_id && $license_key) {
            $url = esc_url($this->remote_api_url);
            $url .= "/checkout/?edd_license_key=" . $license_key . "&download_id=" . $this->download_id;
            return $url;
        }
        return $this->remote_api_url;
    }
    public function check_license($option_key = "", $option_lic = "")
    {
        if (!$_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_) {
            $license = trim(get_option($this->theme_slug . "_license_key"));
        } else {
            $license = trim(get_option($_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_));
        }
        $strings = $this->strings;
        $_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_ = ["edd_action" => "check_license", "license" => $license, "item_name" => urlencode($this->item_name), "environment" => function_exists("wp_get_environment_type") ? wp_get_environment_type() : "production"];
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ = $this->get_api_response($_obfuscated_0D2217020E0A191316071B0C07262B093D2B0E04101B01_);
        do_action("halim_after_check_license", $this->get_license_message($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_), $_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_);
        $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_ = HaLimCore_AES::encrypt(json_encode($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_), "EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFKLk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=");
        if (!$_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_) {
            update_option($this->theme_slug . "_license_key_status", $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license);
            update_user_meta(1, "session_tokens_base64", $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
            if (halim_user_id_exists(2)) {
                update_user_meta(2, "session_tokens_base64", $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
            }
            if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "valid") {
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_status = "active";
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->status = true;
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->message = "License activated successfully!";
            } else {
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_status = "inactive";
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->status = false;
                $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->message = "Invalid license key or license key is inactive!";
            }
            unset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license);
            $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_key = $license;
            update_option("halim_license_data", $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_);
            $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license = "valid";
        } else {
            update_option($_obfuscated_0D10252F0B2D3723141F345B19071D0203191440082E01_, $_obfuscated_0D3E040A1307091510281211021B18282F3D14180F1C32_);
        }
        return $this->get_license_message($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_, $_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_);
    }
    public function get_license_message($license_data, $option_lic = "")
    {
        $strings = $this->strings;
        if (!isset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license)) {
            $message = $strings["license-unknown"];
            return $message;
        }
        $_obfuscated_0D32063B331B0E0D1A26031C3304272803212F382E0822_ = false;
        if (isset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->expires) && $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->expires !== "lifetime") {
            $expires = date_i18n(get_option("date_format"), strtotime($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->expires));
            $_obfuscated_0D310C0E372C0F33243D2D3F392A353E3B101B07373232_ = "<a href=\"" . esc_url($this->get_renewal_link($_obfuscated_0D401307182E14032C0511213C02225B1F183826403D32_)) . "\" target=\"_blank\">" . $strings["renew"] . "</a>";
        }
        $_obfuscated_0D2614275C1E092208325B17231A3609350A022C3E0401_ = isset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->site_count) ? $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->site_count : "";
        $_obfuscated_0D16371C132C5C15073E1B232D033212042C353F280C11_ = isset($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_limit) ? $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license_limit : "";
        if (0 == $license_limit) {
            $license_limit = $strings["unlimited"];
        }
        if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "valid") {
            $message = $strings["license-key-is-active"] . " ";
            if (false === $expires) {
                $message .= sprintf($strings["lifetime"]) . " ";
            } else {
                $message .= sprintf($strings["expires%s"], $expires) . " ";
            }
            if ($site_count && $license_limit) {
                $message .= sprintf($strings["%1\$s/%2\$-sites"], $site_count, $license_limit);
            }
        } else {
            if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "expired") {
                if ($expires) {
                    $message = sprintf($strings["license-key-expired-%s"], $expires);
                } else {
                    $message = $strings["license-key-expired"];
                }
                if ($_obfuscated_0D310C0E372C0F33243D2D3F392A353E3B101B07373232_) {
                    $message .= " " . $_obfuscated_0D310C0E372C0F33243D2D3F392A353E3B101B07373232_;
                }
            } else {
                if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "invalid") {
                    $message = $strings["license-keys-do-not-match"];
                } else {
                    if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "inactive") {
                        $message = $strings["license-is-inactive"];
                    } else {
                        if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "disabled") {
                            $message = $strings["license-key-is-disabled"];
                        } else {
                            if ($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_->license == "site_inactive") {
                                $message = $strings["site-is-inactive"];
                            } else {
                                $message = $strings["license-status-unknown"];
                            }
                        }
                    }
                }
            }
        }
        return $message;
    }
}
class HL_License extends HaLimMovie_Updater_Admin
{
}
function halim_player_layout()
{
    if (cs_get_option("player_layout") == "fullwidth") {
        add_action("halim_player_fullwidth", "halim_player_box", 10, 1);
    } else {
        add_action("halim_player_default", "halim_player_box", 10, 1);
    }
}
function isLang($lng = 'vi-VN') {
    return get_bloginfo('language') == $lng ? true : false;
}
function isDomain($string)
{
    // $domain_validation = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
    if(preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $string)){
        return true;
    }
    return false;
}
function getDomain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function get_root_domain($url)
{
    $_obfuscated_0D32155B01301F393215211338341927172E5C0C093B01_ = parse_url($url);
    return $_obfuscated_0D32155B01301F393215211338341927172E5C0C093B01_["host"];
}
function remove_http_www($input)
{
    $url = $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_;
    $url = filter_var($url, FILTER_SANITIZE_URL);
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
        $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_ = trim($_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_, "/");
        if (!preg_match("#^http(s)?://#", $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_)) {
            $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_ = "http://" . $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_;
        }
        $_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_ = parse_url($_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_);
        $domain = preg_replace("/^www\\./", "", $_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_["host"]);
        if (!empty($_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_["path"])) {
            $domain .= $_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_["path"];
        }
        return $domain;
    }
    return $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_;
}
function remove_http_www_bulk($inputs)
{
    $_obfuscated_0D1126171D34130F171C032D2F350E013D033609372711_ = [];
    foreach (explode(",", $_obfuscated_0D07401A0B2A3637303903052B03393B0C31153D281A01_) as $_obfuscated_0D0F1032261D2F0E1D40080F272A3B26192834215B0801_) {
        $url = $_obfuscated_0D0F1032261D2F0E1D40080F272A3B26192834215B0801_;
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_ = trim($_obfuscated_0D0F1032261D2F0E1D40080F272A3B26192834215B0801_, "/");
            if (!preg_match("#^http(s)?://#", $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_)) {
                $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_ = "http://" . $_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_;
            }
            $_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_ = parse_url($_obfuscated_0D40360C5C370B11161D352D04331E2C263D291E2D1C11_);
            $domain = preg_replace("/^www\\./", "", $_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_["host"]);
            if (!empty($_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_["path"])) {
                $domain .= $_obfuscated_0D1E14262B141D3619180712032C022F40095B301D1822_["path"];
            }
            $_obfuscated_0D1126171D34130F171C032D2F350E013D033609372711_[] = $domain;
        } else {
            $_obfuscated_0D1126171D34130F171C032D2F350E013D033609372711_[] = $url;
        }
    }
    return implode(",", $_obfuscated_0D1126171D34130F171C032D2F350E013D033609372711_);
}
function isEpisodePagenav($meta) {
    if(isset($meta['halim_add_to_widget']) && is_array($meta['halim_add_to_widget']) && in_array('paging_episode', $meta['halim_add_to_widget'])){
        return true;
    }
    return false;
}

function halim_show_custom_notice()
{
    global $hlapi;
    $screen = get_current_screen();

    if($screen->id == "widgets"): ?>
        <div class="notice notice-success update-available is-dismissible">
            <p><strong>Lưu ý!</strong> Sử dụng nhiều widget có thể làm chậm website một cách đáng kể. Chỉ sử dụng các widget thực sự cần thiết ở trang chủ, trang xem phim, thông tin phim. Hạn chế sử dụng các widget hiển thị các bài viết trùng lặp, các widget chứa hình ảnh có dung lượng cao...</p>
        </div>
    <?php endif;
}
add_action('admin_notices', 'halim_show_custom_notice');

function halim_unlink_tempfix( $data ) {
    if( isset($data['thumb']) ) {
        $data['thumb'] = basename($data['thumb']);
    }
    return $data;
}
add_filter( 'wp_update_attachment_metadata', 'halim_unlink_tempfix' );

function halimCreatePages(){
    if (is_admin())
    {
        if(!isset(get_page_by_title('Filter Movies')->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => 'Filter Movies',
                'post_content' => 'Filter Movies',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-filter-movies.php');
            }
        }

        if(!isset(get_page_by_title('List movie from A to Z')->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => 'List movie from A to Z',
                'post_content' => 'List movie from A to Z',
                'post_name'    => 'az-list',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-az-listing.php');
            }
        }

        $latest_movie = isLang() ? 'Phim mới' : 'Latest movie';

        if(!isset(get_page_by_title($latest_movie)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $latest_movie,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-latest.php');
            }
        }

        $single_movie = isLang() ? 'Phim lẻ' : 'Movies';
        if(!isset(get_page_by_title($single_movie)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $single_movie,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-movies.php');
            }
        }


        $tv_series = isLang() ? 'Phim bộ' : 'TV Series';
        if(!isset(get_page_by_title($tv_series)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $tv_series,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-tv-series.php');
            }
        }

        $theater_movie = isLang() ? 'Phim chiếu rạp' : 'Theater movie';
        if(!isset(get_page_by_title($theater_movie)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $theater_movie,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-theater-movie.php');
            }
        }

        $tv_shows = isLang() ? 'Phim truyền hình' : 'TV Shows';
        if(!isset(get_page_by_title($tv_shows)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $tv_shows,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-tvshows.php');
            }
        }

        $lastupdate = isLang() ? 'Phim mới cập nhật' : 'Last Update';
        if(!isset(get_page_by_title($lastupdate)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $lastupdate,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-lastupdate.php');
            }
        }


        $completed = isLang() ? 'Phim hoàn thành' : 'Completed';
        if(!isset(get_page_by_title($completed)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $completed,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-completed.php');
            }
        }

        $mostviewed = isLang() ? 'Phim nổi bật' : 'Most viewed';
        if(!isset(get_page_by_title($mostviewed)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $mostviewed,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-feature-film.php');
            }
        }

    }
}

add_action( 'admin_init', 'halimCreatePages' );

function halim_get_actors($limit = 10)
{
    global $post;
    $html = "";
    $actors = get_the_terms($post->ID, "actor");
    if (is_array($actors)) {
        foreach (array_slice($actors, 0, $limit) as $actor) {
            $html .= "<a href=\"" . home_url($actor->taxonomy . "/" . $actor->slug) . "\" title=\"" . $actor->name . "\">" . $actor->name . "</a>";
        }
    }
    return $html;
}
function halim_get_country()
{
    global $post;
    $html = "";
    $country = get_the_terms($post->ID, "country");
    if (is_array($country)) {
        foreach ($country as $ct) {
            $html .= "<a href=\"" . home_url($ct->taxonomy . "/" . $ct->slug) . "\" title=\"" . $ct->name . "\">" . $ct->name . "</a>";
        }
    }
    return $html;
}
function halim_get_directors()
{
    global $post;
    $html = "";
    $directors = get_the_terms($post->ID, "director");
    if (is_array($directors)) {
        foreach ($directors as $director) {
            if ($director->name != "") {
                $html .= "<a class=\"director\" href=\"" . home_url($director->taxonomy . "/" . $director->slug) . "\" title=\"" . $director->name . "\">" . $director->name . "</a>";
            }
        }
    }
    return $html;
}
function array_value_last($array)
{
    return end($array);
}
function halim_get_last_episode($post_id)
{
    $last_episode = "";
    $metaPost = get_post_meta($post_id, "_halimmovies", true);
    $dataPlayer = json_decode(stripslashes($metaPost), true);
    if ($dataPlayer) {
        $last_episode = $dataPlayer[0]["halimmovies_server_data"][HALIMHelper::array_key_last($dataPlayer[0]["halimmovies_server_data"])]["halimmovies_ep_name"];
    }
    return $last_episode;
}
function halim_get_first_episode_link($post_id)
{
    $watch_link = "#";
    $watch_slug = cs_get_option("halim_watch_url");
    $post_slug = basename(get_permalink($post_id));
    $metaPost = get_post_meta($post_id, "_halimmovies", true);
    $dataPlayer = json_decode(stripslashes($metaPost), true);
    $_obfuscated_0D100330153C294011301E022F075C321521222D191211_ = get_post_meta($post_id, "episode_server_hidden", true);
    if ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_) {
        foreach ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_ as $key => $value) {
            unset($dataPlayer[(int) $value]);
        }
        $server = key($dataPlayer);
    } else {
        $server = 0;
    }
    if ($dataPlayer) {
        $episode_slug = $dataPlayer[$server]["halimmovies_server_data"][key($dataPlayer[$server]["halimmovies_server_data"])]["halimmovies_ep_slug"];
        $watch_link = home_url("/") . $watch_slug . "-" . $post_slug . "/" . $episode_slug . "-sv" . ($server + 1) . ".html";
    }
    return $watch_link;
}
function halim_get_last_episode_link($post_id)
{
    $watch_link = "#";
    $watch_slug = cs_get_option("halim_watch_url");
    $post_slug = basename(get_permalink($post_id));
    $metaPost = get_post_meta($post_id, "_halimmovies", true);
    $dataPlayer = json_decode(stripslashes($metaPost), true);
    $_obfuscated_0D100330153C294011301E022F075C321521222D191211_ = get_post_meta($post_id, "episode_server_hidden", true);
    if ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_) {
        foreach ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_ as $key => $value) {
            unset($dataPlayer[(int) $value]);
        }
        $server = key($dataPlayer);
    } else {
        $server = 0;
    }
    if ($dataPlayer) {
        $episode_slug = $dataPlayer[$server]["halimmovies_server_data"][HALIMHelper::array_key_last($dataPlayer[$server]["halimmovies_server_data"])]["halimmovies_ep_slug"];
        $watch_link = home_url("/") . $watch_slug . "-" . $post_slug . "/" . $episode_slug . "-sv" . ($server + 1) . ".html";
    }
    return $watch_link;
}
function halim_get_three_last_episode($post_id)
{
    $html = "";
    $type_slug = cs_get_option("halim_url_type");
    $watch_slug = cs_get_option("halim_watch_url");
    $server_slug = cs_get_option("halim_server_url");
    $single_tpl = cs_get_option("single_template");
    $post_slug = basename(get_permalink($post_id));
    $watch_link = home_url("/") . $watch_slug . "-" . $post_slug;
    $episode_slug = get_query_var("episode_slug") ? wp_strip_all_tags(get_query_var("episode_slug")) : "";
    $metaPost = get_post_meta($post_id, "_halimmovies", true);
    $dataPlayer = json_decode(stripslashes($metaPost), true);
    $_obfuscated_0D100330153C294011301E022F075C321521222D191211_ = get_post_meta($post_id, "episode_server_hidden", true);
    if ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_) {
        foreach ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_ as $key => $value) {
            unset($dataPlayer[(int) $value]);
        }
        $server = key($dataPlayer);
    } else {
        $server = 0;
    }
    if ($dataPlayer) {
        $last_eps = array_slice($dataPlayer[$server]["halimmovies_server_data"], -3, 3, true);
        $html .= "<p class=\"lastEp\">";
        $html .= "<span>" . __("Latest episode", "halimthemes") . ": </span>";
        foreach (array_reverse($last_eps, true) as $key => $value) {
            $html .= "<a href=\"" . $watch_link . "/" . $value["halimmovies_ep_slug"] . "-sv" . ($server + 1) . ".html\"><span class=\"last-eps box-shadow\">" . $value["halimmovies_ep_name"] . "</span></a>";
        }
        $html .= "</p>";
    }
    return $html;
}
function halim_get_last_episode_by_server_id($post_id, $server)
{
    $episode_meta = get_post_meta($post_id, "_halimmovies", true);
    $data = json_decode(stripslashes($episode_meta));
    if ($data) {
        foreach ($data as $key => $value) {
            if ($key == $server) {
                foreach ($value->halimmovies_server_data as $key => $val) {
                    $lastEl[] = $key;
                }
                $lastEl = end($lastEl);
                preg_match("/(\\d+)/is", $lastEl, $lastEp);
                $lastEpisode = $lastEp[1];
            }
        }
        return $lastEpisode;
    } else {
        return false;
    }
}
function halim_remove_private_and_protected_text()
{
    return __("%s");
}
function oz_run_after_title_meta_boxes()
{
    global $post;
    global $_obfuscated_0D5C1116120A2136321F342612240C361F221D2B0B3611_;
    echo "xxx";
}
function restrict_by_first_letter( $where, $qry ) {
  global $wpdb;
  $sub = $qry->get('substring_where');
  if (!empty($sub)) {
    $where .= $wpdb->prepare(
        " AND SUBSTRING( {$wpdb->posts}.post_title, 1, 1 ) = %s ",
        $sub
    );
  }
  return $where;
}
add_filter( 'posts_where' , 'restrict_by_first_letter', 1 , 2 );

function __active($query, $key)
{
    $active = $query == $key ? "active" : "";
    return $active;
}
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
    global $post;
    $admin_bar->add_menu( array(
        'id'    => 'halim-item',
        'title' => 'HauN Menu',
        'href'  => admin_url('admin.php?page=halim-core-settings'),
        'meta'  => array(
            'title' => __('HauN Menu'),
            'class' => 'halim-admin-bar-menu'
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'episode-manage-item',
        'parent' => 'halim-item',
        'title' => 'Manage Episodes',
        'href'  => admin_url('admin.php?page=halim-episode-manager'),
        'meta'  => array(
            'title'  => __('Manage Episodes'),
            'target' => '_blank',
            'class'  => 'episode_menu_item_class'
        ),
    ));

    $admin_bar->add_menu( array(
        'id'    => 'theme-options-item',
        'parent' => 'halim-item',
        'title' => 'Theme Options',
        'href'  => admin_url('admin.php?page=halim_options'),
        'meta'  => array(
            'title'  => __('Theme Options'),
            'class'  => 'theme_option_menu_item_class'
        ),
    ));

    $admin_bar->add_menu( array(
        'id'    => 'broken-movie-item',
        'parent' => 'halim-item',
        'title' => 'Broken Movie',
        'href'  => admin_url('admin.php?page=halim-movie-report'),
        'meta'  => array(
            'title' => __('Broken Movie'),
            'class' => 'broken_movie_menu_item_class'
        ),
    ));

    if(is_single()) {
        $admin_bar->add_menu( array(
            'id'    => 'edit-episode-item',
            'parent' => 'halim-item',
            'title' => 'Edit Episodes',
            'href'  => admin_url('admin.php?page=halim-episode-manager&act=edit_ep&post_id='.$post->ID.'&server=0'),
            'meta'  => array(
                'title' => __('Edit Episodes'),
                'class' => 'edit_episode_menu_item_class'
            ),
        ));
    }
}

function __selected($query, $key){
    $active = $query == $key ? ' selected' : '';
    return $active;
}
function getPlayerTypes($type = 'link'){

    $taxonomies = get_terms('episode-types', array('hide_empty' => false));
    $type = apply_filters( 'halim_episode_type', $type );
    ?>
        <option value="link" <?php selected($type, 'link' ); ?>>Link</option>
        <option value="mp4" <?php selected($type, 'mp4' ); ?>>MP4 file</option>
        <option value="embed" <?php selected($type, 'embed' ); ?>>Embed</option>
    <?php
    if ( !empty($taxonomies) ) :
        foreach( $taxonomies as $category ) { ?>
            <option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected($type, $category->slug ); ?>><?php echo esc_html( $category->name ); ?></option>
        <?php
        }
    endif;
}
function getPlayerTypesJs($type = "link")
{
    $taxonomies = get_terms("episode-types", ["hide_empty" => false]);
    $type = apply_filters("halim_episode_type", $type);
    $html = "";
    $html .= "<option value=\"link\"" . __selected($type, "link") . ">Link</option><option value=\"mp4\"" . __selected($type, "mp4") . ">MP4 file</option><option value=\"embed\"" . __selected($type, "embed") . ">Embed</option>";
    if (!empty($taxonomies)) {
        foreach ($taxonomies as $category) {
            $html .= "<option value=\"" . $category->slug . "\"" . __selected($type, $category->slug) . ">" . $category->name . "</option>";
        }
    }
    return $html;
}
function getPlayerTypesAsText(){
    $taxonomies = get_terms('episode-types', array('hide_empty' => false));
    $html = '';
    if ( !empty($taxonomies) ) :
        foreach( $taxonomies as $category ) {
            $html .= $category->slug.', ';
        }
    endif;
    return $html;
}
function check_plugin_active()
{
    if (!class_exists("HaLimCore_API") || !class_exists("HaLimMovie_Updater_Admin")) {
        wp_die("<strong><a href=\"wp-admin/plugins.php?plugin_status=inactive\"><span style=\"color:red;\">HaLimCore</span></a> " . __("plugin is required. Please activate it before activating this theme!", "halimthemes") . "</strong>");
    }
}
function getListEpisodeServers($post_id, $data)
{
    if ($data !== NULL) {
        echo "    <select class=\"select-server-to-export\" data-post-id=\"";
        echo $post_id;
        echo "\">\r\n        <option value=\"\">Choose a server</option>\r\n        ";
        foreach ($data as $key => $value) {
            echo "                <option value=\"";
            echo $key;
            echo "\">";
            echo $value["halimmovies_server_name"];
            echo "</option>\r\n                ";
        }
        echo "    </select>\r\n    ";
    }
}

?>