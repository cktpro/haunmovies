<?php
class HaLimCore_Init extends HaLimCore_Abstract
{
    public function init()
    {
        global $_obfuscated_0D5C291604262D0B321E3B170D070D30361E3401122E11_;
        $_obfuscated_0D1E08060B310D030914210C213622382E24111B3C0C01_ = new HaLimCore_Scripts();
        $this->addAction("wp", "halimThemeInfo");
        $this->addAction("init", "cs_framework_init", 10);
        if (is_admin()) {
            $this->addAction("after_setup_theme", "halim_core_init");
        }
        $this->addAction("admin_enqueue_scripts", "halim_license_details_enqueue_scripts", 10, 1);
        $this->addAction("wp_ajax_halim_check_license_details", "halim_check_license_details");
        $this->addAction("wp_ajax_halim_activate_license", "halim_activate_license");
        $this->addAction("wp_ajax_halim_deactivate_license", "halim_deactivate_license");
    }
    public function halim_check_license_details()
    {
        global $_obfuscated_0D0B2E1D1D061A020E0E0B212F271A06281C2808363132_;
        $_obfuscated_0D1D2111401017322A0C260A1C21320A342D3430123B01_ = new HL_License($_obfuscated_0D0B2E1D1D061A020E0E0B212F271A06281C2808363132_);
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ = $_obfuscated_0D1D2111401017322A0C260A1C21320A342D3430123B01_->check_license();
        wp_send_json($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_);
    }
    public function halim_deactivate_license()
    {
        global $_obfuscated_0D0B2E1D1D061A020E0E0B212F271A06281C2808363132_;
        $_obfuscated_0D1D2111401017322A0C260A1C21320A342D3430123B01_ = new HL_License($_obfuscated_0D0B2E1D1D061A020E0E0B212F271A06281C2808363132_);
        $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ = $_obfuscated_0D1D2111401017322A0C260A1C21320A342D3430123B01_->deactivate_license();
        wp_send_json($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_);
    }
    public function halim_activate_license()
    {
        global $_obfuscated_0D0B2E1D1D061A020E0E0B212F271A06281C2808363132_;
        $_obfuscated_0D1D2111401017322A0C260A1C21320A342D3430123B01_ = new HL_License($_obfuscated_0D0B2E1D1D061A020E0E0B212F271A06281C2808363132_);
        $license_key = isset($_POST["license_key"]) ? sanitize_text_field($_POST["license_key"]) : "";
        if (!empty($license_key)) {
            update_option(get_template() . "_license_key", $license_key);
            $_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_ = $_obfuscated_0D1D2111401017322A0C260A1C21320A342D3430123B01_->activate_license();
            wp_send_json($_obfuscated_0D1F2E362601352516152D2C5C1F15091A0F212F350501_);
        } else {
            wp_send_json(["status" => false, "message" => "License key can't be empty!"]);
        }
    }
    public function cs_framework_init()
    {
        if (function_exists("cs_locate_template")) {
            cs_locate_template("functions/deprecated.php");
            cs_locate_template("functions/fallback.php");
            cs_locate_template("functions/helpers.php");
            cs_locate_template("functions/actions.php");
            cs_locate_template("functions/enqueue.php");
            cs_locate_template("functions/sanitize.php");
            cs_locate_template("functions/validate.php");
            cs_locate_template("classes/abstract.class.php");
            cs_locate_template("classes/options.class.php");
            cs_locate_template("classes/framework.class.php");
            cs_locate_template("classes/metabox.class.php");
            cs_locate_template("config/framework.config.php");
            cs_locate_template("config/metabox.config.php");
        }
    }
    public function halimThemeInfo()
    {
        $_obfuscated_0D0921252632041127381A2816051426402D013F0C3411_ = wp_get_theme("haunmovies");
        if ($_obfuscated_0D0921252632041127381A2816051426402D013F0C3411_->get("Name") !== "HauNMovie Nulled" || $_obfuscated_0D0921252632041127381A2816051426402D013F0C3411_->get("ThemeURI") !== "https://mphe.net" || $_obfuscated_0D0921252632041127381A2816051426402D013F0C3411_->get("Author") !== "HauN Nulled" || $_obfuscated_0D0921252632041127381A2816051426402D013F0C3411_->get("AuthorURI") !== "https://mphe.net") {
            wp_die("<h3 style=\"text-align: center;display: block;\">Please do not change the author information!</h3> <span style=\"text-align: center;display: block;\">Contact: allhadpro@gmail.com</span>", "HaLimThemes.Com");
        }
    }
    public function halim_core_init()
    {
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_ = new HaLimCore_Plugin();
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_["path"] = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR;
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_["url"] = plugin_dir_url(__FILE__);
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_["version"] = wp_get_theme("halimmovies")->get("Version");
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_["settings_page_properties"] = ["parent_slug" => "themes.php", "page_title" => "HaLim License Manager", "menu_title" => "License Manager", "capability" => "administrator", "menu_slug" => "halim-license-manager", "option_group" => "halim_core_option_group", "option_name" => "halim_core_option_name", "option_lic" => "halim_license_data", "option_lic_status" => "halim_license_status"];
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_["settings_page"] = [$this, "halim_core_service_settings"];
        $_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_->run();
    }
    public function halim_core_service_settings($plugin)
    {
        if (NULL !== $_obfuscated_0D013B0201161F3934082B380C213C5C310C323F062711_) {
            return $_obfuscated_0D013B0201161F3934082B380C213C5C310C323F062711_;
        }
        $_obfuscated_0D013B0201161F3934082B380C213C5C310C323F062711_ = new HaLimCore_SettingsPage($_obfuscated_0D2B0C3C0D240B281805352A32015B042A323D3F221901_["settings_page_properties"]);
        return $_obfuscated_0D013B0201161F3934082B380C213C5C310C323F062711_;
    }
    public function halim_license_details_enqueue_scripts($hook)
    {
        wp_enqueue_style("license-details", HALIM_THEME_URI . "/core/assets/css/license-details.css", "", time());
        wp_enqueue_script("halim-license-manager", HALIM_THEME_URI . "/core/assets/js/license-manager.js", [], time(), true);
        wp_localize_script("halim-license-manager", "halim_license", ["ajax_url" => admin_url("admin-ajax.php")]);
    }
}

?>