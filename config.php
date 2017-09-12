<?php
return array(
    	'URL_MODEL'=>2, // 如果你的环境不支持PATHINFO 请设置为3
	'URL_PATHINFO_MODEL'=>2,
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'123.206.8.56',      //数据库地址
	'DB_NAME'=>'maimaibao',             //数据库用户名
	'DB_USER'=>'maimaibao_reads',         //数据库名
        //'DB_USER'=>'root',         //数据库名
	//'DB_PWD'=>'327493dbe08dab4707ecf4005f2aa198',         //数据库密码
	'DB_PWD'=>'308a2efa87020d75667b1696af72e086',         //数据库密码
        //'DB_PWD'=>'',         //数据库密码
	'DB_PORT'=>'3306',       //数据库端口
	'DB_PREFIX'=>'zyrj_',   //数据库前缀
	'DATE_Expired'=>'2015-7-22', //留空时提示测试提示，正式时输入正式的日期（如：2014-8-20）,提前一个月后提醒管理员续费。
	'TMPL_CACHE_ON' => false,
        'APP_DEBUG'=>true,
        'DB_FIELD_CACHE'=>false,
        'HTML_CACHE_ON'=>false
)
?>
