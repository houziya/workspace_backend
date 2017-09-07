<?php
if (!defined('THINK_PATH')) exit();
$config	=	require './config.php';
//$configMain	=	require './params.php';
$array=array(
    'LOAD_EXT_CONFIG'                   =>'params',
	/* 系统缓存 */
	'DATA_CACHE_TYPE'                   => 'Redis',
	'REDIS_HOST'                        => '127.0.0.1',
	'REDIS_PORT'                        => 63790,
	'DATA_CACHE_TIME'                   => 3600,
	'USER_AUTH_ON'=>true,
	'USER_AUTH_TYPE'		=>2,		// 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY'			=>'authId_N_c116',	// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'		=>'administrator',
	'USER_AUTH_MODEL'		=>'fck',	// 默认验证数据表模型
	'AUTH_PWD_ENCODER'		=>'md5',	// 用户认证密码加密方式
	'NOT_AUTH_MODULE'		=>'Public,Reg,Crontab',		// 默认无需认证模块
	'REQUIRE_AUTH_MODULE'	=>'',		// 默认需要认证模块
	'NOT_AUTH_ACTION'		=>'',		// 默认无需认证操作
	'REQUIRE_AUTH_ACTION'	=>'',		// 默认需要认证操作
    'GUEST_AUTH_ON'			=>false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'			=>0,     // 游客的用户ID
	'SHOW_RUN_TIME'			=>false,			// 运行时间显示
	'SHOW_ADV_TIME'			=>false,			// 显示详细的运行时间
	'SHOW_DB_TIMES'			=>false,			// 显示数据库查询和写入次数
	'SHOW_CACHE_TIMES'		=>false,		// 显示缓存操作次数
	'SHOW_USE_MEM'			=>false,			// 显示内存开销
	'ONE_PAGE_RE'			=>10,           // 每页显示记录数
	'PAGE_LISTROWS'			=>10,
	'PAGE_ROLLPAGE'			=>5,
    'DB_LIKE_FIELDS'		=>'title|remark',
	'RBAC_ROLE_TABLE'		=>'think_role',
	'RBAC_USER_TABLE'		=>'think_role_user',
	'RBAC_ACCESS_TABLE'		=>'think_access',
	'RBAC_NODE_TABLE'		=>'think_node',
	'USER_AUTH_GATEWAY'		=>'/Public/login',	// 默认认证网关
	
	'TMPL_ACTION_ERROR'		=>'Tpl/Public::error', // 默认错误跳转对应的模板文件
	
	'VAR_PAGE'	=>	'p',	//分页传递参数

	//=======奖金项名称============
	'Bonus_B1'   => '奖金',
	'Bonus_B1c'  => '',   //空则显示, style="display:none;"则不显示
	'Bonus_B2'   => '服务补贴',
	'Bonus_B2c'  => '',
	'Bonus_B3'   => '推荐补贴',
	'Bonus_B3c'  => '',
	'Bonus_B4'   => '个人所得税',
	'Bonus_B4c'  => '',
	'Bonus_B5'   => '报单费',
	'Bonus_B5c'  => '',
	'Bonus_B6'   => '分红',
	'Bonus_B6c'  => ' style="display:none;"',
	'Bonus_B7'   => '理财金',
	'Bonus_B7c'  => ' style="display:none;"',
	'Bonus_B8'   => '税收',
	'Bonus_B8c'  => ' style="display:none;"',
	'Bonus_B9'   => '直推奖',
	'Bonus_B9c'  => ' style="display:none;"',
	'Bonus_B10'  => '直推奖',
	'Bonus_B10c' => ' style="display:none;"',
	'Bonus_HJ'   => '合计',
	'Bonus_HJc'  => ' style="display:none;"',
	'Bonus_B0'   => '实发',
	'Bonus_B0c'  => ' style="display:none;"',
	'Bonus_XX'   => '详细',
	'Bonus_XXc'  => '',

	//=======系统参数=========
	'System_namex'  => '新买卖宝',				//系统名字
	'System_bankx'  => '农业银行|工商银行',      //银行名字
	//'System_bankx'  => '财付通',      //银行名字
	'User_namex'    => '会员编号',
	'Nick_namex'    => '昵称',
	'Member_Level'  => '普通会员',    //会员级别名称
	'Member_Money'  => '6600|1000|3000|9000|18000|36000',             //注册金额
	'Member_Single' => '1|2|6|18|36|72',                      //会员级别单数
	
	'BAK_Data_Path'	=> 'Bak_data',	//备份数据路径
	'BAK_Zip_Path'	=> 'Bak_zip',	//压缩数据路径
	'BAK_Error_Path'=> 'ErrorLog',	//还原错误文档存储路径
	
	'Member_Get_Level'	=> 'H1|H2|H3|H4|H5|H6|H7|H8',//股东级别名称
	'Agent_Us_Name'		=> '1级微店|2级微店|3级微店',
	
	'GuPiao_first_Open'	=> '0',//首次发行数量
	
	'BANK_CODE_MAP' => array('ICBC','ABC','CCB','CMB','BOC','BCOM','CEBB','CMBC','SPDB','CIB','PSBC','GDB','ECITIC','BEA','HXB','SPABANK'),
	'BANK_NAME_MAP' => array('工商银行','中国农业银行','建设银行','招商银行','中国银行','交通银行','光大银行','中国民生银行','上海浦东发展银行','兴业银行','中国邮政','广发银行','中信银行','东亚银行','华夏银行','平安银行'),
	'BANK_IMG_MAP' => array('gongshang.gif','nongye.gif','jianshe.gif','zhaohang.gif','zhongguo.gif','jiaotong.gif','guangda.gif','minsheng.gif','shangpufa.gif','xingye.gif','youzheng.gif','guangfa.gif','zhongxin.gif','dongya.gif','huaxia.gif','pingan.gif'),
	
	
	//语言相关配置
	'LANGUAGE_FILE_NAME' => 'zh_cn',
	
	//模板常量
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => __ROOT__.'/Public',
		'__PUBLIC_COMMON__' => __ROOT__.'/Public',
	),

            //支付宝配置参数
   'alipay_config'=>array(
      'partner'=>'2088121753335903',   //这里是你在成功申请支付宝接口后获取到的PID；
      'key'=>'un11guajk06053q1ulkz8qsz9rq5n6m1',//这里是你在成功申请支付宝接口后获取到的Key
      'sign_type'=>strtoupper('MD5'),
      'input_charset'=> strtolower('utf-8'),
      'cacert'=> getcwd().'\\cacert.pem',
      'transport'=> 'http',
   ),

   'alipay'   =>array(
               //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
      //'seller_email'=>'ok***bo@126.com',
      'seller_email'=>'842***79@qq.com',
               //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
      'notify_url'=>'/Public/notifyurl', 
               //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
      'return_url'=>'/Pay/returnurl',
               //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
      'successpage'=>'/Change/FrontCode',   
               //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
      'errorpage'=>'/Change/FrontCode', 
   ),
   'CARD_PRICE'=>10,//门票价格
   'sms_uid'=>'zkwt0012',
   'sms_key'=>'8644429688ededbe22806',
   
   'sms_sign'=>'新买卖宝',
);

$params = array(
    "isburns" => 1,//是否烧伤
);
return array_merge($config,$array,$params);
?>
