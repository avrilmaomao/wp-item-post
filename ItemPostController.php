<?php
/**
 * Created by PhpStorm.
 * User: zhiliang
 * Date: 14/11/4
 * Time: 19:10
 */
class JSON_API_ITEMPOST_Controller {

	const DEFAULT_CATEGORY = 9;

	public function test(){
		return 'This is a test';
	}

	public function create(){
		global $json_api;
		$title = $json_api->query->item_name;
		$content = $json_api->query->item_info;
		$item_name = $json_api->query->item_name;
		$item_info = $json_api->query->item_info;
		$item_url = $json_api->query->item_url;
		$email = $json_api->query->email;
		if(empty($content) || empty($item_url)){
			return array('status'=>'fail','data'=>'missing param');
		}
		if(empty($title)){
			$title = sprintf('【用户投稿】-%s',date('Y-m-d H:i:s'));
		}
		$ret = item_post_create_post($title,$content,'draft','',$item_name,
							'','',$item_url,'',$item_info,$email,array(self::DEFAULT_CATEGORY));
		if(!$ret){
			return array('status'=>'fail');
		}
		return array('status'=>'ok','data'=>$ret);

	}
	public function read(){
		global $json_api;
		$post_id = $json_api->query->post_id;
		if(empty($post_id)){
			return array('status'=>'fail','data'=>'missing param');
		}
		$ret = item_post_add_post_read_count($post_id);
		return array('status'=>'ok','data'=>$ret);
	}

}