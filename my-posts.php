<?php
/**
 * Plugin Name: My Posts
 * Plugin URI: https://iyware.com/my-posts-wordpress-plugin/
 * Description: Adds a "My Posts" link under the "Posts" menu in the admin area.
 * Version: 1.0.0
 * Author: Danny Wahl
 * Author URI: https://iyware.com
 * Text Domain: my-posts
 * Domain Path: /lang/
 * License: GPLv2 or later
 *
 * Copyright 2015  Danny Wahl
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined( 'ABSPATH' ) or die();

load_plugin_textdomain( 'my-posts', false, basename( dirname( __FILE__ ) ) . '/lang' );

/** 
 * Redirects the page to the current user's posts
 *
 * This function is the callback used by add_user_posts_link()
 * to redirect the output to the current user's posts
 *
 * @since 1.0.0
 */
function goto_user_posts() {
	$user_ID = get_current_user_id();
	$admin_url = get_admin_url( null, 'edit.php' );
	$query_string = build_query( array( 'post_type' => 'post', 'author'=> $user_ID ) );
	wp_redirect( $admin_url . '?' . $query_string );
}

/** 
 * Generates a sub-menu called 'My Posts'
 *
 * This function outputs a sub-menu called 'My Posts'
 * under the menu 'Posts' and uses goto_user_posts()
 * to redirect to current user's posts.  Requires 
 * capability 'edit_posts' to be accessed.
 *
 * @since 1.0.0
 */
function add_user_posts_link() {
	$myposts = __( 'My Posts', 'my-posts' );
	add_posts_page( $myposts, $myposts, 'edit_posts', 'my-posts', 'goto_user_posts' );
}

add_action( 'admin_menu', 'add_user_posts_link' );
?>