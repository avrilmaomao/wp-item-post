<?php
/**
 * Created by PhpStorm.
 * User: zhiliang
 * Date: 14/11/4
 * Time: 19:10
 */
class JSON_API_ITEMPOST_Controller {
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
		$ret = create_post($title,$content,'draft','',$item_name,
							'','',$item_url,'',$item_info,$email);
		if(!$ret){
			return array('status'=>'fail');
		}
		return array('status'=>'ok','data'=>$ret);

	}


}