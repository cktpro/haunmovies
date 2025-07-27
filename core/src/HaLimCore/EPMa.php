<?php

class HaLimCore_EPM extends HaLimCore_Init
{
    public function __construct()
    {
        $this->addAction("admin_menu", "halim_add_apisode_manage_menu");
        $this->addFilter("manage_edit-post_columns", "halim_episode_cpt_column_name");
        $this->addFilter("manage_edit-post_sortable_columns", "halim_episode_cpt_column_name");
        $this->addAction("manage_post_posts_custom_column", "halim_episode__cpt_columns", 10, 2);
    }
    public function halim_episode_cpt_column_name($columns)
    {
        $_obfuscated_0D220A3302302B113831083D2B2A06143803053C1F2E01_["episode"] = __("Episode", "halimthemes");
        return $_obfuscated_0D220A3302302B113831083D2B2A06143803053C1F2E01_;
    }
    public function halim_episode__cpt_columns($colname, $cptid)
    {
        if ($_obfuscated_0D3C3D3D2B3213143D29053E311F3B2C342B0A5C195C22_ == "episode") {
            echo "<a class=\"editEPS\" href=\"" . admin_url("admin.php?page=halim-episode-manager&act=edit_ep&post_id=" . $_obfuscated_0D2A5B31192D2128253011262417343709153819141F22_ . "&server=0") . "\" target=\"_blank\" style=\"background: #83b149;color: #fff;padding: 2px 6px 4px;border-radius: 2px;font-size: 12px;\"><span class=\"dashicons dashicons-edit\"></span></a>";
        }
    }
    public function halim_add_apisode_manage_menu()
    {
        add_menu_page(__("Episode Manager", "halimthemes"), __("Episode Manager", "halimthemes"), "edit_pages", "halim-episode-manager", [$this, "halim_episode_manager"]);
    }
    public function halim_episode_manager()
    {
        if (wp_isvl()) {
            echo "\t\t\t<div class=\"wrap\">\r\n\t\t\t\t<h1>Your license key is invalid or not activated, Please buy a valid license and enter it in the options page!</h1>\r\n\t\t\t\t<h3>You should be automatically redirected to the License page after 3s</h3>\r\n\t\t\t\t<script>\r\n\t\t\t\t\tsetTimeout(function(){\r\n\t\t\t\t\t\twindow.location = '";
            echo admin_url("admin.php?page=halim-license-manager");
            echo "'\r\n\t\t\t\t\t}, 3000)\r\n\t\t\t\t</script>\r\n\t\t\t</div>\r\n\t\t\t";
        } else {
            $post_query = isset($_GET["s"]) ? wp_strip_all_tags($_GET["s"]) : "";
            $postID = isset($_GET["post_id"]) ? absint($_GET["post_id"]) : 0;
            $server = isset($_GET["server"]) ? absint($_GET["server"]) : 0;
            $episode = isset($_GET["episode_slug"]) && $_GET["episode_slug"] ? wp_strip_all_tags(str_replace("-", "_", $_GET["episode_slug"])) : "";
            $paged = isset($_GET["paged"]) ? absint($_GET["paged"]) : 1;
            $cat_id = isset($_GET["cat"]) ? wp_strip_all_tags($_GET["cat"]) : "";
            $p = isset($_GET["p"]) ? absint($_GET["p"]) : 1;
            $_obfuscated_0D07355C2E0D2F122F3E271A1D283C1732015B3B292401_ = isset($_GET["country_id"]) ? absint($_GET["country_id"]) : "";
            $_obfuscated_0D0A2C342B1D0E362F361E1227193C0B2D381A06042232_ = isset($_GET["released"]) ? wp_strip_all_tags($_GET["released"]) : "";
            $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_ = isset($_GET["formality"]) ? wp_strip_all_tags($_GET["formality"]) : "";
            $status = isset($_GET["status"]) ? wp_strip_all_tags($_GET["status"]) : "";
            $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_ = isset($_GET["orderby"]) ? wp_strip_all_tags($_GET["orderby"]) : "";
            $_obfuscated_0D141A2C0A230131060D1137313C081F03402B065B0D01_ = halim_get_post_format_type($_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_);
            $_obfuscated_0D37012D08172F112C233529053B352A10123434082E32_ = ["single_movies" => __("Single movie", "halimthemes"), "tv_series" => __("TV series", "halimthemes"), "tv_shows" => __("TV show", "halimthemes"), "theater_movie" => __("Theater movie", "halimthemes"), "completed" => __("Completed", "halimthemes"), "ongoing" => __("Ongoing", "halimthemes"), "is_trailer" => __("Trailer", "halimthemes")];
            echo "\t    <div id=\"download-episode\" style=\"display: none\"></div>\r\n\t    <script>var current_subtitle_count, current_listsv_count; \$ = jQuery.noConflict();</script>\r\n\t    <div class=\"wrap halim-wrap\" style=\"margin-top: 50px;\">\r\n\r\n\t        <select id=\"category_select\">\r\n\t            <option value=\"?page=halim-episode-manager\" selected>";
            _e("All categories", "halimthemes");
            echo "</option>\r\n\t            ";
            $_obfuscated_0D2527263F22173C1929270A25333C1D040D0D16322832_ = get_categories();
            foreach ($_obfuscated_0D2527263F22173C1929270A25333C1D040D0D16322832_ as $_obfuscated_0D3409351D2422085C07313E0C062A29033B2F2B060411_) {
                $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ = $cat_id == $_obfuscated_0D3409351D2422085C07313E0C062A29033B2F2B060411_->term_id ? " selected" : "";
                echo "<option value=\"?page=halim-episode-manager&cat=" . $_obfuscated_0D3409351D2422085C07313E0C062A29033B2F2B060411_->term_id . "\"" . $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ . ">" . $_obfuscated_0D3409351D2422085C07313E0C062A29033B2F2B060411_->name . "</option>";
            }
            echo "\t        </select>\r\n\r\n\t        <select id=\"country_select\">\r\n\t            <option value=\"?page=halim-episode-manager\" selected>";
            _e("All countries", "halimthemes");
            echo "</option>\r\n\t            ";
            $_obfuscated_0D240611321D2E2B143726292C3E34305B141D2C5B1C22_ = get_terms("country");
            foreach ($_obfuscated_0D240611321D2E2B143726292C3E34305B141D2C5B1C22_ as $_obfuscated_0D1439322D1B393B13120205171A2F235B08030A193B22_) {
                $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ = $_obfuscated_0D07355C2E0D2F122F3E271A1D283C1732015B3B292401_ == $_obfuscated_0D1439322D1B393B13120205171A2F235B08030A193B22_->term_id ? " selected" : "";
                echo "<option value=\"?page=halim-episode-manager&country_id=" . $_obfuscated_0D1439322D1B393B13120205171A2F235B08030A193B22_->term_id . "\"" . $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ . ">" . $_obfuscated_0D1439322D1B393B13120205171A2F235B08030A193B22_->name . "</option>";
            }
            echo "\t        </select>\r\n\r\n\t        <select id=\"release_select\">\r\n\t            <option value=\"?page=halim-episode-manager\" selected>";
            _e("All release", "halimthemes");
            echo "</option>\r\n\t            ";
            $_obfuscated_0D09272306375B402605381028242C1427302E2F300401_ = get_terms("release");
            foreach ($_obfuscated_0D09272306375B402605381028242C1427302E2F300401_ as $_obfuscated_0D0E082813072A1E3D293E031D0928180E192B28333D32_) {
                $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ = $_obfuscated_0D0A2C342B1D0E362F361E1227193C0B2D381A06042232_ == $_obfuscated_0D0E082813072A1E3D293E031D0928180E192B28333D32_->term_id ? " selected" : "";
                echo "<option value=\"?page=halim-episode-manager&released=" . $_obfuscated_0D0E082813072A1E3D293E031D0928180E192B28333D32_->term_id . "\"" . $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ . ">" . $_obfuscated_0D0E082813072A1E3D293E031D0928180E192B28333D32_->name . "</option>";
            }
            echo "\t        </select>\r\n\r\n\t        <select id=\"formality_select\">\r\n\t            <option value=\"\">";
            _e("Formality", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&formality=single_movies\"";
            echo __selected("single_movies", $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_);
            echo ">";
            _e("Movies", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&formality=theater_movie\"";
            echo __selected("theater_movie", $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_);
            echo ">";
            _e("Theater movie", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&formality=tv_series\"";
            echo __selected("tv_series", $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_);
            echo ">";
            _e("TV Series", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&formality=tv_shows\"";
            echo __selected("tv_shows", $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_);
            echo ">";
            _e("TV Shows", "halimthemes");
            echo "</option>\r\n\t        </select>\r\n\r\n\t        <select id=\"status_select\">\r\n\t            <option value=\"\">";
            _e("Status", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&status=is_trailer\"";
            echo __selected("is_trailer", $status);
            echo ">";
            _e("Trailer", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&status=ongoing\"";
            echo __selected("ongoing", $status);
            echo ">";
            _e("Ongoing", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&status=completed\"";
            echo __selected("completed", $status);
            echo ">";
            _e("Complete", "halimthemes");
            echo "</option>\r\n\t        </select>\r\n\r\n\r\n\t        <select id=\"orderby_select\">\r\n\t            <option value=\"\">";
            _e("Orderby", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&orderby=ASC\"";
            echo __selected("ASC", $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_);
            echo ">";
            _e("ASC", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&orderby=DESC\"";
            echo __selected("DESC", $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_);
            echo ">";
            _e("DESC", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&orderby=date\"";
            echo __selected("date", $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_);
            echo ">";
            _e("Date", "halimthemes");
            echo "</option>\r\n\t            <option value=\"?page=halim-episode-manager&orderby=modified\"";
            echo __selected("modified", $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_);
            echo ">";
            _e("Modified", "halimthemes");
            echo "</option>\r\n\t        </select>\r\n\r\n\r\n\t        <form action=\"";
            echo admin_url("admin.php");
            echo "\" class=\"post_query search-box\" style=\"display: initial;float: right;\">\r\n\t            <input type=\"hidden\" name=\"page\" value=\"halim-episode-manager\">\r\n\t            <input type=\"search\" name=\"s\" placeholder=\"";
            _e("Search post", "halimthemes");
            echo "\" required>\r\n\t            <input type=\"submit\" value=\"";
            _e("Search", "halimthemes");
            echo "\" class=\"button\">\r\n\t        </form>\r\n\r\n\r\n\t        ";
            if ($cat_id) {
                echo "<h2>" . get_cat_name($cat_id) . "</h2>";
            } else {
                $_obfuscated_0D231A0E1B393306192E0D0B060B26270F09250C341D01_ = "";
                $_obfuscated_0D231A0E1B393306192E0D0B060B26270F09250C341D01_ .= $_obfuscated_0D07355C2E0D2F122F3E271A1D283C1732015B3B292401_ ? get_term_by("id", $_obfuscated_0D07355C2E0D2F122F3E271A1D283C1732015B3B292401_, "country")->name : "";
                $_obfuscated_0D231A0E1B393306192E0D0B060B26270F09250C341D01_ .= $_obfuscated_0D0A2C342B1D0E362F361E1227193C0B2D381A06042232_ ? get_term_by("id", $_obfuscated_0D0A2C342B1D0E362F361E1227193C0B2D381A06042232_, "release")->name : "";
                $_obfuscated_0D231A0E1B393306192E0D0B060B26270F09250C341D01_ .= $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_ ? $_obfuscated_0D37012D08172F112C233529053B352A10123434082E32_[$_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_] : "";
                $_obfuscated_0D231A0E1B393306192E0D0B060B26270F09250C341D01_ .= $status ? $_obfuscated_0D37012D08172F112C233529053B352A10123434082E32_[$status] : "";
                echo "<h2>" . $_obfuscated_0D231A0E1B393306192E0D0B060B26270F09250C341D01_ . "</h2>";
            }
            $showpost = 10;
            $args = ["post_type" => "post", "paged" => $paged];
            if ($post_query) {
                $args["s"] = $post_query;
            } else {
                $args["posts_per_page"] = $showpost;
            }
            if ($_obfuscated_0D07355C2E0D2F122F3E271A1D283C1732015B3B292401_) {
                $args["tax_query"][] = ["taxonomy" => "country", "field" => "term_id", "terms" => $_obfuscated_0D07355C2E0D2F122F3E271A1D283C1732015B3B292401_];
            }
            if ($_obfuscated_0D0A2C342B1D0E362F361E1227193C0B2D381A06042232_) {
                $args["tax_query"][] = ["taxonomy" => "release", "field" => "term_id", "terms" => $_obfuscated_0D0A2C342B1D0E362F361E1227193C0B2D381A06042232_];
            }
            if ($_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_) {
                $args["tax_query"] = [["taxonomy" => "post_format", "field" => "slug", "terms" => ["post-format-" . $_obfuscated_0D141A2C0A230131060D1137313C081F03402B065B0D01_], "operator" => "IN"]];
            }
            if ($status) {
                $args["tax_query"][] = ["taxonomy" => "status", "field" => "slug", "terms" => $status];
            }
            if ($cat_id) {
                $args["cat"] = $cat_id;
            }
            if ($_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_ == "modified" || $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_ == "date") {
                $args["orderby"] = $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_;
            } else {
                if ($_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_ == "ASC" || $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_ == "DESC") {
                    $args["order"] = $_obfuscated_0D1C0A2E1E1C0A0302240C5B285B02352840272D0D0522_;
                }
            }
            $wp_query = new WP_Query($args);
            $total_post = isset($wp_query->found_posts) ? $wp_query->found_posts : wp_count_posts()->publish;
            echo "\r\n<style>\r\n\tdiv#listepisode-exported, #download-episode {\r\n\t    background: #fff;\r\n\t    margin-top: 15px;\r\n\t    padding: 30px;\r\n\t    text-align: center;\r\n\t    border: 2px dashed #ff0081;\r\n\t}\r\n</style>\r\n<script>\r\n\r\n\t\$(document).ready(function(){\r\n\r\n\t\t\$( \".checkbox-dropdown\" ).click(function() {\r\n\t\t\t\$(this).toggleClass('is-active');\r\n\t\t});\r\n\r\n\t\t\$(\".checkbox-dropdown ul\").click(function(e) {\r\n\t\t    e.stopPropagation();\r\n\t\t});\r\n\t\t\$('.save-option').on('click', function(){\r\n\t\t\tvar post_id = \$(this).data('post-id')\r\n\t\t\tvar divid = \$(this).data('divid')\r\n\t\t\tvar val = \$('#' + divid + ' input[name=\"episode_server_hidden\"]:checked').map(function(){return \$(this).val();}).get()\r\n\t\t\t\$('[data-divid=\"'+divid+'\"] span').text('Saving...')\r\n\t\t\t\$.ajax({\r\n\t\t\t\ttype: 'POST',\r\n\t\t\t\turl: ajax_url,\r\n\t\t\t\tdata: {\r\n\t\t\t\t\taction: 'save_episode_server_hidden_option',\r\n\t\t\t\t\tpost_id: post_id,\r\n\t\t\t\t\tvalue: val\r\n\t\t\t\t},\r\n\t\t\t\tsuccess: function(res){\r\n\t\t\t\t\t\$('[data-divid=\"'+divid+'\"] span').text('Done!')\r\n\t\t\t\t\tsetTimeout(function (){\r\n\t\t\t\t\t\t\$('[data-divid=\"'+divid+'\"] span').text('Save')\r\n\t\t\t\t\t}, 1000)\r\n\t\t\t\t}\r\n\t\t\t})\r\n\t\t})\r\n\t});\r\n</script>\r\n\r\n<div class=\"panel panel-default\">\r\n    <table class=\"table\">\r\n        <thead>\r\n            <tr>\r\n                <th>Post Name</th>\r\n                <th class=\"text-center\">Show/Hide Episode Server</th>\r\n                <th class=\"text-center\">Post Status</th>\r\n                <th>Latest Episode</th>\r\n                <th class=\"text-center\">Status</th>\r\n                <th class=\"text-center\">Post Type</th>\r\n                <th class=\"text-center\">Export Episodes</th>\r\n                <th class=\"text-center\">Actions</th>\r\n            </tr>\r\n        </thead>\r\n        <tbody>\r\n        \t";
            if ($wp_query->have_posts()) {
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    global $post;
                    $active = $postID == $post->ID ? " active" : "";
                    $post_meta = get_post_meta($post->ID, "_halimmovies", true);
                    $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_ = get_post_meta($post->ID, "_halim_metabox_options", true);
                    $_obfuscated_0D25333135122A065B2F403437252F0619021718320122_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_total_episode"]) && $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_total_episode"] != "" ? $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_total_episode"] : "0";
                    $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"]) && $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"] != "" ? $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"] : "";
                    $_obfuscated_0D12221134163E332405180813093D3B3929315B0B3D32_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_status"]) && $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_status"] != "" ? $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_status"] : "";
                    if (is_array($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"])) {
                        $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"]) && $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"] ? "<span class=\"halim_formality\">" . str_replace("_", " ", array_values(array_filter($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"]))[0]) . "</span>" : "";
                    } else {
                        $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_ = isset($_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"]) && $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"] ? "<span class=\"halim_formality\">" . str_replace("_", " ", $_obfuscated_0D40391C1F283908071C3D0A0F1E13041A123F02061911_["halim_movie_formality"]) . "</span>" : "";
                    }
                    $data = json_decode(stripslashes($post_meta), true);
                    $_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_ = isset($data) && $data != NULL ? key($data[0]["halimmovies_server_data"]) : NULL;
                    $link = $_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_ != NULL ? $data[0]["halimmovies_server_data"][$_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_]["halimmovies_ep_link"] : "";
                    $_obfuscated_0D3C37191017381219263E5C251515295B34361A2C1F32_ = $_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_ != NULL ? $data[0]["halimmovies_server_data"][$_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_]["halimmovies_ep_name"] : "";
                    $_obfuscated_0D2203023015370F1F092B100629193730252607250432_ = get_post_status($post->ID) !== "publish" ? "<span class=\"publish_post\" data-post-id=\"" . $post->ID . "\"><span class=\"publish-post-btn dashicons dashicons-update-alt\"></span> <span class=\"publish-txt\">Publish</span></span>" : "";
                    $_obfuscated_0D0A2909083824392D26060A2E3640031C112410323011_ = isset($data) && $data != NULL && is_array($data[0]["halimmovies_server_data"]) && count($data[0]["halimmovies_server_data"]) ? "EP " . count($data[0]["halimmovies_server_data"]) . "/" . $_obfuscated_0D25333135122A065B2F403437252F0619021718320122_ : "0/" . $_obfuscated_0D25333135122A065B2F403437252F0619021718320122_;
                    $_obfuscated_0D1119303D023C16223002362517112415402B0F1E2932_ = halim_get_last_episode($post->ID) . "/" . $_obfuscated_0D25333135122A065B2F403437252F0619021718320122_;
                    echo "\t\t        <tr>\r\n\t\t            <td scope=\"row\" class=\"";
                    echo $active;
                    echo "\">";
                    echo "<a href=\"" . get_permalink($post->ID) . "\" target=\"_blank\">" . $post->post_title . "</a><a class=\"edit-post-link\" href=\"" . get_edit_post_link($post->ID) . "\" target=\"_blank\"><span class=\"dashicons dashicons-edit\"></span></a>";
                    echo "\t\t            </td>\r\n\t\t            <td class=\"";
                    echo $active;
                    echo "\">\r\n\r\n\t\t\t\t\t\t<div class=\"checkbox-dropdown\">\r\n\t\t\t\t\t\t  <span class=\"opensv\">Choose Server to hide</span>\r\n\t\t\t\t\t\t  <ul class=\"checkbox-dropdown-list\">\r\n\t\t\t\t\t\t\t<li data-divid=\"episode_server_hidden-";
                    echo $post->ID;
                    echo "\" data-post-id=\"";
                    echo $post->ID;
                    echo "\" class=\"save-option\"><span>Save</span></li>\r\n\t\t\t\t\t\t    ";
                    $_obfuscated_0D100330153C294011301E022F075C321521222D191211_ = get_post_meta($post->ID, "episode_server_hidden", true);
                    $_obfuscated_0D0D1B252C26375B273E06131039240C300F3E10352B32_ = json_decode(stripslashes($post_meta), true);
                    foreach ($_obfuscated_0D0D1B252C26375B273E06131039240C300F3E10352B32_ as $key => $value) {
                        echo "\r\n\t\t\t\t\t\t\t\t    <li id=\"episode_server_hidden-";
                        echo $post->ID;
                        echo "\">\r\n\t\t\t\t\t\t\t\t      <label>\r\n\t\t\t\t\t\t\t\t        \t<input type=\"checkbox\" value=\"";
                        echo $key;
                        echo "\" name=\"episode_server_hidden\" ";
                        if ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_) {
                            checked_selected_multiple($_obfuscated_0D100330153C294011301E022F075C321521222D191211_, $key, "checked");
                        }
                        echo "/>Hide <strong>";
                        echo $value["halimmovies_server_name"];
                        echo "</strong>\r\n\t\t\t\t\t\t\t\t        </label>\r\n\t\t\t\t\t\t\t\t    </li>\r\n\r\n\t\t\t\t\t\t        \t";
                    }
                    echo "\r\n\t\t\t\t\t\t  </ul>\r\n\t\t\t\t\t\t</div>\r\n\r\n\t\t            </td>\r\n\t\t            <td class=\"text-center post_status";
                    echo $active;
                    echo "\">";
                    echo "<strong>" . ucwords(get_post_status($post->ID)) . "</strong>" . $_obfuscated_0D2203023015370F1F092B100629193730252607250432_;
                    echo "</td>\r\n\t\t            <td class=\"lastep";
                    echo $active;
                    echo "\"><span>";
                    echo $_obfuscated_0D1119303D023C16223002362517112415402B0F1E2932_;
                    echo "</span></td>\r\n\t\t            <td class=\"text-center film_status";
                    echo $active;
                    echo "\">";
                    echo "<span>" . $_obfuscated_0D12221134163E332405180813093D3B3929315B0B3D32_ . "</span>";
                    echo "</td>\r\n\t\t            <td class=\"text-center film_type";
                    echo $active;
                    echo "\">";
                    echo "<span>" . $_obfuscated_0D37151F121230242A3925150B0F1523102640123F1901_ . "</span>";
                    echo "</td>\r\n\r\n\t\t            <td class=\"text-center export-ep";
                    echo $active;
                    echo "\">\r\n\t\t            \t";
                    getListEpisodeServers($post->ID, $data);
                    echo "\r\n\t\t            </td>\r\n\r\n\t\t            <td class=\"text-center sv-item";
                    echo $active;
                    echo "\">\r\n\r\n\t\t            \t";
                    if ($link != "" || $_obfuscated_0D3C37191017381219263E5C251515295B34361A2C1F32_ != "") {
                        echo "<a class=\"item-btn item-btn-red\" href=\"?page=halim-episode-manager&act=edit_ep&post_id=" . $post->ID . "&server=0&paged=" . $paged . "&cat=" . $cat_id . "&s=" . $post_query . "\">" . __("Edit", "halimthemes") . "</a>";
                    } else {
                        echo "<a class=\"act-btn\" href=\"?page=halim-episode-manager&act=add-new-server&post_id=" . $post->ID . "&server=0&paged=" . $paged . "&cat=" . $cat_id . "&s=" . $post_query . "\" style=\"background: #e88100;border: 1px solid #e88100;\">" . __("Add Server", "halimthemes") . "</a>";
                    }
                    echo "\r\n\t                </td>\r\n\t\t        </tr>\r\n        \t\t";
                }
            }
            echo "\r\n        </tbody>\r\n    </table>\r\n    ";
            $this->halim_pagenav($total_post, $showpost, $paged);
            wp_reset_query();
            echo "</div>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\t\t";
            if (isset($_GET["act"]) && $_GET["act"] == "add_new_ep") {
                $post_meta = get_post_meta($postID, "_halimmovies", true);
                $data = json_decode(stripslashes($post_meta), true);
                $_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_ = isset($data) && $data != NULL ? key($data[0]["halimmovies_server_data"]) : NULL;
                $link = $_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_ != NULL ? $data[0]["halimmovies_server_data"][$_obfuscated_0D052B3F18322422293E362B1201062B1F120712030332_]["halimmovies_ep_link"] : "";
                echo "\t            <div id=\"halimmovies\" class=\"postbox\">\r\n\r\n\t                <button type=\"button\" class=\"handlediv\" aria-expanded=\"true\"><span class=\"screen-reader-text\">Toggle panel: Episode list</span><span class=\"toggle-indicator\" aria-hidden=\"true\"></span></button>\r\n\t                <h2 class=\"hndle ui-sortable-handle\" style=\"margin-left: 10px;padding-bottom: 15px;\">\r\n\t                    <span>";
                _e("Add new episode to", "halimthemes");
                echo " <span class=\"movie-name\">";
                echo get_the_title($postID);
                echo "</span></span>\r\n\t                    <span class=\"editep\"><a href=\"?page=halim-episode-manager&act=edit_ep&post_id=";
                echo $postID;
                echo "&server=";
                echo $server;
                echo "&paged=";
                echo $paged;
                echo "\"><span class=\"dashicons dashicons-edit\"></span> ";
                _e("Edit Episode", "halimthemes");
                echo "</a></span>\r\n\t                </h2>\r\n\t                <div class=\"inside\">\r\n\t                    <div class=\"clear\"></div>\r\n\t                    <div id=\"halimmovies-player-data\">\r\n\t                        <div class=\"tab-content\">\r\n\t                            <div class=\"tab-pane active\" id=\"server_1\" data-server=\"1\">\r\n\t                                <div id=\"halimmovies_episodes\" class=\"form-horizontal\">\r\n\t                                    <div class=\"form-group\">\r\n\t                                        <label for=\"halimmovies_server_name\"><h3>";
                _e("Select server to add new episode", "halimthemes");
                echo "</h3></label>\r\n\t                                        <div class=\"listsv addnew addnew-server-act\">\r\n\t                                            ";
                foreach ($data as $key => $value) {
                    $active = $server == $key ? " active" : "";
                    echo "<span class=\"svitem xx\"><a class=\"item" . $active . "\" href=\"?page=halim-episode-manager&act=add_new_ep&post_id=" . $postID . "&server=" . $key . "&paged=" . $paged . "&cat=" . $cat_id . "\">" . $value["halimmovies_server_name"] . "</a><span class=\"del-server\" data-index=\"" . $key . "\"><span class=\"dashicons dashicons-no\"></span></span></span>";
                    $last_sv[] = $key;
                }
                $last_sv = HALIMHelper::array_key_last($last_sv);
                echo "\t                                             <div class=\"add-server\" style=\"display: none\">\r\n\r\n\t                                                <input type=\"text\" name=\"server_name\" id=\"halim-server_name\" placeholder=\"Server name\">\r\n\t                                                <div id=\"add-server\"><span class=\"dashicons dashicons-plus\"></span> ";
                _e("Add new server", "halimthemes");
                echo "</div>\r\n\t                                            </div>\r\n\t                                        </div>\r\n\t                                        <script>var last_sv = ";
                echo $last_sv + 1;
                echo "</script>\r\n\r\n\t                                    </div>\r\n\r\n\t                                    <h3>";
                _e("Add New Episode", "halimthemes");
                echo " (";
                _e("Latest episode", "halimthemes");
                echo ": <span class=\"last_ep\">";
                echo count($data[$server]["halimmovies_server_data"]);
                echo "</span>) <a id=\"add-new-eps\" class=\"add_new_ep\" data-ep-total=\"";
                echo count($data[$server]["halimmovies_server_data"]) + 1;
                echo "\" data-server=\"1\"><span class=\"dashicons dashicons-plus\"></span><span>";
                _e("Add New Episode Field", "halimthemes");
                echo "</span></a></h3>\r\n\t                                    <div class=\"halimmovies_episodes episodes row\" data-ep=\"1\" data-server=\"1\">\r\n\r\n\t                                        <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                            <label for=\"halimmovies_ep_name\">";
                _e("Episode Name", "halimthemes");
                echo "</label>\r\n\t                                            <input id=\"halimmovies_ep_name\" type=\"text\" class=\"form-control\" name=\"halimmovies_ep_name[]\" value=\"";
                echo count($data[$server]["halimmovies_server_data"]) + 1;
                echo "\" placeholder=\"";
                _e("Episode Name", "halimthemes");
                echo "\">\r\n\t                                        </div>\r\n\t                                        <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                            <label for=\"halimmovies_ep_slug\">";
                _e("Episode Slug", "halimthemes");
                echo "</label>\r\n\t                                            <input id=\"halimmovies_ep_slug\" type=\"text\" class=\"form-control\" name=\"halimmovies_ep_slug[]\" value=\"";
                echo $this->cs_get_option("halim_episode_url") . "-" . (count($data[$server]["halimmovies_server_data"]) + 1);
                echo "\" placeholder=\"";
                _e("Episode Slug", "halimthemes");
                echo "\">\r\n\t                                        </div>\r\n\t                                        <div class=\"form-group col-lg-2\" style=\"margin-right: -1px\">\r\n\t                                            <label>";
                _e("Type", "halimthemes");
                echo ": </label>\r\n\t                                            <select name=\"halimmovies_ep_type[]\" id=\"halimmovies_ep_type\" style=\"display:block;width:100%;margin-top: 1px;height: 32px;\">\r\n\t                                                ";
                getPlayerTypes();
                echo "\t                                            </select>\r\n\t                                        </div>\r\n\t                                        <div class=\"form-group col-lg-8\">\r\n\t                                            <label for=\"halimmovies_ep_link\">";
                _e("Link", "halimthemes");
                echo ": </label>\r\n\t                                            <input class=\"form-control\" type=\"text\" id=\"halimmovies_ep_link\" name=\"halimmovies_ep_link[]\" style=\"width:100%\" value=\"\" placeholder=\"Video url\">\r\n\t                                        </div>\r\n\r\n\t                                    </div>\r\n\r\n\t                                </div>\r\n\r\n\t                            </div>\r\n\t                        </div>\r\n\t                    </div>\r\n\t                </div>\r\n\t            </div>\r\n\t        <div id=\"add-eps\" class=\"button-primary\" style=\"float: right;\">";
                _e("Add New Episode", "halimthemes");
                echo "</div>\r\n\t        <div id=\"result\"></div>\r\n\t        <div id=\"message\"></div>\r\n\t        <div class=\"clearfix\"></div>\r\n\t        <div class=\"import-multi-episode\" style=\"display:none;\">\r\n\t            <h2>";
                _e("Import Multiple Episode", "halimthemes");
                echo "</h2>\r\n\t            <p>\r\n\t\t            <span class=\"tip\" style=\"border: 1px solid #7e8993;margin-bottom: 3px;padding: 10px 15px;font-size: 12px;\"><span>";
                _e("Episode name", "halimthemes");
                echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                _e("Episode URL", "halimthemes");
                echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                _e("Type", "halimthemes");
                echo " (Episode Type support list: <span style=\"color: #4d5bff;font-weight: bold;font-family: inherit;\">";
                echo getPlayerTypesAsText();
                echo " link, mp4, embed</span>)</span></span>\r\n\t                <textarea id=\"multiple-import-list\" rows=\"15\" style=\"width: 100%\"></textarea>\r\n\t            </p>\r\n\t            <p>\r\n\t                <span class=\"tip\"><span>";
                _e("Episode name", "halimthemes");
                echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                _e("Episode URL", "halimthemes");
                echo "<span style=\"color: red;font-weight: 700;\">#</span>";
                _e("Type", "halimthemes");
                echo " (link, mp4, embed)</span></span>\r\n\t                <textarea id=\"import-multi-episode\" rows=\"15\" placeholder=\"EP 1|https://www.facebook.com/266609707276074/videos/1098819176961657/#link\"></textarea>\r\n\t            </p>\r\n\t            <div id=\"import-multi-ep\" class=\"button-primary\" onClick=\"javascript:halim_ImportEPS();\">";
                _e("Import Episode", "halimthemes");
                echo "</div>\r\n\t            <div class=\"button-primary\" onClick=\"javascript:fastImport();\">";
                _e("Fast Import Episode", "halimthemes");
                echo "</div>\r\n\r\n\t        </div>\r\n\t        <div id=\"status\" style=\"display: none;\"></div>\r\n\r\n\t\t";
            } else {
                if (isset($_GET["act"]) && $_GET["act"] == "add-new-server") {
                    $_obfuscated_0D295C23251F1F3E0B152C2629371228165C232A2D2201_ = get_post_meta($postID, "_halimmovies", true);
                    $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ = json_decode(stripslashes($_obfuscated_0D295C23251F1F3E0B152C2629371228165C232A2D2201_));
                    $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_ = isset($_GET["server"]) ? $_GET["server"] : "0";
                    if ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) {
                        echo "\t\t\t\t<div class=\"current_server\">\r\n\t\t\t\t\t<p style=\"font-weight: 700;\">Current Server:</p>\r\n\t\t\t\t\t";
                        foreach ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ as $key => $value) {
                            $active = $server == $key ? " active" : "";
                            echo "<span class=\"lsv\"><a class=\"item" . $active . "\" href=\"?page=halim-episode-manager&act=edit_ep&post_id=" . $postID . "&server=" . $key . "&paged=" . $paged . "&cat=" . $cat_id . "\">" . $value->halimmovies_server_name . "</a><span class=\"del-server\" data-index=\"" . $key . "\" data-reload=\"\"><span class=\"dashicons dashicons-no\"></span></span></span>";
                            $last_sv[] = $key;
                        }
                        echo "\t\t\t\t</div>\r\n\t\t\t";
                    }
                    echo "\r\n\t\t\t<p>\r\n\t\t\t\t<label for=\"servername\" style=\"font-weight: 700;\">New Server Name:</label>\r\n\t\t\t\t<input type=\"text\" name=\"servername\" id=\"servername\" value=\"Server #";
                    echo $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ ? HALIMHelper::array_key_last($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) + 2 : $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_ + 1;
                    echo "\" placeholder=\"Server HD\" data-server=\"";
                    echo $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ ? HALIMHelper::array_key_last($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) + 1 : $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_;
                    echo "\" data-post-id=\"";
                    echo $postID;
                    echo "\">\r\n\t\t\t</p>\r\n            <p>\r\n\t            <span class=\"tip\" style=\"border: 1px solid #7e8993;margin-bottom: 3px;padding: 10px 15px;font-size: 12px;\"><span>";
                    _e("Episode name", "halimthemes");
                    echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                    _e("Episode URL", "halimthemes");
                    echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                    _e("Type", "halimthemes");
                    echo " (Episode Type support list: <span style=\"color: #4d5bff;font-weight: bold;font-family: inherit;\">";
                    echo getPlayerTypesAsText();
                    echo " link, mp4, embed</span>)</span></span>\r\n            </p>\r\n            <p>\r\n                <textarea id=\"addnewsv-list\" rows=\"15\" style=\"width: 100%\"></textarea>\r\n            </p>\r\n            <div>\r\n            \t<div class=\"button-primary\" onClick=\"javascript:AddNewServer();\" id=\"addnewsv-btn\" style=\"padding: 7px 35px;height: auto;\"><span class=\"addsv-btn-txt\">Add new server</span></div>\r\n            </div>\r\n            <p>\r\n            \t<input type=\"radio\" name=\"redirect_options\" value=\"redirect\" id=\"redirect\" checked>\r\n            \t<label for=\"redirect\" style=\"margin-right: 10px;\">Chuyển hướng đến trang Edit</label>\r\n            \t<input type=\"radio\" name=\"redirect_options\" value=\"reload\" id=\"reload\">\r\n            \t<label for=\"reload\">Tải lại trang này</label>\r\n            </p>\r\n\t\t\t<div id=\"status\" style=\"display: none;\"></div>\r\n\t\t\t<div class=\"_episode\">\r\n\t\t\t\t<p>Example:</p>\r\n\t\t\t\t<pre>EP 10|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t\t<pre>EP 11|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|embed</pre>\r\n\t\t\t\t<pre>EP 12|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t</div>\r\n\t\t\t<style>\r\n\t\t\t\t._episode pre {\r\n\t\t\t\t    background: #ffffff;\r\n\t\t\t\t    color: #f51f64;\r\n\t\t\t\t    padding: 3px 5px;\r\n\t\t\t\t    border-radius: 0;\r\n\t\t\t\t    margin: 0;\r\n\t\t\t\t}\r\n\t\t\t\t.current_server {\r\n\t\t\t\t\tmargin-bottom: 15px\r\n\t\t\t\t}\r\n\t\t\t\t.current_server .lsv {\r\n\t\t\t\t    background: #b50f0f;\r\n\t\t\t\t    color: #fff;\r\n\t\t\t\t    margin-right: 37px;\r\n\t\t\t\t    padding: 5px 6px;\r\n\t\t\t\t    border-radius: 3px;\r\n\t\t\t\t    cursor: pointer;\r\n\t\t\t\t    position: relative;\r\n\t\t\t\t}\r\n\t\t\t\t.current_server .lsv a {\r\n\t\t\t\t\tcolor: #fff\r\n\t\t\t\t}\r\n\t\t\t\t.current_server .lsv .del-server {\r\n\t\t\t\t    position: absolute;\r\n\t\t\t\t    right: -28px;\r\n\t\t\t\t    top: 0;\r\n\t\t\t\t}\r\n\t\t\t</style>\r\n\r\n\t\t\t<script>\r\n\t\t\t\tfunction AddNewServer()\r\n\t\t\t\t{\r\n\t\t\t\t    var list_link = \$('#addnewsv-list').val().split(/\\r?\\n/);\r\n\t\t\t\t    var post_id = ";
                    echo $postID;
                    echo ";\r\n\t\t\t\t    var server = \$(\"#servername\").data('server');\r\n\t\t\t\t    var server_name = \$(\"#servername\").val();\r\n\t\t\t\t    var redirect_options = \$('input[name=\"redirect_options\"]:checked').val();\r\n\t\t\t\t    if(server_name == '')  {\r\n\t\t\t\t    \talert('Vui lòng nhập tên server');\r\n\t\t\t\t    } else if(list_link == '') {\r\n\t\t\t\t    \talert('Vui lòng nhập danh sách tập phim theo mẫu!');\r\n\t\t\t\t    } else {\r\n\t\t\t\t    \t\$('#status').show().html('Please wait...');\r\n\t\t\t\t\t    \$.ajax({\r\n\t\t\t\t\t        url: \"";
                    echo admin_url("admin-ajax.php");
                    echo "\",\r\n\t\t\t\t\t        type: 'POST',\r\n\t\t\t\t\t        data: {\r\n\t\t\t\t\t            action: 'halim_ajax_addnewserver',\r\n\t\t\t\t\t            post_id: post_id,\r\n\t\t\t\t\t            server: server,\r\n\t\t\t\t\t            list_link: list_link,\r\n\t\t\t\t\t            server_name: server_name\r\n\t\t\t\t\t        },\r\n\t\t\t\t\t        success: function(result) {\r\n\t\t\t\t\t            \$('#status').show().html('Import successfuly!');\r\n\t\t\t\t\t            if(redirect_options == 'redirect') {\r\n\t\t\t\t\t\t            setTimeout(function(){\r\n\t\t\t\t\t\t                // window.location = '?page=halim-episode-manager&act=import&post_id='+post_id+'&server='+server;\r\n\t\t\t\t\t\t                window.location = '?page=halim-episode-manager&act=edit_ep&post_id='+post_id+'&server='+server;\r\n\t\t\t\t\t\t            }, 1000);\r\n\t\t\t\t\t            } else {\r\n\t\t\t\t\t            \tlocation.reload();\r\n\t\t\t\t\t            }\r\n\t\t\t\t\t        }\r\n\t\t\t\t\t    });\r\n\t\t\t\t    }\r\n\t\t\t\t}\r\n\t\t\t</script>\r\n\r\n\r\n\t    ";
                } else {
                    if (isset($_GET["act"]) && $_GET["act"] == "edit_ep") {
                        $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_ = get_post_meta($postID, "_halim_metabox_options", true);
                        $_obfuscated_0D400F241F230C21100F1506251A360D325C191B0A1522_ = get_post_meta($postID, "_halimmovies", true);
                        $data = json_decode(stripslashes($_obfuscated_0D400F241F230C21100F1506251A360D325C191B0A1522_), true);
                        $_obfuscated_0D1B033009382F0C0A3B372F390E383E371738350F0701_ = count($data[$server]["halimmovies_server_data"]);
                        $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ = json_decode(stripslashes($_obfuscated_0D400F241F230C21100F1506251A360D325C191B0A1522_));
                        echo "\t\t\t\t<div class=\"list-action\" style=\"text-align: center;\">\r\n\t\t\t\t\t";
                        do_action("halim-btn-action-before", $postID);
                        echo "\t\t\t\t\t";
                        if ($data) {
                            echo "\r\n\t\t\t\t\t\t<button href=\"#import-multi-episode\" class=\"expand-act-box bubbly-button import\"><span class=\"dashicons dashicons-plus-alt\"></span> Mass import Episode (Option 1)</button>\r\n\t\t\t\t\t\t<button href=\"#import-multi-episode-1\" class=\"expand-act-box bubbly-button import\"><span class=\"dashicons dashicons-plus-alt\"></span> Mass import Episode (Option 2)</button>\r\n\t\t\t\t\t";
                        }
                        echo "\r\n\t\t\t\t\t<button href=\"#halim-add-new-server-box\" class=\"expand-act-box bubbly-button add\"><span class=\"dashicons dashicons-plus-alt\"></span> Add Episode Server</button>\r\n\t\t\t\t\t<button href=\"#halim-post-info-edit-box\" class=\"expand-act-box bubbly-button edit\"><span class=\"dashicons dashicons-plus-alt\"></span> Edit Movie Details</button>\r\n\t\t\t\t\t";
                        do_action("halim-btn-action-after", $postID);
                        echo "\r\n\t\t\t\t\t<script>\r\n\t\t\t\t\t\tvar \$ = jQuery.noConflict();\r\n\t\t\t\t\t\t\$(document).ready(function() {\r\n\t\t\t\t\t\t\t\$('.expand-act-box').click(function(){\r\n\t\t\t\t\t\t\t\tvar collapse_content_selector = \$(this).attr('href');\r\n\t\t\t\t\t\t\t\tvar toggle_switch = \$(this);\r\n\t\t\t\t\t\t\t\t\$(collapse_content_selector).toggle(function(){\r\n\t\t\t\t\t\t\t\t  \tif(\$(this).css('display')=='none'){\r\n\t\t\t\t\t\t\t\t\t\ttoggle_switch.html('<span class=\"dashicons dashicons-plus-alt\"></span> '+toggle_switch.text());\r\n\t\t\t\t\t\t\t\t  \t}else{\r\n\t\t\t\t\t\t\t\t\t\ttoggle_switch.html('<span class=\"dashicons dashicons-dismiss\"></span> '+toggle_switch.text());\r\n\t\t\t\t\t\t\t\t  \t}\r\n\t\t\t\t\t\t\t\t\t\$('html, body').animate({\r\n\t\t\t\t\t                    scrollTop: \$(collapse_content_selector).offset().top - 100\r\n\t\t\t\t\t                }, 500);\r\n\t\t\t\t\t\t\t\t});\r\n\t\t\t\t\t\t\t});\r\n\t\t\t\t\t\t});\r\n\r\n\t\t\t\t\t\tvar animateButton = function(e) {\r\n\r\n\t\t\t\t\t\t  \te.preventDefault;\r\n\t\t\t\t\t\t  \t//reset animation\r\n\t\t\t\t\t\t  \te.target.classList.remove('animate');\r\n\r\n\t\t\t\t\t\t  \te.target.classList.add('animate');\r\n\t\t\t\t\t\t  \tsetTimeout(function(){\r\n\t\t\t\t\t\t    \te.target.classList.remove('animate');\r\n\t\t\t\t\t\t  \t},700);\r\n\t\t\t\t\t\t};\r\n\r\n\t\t\t\t\t\tvar bubblyButtons = document.getElementsByClassName(\"bubbly-button\");\r\n\r\n\t\t\t\t\t\tfor (var i = 0; i < bubblyButtons.length; i++) {\r\n\t\t\t\t\t\t  \tbubblyButtons[i].addEventListener('click', animateButton, false);\r\n\t\t\t\t\t\t}\r\n\t\t\t\t\t</script>\r\n\t\t\t\t</div>\r\n\r\n\t\t\t\t<style>\r\n\r\n\t\t\t\t\t.bubbly-button {\r\n\t\t\t\t\t  font-family: 'Helvetica', 'Arial', sans-serif;\r\n\t\t\t\t\t  display: inline-block;\r\n\t\t\t\t\t  font-size: 1em;\r\n\t\t\t\t\t  padding: 1em 2em;\r\n\t\t\t\t\t  margin-top: 25px;\r\n\t\t\t\t\t  margin-bottom: 30px;\r\n\t\t\t\t\t  -webkit-appearance: none;\r\n\t\t\t\t\t  appearance: none;\r\n\t\t\t\t\t  background-color: #ff0081;\r\n\t\t\t\t\t  color: #fff;\r\n\t\t\t\t\t  border-radius: 4px;\r\n\t\t\t\t\t  border: none;\r\n\t\t\t\t\t  cursor: pointer;\r\n\t\t\t\t\t  position: relative;\r\n\t\t\t\t\t  transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;\r\n\t\t\t\t\t  box-shadow: 0 2px 25px rgba(255, 0, 130, 0.5);\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button.import {\r\n\t\t\t\t\t\tbackground-color: #ff0081;\r\n\t\t\t\t\t\tbox-shadow: 0 2px 25px rgba(255, 0, 130, 0.5);\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button.edit {\r\n\t\t\t\t\t    background-color: #76b102;\r\n\t\t\t\t\t    box-shadow: 0 2px 25px rgba(118, 177, 2, 0.45);\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button.add {\r\n\t\t\t\t\t    background-color: #139ee0;\r\n\t\t\t\t\t    box-shadow: 0 2px 25px rgba(19, 158, 224, 0.42);\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button:focus {\r\n\t\t\t\t\t  outline: 0;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button:before, .bubbly-button:after {\r\n\t\t\t\t\t  position: absolute;\r\n\t\t\t\t\t  content: '';\r\n\t\t\t\t\t  display: block;\r\n\t\t\t\t\t  width: 140%;\r\n\t\t\t\t\t  height: 100%;\r\n\t\t\t\t\t  left: -20%;\r\n\t\t\t\t\t  z-index: -1000;\r\n\t\t\t\t\t  transition: all ease-in-out 0.5s;\r\n\t\t\t\t\t  background-repeat: no-repeat;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button:before {\r\n\t\t\t\t\t  display: none;\r\n\t\t\t\t\t  top: -75%;\r\n\t\t\t\t\t  background-image: radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 20%, #ff0081 20%, transparent 30%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ff0081 15%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%);\r\n\t\t\t\t\t  background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button:after {\r\n\t\t\t\t\t  display: none;\r\n\t\t\t\t\t  bottom: -75%;\r\n\t\t\t\t\t  background-image: radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ff0081 15%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%);\r\n\t\t\t\t\t  background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button:active {\r\n\t\t\t\t\t  transform: scale(0.9);\r\n\t\t\t\t\t  background-color: #e60074;\r\n\t\t\t\t\t  box-shadow: 0 2px 25px rgba(255, 0, 130, 0.2);\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button.animate:before {\r\n\t\t\t\t\t  display: block;\r\n\t\t\t\t\t  animation: topBubbles ease-in-out 0.75s forwards;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.bubbly-button.animate:after {\r\n\t\t\t\t\t  display: block;\r\n\t\t\t\t\t  animation: bottomBubbles ease-in-out 0.75s forwards;\r\n\t\t\t\t\t}\r\n\r\n\t\t\t\t\t@keyframes topBubbles {\r\n\t\t\t\t\t  0% {\r\n\t\t\t\t\t    background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;\r\n\t\t\t\t\t  }\r\n\t\t\t\t\t  50% {\r\n\t\t\t\t\t    background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;\r\n\t\t\t\t\t  }\r\n\t\t\t\t\t  100% {\r\n\t\t\t\t\t    background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;\r\n\t\t\t\t\t    background-size: 0% 0%, 0% 0%,  0% 0%,  0% 0%,  0% 0%,  0% 0%;\r\n\t\t\t\t\t  }\r\n\t\t\t\t\t}\r\n\t\t\t\t\t@keyframes bottomBubbles {\r\n\t\t\t\t\t  0% {\r\n\t\t\t\t\t    background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;\r\n\t\t\t\t\t  }\r\n\t\t\t\t\t  50% {\r\n\t\t\t\t\t    background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;\r\n\t\t\t\t\t  }\r\n\t\t\t\t\t  100% {\r\n\t\t\t\t\t    background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;\r\n\t\t\t\t\t    background-size: 0% 0%, 0% 0%,  0% 0%,  0% 0%,  0% 0%,  0% 0%;\r\n\t\t\t\t\t  }\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.halim-export-episodes {\r\n\t\t\t\t\t    font-family: 'Helvetica', 'Arial', sans-serif;\r\n\t\t\t\t\t    display: inline-block;\r\n\t\t\t\t\t    font-size: 1em;\r\n\t\t\t\t\t    padding: 11px 10px;\r\n\t\t\t\t\t    margin-right: 15px;\r\n\t\t\t\t\t    -webkit-appearance: none;\r\n\t\t\t\t\t    appearance: none;\r\n\t\t\t\t\t    background-color: #ff0081;\r\n\t\t\t\t\t    color: #fff;\r\n\t\t\t\t\t    border-radius: 4px;\r\n\t\t\t\t\t    border: none;\r\n\t\t\t\t\t    float: right;\r\n\t\t\t\t\t    cursor: pointer;\r\n\t\t\t\t\t    position: relative;\r\n\t\t\t\t\t    transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;\r\n\t\t\t\t\t    box-shadow: 0px 2px 4px 0 rgb(191 12 103);\r\n\t\t\t\t\t}\r\n\t\t\t\t</style>\r\n\r\n\t\t\t\t<div id=\"halim-post-info-edit-box\" style=\"display: none;\">\r\n\t\t\t\t\t<form id=\"halim-update-post-meta-form\">\r\n\t\t\t\t\t\t<p style=\"font-weight: 700;font-size: 16px;font-family: initial;\">Edit post info \"<a href=\"";
                        echo get_permalink($postID);
                        echo "\" target=\"_blank\">";
                        echo get_the_title($postID);
                        echo "</a>\"</p>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_original_title\">";
                        _e("Original title", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_original_title\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_original_title"];
                        echo "\" id=\"halim_original_title\" placeholder=\"Original title\">\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_trailer_url\">";
                        _e("Trailer URL", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_trailer_url\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_trailer_url"];
                        echo "\" id=\"halim_trailer_url\" placeholder=\"Trailer URL\">\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_runtime\">";
                        _e("Runtime", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_runtime\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_runtime"];
                        echo "\" id=\"halim_runtime\" placeholder=\"Runtime\">\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_rating\">";
                        _e("IMBD Rating", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_rating\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_rating"];
                        echo "\" id=\"halim_rating\" placeholder=\"IMDb rating\">\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_votes\">";
                        _e("IMBD Votes", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_votes\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_votes"];
                        echo "\" id=\"halim_votes\" placeholder=\"IMDb votes\">\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_quality\">";
                        _e("Quality", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_quality\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_quality"];
                        echo "\" id=\"halim_quality\" placeholder=\"Quality\">\r\n\t\t\t\t\t\t</div>\r\n\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_episode\">";
                        _e("Episode", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_episode\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_episode"];
                        echo "\" id=\"halim_episode\" placeholder=\"Latest Episode\">\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t<label for=\"halim_total_episode\">";
                        _e("Total Episode", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t<input type=\"text\" name=\"halim_total_episode\" value=\"";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_total_episode"];
                        echo "\" id=\"halim_total_episode\" placeholder=\"Total Episode\">\r\n\t\t\t\t\t\t</div>\r\n\r\n\t\t\t\t\t\t<div class=\"box\">\r\n\t\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t\t<label for=\"halim_movie_notice\">";
                        _e("Notification / Note", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<textarea name=\"halim_movie_notice\" id=\"halim_movie_notice\" placeholder=\"Notification / Note\" style=\"width: 100%;\">";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_notice"];
                        echo "</textarea>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div class=\"halim-input-box\">\r\n\t\t\t\t\t\t\t\t<label for=\"halim_showtime_movies\">";
                        _e("Showtime movies", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<textarea name=\"halim_showtime_movies\" id=\"halim_showtime_movies\" placeholder=\"Showtime movies\" style=\"width: 100%;\">";
                        echo $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_showtime_movies"];
                        echo "</textarea>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</div>\r\n\r\n\t\t\t\t\t\t<div class=\"box\">\r\n\t\t\t\t\t\t\t<div class=\"halim-input-checkbox\">\r\n\t\t\t\t\t\t\t\t<span>";
                        _e("Status", "halimthemes");
                        echo "</span>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_status\" value=\"ongoing\" id=\"ongoing\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_status"], "ongoing");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"ongoing\">";
                        _e("Ongoing", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_status\" value=\"completed\" id=\"completed\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_status"], "completed");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"completed\">";
                        _e("Completed", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_status\" value=\"is_trailer\" id=\"is_trailer\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_status"], "is_trailer");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"is_trailer\">";
                        _e("Trailer", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t<div class=\"box\">\r\n\t\t\t\t\t\t\t<div class=\"halim-input-checkbox\">\r\n\t\t\t\t\t\t\t\t<span>";
                        _e("Formality", "halimthemes");
                        echo "</span>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_formality\" value=\"single_movies\" id=\"single_movies\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_formality"], "single_movies");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"single_movies\">";
                        _e("Movies", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_formality\" value=\"tv_series\" id=\"tv_series\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_formality"], "tv_series");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"tv_series\">";
                        _e("TV Series", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_formality\" value=\"tv_shows\" id=\"tv_shows\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_formality"], "tv_shows");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"tv_shows\">";
                        _e("TV Shows", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"halim_movie_formality\" value=\"theater_movie\" id=\"theater_movie\" ";
                        checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_movie_formality"], "theater_movie");
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"theater_movie\">";
                        _e("Theater movie", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</div>\r\n\r\n\t\t\t\t\t\t<div class=\"box\">\r\n\t\t\t\t\t\t\t<div class=\"halim-input-checkbox\">\r\n\t\t\t\t\t\t\t\t<span>";
                        _e("Options", "halimthemes");
                        echo "</span>\r\n\r\n\r\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"is_adult\" value=\"1\" id=\"is_adult\" ";
                        if (isset($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["is_adult"])) {
                            checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["is_adult"], 1);
                        }
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"is_adult\">";
                        _e("Adult content (18+)", "halimthemes");
                        echo "</label>\r\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"is_copyright\" value=\"1\" id=\"is_copyright\" ";
                        if (isset($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["is_copyright"])) {
                            checked($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["is_copyright"], 1);
                        }
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"is_copyright\">";
                        _e("Copyright", "halimthemes");
                        echo "</label>\r\n\r\n\r\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"halim_add_to_widget\" value=\"is_one_slide\" id=\"is_one_slide\"\r\n\t\t\t\t\t\t\t\t";
                        echo is_array($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_add_to_widget"]) && in_array("is_one_slide", $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_add_to_widget"]) ? "checked" : "";
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"is_one_slide\">";
                        _e("Add to One Slide (Slider one by one)", "halimthemes");
                        echo "</label>\r\n\r\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"halim_add_to_widget\" value=\"is_carousel_slide\" id=\"is_carousel_slide\" ";
                        echo is_array($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_add_to_widget"]) && in_array("is_carousel_slide", $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_add_to_widget"]) ? "checked" : "";
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"is_carousel_slide\">";
                        _e("Add to Carousel Slider", "halimthemes");
                        echo "</label>\r\n\r\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"halim_add_to_widget\" value=\"paging_episode\" id=\"paging_episode\" ";
                        echo is_array($_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_add_to_widget"]) && in_array("paging_episode", $_obfuscated_0D182E0B21332A25160C18143E3435405B27263B212B22_["halim_add_to_widget"]) ? "checked" : "";
                        echo ">\r\n\t\t\t\t\t\t\t\t<label for=\"paging_episode\">";
                        _e("Paging the episode list", "halimthemes");
                        echo "</label>\r\n\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</div>\r\n\r\n\t\t\t\t\t\t<input type=\"submit\" name=\"halim-update-post-meta\" value=\"Update Post Info\" id=\"halim-update-post-meta\" style=\"outline: none;\">\r\n\t\t\t\t\t</form>\r\n\t\t\t\t</div>\r\n\r\n\t\t\t\t<script>\r\n\r\n\t\t\t\t\t\$( \"form#halim-update-post-meta-form\" ).submit(function( event ) {\r\n\t\t\t\t\t\tvar post_id = ";
                        echo $postID;
                        echo ";\r\n\t\t\t\t\t\t\$('#halim-update-post-meta').val('Please wait...');\r\n\t\t\t\t\t    \$.ajax({\r\n\t\t\t\t\t        url: \"";
                        echo admin_url("admin-ajax.php");
                        echo "\",\r\n\t\t\t\t\t        type: 'POST',\r\n\t\t\t\t\t        data: {\r\n\t\t\t\t\t            action: 'halim_ajax_update_post_meta',\r\n\t\t\t\t\t            post_id: post_id,\r\n\t\t\t\t\t            post_meta: \$(this).serializeArray()\r\n\t\t\t\t\t        },\r\n\t\t\t\t\t        success: function(result) {\r\n\t\t\t\t\t        \t\$('#halim-update-post-meta').val('Successfully');\r\n\t\t\t\t\t        \tsetTimeout(function(){\r\n\t\t\t\t\t        \t\t\$('#halim-update-post-meta').val('Update Post Info');\r\n\t\t\t\t\t        \t}, 800);\r\n\r\n\t\t\t\t\t        }\r\n\t\t\t\t\t    });\r\n\t\t\t\t\t  \tevent.preventDefault();\r\n\t\t\t\t\t});\r\n\r\n\t\t\t\t</script>\r\n\r\n\t\t\t\t<style>\r\n\t\t\t\t\t.halim-input-checkbox span {\r\n\t\t\t\t\t    font-weight: bold;\r\n\t\t\t\t\t    width: 100px;\r\n\t\t\t\t\t    display: inline-block;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.halim-input-checkbox label {\r\n\t\t\t\t\t    vertical-align: text-bottom;\r\n\t\t\t\t\t    margin-right: 10px;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t#halim-post-info-edit-box {\r\n\t\t\t\t\t    background: #fff;\r\n\t\t\t\t\t    overflow: hidden;\r\n\t\t\t\t\t    display: block;\r\n\t\t\t\t\t    border: 1px solid #ddd;\r\n\t\t\t\t\t    border-radius: 5px;\r\n\t\t\t\t\t    padding: 20px;\r\n\t\t\t\t\t    margin: 15px 0;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.box {\r\n\t\t\t\t\t    display: block;\r\n\t\t\t\t\t    width: 100%;\r\n\t\t\t\t\t    overflow: hidden;\r\n\t\t\t\t\t    margin: 15px 0;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t.halim-input-box {\r\n\t\t\t\t\t    margin: 3px 0;\r\n\t\t\t\t\t}\r\n\t\t\t\t\t#halim-update-post-meta {\r\n\t\t\t\t\t\tdisplay: inline-block;\r\n\t\t\t\t\t\tcolor: #fff;\r\n\t\t\t\t\t    padding: 10px;\r\n\t\t\t\t\t    border-radius: 4px;\r\n\t\t\t\t\t    text-align: center;\r\n\t\t\t\t\t    border: none;\r\n\t\t\t\t\t    background-size: 300% 100%;\r\n\t\t\t\t\t    moz-transition: all .4s ease-in-out;\r\n\t\t\t\t\t    -o-transition: all .4s ease-in-out;\r\n\t\t\t\t\t    -webkit-transition: all .4s ease-in-out;\r\n\t\t\t\t\t    transition: all .4s ease-in-out;\r\n\t\t\t\t\t    background-image: linear-gradient(to right, #ffbb00, #e43603, #ff6290, #ff5000);\r\n\t\t\t\t\t    box-shadow: 0px 2px 4px 0 rgba(229, 66, 10, 0.75);\r\n\t\t\t\t\t    cursor: pointer;\r\n\t\t\t\t\t}\r\n\t\t\t\t</style>\r\n\r\n\t        ";
                        if ($data) {
                            echo "\r\n\r\n\r\n\r\n<!-- Start import-multi-episode-->\r\n\r\n\r\n\r\n\r\n        <div id=\"import-multi-episode\" class=\"import-multi-episode\" style=\"width: 80%; display: none;\">\r\n        \t<p style=\"font-weight: 700;font-size: 16px;font-family: initial;\">Import Episode to \"<a href=\"";
                            echo get_permalink($postID);
                            echo "\" target=\"_blank\">";
                            echo get_the_title($postID);
                            echo "</a>\"</p>\r\n        \t<p style=\"font-weight: 700;color: #ff6a00;font-size: 17px;\">Latest Episode: ";
                            echo halim_get_last_episode($postID);
                            echo "</p>\r\n\r\n\t\t\t<p class=\"radio-checked-box\">\r\n\t\t\t\t<input type=\"radio\" name=\"import_type\" value=\"listepisode\" id=\"listepisode\" checked>\r\n\t\t\t\t<label for=\"listepisode\">";
                            _e("Episode", "halimthemes");
                            echo "\t\t\t\t\t<span class=\"icon-help\" data-ui-tooltip=\"<img src='https://i.imgur.com/zs2ftNt.png'>\">?</span>\r\n\t\t\t\t</label>\r\n\t\t\t\t<input type=\"radio\" name=\"import_type\" value=\"listserver\" id=\"listserver\">\r\n\t\t\t\t<label for=\"listserver\">";
                            _e("Alternate server fallback", "halimthemes");
                            echo "\t\t\t\t\t<span class=\"icon-help\" data-ui-tooltip=\"<img src='https://i.imgur.com/byOhGBz.png'>\">?</span>\r\n\t\t\t\t</label>\r\n\t\t\t\t<input type=\"radio\" name=\"import_type\" value=\"subtitle\" id=\"subtitle\">\r\n\t\t\t\t<label for=\"subtitle\">";
                            _e("Subtitle", "halimthemes");
                            echo "\t\t\t\t\t<span class=\"icon-help\" data-ui-tooltip=\"<img src='https://i.imgur.com/UiRpLLF.png'>\">?</span>\r\n\t\t\t\t</label>\r\n\t\t\t</p>\r\n\t\t\t<select name=\"serverLists\" id=\"serverLists\">\r\n\t\t\t\t";
                            if (!$_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) {
                                echo "<option value=\"0\">Server HD</option>";
                            }
                            foreach ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ as $key => $val) {
                                $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ = $key == $server ? " selected" : "";
                                echo "<option value=\"" . $key . "\" " . $_obfuscated_0D2721140D070E402E373C1D280B25092939351E2B1D22_ . ">" . $val->halimmovies_server_name . "</option>";
                            }
                            echo "\t\t\t</select>\r\n\t\t\t<select name=\"listepisode\" id=\"list-listepisode\" style=\"display: none\">\r\n\t\t\t\t<option value=\"\" id=\"choose-ep\">";
                            _e("Choose Episode", "halimthemes");
                            echo "</option>\r\n\t\t\t\t";
                            foreach ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_[$server]->halimmovies_server_data as $key => $val) {
                                echo "<option value=\"" . $key . "\">" . $val->halimmovies_ep_name . "</option>";
                            }
                            echo "\t\t\t</select>\r\n\t\t\t<span class=\"loading\" style=\"display: none;\"><img src=\"";
                            echo HALIM_THEME_URI;
                            echo "/assets/images/loading.gif\" alt=\"loading\"></span>\r\n\t\t\t<div style=\"margin: 10px 0;\"></div>\r\n\t\t\t<div class=\"_episode\">\r\n\t\t\t\t<pre>EP 10|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t\t<pre>EP 11|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|embed</pre>\r\n\t\t\t\t<pre>EP 12|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t</div>\r\n\t\t\t<div class=\"_listserver\" style=\"display: none;\">\r\n\t\t\t\t<pre>#1|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t\t<pre>#2|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|embed</pre>\r\n\t\t\t\t<pre>Server Drive|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t</div>\r\n\t\t\t<div class=\"_subtitle\" style=\"display: none;\">\r\n\t\t\t\t<pre>Vietnamese|https://yourdomain.com/files/subtitles/the-movie-title-Vietnamese.srt</pre>\r\n\t\t\t\t<pre>English|https://yourdomain.com/files/subtitles/the-movie-title-English.vtt</pre>\r\n\t\t\t\t<pre>French|https://yourdomain.com/files/subtitles/the-movie-title-French.vtt</pre>\r\n\t\t\t</div>\r\n\r\n            <p>\r\n\t            <span class=\"tip\" style=\"border: 1px solid #7e8993;margin-bottom: 3px;padding: 10px 15px;font-size: 12px;\"><span>";
                            _e("Episode name", "halimthemes");
                            echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                            _e("Episode URL", "halimthemes");
                            echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                            _e("Type", "halimthemes");
                            echo " (Episode Type support list: <span style=\"color: #4d5bff;font-weight: bold;font-family: inherit;\">";
                            echo getPlayerTypesAsText();
                            echo " link, mp4, embed</span>)</span></span>\r\n                <textarea id=\"multiple-import-list\" rows=\"15\" style=\"width: 100%\"></textarea>\r\n            </p>\r\n\t\t\t<p style=\"display: none;\">\r\n\t\t\t\t<input type=\"radio\" name=\"import_option\" value=\"1\" id=\"addnew\" checked>\r\n\t\t\t\t<label for=\"addnew\">Add new</label>\r\n\t\t\t\t<input type=\"radio\" name=\"import_option\" value=\"1\" id=\"replace\">\r\n\t\t\t\t<label for=\"replace\">Replace* <span style=\"font-size: 12px;color: #f00;\">(This option will replace all the old episodes)</span></label>\r\n\t\t\t</p>\r\n            <div>\r\n            \t<div class=\"button-primary\" onClick=\"javascript:Importer();\" id=\"import-btn\" style=\"padding: 7px 35px;height: auto;\"><span style=\"vertical-align: sub;margin-right: 5px;\"><img src=\"https://i.imgur.com/AclBCr8.png\" width=\"16\" height=\"16\"></span><span class=\"import-btn-txt\">Import Episode</span></div>\r\n            </div>\r\n\r\n        </div>\r\n        <div id=\"status\" style=\"display: none;\"></div>\r\n\r\n\t\t<div class=\"tooltipOuter\">\r\n\t\t    <div class=\"tooltipInner\"></div>\r\n\t\t</div>\r\n\t\t<style>\r\n\t\t\tinput[type=radio] + label {\r\n\t\t\t  \tcolor: #333;\r\n\t\t\t\tmargin-right: 10px;\r\n\t\t\t}\r\n\t\t\tinput[type=radio]:checked + label {\r\n\t\t\t  \tcolor: #f00;\r\n\t\t\t  \tfont-weight: 700;\r\n\t\t\t}\r\n\t\t\t.import-multi-episode pre {\r\n\t\t\t    background: #ffffff;\r\n\t\t\t    color: #f51f64;\r\n\t\t\t    padding: 3px 5px;\r\n\t\t\t    /* border-radius: 3px; */\r\n\t\t\t    margin: 0;\r\n\t\t\t}\r\n\t\t\t/* ToolTip */\r\n\t\t\t.tooltipOuter {\r\n\t\t\t    position: absolute;\r\n\t\t\t    display: block;\r\n\t\t\t    top: 200px;\r\n\t\t\t    left: 400px;\r\n\t\t\t    z-index: 9999;\r\n\t\t\t    -webkit-border-radius: 5px;\r\n\t\t\t    border-radius: 5px;\r\n\t\t\t    display: none;\r\n\t\t\t}\r\n\t\t\t.tooltipInner {\r\n\t\t\t    padding: 0.75em;\r\n\t\t\t    color:#292926;\r\n\t\t\t    text-align: center;\r\n\t\t\t    font-size: 12px;\r\n\t\t\t    line-height: 16px;\r\n\t\t\t    -webkit-border-radius: 5px;\r\n\t\t\t    border-radius: 5px;\r\n\t\t\t}\r\n\t\t\t.tooltipInner img {\r\n\t\t\t    width: 60%;\r\n\t\t\t    -webkit-box-shadow: 0px 0px 20px 5px rgba(128, 128, 128, 0.88);\r\n\t\t\t    box-shadow: 0px 0px 20px 5px rgba(128, 128, 128, 0.88);\r\n\t\t\t}\r\n\t\t\t.tooltipInner::before {\r\n\t\t\t    content: \" \";\r\n\t\t\t    display: block;\r\n\t\t\t    background-color: transparent;\r\n\t\t\t    position: absolute;\r\n\t\t\t    bottom: -6px;\r\n\t\t\t    margin: 0 0 0 -10px;\r\n\t\t\t    left: 50%;\r\n\t\t\t    width: 0;\r\n\t\t\t    height: 0;\r\n\t\t\t    border-left: 6px solid transparent;\r\n\t\t\t    border-right: 6px solid transparent;\r\n\t\t\t    border-top: 6px solid #333;\r\n\t\t\t}\r\n\r\n\t\t\t.icon-help {\r\n\t\t\t    cursor: pointer;\r\n\t\t\t    font-size: 11px;\r\n\t\t\t    background: #000;\r\n\t\t\t    color: #fff;\r\n\t\t\t    padding: 0 5px;\r\n\t\t\t    border-radius: 100%;\r\n\t\t\t}\r\n\t\t</style>\r\n\r\n\t\t<script>\r\n\t\t\tvar \$ = jQuery.noConflict();\r\n\r\n\r\n\t\t\t\$('.radio-checked-box input:radio').click(function() {\r\n\t\t\t    if(\$(this).val() === 'listepisode') {\r\n\t\t\t      \t\$('.import-btn-txt').html('Import Episode');\r\n\t\t\t      \t\$('#list-listepisode').hide();\r\n\t\t\t      \t\$('._listserver').hide();\r\n\t\t\t      \t\$('._episode').show();\r\n\t\t\t      \t\$('._subtitle').hide()\r\n\t\t\t    } else if(\$(this).val() === 'listserver') {\r\n\t\t\t      \t\$('.import-btn-txt').html('Import Server');\r\n\t\t\t      \t\$('._listserver').show();\r\n\t\t\t      \t\$('._episode').hide();\r\n\t\t\t      \t\$('._subtitle').hide()\r\n\t\t\t      \t\$('#list-listepisode').show();\r\n\t\t\t    } else if(\$(this).val() === 'subtitle') {\r\n\t\t\t    \t\$('.import-btn-txt').html('Import Subtitle');\r\n\t\t\t    \t\$('#list-listepisode').show();\r\n\t\t\t    \t\$('._listserver').hide();\r\n\t\t\t    \t\$('._episode').hide();\r\n\t\t\t    \t\$('._subtitle').show()\r\n\t\t\t    }\r\n\t\t\t});\r\n\r\n\t\t    \$('#serverLists').on('change', function () {\r\n\t\t    \tlet server = \$('select#serverLists option:selected').val();\r\n\t\t    \t\$('.loading').show();\r\n\t\t    \t\$('#choose-ep').text('Loading...');\r\n\t\t    \tgetListEpByServerID(";
                            echo $postID;
                            echo ", server);\r\n\r\n\t\t        return false;\r\n\t\t    });\r\n\r\n\t\t    \$('#list-listepisode').on('change', function () {\r\n\t\t    \t\$('.loading').show();\r\n\t\t    \tsetTimeout(function(){\r\n\t\t    \t\t\$('.loading').hide();\r\n\t\t    \t}, 300)\r\n\t\t        return false;\r\n\t\t    });\r\n\r\n\t\t    function getListEpByServerID(post_id, server) {\r\n\t\t        \$.ajax({\r\n\t\t            type: 'POST',\r\n\t\t            url: ajax_url,\r\n\t\t            data: {\r\n\t\t                action: 'halim_get_list_episode_by_server_id',\r\n\t\t                post_id: post_id,\r\n\t\t                server: server\r\n\t\t            },\r\n\t\t            success: function(data) {\r\n\t\t                \$('#list-listepisode').html(data);\r\n\t\t                \$('.loading').hide();\r\n\t\t            }\r\n\t\t        });\r\n\t\t    }\r\n\r\n\t\t\tfunction Importer()\r\n\t\t\t{\r\n\t\t\t    var list_link = \$('#multiple-import-list').val().split(/\\r?\\n/);\r\n\t\t\t    var post_id = ";
                            echo $postID;
                            echo ";\r\n\t\t\t    var server = \$(\"#serverLists option:selected\").val();\r\n\t\t\t    var server_name = \$('#serverLists option:selected').text();\r\n\t\t\t    var episode_slug = \$('#list-listepisode option:selected').val();\r\n\t\t\t    var import_type = \$('input[name=\"import_type\"]:checked').val();\r\n\r\n\t\t\t    if(import_type !== 'listepisode' && episode_slug == '')  {\r\n\t\t\t    \talert('Vui lòng chọn tập phim cần import!');\r\n\t\t\t    } else if(list_link == '') {\r\n\t\t\t    \talert('Vui lòng nhập danh sách link!');\r\n\t\t\t    } else {\r\n\t\t\t    \t\$('#status').show().html('Please wait...');\r\n\t\t\t\t    \$.ajax({\r\n\t\t\t\t        url: \"";
                            echo admin_url("admin-ajax.php");
                            echo "\",\r\n\t\t\t\t        type: 'POST',\r\n\t\t\t\t        data: {\r\n\t\t\t\t            action: 'halim_ajax_importer',\r\n\t\t\t\t            post_id: post_id,\r\n\t\t\t\t            server: server,\r\n\t\t\t\t            list_link: list_link,\r\n\t\t\t\t            server_name: server_name,\r\n\t\t\t\t            import_type: import_type,\r\n\t\t\t\t            episode_slug: episode_slug\r\n\t\t\t\t        },\r\n\t\t\t\t        success: function(result) {\r\n\t\t\t\t            // \$('#status').show().html(result);\r\n\t\t\t\t            getListEpByServerID(post_id, server);\r\n\t\t\t\t            \$('#status').show().html('Import successfuly!');\r\n\t\t\t\t\t       setTimeout(function() {\r\n\t\t\t\t            \twindow.location.reload();\r\n\t\t\t\t            }, 1000)\r\n\t\t\t\t        }\r\n\t\t\t\t    });\r\n\t\t\t    }\r\n\t\t\t}\r\n\r\n\r\n\t\t\t\$(document).ready(function(){\r\n\t\t\t      tooltipObj.init();\r\n\t\t\t    });\r\n\r\n\t\t\tvar tooltipObj = {\r\n\t\t\t    init: function(){\r\n\t\t\t        this.events();\r\n\t\t\t    },\r\n\t\t\t    events: function(){\r\n\t\t\t        var _this = this;\r\n\t\t\t        \$('[data-ui-tooltip]').on('mouseenter',function(e){\r\n\r\n\t\t\t            var \$el = \$(this),\r\n\t\t\t                text = \$el.data(\"ui-tooltip\");\r\n\t\t\t            _this.mouseenterEvent(e, text, \$el);\r\n\t\t\t        });\r\n\r\n\t\t\t        \$('[data-ui-tooltip]').on('mouseleave click',function(e){\r\n\t\t\t            _this.mouseleaveEvent(e);\r\n\t\t\t        });\r\n\t\t\t    },\r\n\t\t\t    mouseenterEvent: function(e, text, \$el){\r\n\r\n\t\t\t        if(typeof text != 'undefined'){\r\n\r\n\t\t\t            var tt      = \$('.tooltipOuter').clone().addClass(\"temp\"),\r\n\t\t\t                ttCon   = \$('.tooltipInner').clone(),\r\n\t\t\t                offset  = \$el.offset();\r\n\r\n\t\t\t            tt.empty()\r\n\t\t\t                .append(ttCon.html(text))\r\n\t\t\t                .appendTo(\"body\");\r\n\r\n\t\t\t            //Calculate after append\r\n\t\t\t            var bWidth  = tt.width() > \$el.width() ? tt.width() :  \$el.width(),\r\n\t\t\t                lWidth  = tt.width() < \$el.width() ? tt.width() :  \$el.width(),\r\n\t\t\t                dWidth  = bWidth - lWidth,\r\n\t\t\t                topVal  = (offset.top - tt.height()) - 8,\r\n\t\t\t                leftVal = (offset.left - (dWidth / 2));\r\n\r\n\t\t\t            tt.css({\r\n\t\t\t                top:topVal,\r\n\t\t\t                left:leftVal\r\n\t\t\t            }).fadeIn(\"fast\");\r\n\t\t\t        }\r\n\t\t\t    },\r\n\t\t\t    mouseleaveEvent: function(e){\r\n\t\t\t        \$('.tooltipOuter.temp').remove();\r\n\t\t\t    }\r\n\t\t\t}\r\n\r\n\t\t</script>\r\n\r\n\r\n<!-- End import-multi-episode -->\r\n\r\n\r\n<!-- Start Import multi Ep2=1 -->\r\n<div id=\"import-multi-episode-1\" style=\"display:none\">\r\n\r\n        <div class=\"import-multi-episode\">\r\n        \t";
                            $_obfuscated_0D295C23251F1F3E0B152C2629371228165C232A2D2201_ = get_post_meta($postID, "_halimmovies", true);
                            $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ = json_decode(stripslashes($_obfuscated_0D295C23251F1F3E0B152C2629371228165C232A2D2201_));
                            echo "        \t<p style=\"font-weight: 700;font-size: 16px;font-family: initial;\">Import Episode to \"<a href=\"";
                            echo get_permalink($postID);
                            echo "\" target=\"_blank\">";
                            echo get_the_title($postID);
                            echo "</a>\"</p>\r\n        \t<p style=\"font-weight: 700;color: #ff6a00;font-size: 17px;\">Latest Episode: ";
                            echo halim_get_last_episode($postID);
                            echo "</p>\r\n\t\t\t<p>\r\n\t\t\t\tTrường hợp chỉ có link tập chính (Only main episode link)\r\n\t\t\t\t<pre>Tập 13x|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t</p>\r\n\r\n\t\t\t<p>\r\n\t\t\t\tTrường hợp có link tập chính và phụ đề rời, không có link dự phòng (Only main episode link and subtitle, not alternate link fallback)\r\n\t\t\t\t<pre>Tập 13|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link|subtitle=file1.srt*VN,file2.srt*EN,file3.vtt*ES</pre>\r\n\t\t\t</p>\r\n\r\n\t\t\t<p>\r\n\t\t\t\tTrường hợp có link tập chính và link dự phòng, không có link phụ đề rời (Only main episode link and alternate link fallback, not subtitles)\r\n\t\t\t\t<pre>Tập 13x|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link|subtitle=|server=sv1.mp4*#1*embed,sv2.mp4*SV2*link</pre>\r\n\t\t\t</p>\r\n\r\n\t\t\t<p>\r\n\t\t\t\tTrường hợp có đầy đủ các tham số (Full of parameters)\r\n\t\t\t\t<pre>Tập 12x|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|embed|subtitle=file1.srt*VN,file2.srt*EN,file3.vtt*ES|server=sv1.mp4*#1*embed,sv2.mp4*SV2*link</pre>\r\n\t\t\t\t<pre><span style=\"background: #777;color: #fff;\">Tập 12x</span>|<span style=\"background: #ffe4e4;\">https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing</span>|embed|<span style=\"background: #0a0;color: #fff;\">subtitle=file1.srt*VN,file2.srt*EN,file3.vtt*ES</span>|server=sv1.mp4*#1*embed,sv2.mp4*SV2*link</pre>\r\n\r\n\t\t\t</p>\r\n\r\n\t\t\t<p>\r\n\t\t\t\t<span style=\"margin-right: 5px;font-weight: 700;\">Choose server:</span>\r\n\t\t\t\t<select name=\"serverLists\" id=\"serverLists\">\r\n\t\t\t\t\t";
                            if (!$_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) {
                                echo "<option value=\"0\">Server #1</option>";
                            }
                            foreach ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ as $key => $val) {
                                echo "<option value=\"" . $key . "\">" . $val->halimmovies_server_name . "</option>";
                            }
                            echo "\t\t\t\t</select>\r\n\t\t\t</p>\r\n            <p>\r\n\t            <span class=\"tip\" style=\"border: 1px solid #7e8993;margin-bottom: 3px;padding: 10px 15px;font-size: 12px;\"><span>";
                            _e("Episode name", "halimthemes");
                            echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                            _e("Episode URL", "halimthemes");
                            echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                            _e("Type", "halimthemes");
                            echo " (Episode Type support list: <span style=\"color: #4d5bff;font-weight: bold;font-family: inherit;\">";
                            echo getPlayerTypesAsText();
                            echo " link, mp4, embed</span>)</span></span>\r\n            </p>\r\n            <p>\r\n                <textarea id=\"import-multi-episode1\" rows=\"15\" placeholder=\"EP 1|https://www.facebook.com/266609707276074/videos/1098819176961657/#link\" style=\"width: 100%\"></textarea>\r\n            </p>\r\n            <div class=\"button-primary\" onClick=\"javascript:episodeImporter();\" id=\"import1\">";
                            _e("Import Episode", "halimthemes");
                            echo "</div>\r\n\r\n        </div>\r\n        <div id=\"status1\" style=\"display: none;\"></div>\r\n\t\t<style>\r\n\t\t\t.import-multi-episode pre {\r\n\t\t\t    background: #ffffff;\r\n\t\t\t    color: #f51f64;\r\n\t\t\t    padding: 3px 5px;\r\n\t\t\t    border-radius: 3px;\r\n\t\t\t}\r\n\t\t</style>\r\n\r\n\t\t<script>\r\n\r\n\t\t\tfunction episodeImporter()\r\n\t\t\t{\r\n\t\t\t    var list_link = \$('#import-multi-episode1').val().split(/\\r?\\n/);\r\n\t\t\t    var post_id = ";
                            echo $postID;
                            echo ";\r\n\t\t\t    var server = \$(\"#serverLists option:selected\").val();\r\n\t\t\t    var server_name = \$('#serverLists option:selected').text();\r\n\r\n\r\n\t\t\t    if(list_link == '') {\r\n\t\t\t    \talert('Vui lòng nhập danh sách tập phim theo mẫu!');\r\n\t\t\t    } else {\r\n\t\t\t\t    \$('#status').show().html('Please wait...');\r\n\t\t\t\t    \$('#import1').html('Loading...');\r\n\r\n\t\t\t\t    \$.ajax({\r\n\t\t\t\t        url: \"";
                            echo admin_url("admin-ajax.php");
                            echo "\",\r\n\t\t\t\t        type: 'POST',\r\n\t\t\t\t        data: {\r\n\t\t\t\t            action: 'halim_ajax_episode_importer2',\r\n\t\t\t\t            post_id: post_id,\r\n\t\t\t\t            server: server,\r\n\t\t\t\t            list_link: list_link,\r\n\t\t\t\t            server_name: server_name\r\n\t\t\t\t        },\r\n\t\t\t\t        success: function(result) {\r\n\t\t\t\t            \$('#status1').show().html('Import successfuly!');\r\n\t\t\t\t            \$('#import1').html('Import Episode');\r\n\t\t\t\t            setTimeout(function() {\r\n\t\t\t\t            \twindow.location.reload();\r\n\t\t\t\t            }, 1000)\r\n\t\t\t\t        }\r\n\t\t\t\t    });\r\n\t\t\t    }\r\n\t\t\t}\r\n\t\t</script>\r\n\r\n\r\n</div>\r\n\r\n<!-- End -->\r\n\r\n";
                        }
                        echo "\r\n<!-- Add new server -->\r\n<div id=\"halim-add-new-server-box\" style=\"display: none;\">\r\n\t\t";
                        $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_ = isset($_GET["server"]) ? $_GET["server"] : "0";
                        if ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) {
                            echo "\t\t\t\t<div class=\"current_server\">\r\n\t\t\t\t\t<p style=\"font-weight: 700;\">Current Server:</p>\r\n\t\t\t\t\t";
                            foreach ($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ as $key => $value) {
                                $active = $server == $key ? " active" : "";
                                echo "<span class=\"lsv\"><a class=\"item" . $active . "\" href=\"?page=halim-episode-manager&act=edit_ep&post_id=" . $postID . "&server=" . $key . "&paged=" . $paged . "&cat=" . $cat_id . "\">" . $value->halimmovies_server_name . "</a><span class=\"del-server\" data-index=\"" . $key . "\" data-reload=\"\"><span class=\"dashicons dashicons-no\"></span></span></span>";
                                $last_sv[] = $key;
                            }
                            echo "\t\t\t\t</div>\r\n\t\t\t";
                        }
                        echo "\r\n\t\t\t<p>\r\n\t\t\t\t<label for=\"servername\" style=\"font-weight: 700;\">New Server Name:</label>\r\n\t\t\t\t<input type=\"text\" name=\"servername\" id=\"servername\" value=\"Server #";
                        echo $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ ? HALIMHelper::array_key_last($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) + 2 : $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_ + 1;
                        echo "\" placeholder=\"Server HD\" data-server=\"";
                        echo $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ ? HALIMHelper::array_key_last($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) + 1 : $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_;
                        echo "\" data-post-id=\"";
                        echo $postID;
                        echo "\">\r\n\t\t\t</p>\r\n            <p>\r\n\t            <span class=\"tip\" style=\"border: 1px solid #7e8993;margin-bottom: 3px;padding: 10px 15px;font-size: 12px;\"><span>";
                        _e("Episode name", "halimthemes");
                        echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                        _e("Episode URL", "halimthemes");
                        echo "<span style=\"color: red;font-weight: 700;\">|</span>";
                        _e("Type", "halimthemes");
                        echo " (Episode Type support list: <span style=\"color: #4d5bff;font-weight: bold;font-family: inherit;\">";
                        echo getPlayerTypesAsText();
                        echo " link, mp4, embed</span>)</span></span>\r\n            </p>\r\n            <p>\r\n                <textarea id=\"addnewsv-list\" rows=\"15\" style=\"width: 100%\"></textarea>\r\n            </p>\r\n            <div>\r\n            \t<div class=\"button-primary\" onClick=\"javascript:AddNewServer();\" id=\"addnewsv-btn\" style=\"padding: 7px 35px;height: auto;\"><span class=\"addsv-btn-txt\">Add new server</span></div>\r\n            </div>\r\n            <p>\r\n            \t<input type=\"radio\" name=\"redirect_options\" value=\"redirect\" id=\"redirect\" checked>\r\n            \t<label for=\"redirect\" style=\"margin-right: 10px;\">Redirect to Server #";
                        echo $_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_ ? HALIMHelper::array_key_last($_obfuscated_0D29291B25012C0A30180D0A0B1E102C2118093B042301_) + 2 : $_obfuscated_0D351C0D07025C1F11390601072B0B01300D340D3E0322_ + 1;
                        echo "</label>\r\n            \t<input type=\"radio\" name=\"redirect_options\" value=\"reload\" id=\"reload\">\r\n            \t<label for=\"reload\">Reload this page</label>\r\n            </p>\r\n\t\t\t<div id=\"status\" style=\"display: none;\"></div>\r\n\t\t\t<div class=\"_episode\">\r\n\t\t\t\t<p>Example:</p>\r\n\t\t\t\t<pre>EP 10|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t\t<pre>EP 11|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|embed</pre>\r\n\t\t\t\t<pre>EP 12|https://drive.google.com/file/d/1ATilCtX62rLXwpo7Gm7h2ba6wiGjbL3I/view?usp=sharing|link</pre>\r\n\t\t\t</div>\r\n\t\t\t<style>\r\n\t\t\t\t._episode pre {\r\n\t\t\t\t    background: #ffffff;\r\n\t\t\t\t    color: #f51f64;\r\n\t\t\t\t    padding: 3px 5px;\r\n\t\t\t\t    border-radius: 0;\r\n\t\t\t\t    margin: 0;\r\n\t\t\t\t}\r\n\t\t\t\t.current_server {\r\n\t\t\t\t\tmargin-bottom: 15px\r\n\t\t\t\t}\r\n\t\t\t\t.current_server .lsv {\r\n\t\t\t\t    background: #b50f0f;\r\n\t\t\t\t    color: #fff;\r\n\t\t\t\t    margin-right: 37px;\r\n\t\t\t\t    padding: 5px 6px;\r\n\t\t\t\t    border-radius: 3px;\r\n\t\t\t\t    cursor: pointer;\r\n\t\t\t\t    position: relative;\r\n\t\t\t\t}\r\n\t\t\t\t.current_server .lsv a {\r\n\t\t\t\t\tcolor: #fff\r\n\t\t\t\t}\r\n\t\t\t\t.current_server .lsv .del-server {\r\n\t\t\t\t    position: absolute;\r\n\t\t\t\t    right: -28px;\r\n\t\t\t\t    top: 0;\r\n\t\t\t\t}\r\n\r\n\r\n\r\n\t\t\t</style>\r\n\r\n\t\t\t<script>\r\n\t\t\t\tfunction AddNewServer()\r\n\t\t\t\t{\r\n\t\t\t\t    var list_link = \$('#addnewsv-list').val().split(/\\r?\\n/);\r\n\t\t\t\t    var post_id = ";
                        echo $postID;
                        echo ";\r\n\t\t\t\t    var server = \$(\"#servername\").data('server');\r\n\t\t\t\t    var server_name = \$(\"#servername\").val();\r\n\t\t\t\t    var redirect_options = \$('input[name=\"redirect_options\"]:checked').val();\r\n\t\t\t\t    if(server_name == '')  {\r\n\t\t\t\t    \talert('Vui lòng nhập tên server');\r\n\t\t\t\t    } else if(list_link == '') {\r\n\t\t\t\t    \talert('Vui lòng nhập danh sách tập phim theo mẫu!');\r\n\t\t\t\t    } else {\r\n\t\t\t\t    \t\$('#status').show().html('Please wait...');\r\n\t\t\t\t\t    \$.ajax({\r\n\t\t\t\t\t        url: \"";
                        echo admin_url("admin-ajax.php");
                        echo "\",\r\n\t\t\t\t\t        type: 'POST',\r\n\t\t\t\t\t        data: {\r\n\t\t\t\t\t            action: 'halim_ajax_addnewserver',\r\n\t\t\t\t\t            post_id: post_id,\r\n\t\t\t\t\t            server: server,\r\n\t\t\t\t\t            list_link: list_link,\r\n\t\t\t\t\t            server_name: server_name\r\n\t\t\t\t\t        },\r\n\t\t\t\t\t        success: function(result) {\r\n\t\t\t\t\t            \$('#status').show().html('Import successfuly!');\r\n\t\t\t\t\t            if(redirect_options == 'redirect') {\r\n\t\t\t\t\t\t            setTimeout(function(){\r\n\t\t\t\t\t\t                window.location = '?page=halim-episode-manager&act=edit_ep&post_id='+post_id+'&server='+server;\r\n\t\t\t\t\t\t            }, 1000);\r\n\t\t\t\t\t            } else {\r\n\t\t\t\t\t            \tlocation.reload();\r\n\t\t\t\t\t            }\r\n\t\t\t\t\t        }\r\n\t\t\t\t\t    });\r\n\t\t\t\t    }\r\n\t\t\t\t}\r\n\t\t\t</script>\r\n\r\n\r\n\r\n</div>\r\n\r\n\r\n";
                        do_action("halim-country-blocker", $postID);
                        echo "\r\n\t        ";
                        if ($data) {
                            echo "\r\n<!-- End -->\r\n\r\n\r\n\r\n\t            <label for=\"halimmovies_server_name\"><h3>";
                            _e("Select server to edit episode", "halimthemes");
                            echo "</h3></label>\r\n\t            <div class=\"listsv postbox\">\r\n\t                    ";
                            $_obfuscated_0D100330153C294011301E022F075C321521222D191211_ = get_post_meta($postID, "episode_server_hidden", true);
                            foreach ($data as $key => $value) {
                                echo "<span class=\"svitem\">";
                                if ($_obfuscated_0D100330153C294011301E022F075C321521222D191211_ && in_array($key, $_obfuscated_0D100330153C294011301E022F075C321521222D191211_)) {
                                    echo "<span class=\"svhidden\">Hidden</span>";
                                }
                                $active = $server == $key ? " active" : "";
                                echo "<a class=\"item" . $active . "\" href=\"?page=halim-episode-manager&act=edit_ep&post_id=" . $postID . "&server=" . $key . "&paged=" . $paged . "&cat=" . $cat_id . "\"><span class=\"dashicons dashicons-database\" style=\"margin-top: -3px;\"></span> " . $value["halimmovies_server_name"] . "</a><span class=\"del-server\" data-index=\"" . $key . "\"><span class=\"dashicons dashicons-no\"></span></span></span>";
                                $last_sv[] = $key;
                            }
                            $last_sv = HALIMHelper::array_key_last($last_sv);
                            echo "\r\n\t                <script> var last_sv = ";
                            echo $last_sv;
                            echo ";</script>\r\n\t                <div id=\"addnew-server-act\" style=\"display: none;\">\r\n\r\n\t                    <div class=\"add-server\">\r\n\t                        <span class=\"add-newsv\"><a href=\"?page=halim-episode-manager&act=add-new-server&post_id=";
                            echo $postID;
                            echo "&server=";
                            echo $last_sv + 1;
                            echo "\"><span class=\"dashicons dashicons-plus\"></span> Add new server</a></span>\r\n\r\n\t                    </div>\r\n\t                    <span class=\"add-newEp\"><a class=\"item\" href=\"?page=halim-episode-manager&act=add_new_ep&post_id=";
                            echo $postID;
                            echo "&server=";
                            echo $server;
                            echo "&paged=";
                            echo $paged;
                            echo "&cat=";
                            echo $cat_id;
                            echo "\"><span class=\"dashicons dashicons-plus\"></span> ";
                            _e("Add new episode", "halimthemes");
                            echo "</a></span>\r\n\r\n\t                    <span class=\"add-newEp\"><a class=\"item\" href=\"?page=halim-episode-manager&act=import&post_id=";
                            echo $postID;
                            echo "&server=";
                            echo $server;
                            echo "&paged=";
                            echo $paged;
                            echo "&cat=";
                            echo $cat_id;
                            echo "\" style=\"background: #e88100;border-color: #bd6b05;\"><span class=\"dashicons dashicons-plus\"></span> ";
                            _e("Import new episode", "halimthemes");
                            echo "</a></span>\r\n\t                </div>\r\n\t            </div>\r\n\r\n\r\n\t            ";
                            foreach ($data as $key => $value) {
                                if ($key == $server) {
                                    echo "\r\n\t                <script>\r\n\t                   jQuery(function(\$) {\r\n\r\n\r\n\t                    halim_set_pagination_items();\r\n\r\n\t                    function checkFragment() {\r\n\t                        // If there's no hash, treat it like page 1.\r\n\t                        var hash = window.location.hash || \"#page-1\";\r\n\r\n\t                        // We'll use a regular expression to check the hash string.\r\n\t                        hash = hash.match(/^#page-(\\d+)\$/);\r\n\r\n\t                        if(hash) {\r\n\t                            // The `selectPage` function is described in the documentation.\r\n\t                            // We've captured the page number in a regex group: `(\\d+)`.\r\n\t                            \$(\"#pagination\").pagination(\"selectPage\", parseInt(hash[1]));\r\n\t                        }\r\n\t                    };\r\n\r\n\t                    // We'll call this function whenever back/forward is pressed...\r\n\t                    \$(window).bind(\"popstate\", checkFragment);\r\n\r\n\t                    // ... and we'll also call it when the page has loaded\r\n\t                    // (which is right now).\r\n\t                    checkFragment();\r\n\r\n\t                    \$('#set_item_per_page').click(function(){\r\n\t                        \$( \".list-episode-item\" ).each(function( i ) {\r\n\t                            if ( this.style.display == \"none\" ) {\r\n\t                                this.style.display = \"block\";\r\n\t                            }\r\n\t                        });\r\n\t                        \$(this).hide();\r\n\t                        \$('#pagination, .ellipse-tip').hide();\r\n\t                    });\r\n\r\n\r\n\t                    function halim_set_pagination_items(perPage){\r\n\t                        // Consider adding an ID to your table\r\n\t                        // incase a second table ever enters the picture.\r\n\t                        var items = \$(\".list-episode-item\");\r\n\r\n\t                        var numItems = items.length;\r\n\t                        var perPage = perPage ? perPage : 10;\r\n\r\n\t                        // Only show the first 2 (or first `per_page`) items initially.\r\n\t                        items.slice(perPage).hide();\r\n\r\n\t                        // Now setup the pagination using the `.pagination-page` div.\r\n\t                        \$(\"#pagination\").pagination({\r\n\t                            items: numItems,\r\n\t                            itemsOnPage: perPage,\r\n\t                            ellipsePageSet: true,\r\n\t                            cssStyle: \"light-theme\",\r\n\t                            // This is the actual page changing functionality.\r\n\t                            onPageClick: function(pageNumber) {\r\n\t                                // We need to show and hide `tr`s appropriately.\r\n\t                                var showFrom = perPage * (pageNumber - 1);\r\n\t                                var showTo = showFrom + perPage;\r\n\r\n\t                                // We'll first hide everything...\r\n\t                                items.hide()\r\n\t                                     // ... and then only show the appropriate rows.\r\n\t                                     .slice(showFrom, showTo).show();\r\n\t                            }\r\n\t                        });\r\n\t                    }\r\n\t                });\r\n\t                </script>\r\n\t\t\t\t\t<div id=\"listepisode-exported\" style=\"display: none;\"></div>\r\n\t                    <div id=\"list--episodes\" class=\"halim-server postbox list-server-sortable\">";
                                    echo "<span class=\"halim-server-name\">" . __("List episodes of", "halimthemes") . " <strong style=\"color:red;\">" . $value["halimmovies_server_name"] . ".</strong> " . __("in the article", "halimthemes") . " <a href=\"" . get_permalink($postID) . "\" target=\"_blank\"><strong style=\"border: 1px solid #e8a4a4;border-radius: 2px;padding: 1px 5px;color: #da6161;\">" . get_the_title($postID) . "</strong></a></span>";
                                    echo "<span class=\"halim-episode-saving\" data-server=\"" . $server . "\" data-post-id=\"" . $postID . "\"><span class=\"dashicons dashicons-update\" style=\"margin-top: -3px;\"></span> Update episodes</span>";
                                    echo "<span class=\"halim-export-episodes\" data-server=\"" . $server . "\" data-post-id=\"" . $postID . "\"><span class=\"dashicons dashicons-database-export\" style=\"margin-top: -3px;\"></span> Export episodes</span>";
                                    echo "<div class=\"clearfix\"></div>";
                                    $halimmovies_server_data = $value["halimmovies_server_data"];
                                    if ($halimmovies_server_data) {
                                        echo "<div class=\"halim-edit-server-name\"><label for=\"halim-server_name\">Server Name</label>";
                                        echo "<input type=\"text\" name=\"halim_server_name\" id=\"halim-server_name\" value=\"" . $value["halimmovies_server_name"] . "\" placeholder=\"Server name\">";
                                        echo "</div><ul class=\"halim-list-eps\">";
                                        foreach ($halimmovies_server_data as $k => $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_) {
                                            if ($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_name"]) {
                                                echo "\r\n\t                                   <div class=\"halimmovies_episodes list-episode-item episodes_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo " row\" data-ep=\"";
                                                echo $k;
                                                echo "\" data-server=\"";
                                                echo $key;
                                                echo "\" style=\"position: relative;overflow: hidden;\">\r\n\t                                        <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                            <input id=\"halimmovies_ep_name_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" type=\"text\" class=\"form-control edit-ep-name\" name=\"halimmovies_ep_name[]\" value=\"";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_name"];
                                                echo "\" placeholder=\"Episode Name\" data-slug_id=\"episode_slug_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\">\r\n\t                                        </div>\r\n\r\n\r\n\t                                        <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                            <input id=\"episode_slug_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" type=\"text\" class=\"form-control edit-episode-slug\" name=\"halimmovies_ep_slug[]\" value=\"";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" placeholder=\"Episode Slug\">\r\n\t                                        </div>\r\n\r\n\t                                        <div class=\"form-group col-lg-2\" style=\"margin-right: -1px\">\r\n\t                                        \t<select name=\"halimmovies_ep_type[]\" id=\"halimmovies_ep_type_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" style=\"display:block;width:100%;margin-top:0;height: 32px;\">\r\n\t                                        \t\t";
                                                getPlayerTypes($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_type"]);
                                                echo "\t                                            </select>\r\n\t                                        </div>\r\n\t                                        <div class=\"form-group col-lg-8\">\r\n\t                                            <input class=\"form-control\" type=\"text\" id=\"halimmovies_ep_link_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" name=\"halimmovies_ep_link[]\" style=\"width:100%\" value=\"";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_link"];
                                                echo "\" placeholder=\"Video url\">\r\n\t                                        </div>\r\n\t                                        <!-- <a class=\"editep\" href=\"?page=halim-episode-manager&act=edit_ep&post_id=";
                                                echo $postID;
                                                echo "&episode_slug=";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "&server=";
                                                echo $key;
                                                echo "&cat=";
                                                echo $cat_id;
                                                echo "&paged=";
                                                echo $paged;
                                                echo "\"><span class=\"dashicons dashicons-plus-alt\"></span></a> -->\r\n\r\n\t                                        <button href=\"#halimmovies_listsv_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" class=\"nav-toggle editep\" style=\"border: none;cursor: pointer;outline: none;\"><span class=\"dashicons dashicons-plus-alt\"></span></button>\r\n\t                                        <a class=\"del_ep\"><span class=\"dashicons dashicons-no\"></span></a>\r\n\t                                        <span class=\"sortable\"><span class=\"dashicons dashicons-move\"></span></span>\r\n\r\n\r\n\r\n\r\n\t\t\t\t\t\t\t\t\t\t    <div id=\"halimmovies_listsv_";
                                                echo $key;
                                                echo "_";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" class=\"collapse list-server-sortable\" style=\"display:none\">\r\n\r\n\r\n<!-- Start -->\r\n\r\n\r\n\r\n\t                                    <div class=\"halimmovies_episodes episodes row x\" data-ep=\"";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" data-server=\"";
                                                echo $server;
                                                echo "\">\r\n\r\n\t                                        <div id=\"list-subtitle-";
                                                echo $k;
                                                echo "\" class=\"form-group col-lg-12 list-subtitle\" style=\"position: relative;\">\r\n\r\n\t                                            <div id=\"halimmovies_subs\" class=\"listsub\">\r\n\t                                                <a style=\"cursor: pointer;\" class=\"add_new_sub\" data-ep=\"";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" data-server=\"";
                                                echo $server;
                                                echo "\"><span class=\"dashicons dashicons-plus\"></span> ";
                                                _e("Add subtitle field", "halimthemes");
                                                echo "</a>\r\n\t                                                ";
                                                if (is_array($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_subs"])) {
                                                    echo "<script>var current_subtitle_count = " . count($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_subs"]) . ";</script>";
                                                }
                                                if (isset($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_subs"]) && $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_subs"]) {
                                                    foreach ($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_subs"] as $s => $_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_) {
                                                        $_obfuscated_0D2938392B0B390F091E192102211127085B2728321E01_ = $_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_["halimmovies_ep_sub_default"] ? " checked" : "";
                                                        echo "\t                                                            <div id=\"subtile-item-";
                                                        echo $s;
                                                        echo "\" class=\"halimmovies_subs\" style=\"margin-bottom: 10px\">\r\n\t                                                                <label>Label: </label>\r\n\t                                                                <input id=\"sub_label_";
                                                        echo $s;
                                                        echo "\" type=\"text\" name=\"sub_label[]\" style=\"width:15%\" value=\"";
                                                        echo esc_attr($_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_["halimmovies_ep_sub_label"]);
                                                        echo "\" />\r\n\t                                                                <input style=\"display: none;\" id=\"sub_label_default_";
                                                        echo $s;
                                                        echo "\" type=\"radio\" name=\"sub_default[]\" value=\"";
                                                        echo $s;
                                                        echo "\" ";
                                                        echo $_obfuscated_0D2938392B0B390F091E192102211127085B2728321E01_;
                                                        echo ">\r\n\t                                                                <label style=\"display: none;\" for=\"sub_label_default_";
                                                        echo $s;
                                                        echo "\">Default</label>\r\n\t                                                                <span>\r\n\t                                                                    <label style=\"margin-left: 1%;\">File: </label>\r\n\t                                                                    <input id=\"sub_file_";
                                                        echo $s;
                                                        echo "\" type=\"text\" name=\"sub_file[]\" style=\"width:68.8%\" value=\"";
                                                        echo esc_attr($_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_["halimmovies_ep_sub_file"]);
                                                        echo "\" />\r\n\t                                                                    <a class=\"del_sub\"><span class=\"dashicons dashicons-no\"></span></a>\r\n\t                                                                    <span class=\"sortable\"><span class=\"dashicons dashicons-move\"></span></span>\r\n\t                                                                </span>\r\n\t                                                            </div>\r\n\t                                                            ";
                                                    }
                                                }
                                                echo "\t                                            </div>\r\n\t                                            <div class=\"update-subtitle\" data-ep-slug=\"";
                                                echo $k;
                                                echo "\">\r\n\t                                            \t";
                                                _e("Update", "halimthemes");
                                                echo "</div>\r\n\r\n\t                                        </div>\r\n\r\n\t                                        <div id=\"list-server-";
                                                echo $k;
                                                echo "\" class=\"form-group col-lg-12 list-server\">\r\n\t                                            <div id=\"halimmovies_listsv\" class=\"list-server-sortable\">\r\n\t                                                <a style=\"cursor: pointer;\" class=\"add_new_listsv\" data-ep=\"";
                                                echo $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_slug"];
                                                echo "\" data-server=\"";
                                                echo $server;
                                                echo "\"><span class=\"dashicons dashicons-plus\"></span> ";
                                                _e("Add alternate server fallback field", "halimthemes");
                                                echo "</a>\r\n\r\n\t                                            ";
                                                if (is_array($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_listsv"])) {
                                                    echo "<script>var current_listsv_count = " . count($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_listsv"]) . ";</script>";
                                                }
                                                if (isset($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_listsv"]) && $_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_listsv"]) {
                                                    foreach ($_obfuscated_0D25302B3503123C2324303709263C2B393F40072C1822_["halimmovies_ep_listsv"] as $s => $_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_) {
                                                        echo "\t                                                        <div id=\"list_backup_link_";
                                                        echo $s;
                                                        echo "\" class=\"halimmovies_listsv\" style=\"margin-bottom: 10px\">\r\n\t                                                            <label>";
                                                        _e("Name", "halimthemes");
                                                        echo ": </label>\r\n\t                                                            <input type=\"text\" id=\"listsv_name_";
                                                        echo $s;
                                                        echo "\" name=\"listsv_name[]\" style=\"width:15%\" value=\"";
                                                        echo esc_attr($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_["halimmovies_ep_listsv_name"]);
                                                        echo "\" />\r\n\r\n\t                                                            <label>";
                                                        _e("Type", "halimthemes");
                                                        echo ": </label>\r\n\t                                                            <select name=\"listsv_type[]\" id=\"listsv_type_";
                                                        echo $s;
                                                        echo "\">\r\n\t                                                                ";
                                                        getPlayerTypes($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_["halimmovies_ep_listsv_type"]);
                                                        echo "\t                                                            </select>\r\n\t                                                            <label>";
                                                        _e("Link", "halimthemes");
                                                        echo ": </label>\r\n\t                                                            <input type=\"text\" id=\"listsv_link_";
                                                        echo $s;
                                                        echo "\" name=\"listsv_link[]\" style=\"width:71%\" value=\"";
                                                        echo esc_attr($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_["halimmovies_ep_listsv_link"]);
                                                        echo "\" />\r\n\t                                                            <span class=\"sortable\"><span class=\"dashicons dashicons-move\"></span></span>\r\n\t                                                            <a class=\"del_listsv\"><span class=\"dashicons dashicons-no\"></span></a>\r\n\r\n\t                                                        </div>\r\n\t                                                        ";
                                                    }
                                                }
                                                echo "\r\n\t                                            </div>\r\n\t                                            <div class=\"update-list-sv\" data-ep-slug=\"";
                                                echo $k;
                                                echo "\"><span class=\"";
                                                echo $k;
                                                echo " dashicons dashicons-image-rotate\"></span> ";
                                                _e("Update", "halimthemes");
                                                echo "</div>\r\n\t                                        </div>\r\n\r\n\r\n\t                                    </div>\r\n\t\t\t\t\t\t\t<!-- End -->\r\n\t\t\t\t\t\t\t\t\t    \t</div>\r\n\r\n\r\n\t                                    </div>\r\n\r\n\t                                ";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                                    echo "</div>";
                                    echo "<span class=\"halim-episode-saving\" data-server=\"" . $server . "\" data-post-id=\"" . $postID . "\">Update episodes</span>";
                                    echo "<div id=\"pagination\"></div><div id=\"set_item_per_page\">Show All</div>";
                                    echo "<p class=\"ellipse-tip\">" . __("Clicking on the ellipse (...) will replace the ellipse with a number type input in which you can manually set the resulting page", "halimthemes") . "</p>";
                                }
                            }
                        }
                        if (isset($_GET["episode_slug"])) {
                            $post_meta = get_post_meta($postID, "_halimmovies", true);
                            $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_ = json_decode(stripslashes($post_meta), true);
                            $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_ = $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_data"][$episode]["halimmovies_ep_name"];
                            $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_ = $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_data"][$episode]["halimmovies_ep_slug"];
                            $_obfuscated_0D0D29250B14090D02091B31270B12270C171E0C1E0F22_ = $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_data"][$episode]["halimmovies_ep_link"];
                            $_obfuscated_0D13142F0414373F11291A1D24371C33333F1E16322F11_ = $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_data"][$episode]["halimmovies_ep_type"];
                            echo "\r\n\t            <div id=\"halimmovies\" class=\"postbox\">\r\n\t                <button type=\"button\" class=\"handlediv\" aria-expanded=\"true\"><span class=\"screen-reader-text\">Toggle panel: Episode list</span><span class=\"toggle-indicator\" aria-hidden=\"true\"></span></button>\r\n\t                <h2 class=\"hndle ui-sortable-handle\" style=\"margin-left: 10px;padding-bottom: 15px;\"><span>";
                            _e("Edit episode on", "halimthemes");
                            echo " <span class=\"movie-name\">";
                            echo get_the_title($postID);
                            echo "</span></span>\r\n\t                    ";
                            if (!empty($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[0]["halimmovies_server_name"])) {
                                echo "\t                    <span class=\"edit\"><a class=\"item\" href=\"?page=halim-episode-manager&act=add_new_ep&post_id=";
                                echo $postID;
                                echo "&server=";
                                echo $server;
                                echo "&paged=";
                                echo $paged;
                                echo "&cat=";
                                echo $cat_id;
                                echo "\"><span class=\"dashicons dashicons-plus\"></span> ";
                                _e("Add new ep", "halimthemes");
                                echo "</a></span>\r\n\t                ";
                            }
                            echo "\t                </h2>\r\n\t                <div class=\"inside\">\r\n\t                    <div class=\"clear\"></div>\r\n\t                    <div id=\"halimmovies-player-data\">\r\n\t                        <div class=\"tab-content\">\r\n\t                            <div class=\"tab-pane active\" id=\"server_";
                            echo $server;
                            echo "\" data-server=\"";
                            echo $server;
                            echo "\">\r\n\t                                <div id=\"halimmovies_episodes\" class=\"form-horizontal\">\r\n\t                                    <script>var last_sv = -1;</script>\r\n\t                                    ";
                            if (empty($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_name"])) {
                                echo "\t                                        <div id=\"add-first-server\">\r\n\r\n\t                                            <div class=\"add-server first\">\r\n\t                                                <input type=\"text\" name=\"server_name\" id=\"halim-server_name\" value=\"Server #";
                                echo $server + 1;
                                echo "\" placeholder=\"Server name\">\r\n\r\n\t                                            </div>\r\n\t                                            <a id=\"add-new-eps\" class=\"add_new_ep xx\" data-ep-total=\"1\" data-server=\"";
                                echo $server;
                                echo "\"><span class=\"dashicons dashicons-plus\"></span><span>";
                                _e("Add New Episode Field", "halimthemes");
                                echo "</span></a>\r\n\t                                            <div class=\"clearfix\"></div>\r\n\r\n\t                                           <div class=\"halimmovies_episodes episodes_1 row\" data-ep=\"1\" data-server=\"";
                                echo $server;
                                echo "\" style=\"position: relative;overflow: hidden;\">\r\n\t                                                <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                                    <label for=\"halimmovies_ep_name_";
                                echo $server;
                                echo "_1\">";
                                _e("Episode Name", "halimthemes");
                                echo "</label>\r\n\t                                                    <input id=\"halimmovies_ep_name_";
                                echo $server;
                                echo "_1\" type=\"text\" class=\"form-control\" name=\"halimmovies_ep_name[]\" value=\"1\" placeholder=\"";
                                _e("Episode Name", "halimthemes");
                                echo "\">\r\n\t                                                </div>\r\n\r\n\r\n\t                                                <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                                    <label for=\"episode_slug_";
                                echo $server;
                                echo "_1\">";
                                _e("Episode Slug", "halimthemes");
                                echo "</label>\r\n\t                                                    <input id=\"episode_slug_";
                                echo $server;
                                echo "_1\" type=\"text\" class=\"form-control\" name=\"halimmovies_ep_slug[]\" value=\"";
                                echo $this->cs_get_option("halim_episode_url");
                                echo "-1\" placeholder=\"";
                                _e("Episode Slug", "halimthemes");
                                echo "\">\r\n\t                                                </div>\r\n\r\n\t                                                <div class=\"form-group col-lg-2\" style=\"margin-right: -1px\">\r\n\t                                                    <label>";
                                _e("Type", "halimthemes");
                                echo ": </label>\r\n\t                                                    <select name=\"halimmovies_ep_type[]\" id=\"halimmovies_ep_type_";
                                echo $server;
                                echo "_1\" style=\"display:block;width:100%;margin-top: 1px;height: 32px;\">\r\n\t                                                        ";
                                getPlayerTypes();
                                echo "\t                                                    </select>\r\n\t                                                </div>\r\n\t                                                <div class=\"form-group col-lg-8\">\r\n\t                                                    <label for=\"halimmovies_ep_link_";
                                echo $server;
                                echo "_1\">";
                                _e("Link", "halimthemes");
                                echo ": </label>\r\n\t                                                    <input class=\"form-control\" type=\"text\" id=\"halimmovies_ep_link_";
                                echo $server;
                                echo "_1\" name=\"halimmovies_ep_link[]\" style=\"width:100%\" value=\"Video url\" placeholder=\"Video url\">\r\n\t                                                </div>\r\n\t                                            </div>\r\n\r\n\t                                        </div>\r\n\r\n\t                                    ";
                            } else {
                                echo "\r\n\t                                    <h3>";
                                _e("Edit Episode", "halimthemes");
                                echo " <span class=\"last_ep\">";
                                echo $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_;
                                echo "</span></h3>\r\n\t                                    <div class=\"halimmovies_episodes episodes row x\" data-ep=\"";
                                echo $episode;
                                echo "\" data-server=\"";
                                echo $server;
                                echo "\">\r\n\r\n\t                                        ";
                                if (empty($_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[0]["halimmovies_server_name"])) {
                                    echo "<div class=\"disable-add-new-ep\"><span>" . __("Please add the Server before you can add new episode", "halimthemes") . "</span></div>";
                                }
                                echo "\r\n\t                                        <div style=\"position: relative;overflow: hidden;\">\r\n\t                                            <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                                <label for=\"halimmovies_ep_name\">";
                                _e("Episode Name", "halimthemes");
                                echo "</label>\r\n\t                                                <input id=\"halimmovies_ep_name\" type=\"text\" class=\"form-control\" name=\"halimmovies_ep_name\" value=\"";
                                echo $_obfuscated_0D100B34010A2B08231D2F264019185C1B1E1908110A01_;
                                echo "\" placeholder=\"";
                                _e("Episode Name", "halimthemes");
                                echo "\" disabled>\r\n\t                                            </div>\r\n\r\n\r\n\t                                            <div class=\"form-group col-lg-1\" style=\"margin-right: -1px\">\r\n\t                                                <label for=\"episode_slug\">";
                                _e("Episode Slug", "halimthemes");
                                echo "</label>\r\n\t                                                <input id=\"episode_slug\" type=\"text\" class=\"form-control\" name=\"halimmovies_ep_slug\" value=\"";
                                echo $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_;
                                echo "\" data-old-ep=\"";
                                echo $_obfuscated_0D121D303204083B2D0A11173B39351F2B183403101C01_;
                                echo "\" placeholder=\"";
                                _e("Episode Slug", "halimthemes");
                                echo "\" disabled>\r\n\t                                            </div>\r\n\r\n\t                                            <div class=\"form-group col-lg-2\" style=\"margin-right: -1px\">\r\n\t                                                <label>";
                                _e("Type", "halimthemes");
                                echo ": </label>\r\n\t                                                <select name=\"halimmovies_ep_type\" id=\"halimmovies_ep_type\" style=\"display:block;width:100%;margin-top: 1px;height: 32px;\" disabled>\r\n\t                                                    ";
                                getPlayerTypes($_obfuscated_0D13142F0414373F11291A1D24371C33333F1E16322F11_);
                                echo "\t                                                </select>\r\n\t                                            </div>\r\n\t                                            <div class=\"form-group col-lg-8\">\r\n\t                                                <label for=\"halimmovies_ep_link\">";
                                _e("Link", "halimthemes");
                                echo ": </label>\r\n\t                                                <input class=\"form-control\" type=\"text\" id=\"halimmovies_ep_link\" name=\"halimmovies_ep_link\" style=\"width:100%\" value=\"";
                                echo $_obfuscated_0D0D29250B14090D02091B31270B12270C171E0C1E0F22_;
                                echo "\" placeholder=\"Video url\" disabled>\r\n\t                                            </div>\r\n\t                                            <div id=\"update-eps\" style=\"display: none;\"><span class=\"dashicons dashicons-image-rotate\"></span> ";
                                _e("Update Episode", "halimthemes");
                                echo "</div>\r\n\t                                        </div>\r\n\r\n\r\n\t                                        <div class=\"form-group col-lg-12 list-subtitle\" style=\"position: relative;\">\r\n\r\n\t                                            <div id=\"halimmovies_subs\" class=\"listsub\">\r\n\t                                                <a style=\"cursor: pointer;\" class=\"add_new_sub\" data-ep=\"";
                                echo $episode;
                                echo "\" data-server=\"";
                                echo $server;
                                echo "\"><span class=\"dashicons dashicons-plus\"></span> ";
                                _e("Add subtitle field", "halimthemes");
                                echo "</a>\r\n\t                                                ";
                                $_obfuscated_0D0B2B351E062A1D5B320D1A2B092118043E255C121432_ = $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_data"][$episode]["halimmovies_ep_subs"];
                                echo "<script>var current_subtitle_count = " . count($_obfuscated_0D0B2B351E062A1D5B320D1A2B092118043E255C121432_) . ";</script>";
                                if (isset($_obfuscated_0D0B2B351E062A1D5B320D1A2B092118043E255C121432_) && $_obfuscated_0D0B2B351E062A1D5B320D1A2B092118043E255C121432_) {
                                    foreach ($_obfuscated_0D0B2B351E062A1D5B320D1A2B092118043E255C121432_ as $s => $_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_) {
                                        $_obfuscated_0D2938392B0B390F091E192102211127085B2728321E01_ = $_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_["halimmovies_ep_sub_default"] ? " checked" : "";
                                        echo "\t                                                            <div id=\"subtile-item-";
                                        echo $s;
                                        echo "\" class=\"halimmovies_subs\" style=\"margin-bottom: 10px\">\r\n\t                                                                <label>Label: </label>\r\n\t                                                                <input id=\"sub_label_";
                                        echo $s;
                                        echo "\" type=\"text\" name=\"sub_label[]\" style=\"width:15%\" value=\"";
                                        echo esc_attr($_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_["halimmovies_ep_sub_label"]);
                                        echo "\" />\r\n\t                                                                <input id=\"sub_label_default_";
                                        echo $s;
                                        echo "\" type=\"radio\" name=\"sub_default[]\" value=\"";
                                        echo $s;
                                        echo "\" ";
                                        echo $_obfuscated_0D2938392B0B390F091E192102211127085B2728321E01_;
                                        echo ">\r\n\t                                                                <label for=\"sub_label_default_";
                                        echo $s;
                                        echo "\">Default</label>\r\n\t                                                                <span>\r\n\t                                                                    <label style=\"margin-left: 1%;\">File: </label>\r\n\t                                                                    <input id=\"sub_file_";
                                        echo $s;
                                        echo "\" type=\"text\" name=\"sub_file[]\" style=\"width:68.8%\" value=\"";
                                        echo esc_attr($_obfuscated_0D152D240538261D0B0337271E365B052F5B15290E2732_["halimmovies_ep_sub_file"]);
                                        echo "\" />\r\n\t                                                                    <a class=\"del_sub\"><span class=\"dashicons dashicons-no\"></span></a>\r\n\t                                                                    <span class=\"sortable\"><span class=\"dashicons dashicons-move\"></span></span>\r\n\t                                                                </span>\r\n\t                                                            </div>\r\n\t                                                            ";
                                    }
                                }
                                echo "\t                                            </div>\r\n\t                                            <div class=\"update-subtitle\" data-index=\"";
                                echo $s;
                                echo "\">";
                                _e("Update", "halimthemes");
                                echo "</div>\r\n\r\n\t                                        </div>\r\n\r\n\t                                        <div class=\"form-group col-lg-12 list-server\">\r\n\t                                            <div id=\"halimmovies_listsv\" class=\"list-server-sortable\">\r\n\t                                                <a style=\"cursor: pointer;\" class=\"add_new_listsv\" data-ep=\"";
                                echo $episode;
                                echo "\" data-server=\"";
                                echo $server;
                                echo "\"><span class=\"dashicons dashicons-plus\"></span> ";
                                _e("Add alternate server fallback field", "halimthemes");
                                echo "</a>\r\n\r\n\t                                            ";
                                $_obfuscated_0D1636350C0E0D1F08243234142C1D332C3D09372E0311_ = $_obfuscated_0D2D15121C300423011427362E2A372515061B16221701_[$server]["halimmovies_server_data"][$episode]["halimmovies_ep_listsv"];
                                echo "<script>var current_listsv_count = " . count($_obfuscated_0D1636350C0E0D1F08243234142C1D332C3D09372E0311_) . ";</script>";
                                if (isset($_obfuscated_0D1636350C0E0D1F08243234142C1D332C3D09372E0311_) && $_obfuscated_0D1636350C0E0D1F08243234142C1D332C3D09372E0311_) {
                                    foreach ($_obfuscated_0D1636350C0E0D1F08243234142C1D332C3D09372E0311_ as $s => $_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_) {
                                        echo "\t                                                        <div id=\"list_backup_link_";
                                        echo $s;
                                        echo "\" class=\"halimmovies_listsv\" style=\"margin-bottom: 10px\">\r\n\t                                                            <label>";
                                        _e("Name", "halimthemes");
                                        echo ": </label>\r\n\t                                                            <input type=\"text\" id=\"listsv_name_";
                                        echo $s;
                                        echo "\" name=\"listsv_name[]\" style=\"width:15%\" value=\"";
                                        echo esc_attr($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_["halimmovies_ep_listsv_name"]);
                                        echo "\" />\r\n\r\n\t                                                            <label>";
                                        _e("Type", "halimthemes");
                                        echo ": </label>\r\n\t                                                            <select name=\"listsv_type[]\" id=\"listsv_type_";
                                        echo $s;
                                        echo "\">\r\n\t                                                                ";
                                        getPlayerTypes($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_["halimmovies_ep_listsv_type"]);
                                        echo "\t                                                            </select>\r\n\t                                                            <label>";
                                        _e("Link", "halimthemes");
                                        echo ": </label>\r\n\t                                                            <input type=\"text\" id=\"listsv_link_";
                                        echo $s;
                                        echo "\" name=\"listsv_link[]\" style=\"width:71%\" value=\"";
                                        echo esc_attr($_obfuscated_0D2A031B0C1C03261222325C07400907135B5C05093611_["halimmovies_ep_listsv_link"]);
                                        echo "\" />\r\n\t                                                            <span class=\"sortable\"><span class=\"dashicons dashicons-move\"></span></span>\r\n\t                                                            <a class=\"del_listsv\"><span class=\"dashicons dashicons-no\"></span></a>\r\n\r\n\t                                                        </div>\r\n\t                                                        ";
                                    }
                                }
                                echo "\r\n\t                                            </div>\r\n\t                                            <div class=\"update-list-sv\" data-index=\"";
                                echo $s;
                                echo "\"><span class=\"dashicons dashicons-image-rotate\"></span> ";
                                _e("Update", "halimthemes");
                                echo "</div>\r\n\t                                        </div>\r\n\r\n\t                                    </div>\r\n\t                                    ";
                            }
                            echo "\r\n\t                                </div>\r\n\t                                ";
                            if (!$episode) {
                                echo "\t                                <div id=\"add-server\" class=\"addnewsv\" data-server=\"";
                                echo $server;
                                echo "\"><span class=\"dashicons dashicons-plus\"></span> Add server & episodes</div>\r\n\t                            ";
                            }
                            echo "\t                            </div>\r\n\t                        </div>\r\n\t                    </div>\r\n\t                </div>\r\n\t            </div>\r\n\t            <div id=\"result\"></div>\r\n\t            ";
                        }
                    }
                }
            }
            echo "\t        <script>\r\n\t        \tvar \$ = jQuery.noConflict();\r\n\t            var post_id = ";
            echo $postID;
            echo ",\r\n\t                server = ";
            echo $server;
            echo ",\r\n\t                episode_slug = \"";
            echo $episode;
            echo "\",\r\n\t                episode_slug_default = \"";
            echo $this->cs_get_option("halim_episode_url");
            echo "\",\r\n\t                ajax_url = '";
            echo admin_url("admin-ajax.php");
            echo "';\r\n\r\n\t            \$(\"#halimmovies_ep_name, .edit-ep-name\").on('change keyup paste', function(){\r\n\t                var value = \$(this).val(), slug_id = \$(this).attr('id').replace('halimmovies_ep_name', 'episode_slug');\r\n\t                \$('#'+slug_id).val( value.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, \"a\").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, \"e\").replace(/ì|í|ị|ỉ|ĩ/g, \"i\").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, \"o\").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, \"u\").replace(/ỳ|ý|ỵ|ỷ|ỹ/g, \"y\").replace(/đ/g, \"d\").replace(/\\+| /g, \"-\").toLowerCase() );\r\n\t            });\r\n\t            var episode_type = '";
            echo getPlayerTypesJs();
            echo "';\r\n\r\n\t\t\t\t\$(document).ready(function() {\r\n\t\t\t\t\t\$('.nav-toggle').click(function(){\r\n\t\t\t\t\t\tvar collapse_content_selector = \$(this).attr('href');\r\n\t\t\t\t\t\tvar toggle_switch = \$(this);\r\n\t\t\t\t\t\t\$(collapse_content_selector).toggle(function(){\r\n\t\t\t\t\t\t  \tif(\$(this).css('display')=='none'){\r\n\t\t\t\t\t\t\t\ttoggle_switch.html('<span class=\"dashicons dashicons-plus-alt\"></span>');\r\n\t\t\t\t\t\t  \t}else{\r\n\t\t\t\t\t\t\t\ttoggle_switch.html('<span class=\"dashicons dashicons-dismiss\"></span>');\r\n\t\t\t\t\t\t  \t}\r\n\t\t\t\t\t\t});\r\n\t\t\t\t\t});\r\n\r\n\t\t\t\t    \$('.halim-export-episodes').click(function(){\r\n\t\t\t\t        var post_id = \$(this).data('post-id'),\r\n\t\t\t\t        \tserver_id = \$(this).data('server');\r\n\t\t\t\t        \thalim_ajax_export_episode(post_id, server_id)\r\n\t\t\t\t    });\r\n\r\n\t\t\t        \$('.select-server-to-export').on('change', function () {\r\n\t\t\t\t        var server_id = \$(this).val(),\r\n\t\t\t\t        \tpost_id = \$(this).data('post-id');\r\n\t\t\t\t        \thalim_ajax_export_episode(post_id, server_id)\r\n\t\t\t\t    });\r\n\r\n\t\t\t        function halim_ajax_export_episode(post_id, server_id)\r\n\t\t\t        {\r\n\t\t\t\t        \$('#download-episode').show().html('Loading...');\r\n\t\t\t\t        \$.ajax({\r\n\t\t\t\t            type: 'POST',\r\n\t\t\t\t            url: ajax_url,\r\n\t\t\t\t            data: {\r\n\t\t\t\t                action: 'halim_ajax_export_episodes',\r\n\t\t\t\t                post_id: post_id,\r\n\t\t\t\t                server_id: server_id\r\n\t\t\t\t            },\r\n\t\t\t\t            success: function(data) {\r\n\t\t\t\t                if(data.status == true) {\r\n\t\t\t\t                    \$('#download-episode').show().html(data.msg)\r\n\t\t\t\t                } else {\r\n\t\t\t\t                    \$('#download-episode').show().html('Error!')\r\n\t\t\t\t                }\r\n\t\t\t\t            }\r\n\t\t\t\t        });\r\n\t\t\t        }\r\n\t\t\t\t});\r\n\t\t\t</script>\r\n\t    </div>\r\n\t    ";
        }
    }
    public function halim_pagenav($total, $showpost, $paged)
    {
        $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ = isset($_GET["post_id"]) ? absint($_GET["post_id"]) : "";
        $server = isset($_GET["server"]) ? absint($_GET["server"]) : "";
        $_obfuscated_0D0329322D2C3D2E0211271D2733160C0B0D1F2C2F3901_ = isset($_GET["paged"]) && $_GET["paged"] ? absint($_GET["paged"]) : "1";
        $p = isset($_GET["p"]) && $_GET["p"] ? $_GET["p"] : "1";
        $_obfuscated_0D182D273B0D26281126255B132E1F0B321D311A0C0D32_ = ceil($_obfuscated_0D182A07041A0E2F312B342115220E1721170B2E1B3711_ / $showpost);
        $paged = isset($_GET["paged"]) ? absint($_GET["paged"]) : 1;
        $max = intval($_obfuscated_0D182D273B0D26281126255B132E1F0B321D311A0C0D32_);
        if (1 <= $paged) {
            $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_[] = $paged;
        }
        if (3 <= $paged) {
            $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_[] = $paged - 1;
            $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_[] = $paged - 2;
        }
        if ($paged + 2 <= $max) {
            $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_[] = $paged + 2;
            $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_[] = $paged + 1;
        }
        echo "<div class=\"text-center pagenav\">";
        echo "<form action=\"admin.php\" method=\"GET\" style=\"width: 20%;display: inline-block;\">\r\n\t    <input name=\"page\" type=\"hidden\" value=\"halim-episode-manager\"/>\r\n\t    <input name=\"act\" type=\"hidden\" value=\"edit_ep\"/>\r\n\t    <input name=\"post_id\" type=\"hidden\" value=\"" . $_obfuscated_0D1A0725351501221F2426130A073C340D19100D053022_ . "\"/>\r\n\t    <input name=\"server\" type=\"hidden\" value=\"" . $server . "\"/>\r\n\t    <input name=\"p\" type=\"hidden\" value=\"" . $p . "\" />\r\n\t    <span>Go to page: </span>\r\n\t    <input name=\"paged\" type=\"number\" value=\"" . $_obfuscated_0D0329322D2C3D2E0211271D2733160C0B0D1F2C2F3901_ . "\" class=\"regular-text\" style=\"width: 25%;\"/>\r\n\t    <button class=\"button-gotopage\">GO</button>\r\n\t    </form>";
        echo "<ul class=\"pagination\" style=\"text-align: center;margin: 20px 0 5px;\">\n";
        if (!in_array(1, $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_)) {
            $_obfuscated_0D013D2E131A02153D1C101A2D2113020F092715400501_ = 1 == $paged ? " class=\"active\"" : "";
            printf("<li%s><a href=\"%s\">%s</a></li>\n", $_obfuscated_0D013D2E131A02153D1C101A2D2113020F092715400501_, esc_url(get_pagenum_link(1)), "1");
        }
        sort($_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_);
        foreach ((int) $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_ as $link) {
            $_obfuscated_0D013D2E131A02153D1C101A2D2113020F092715400501_ = $paged == $link ? " class=\"active\"" : "";
            printf("<li%s><a href=\"%s\">%s</a></li>\n", $_obfuscated_0D013D2E131A02153D1C101A2D2113020F092715400501_, esc_url(get_pagenum_link($link)), $link);
        }
        if (!in_array($max, $_obfuscated_0D111F31182F12072F31373223050A130716133F011A01_)) {
            $_obfuscated_0D013D2E131A02153D1C101A2D2113020F092715400501_ = $paged == $max ? " class=\"active\"" : "";
            printf("<li%s><a href=\"%s\">%s</a></li>\n", $_obfuscated_0D013D2E131A02153D1C101A2D2113020F092715400501_, esc_url(get_pagenum_link($max)), $max);
        }
        echo "</ul></div>\n";
    }
}

?>