<?php
/**
 * Plugin Name: Relevanssi Extras
 * Plugin URI: https://tngconsulting.ca
 * Description: Includes hyphen removal, search results per page and exclude from results.
 * Version: 1.0
 * Author: TNG Consulting Inc. (Michael Milette)
 * Author URI: https://www.tngconsulting.ca/
 * Copyright 2012-2024 TNG Consulting Inc.
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * Removes hyphens from Relevanssi word index.
 *
 * @param string $str The input string.
 * @return string The modified string with hyphens removed.
 */
function ERS_hyphensoff($str) {
    return str_replace('-', '', $str);
}
add_filter('relevanssi_remove_punctuation', 'ERS_hyphensoff', 9);

/**
 * Sets the number of Relevanssi search results per page.
 *
 * This function is used to modify the number of search results per page in the Relevanssi plugin.
 * It checks if the current page is a search page and if so, it sets the 'posts_per_page' query variable
 * of the global $wp_query object to the desired number of search results per page.
 *
 * @param mixed $limits The current limit value.
 * @return mixed The modified limit value.
 */
function ERS_postsperpage($limits) {
    if (is_search()) {
        global $wp_query;
        $wp_query->query_vars['posts_per_page'] = 10; // This is the number you want to change.
    }
    return $limits;
}
add_filter('post_limits', 'ERS_postsperpage');

/**
 * Provides option to a page or post to exclude it from Relevanssi search results.
 *
 * Removes posts from search results based on the 'search_exclude' meta key.
 *
 * This function is used as a filter for the 'relevanssi_search_filters' hook.
 * It retrieves all posts that have the 'search_exclude' meta key set to 1,
 * and removes them from the search results by modifying the 'expost' value in the $values_to_filter array.
 *
 * Updated by: Michael Milette for compatibility with Relevanssi 4.0.5+ - https://www.tngconsulting.ca
 * Written by: Tomas Kapler - https://kapler.cz/
 * https://wordpress.org/support/topic/plugin-relevanssi-a-better-search-solved-feature-easier-selection-of-what-to-not-search
 *
 * @param array $values_to_filter The array of values to filter.
 * @return array The modified array with excluded posts removed.
 */
function ERS_exclude_relevanssi($values_to_filter) {
    $atts = [
        'post_type' => 'any',
        'meta_key' => 'search_exclude',
        'meta_value' => 1,
        'posts_per_page' => -1,
    ];
    $my_query = new WP_Query($atts);
    $myposts = $my_query->posts;

    if ($myposts) {
        $values_to_filter['expost'] = array_filter(explode(',', $values_to_filter['expost']));
        foreach ($myposts as $post) {
            $values_to_filter['expost'][] = $post->ID;
        }
        $values_to_filter['expost'] = implode(',', $values_to_filter['expost']);
    };
    return $values_to_filter;
}
add_filter('relevanssi_search_filters', 'ERS_exclude_relevanssi');

// ...----------------------------------------------------------------------------------------------------.

/**
 * Updates the exclusions for a post.
 *
 * This function is used to update the 'search_exclude' meta key for a post based on the value of the 'ERS_this_page_searched' checkbox.
 * If the checkbox is checked, the 'search_exclude' meta key is set to 1 for the post. Otherwise, the 'search_exclude' meta key is deleted.
 *
 * @param int $post_ID The ID of the post to update.
 * @return void
 */
function ERS_update_exclusions($post_ID) {
    // Avoid loosing setting if time-saved.
    if (!(bool) @$_POST['ERS_ctrl_present']) {
        return;
    }

    if ((isset($_POST['ERS_this_page_searched']))) {
        $excludeFromSearch = (bool) @$_POST['ERS_this_page_searched'];
    } else {
        $excludeFromSearch = false;
    }
    if ($excludeFromSearch) {
        add_post_meta($post_ID, 'search_exclude', 1, true);
    } else {
        delete_post_meta($post_ID, 'search_exclude', 1);
    }
}

/**
 * Displays the exclude search checkbox in the admin sidebar.
 *
 * This function is used to display the exclude search checkbox in the admin sidebar when editing a page.
 * It retrieves the current post ID and checks if the 'search_exclude' meta key is set to determine if the checkbox should be checked.
 * The checkbox allows the user to exclude the page from search results by setting the 'search_exclude' meta key to 1.
 *
 * @return void
 */
function ERS_admin_sidebar_wp25() {
    global $post_ID;
    echo '	<div id="excludesearchdiv" class="ERS-admin-wp25">';
    echo '		<div class="outer"><div class="inner">';
    echo '		<p><label for="ERS_this_page_searched" class="selectit">';
    echo '		<input ';
    echo '			type="checkbox" ';
    echo '			name="ERS_this_page_searched" ';
    echo '			id="ERS_this_page_searched" ';

    if (get_post_meta($post_ID, 'search_exclude', true)) {
        echo 'checked="checked"';
    }

    echo '>';
    echo '			' . __('DO NOT INCLUDE this page in search results') . '</label>';
    echo '		<input type="hidden" name="ERS_ctrl_present" value="1"></p>';
    echo '		</div></div>';
    echo '	</div>';
}

/**
 * Displays the CSS styles for the admin interface.
 *
 * This function is used to display the CSS styles for the admin interface.
 * It defines the styles for various elements such as font size, background color, padding, and border.
 *
 * @return void
 */
function ERS_admin_css() {
    ?>
<style type="text/css" media="screen">
    .ERS_exclude_alert {font-size: 11px;}
    .ERS-admin-wp25 {font-size: 11px; background-color: #fff;}
    .ERS-admin-wp25 .inner {padding: 8px 12px; background-color: #EAF3FA; border: 1px solid #EAF3FA; -moz-border-radius: 3px; -khtml-border-bottom-radius: 3px; -webkit-border-bottom-radius: 3px; border-bottom-radius: 3px;}
    #ERS_admin_meta_box .inner {padding: inherit; background-color: transparent; border: none;}
    #ERS_admin_meta_box .inner label {background-color: none;}
    .ERS-admin-wp25 .exclude_alert {padding-top: 5px;}
    .ERS-admin-wp25 .exclude_alert em {font-style: normal;}
</style>
    <?php
}

/**
 * Initializes the ERS admin functionality.
 *
 * This function adds panels into the editing sidebar(s), sets the exclusion when the post is saved,
 * and adds the CSS to the admin header.
 *
 * @since 1.0.0
 */
function ERS_admin_init() {
    // Add panels into the editing sidebar(s).
    add_meta_box('ERS_admin_meta_box', __('Exclude Relevanssi Page Search'), 'ERS_admin_sidebar_wp25', 'page', 'side', 'low');
    // Set the exclusion when the post is saved.
    add_action('save_post', 'ERS_update_exclusions');
    // Add the CSS to the admin header.
    add_action('admin_head', 'ERS_admin_css');
}
// Hook it up to WordPress.
add_action('admin_init', 'ERS_admin_init');
