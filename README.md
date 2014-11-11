###商品推荐接口（在后台添加一篇草稿）

地址：json=itempost/create
参数：
item_name 商品名称
item_info 必选 商品描述（推荐理由）
item_url  必选  商品链接
email   推荐人邮箱

###增加阅读数
地址：json=itempost/read
参数：
	post_id  必选 文章id 

返回最新的阅读数

在文章信息里的custom_fields里对应
item_post_read_count
