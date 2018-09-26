<?php
use Think\Controller;
	function Code(){
        $config =    array(
        'fontSize'    =>    30,    // 验证码字体大小
        'length'      =>    4,     // 验证码位数
        //'useImgBg' => true,     //背景
        //'useZh' => true,          //启用中文字体
        //'fontttf' => 'zw.ttf',      //字体
        //'zhSet' => '大梦想家每个人都是大梦想家',
        'bg'      => array(200,200,200),
        );
         $Verify = new \Think\Verify($config);
         $Verify->entry();
        //create_verify_code($config);
        }
    //验证码验证
    function check_code($code,$id=''){
	  		$verify = new \Think\Verify();
	        return $verify->check($code,$id);
		}
    //价格格式化
	function format($price){
        return "<b>".number_format($price,2)."</b>";
    }
    //用于表单中的价格格式化
    function format1($price){
        return number_format($price,2);
    }
    