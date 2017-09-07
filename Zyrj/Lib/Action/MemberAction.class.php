<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 23:32
 */
class MemberAction extends CommonAction
{
    public function _initialize()
    {
        parent::_initialize();
        header("Content-Type:text/html; charset=utf-8");
        $this->_inject_check(0);//调用过滤函数
        $this->_checkUser();
    }

    //会员商城
    public function shops(){
        $this->distheme("shops","会员商城");
        //$this->display();
    }
}
?>