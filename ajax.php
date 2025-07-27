<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2
 * @ Decoder version: 1.0.4
 * @ Release: 01/09/2021
 */

add_action("wp_ajax_halim_update_download_viewcount", "halim_ajax_update_download_viewcount");
add_action("wp_ajax_save_episode_server_hidden_option", "halim_ajax_episode_server_hidden");
add_action("wp_ajax_halim_ajax_update_post_meta", "halim_ajax_update_post_meta_callback");
add_action("wp_ajax_halim_ajax_importer", "halim_ajax_importer_callback");
add_action("wp_ajax_halim_ajax_addnewserver", "halim_add_new_server_callback");
function halim_ajax_update_download_viewcount()
{
    $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ = isset($_POST["post_id"]) ? absint($_POST["post_id"]) : NULL;
    $_obfuscated_0D0A0E39170D370A2826293D2402260918342F161E3B32_ = isset($_POST["index"]) ? absint($_POST["index"]) : NULL;
    if ($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_) {
        $_obfuscated_0D0F1E270C133D371B061F2E5C1E2F2E390D1639163822_ = get_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "halim_download_fields", true);
        $_obfuscated_0D0F1E270C133D371B061F2E5C1E2F2E390D1639163822_[$_obfuscated_0D0A0E39170D370A2826293D2402260918342F161E3B32_]["view"] = $_obfuscated_0D0F1E270C133D371B061F2E5C1E2F2E390D1639163822_[$_obfuscated_0D0A0E39170D370A2826293D2402260918342F161E3B32_]["view"] + 1;
        update_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "halim_download_fields", $_obfuscated_0D0F1E270C133D371B061F2E5C1E2F2E390D1639163822_);
        wp_send_json(["view" => $_obfuscated_0D0F1E270C133D371B061F2E5C1E2F2E390D1639163822_[$_obfuscated_0D0A0E39170D370A2826293D2402260918342F161E3B32_]["view"]]);
    }
    exit("post id not found!");
}
function halim_ajax_episode_server_hidden()
{
    $value = isset($_POST["value"]) ? $_POST["value"] : "";
    $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ = isset($_POST["post_id"]) ? absint($_POST["post_id"]) : "";
    update_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "episode_server_hidden", $value);
    wp_die();
}
function get_list_episode_by_server_id($server, $postid)
{
    $_obfuscated_0D400F241F230C21100F1506251A360D325C191B0A1522_ = get_post_meta($_obfuscated_0D1C402405290E40271F3B072C1F21022A2430143F1C32_, "_halimmovies", true);
    $data = json_decode(stripslashes($_obfuscated_0D400F241F230C21100F1506251A360D325C191B0A1522_))[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_];
    return $data;
}
function halim_ajax_update_post_meta_callback()
{
    $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ = isset($_POST["post_id"]) ? absint($_POST["post_id"]) : "";
    $_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_ = isset($_POST["server"]) ? absint($_POST["server"]) : "";
    $_obfuscated_0D211B120F1C332325081D1602093B13312809360D1322_ = isset($_POST["post_meta"]) ? $_POST["post_meta"] : "";
    $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_ = get_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halim_metabox_options", true);
    $array["halim_poster_url"] = sanitize_text_field($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_poster_url"]);
    $array["halim_thumb_url"] = sanitize_text_field($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_thumb_url"]);
    foreach ($_obfuscated_0D211B120F1C332325081D1602093B13312809360D1322_ as $key => $val) {
        $array[$val["name"]] = sanitize_text_field($val["value"]);
        if ($val["name"] == "halim_add_to_widget") {
            $_obfuscated_0D0F103139355C1B24022B1F13052239031B275C323D11_[] = sanitize_text_field($val["value"]);
        }
    }
    $array["halim_add_to_widget"] = $_obfuscated_0D0F103139355C1B24022B1F13052239031B275C323D11_;
    HALIMHelper::set_post_modified($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_);
    update_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halim_metabox_options", $array);
    sleep(1);
    $_obfuscated_0D211B120F1C332325081D1602093B13312809360D1322_ = get_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halim_metabox_options", true);
    wp_set_object_terms($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, $_obfuscated_0D211B120F1C332325081D1602093B13312809360D1322_["halim_movie_status"], "status", false);
    wp_set_object_terms($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, $_obfuscated_0D211B120F1C332325081D1602093B13312809360D1322_["halim_add_to_widget"], "post_options", false);
    $_obfuscated_0D141A2C0A230131060D1137313C081F03402B065B0D01_ = halim_get_post_format_type($_obfuscated_0D211B120F1C332325081D1602093B13312809360D1322_["halim_movie_formality"]);
    set_post_format($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, $_obfuscated_0D141A2C0A230131060D1137313C081F03402B065B0D01_);
    wp_die(json_encode($array, JSON_UNESCAPED_UNICODE));
}
function halim_ajax_importer_callback()
{
    $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ = isset($_POST["post_id"]) ? absint($_POST["post_id"]) : "";
    $_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_ = isset($_POST["server"]) ? absint($_POST["server"]) : "";
    $_obfuscated_0D1F35233910382534050D112B282122330C2603291B11_ = isset($_POST["list_link"]) ? $_POST["list_link"] : "";
    $_obfuscated_0D17320F38033B1D1C3F0D0704193130271D013C260C22_ = isset($_POST["import_type"]) ? sanitize_text_field($_POST["import_type"]) : "";
    $_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_ = isset($_POST["episode_slug"]) ? sanitize_text_field($_POST["episode_slug"]) : "";
    $_obfuscated_0D2F07241E04230737171F250425051F0C340C39403D32_ = cs_get_option("halim_episode_url");
    $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_ = json_decode(stripslashes(get_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halimmovies", true)), true);
    foreach ($_obfuscated_0D1F35233910382534050D112B282122330C2603291B11_ as $key => $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_) {
        if ($_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_ != "") {
            if ($_obfuscated_0D17320F38033B1D1C3F0D0704193130271D013C260C22_ == "listserver") {
                $_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_ = explode("|", $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_);
                if ($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_]["halimmovies_ep_listsv"] == NULL) {
                    $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_[$key]["halimmovies_ep_listsv_name"] = sanitize_text_field($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_[0]);
                    $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_[$key]["halimmovies_ep_listsv_link"] = sanitize_text_field($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_[1]);
                    $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_[$key]["halimmovies_ep_listsv_type"] = sanitize_text_field($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_[2]);
                    $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_]["halimmovies_ep_listsv"] = $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_;
                } else {
                    $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_["halimmovies_ep_listsv_name"] = sanitize_text_field($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_[0]);
                    $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_["halimmovies_ep_listsv_link"] = sanitize_text_field($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_[1]);
                    $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_["halimmovies_ep_listsv_type"] = sanitize_text_field($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_[2]);
                    array_push($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_]["halimmovies_ep_listsv"], $_obfuscated_0D0D0F2E19323F2D1C3F3203222F5C2C36091F37255C22_);
                }
            } else {
                if ($_obfuscated_0D17320F38033B1D1C3F0D0704193130271D013C260C22_ == "subtitle") {
                    $_obfuscated_0D3F2F110813272F3201261A1D170C0D2E3B3816221F22_ = explode("|", $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_);
                    if ($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_]["halimmovies_ep_subs"] == NULL) {
                        $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_[$key]["halimmovies_ep_sub_label"] = sanitize_text_field($_obfuscated_0D3F2F110813272F3201261A1D170C0D2E3B3816221F22_[0]);
                        $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_[$key]["halimmovies_ep_sub_file"] = sanitize_text_field($_obfuscated_0D3F2F110813272F3201261A1D170C0D2E3B3816221F22_[1]);
                        $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_[$key]["halimmovies_ep_sub_default"] = 1;
                        $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_]["halimmovies_ep_subs"] = $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_;
                    } else {
                        $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_["halimmovies_ep_sub_label"] = sanitize_text_field($_obfuscated_0D3F2F110813272F3201261A1D170C0D2E3B3816221F22_[0]);
                        $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_["halimmovies_ep_sub_file"] = sanitize_text_field($_obfuscated_0D3F2F110813272F3201261A1D170C0D2E3B3816221F22_[1]);
                        $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_["halimmovies_ep_sub_default"] = 1;
                        array_push($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D1A0E34243B362D0311183E0C3316362F2A09012E5C22_]["halimmovies_ep_subs"], $_obfuscated_0D32323622161A0F120C1F3F1F0B322E0C2B21292C1222_);
                    }
                } else {
                    $data = explode("|", $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_);
                    $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_ = sanitize_text_field($data[0]);
                    $_obfuscated_0D0D29250B14090D02091B31270B12270C171E0C1E0F22_ = sanitize_text_field($data[1]);
                    $_obfuscated_0D13142F0414373F11291A1D24371C33333F1E16322F11_ = sanitize_text_field($data[2]);
                    $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_ = preg_match("/([a-z]+)/is", $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_) ? sanitize_title($_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_) : sanitize_title($_obfuscated_0D2F07241E04230737171F250425051F0C340C39403D32_ . " " . $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_);
                    $_obfuscated_0D392F0312333F1C292B25103D270C3223283E1A351B11_ = str_replace("-", "_", $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_);
                    $array = ["halimmovies_ep_name" => $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_, "halimmovies_ep_slug" => $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_, "halimmovies_ep_type" => $_obfuscated_0D13142F0414373F11291A1D24371C33333F1E16322F11_, "halimmovies_ep_link" => $_obfuscated_0D0D29250B14090D02091B31270B12270C171E0C1E0F22_, "halimmovies_ep_subs" => [], "halimmovies_ep_listsv" => []];
                    $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D392F0312333F1C292B25103D270C3223283E1A351B11_] = $array;
                }
            }
        }
    }
    HALIMHelper::set_post_modified($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_);
    update_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halimmovies", json_encode($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_, JSON_UNESCAPED_UNICODE));
    wp_die(json_encode($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_, JSON_UNESCAPED_UNICODE));
}
function halim_add_new_server_callback()
{
    $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ = isset($_POST["post_id"]) ? absint($_POST["post_id"]) : "";
    $_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_ = isset($_POST["server"]) ? absint($_POST["server"]) : "";
    $_obfuscated_0D1F250A192C2D3E310207283C40171707140C302A3B32_ = isset($_POST["server_name"]) ? sanitize_text_field($_POST["server_name"]) : "";
    $_obfuscated_0D1F35233910382534050D112B282122330C2603291B11_ = isset($_POST["list_link"]) ? $_POST["list_link"] : "";
    $_obfuscated_0D2F07241E04230737171F250425051F0C340C39403D32_ = cs_get_option("halim_episode_url");
    $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_ = json_decode(stripslashes(get_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halimmovies", true)), true);
    $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_name"] = $_obfuscated_0D1F250A192C2D3E310207283C40171707140C302A3B32_;
    foreach ($_obfuscated_0D1F35233910382534050D112B282122330C2603291B11_ as $key => $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_) {
        $data = explode("|", $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_);
        $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_ = sanitize_text_field($data[0]);
        $_obfuscated_0D0D29250B14090D02091B31270B12270C171E0C1E0F22_ = sanitize_text_field($data[1]);
        $_obfuscated_0D13142F0414373F11291A1D24371C33333F1E16322F11_ = sanitize_text_field($data[2]);
        $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_ = preg_match("/([a-z]+)/is", $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_) ? sanitize_title($_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_) : sanitize_title($_obfuscated_0D2F07241E04230737171F250425051F0C340C39403D32_ . " " . $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_);
        $_obfuscated_0D392F0312333F1C292B25103D270C3223283E1A351B11_ = str_replace("-", "_", $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_);
        $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$_obfuscated_0D2C3C34273F350315385C332E075C191316352A044032_]["halimmovies_server_data"][$_obfuscated_0D392F0312333F1C292B25103D270C3223283E1A351B11_] = ["halimmovies_ep_name" => $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_, "halimmovies_ep_slug" => $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_, "halimmovies_ep_type" => $_obfuscated_0D13142F0414373F11291A1D24371C33333F1E16322F11_, "halimmovies_ep_link" => $_obfuscated_0D0D29250B14090D02091B31270B12270C171E0C1E0F22_, "halimmovies_ep_subs" => [], "halimmovies_ep_listsv" => []];
    }
    HALIMHelper::set_post_modified($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_);
    update_post_meta($_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_, "_halimmovies", json_encode($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_, JSON_UNESCAPED_UNICODE));
    wp_die(json_encode($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_, JSON_UNESCAPED_UNICODE));
}
function halim_footer_copyright($html = "")
{
    $html = cs_get_option("copyright_text");
    if (!$html) {
        $html = "Theme developed by R";
    }
    $text = "© <a id=\"halimthemes\" href=\"" . home_url("/") . "\" title=\"" . $html . "\">" . $html . "</a>";
    return apply_filters("halim_copyright_text", $text);
}

?>