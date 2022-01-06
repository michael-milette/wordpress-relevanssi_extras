<?php
/*
Plugin Name: Relevanssi Extras
Plugin URI: http://tngconsulting.ca
Description: Includes hyphen removal, search results per page and exclude from results.
Version: 1.0
Author: TNG Consulting Inc. (Michael Milette)
Author URI: http://www.tngconsulting.ca/
Copyright 2012-2022 TNG Consulting Inc.
This script is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.
This script is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
 * Purpose: Remove hyphens from Relevanssi word index
 */
function ERS_hyphensoff($str) {
    return str_replace('-', '', $str);
}
add_filter('relevanssi_remove_punctuation', 'ERS_hyphensoff', 9);

/*
 * Purpose: Sets the number of Relevanssi search results per page.
 */
add_filter('post_limits', 'ERS_postsperpage');
function ERS_postsperpage($limits) {
	if (is_search()) {
		global $wp_query;
		$wp_query->query_vars['posts_per_page'] = 10; // This is the number you want to change.
	}
	return $limits;
}

/* ----------------------------------------------------------------------------------------------------
 * Purpose: Provides option to a page or post to exclude it from Relevanssi search results.
 * Updated by: Michael Milette for compatibility with Relevanssi 4.0.5+ - https://www.tngconsulting.ca
 * Written by: Tomas Kapler - http://kapler.cz/
 * http://wordpress.org/support/topic/plugin-relevanssi-a-better-search-solved-feature-easier-selection-of-what-to-not-search
 */
add_filter('relevanssi_search_filters', 'ERS_exclude_relevanssi');
function ERS_exclude_relevanssi ($values_to_filter) {
   $atts = array(
       'post_type' => 'any',
       'meta_key' => 'search_exclude',
       'meta_value' => 1,
       'posts_per_page' => -1
   );
   $my_query = new WP_Query($atts);
   $myposts = $my_query->posts;

	if($myposts) {
        $values_to_filter['expost'] = array_filter(explode(',',$values_to_filter['expost']));
        foreach ($myposts as $post) {
            $values_to_filter['expost'][] = $post->ID;
        }
        $values_to_filter['expost'] = implode(',',$values_to_filter['expost']);
    };
    return $values_to_filter;
}
// ----------------------------------------------------------------------------------------------------

function ERS_update_exclusions( $post_ID ) {
    // Avoid loosing setting if time-saved.
    if (! (bool) @ $_POST['ERS_ctrl_present'] )
        return;

    if ( (isset($_POST['ERS_this_page_searched'])) ) {
        $exclude_from_search = (bool) @ $_POST['ERS_this_page_searched'];
    } else {
        $exclude_from_search = false;
    }
    if ( $exclude_from_search ) {
        add_post_meta($post_ID, 'search_exclude', 1, true);
    } else {
        delete_post_meta($post_ID, 'search_exclude', $meta_value);
    }
}

function ERS_admin_sidebar_wp25() {
    global $post_ID;
    echo '	<div id="excludesearchdiv" class="ERS-admin-wp25">';
    echo '		<div class="outer"><div class="inner">';
    echo '		<p><label for="ERS_this_page_searched" class="selectit">';
    echo '		<input ';
    echo '			type="checkbox" ';
    echo '			name="ERS_this_page_searched" ';
    echo '			id="ERS_this_page_searched" ';

    if ( get_post_meta($post_ID, 'search_exclude', true) ) {
        echo 'checked="checked"';
    }

    echo '>';
    echo '			'.__( 'DO NOT INCLUDE this page in search results' ).'</label>';
    echo '		<input type="hidden" name="ERS_ctrl_present" value="1"></p>';
    echo '		</div></div>';
    echo '	</div>';
}

function ERS_admin_css() {
	echo <<<END
<style type="text/css" media="screen">
	.ERS_exclude_alert { font-size: 11px; }
	.ERS-admin-wp25 { font-size: 11px; background-color: #fff; }
	.ERS-admin-wp25 .inner {  padding: 8px 12px; background-color: #EAF3FA; border: 1px solid #EAF3FA; -moz-border-radius: 3px; -khtml-border-bottom-radius: 3px; -webkit-border-bottom-radius: 3px; border-bottom-radius: 3px; }
	#ERS_admin_meta_box .inner {  padding: inherit; background-color: transparent; border: none; }
	#ERS_admin_meta_box .inner label { background-color: none; }
	.ERS-admin-wp25 .exclude_alert { padding-top: 5px; }
	.ERS-admin-wp25 .exclude_alert em { font-style: normal; }
</style>
END;
}

// INIT FUNCTION
function ERS_admin_init() {
	// Add panels into the editing sidebar(s)
	add_meta_box('ERS_admin_meta_box', __( 'Exclude Relevanssi Page Search' ), 'ERS_admin_sidebar_wp25', 'page', 'side', 'low');
	// Set the exclusion when the post is saved
	add_action('save_post', 'ERS_update_exclusions');
	// Add the CSS to the admin header
	add_action('admin_head', 'ERS_admin_css');
}

// HOOK IT UP TO WORDPRESS
add_action( 'admin_init', 'ERS_admin_init' );
