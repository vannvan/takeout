<?php
namespace Home\Controller;
use Think\Controller;
class SignController extends Controller {
    public function signin(){
    	$Sign=M("Sign");
        //当前日期,用来计算用户当前签到时间和上次签到时间差
        $curtime=date("Y-m-d");
    	//当前日期最后时间
        $nowtime=date("Y-m-d 23:59:59");
        //前一天最后时间
        $yestime=date("Y-m-d 23:59:59",strtotime("-1 day"));
    	$data=I('post.');
    	$userid=$data['userid'];
    	$map['userid']=$userid;
    	$data['signdate']=time();
    	$rst=$Sign->where($map)->create();
    	//当前用户在数据表是否有记录
    	$userinfo=$Sign->where($map)->find();
    	if($userinfo==null){
            //用户无签到记录，第一次签到积分加3
    		$data['userid']=$userid;
    		$rst=$Sign->create($data);
    		$rst=$Sign->add();
    		$map['userid']=$userid;
    		M('Sign')->where($map)->setInc('signtime');//签到次数加一
            M('Sign')->where($map)->setInc('integral',3);//积分加3
            return show(1,'首次签到，爱豆+3');
    	}else if($userinfo!=null){
    		$map['userid']=$userid;
    		$signdate=$Sign->where($map)->getField('signdate');
    		$Thesigndate=date('Y-m-d H:i:s', $signdate);//用户上次签到时间
            if($Thesigndate > $yestime && $Thesigndate < $nowtime){
            	return show(2,'你今天已经签过啦');
            }else{
                //用户连续签到相隔天数，大于3天加1，在1到3天之内加2，一天加3
                //两日期相隔天数
                $signdate1=date('y-m-d',$signdate);
                $day=diffBetweenTwoDays($curtime,$signdate1);
                if($day>=3){
                    $map['userid']=$userid;
                    $rst=$Sign->where($map)->save($data);
                    M('Sign')->where($map)->setInc('signtime');//签到次数加一
                    M('Sign')->where($map)->setInc('integral');//积分加1 
                    return show(1,'签到成功,爱豆+1');
                }elseif($day>1&&$day<3) {
                    $map['userid']=$userid;
                    $rst=$Sign->where($map)->save($data);
                    M('Sign')->where($map)->setInc('signtime');//签到次数加一
                    M('Sign')->where($map)->setInc('integral',2);//积分加2 
                    return show(1,'签到成功,爱豆+2');
                }else{
                    $map['userid']=$userid;
                    $rst=$Sign->where($map)->save($data);
                    M('Sign')->where($map)->setInc('signtime');//签到次数加一
                    M('Sign')->where($map)->setInc('integral',3);//积分加3
                    return show(1,'签到成功,爱豆+3');
                }	
            }   
    	}else{
    		return show(0,'签到失败');
    	}    
    }
}