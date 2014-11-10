<?php
/*
	Plugin Name: wp_item_post
	Plugin URI: 插件的介绍或更新地址
	Description: 插件描述
	Version: 0.1
	Author: 插件作者名称
	Author URI: 插件作者的链接
	License: GPL2
*/

/**
 * create post and meta
 *
 * @param $title
 * @param $content
 * @param string $status
 * @param string $author
 * @param string $item_name
 * @param string $item_price
 * @param $item_source
 * @param string $item_url
 * @param string $item_image
 * @param string $item_desc
 * @param string $email
 * @param array $category
 *
 * @return int|false success: postid error :false
 */
function item_post_create_post($title,$content,$status = 'draft',$author = '', $item_name = '',
					$item_price = '',$item_source,$item_url = '',$item_image = '',
					$item_desc = '',$email = '',$category = array()){
	$post = array(
		  'ID'             => '' ,// Are you updating an existing post?
		  'post_content'   => $content, // The full text of the post.
		  'post_name'      => $title, // The name (slug) for your post
		  'post_title'     => $title ,// The title of your post.
		  'post_status'    => $status,//[ 'draft' | 'publish' | 'pending'| 'future' | 'private' | custom registered status ]  Default 'draft'.
		  'post_type'      => 'post',//[ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ]  Default 'post'.
		  'post_author'    => $author, // The user ID number of the author. Default is the current user ID.
		  //'ping_status'    => [ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
		  //'post_parent'    => [ <post ID> ] // Sets the parent of the new post, if any. Default 0.
		  //'menu_order'     => [ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
		  //'to_ping'        => // Space or carriage return-separated list of URLs to ping. Default empty string.
		  //'pinged'         => // Space or carriage return-separated list of URLs that have been pinged. Default empty string.
		  //'post_password'  => [ <string> ] // Password for post, if any. Default empty string.
		  //'guid'           => // Skip this and let Wordpress handle it, usually.
		  //'post_content_filtered' => // Skip this and let Wordpress handle it, usually.
		  //'post_excerpt'   => [ <string> ] // For all your post excerpt needs.
		  'post_date'      => date('Y-m-d H:i:s'), // The time post was made.
		  'post_date_gmt'  => gmdate('Y-m-d H:i:s'),// The time post was made, in GMT.
		  //'comment_status' => [ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
		  'post_category'  => $category // Default empty.
		  //'tags_input'     => [ '<tag>, <tag>, ...' | array ] // Default empty.
		  //'tax_input'      => [ array( <taxonomy> => <array | string> ) ] // For custom taxonomies. Default empty.
		  //'page_template'  => [ <string> ] // Requires name of template file, eg template.php. Default empty.
	);
	$ret = wp_insert_post($post,false);
	if(empty($ret)){
		return false;
	}
	$post_id = $ret;
	//create meta
	$metas = array(
		'item_name'=>$item_name,
		'item_price'=>$item_price,
		'item_source'=>$item_source,
		'item_url'=>$item_url,
		'item_pic'=>$item_image,
		'item_info' => $item_desc,
		'poster_email'=>$email
	);
	foreach($metas as $k=>$v){
		add_post_meta($post_id,$k,$v,true);
	}
	return $post_id;



}

function item_post_add_post_read_count($post_id,$count = 1){
	$meta_key_name = 'item_post_read_count';
	$ret = get_post_meta($post_id,$meta_key_name,true);
	$number = 0;
	if(empty($ret)){
		$number = $count;
		add_post_meta($post_id,$meta_key_name,$number,true) || update_post_meta($post_id,$meta_key_name,$number);
	}else{
		$number = $ret + $count;
		update_post_meta($post_id,$meta_key_name,$number);
	}
	return $number;
}


/**
 * Extend JSON API Plugin
 *
 * More about json api: https://wordpress.org/plugins/json-api/other_notes
 */

// Add a new controller
add_filter('json_api_controllers', 'add_itempost_controller');
function add_itempost_controller($controllers) {
	// Corresponds to the class JSON_API_MyController_Controller
	$controllers[] = 'itempost';
	return $controllers;
}

// Register the source file for JSON_API_Widgets_Controller
add_filter('json_api_itempost_controller_path', 'itempost_controller_path');
function itempost_controller_path($default_path) {
	return __DIR__ . '/ItemPostController.php';
}