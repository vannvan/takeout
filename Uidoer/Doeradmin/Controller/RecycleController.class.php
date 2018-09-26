<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class RecycleController extends BaseController{
		public function index(){
			$map['status']=array('eq',-1);
			$banner=M("Banner")->where($map)->count('id');
			$merchants=M("merchants")->where($map)->count('id');
			$product=M("product")->where($map)->count('id');
			$feedback=M("feedback")->where($map)->count('id');
			$userinfo=M("userinfo")->where($map)->count('id');
			$notice=M("notice")->where($map)->count('id');
			$help=M("help")->where($map)->count('id');
			$message=M("message")->where($map)->count('id');

			$count['banner']=$banner;
			$count['merchants']=$merchants;
			$count['product']=$product;
			$count['feedback']=$feedback;
			$count['userinfo']=$userinfo;
			$count['notice']=$notice;
			$count['help']=$help;
			$count['message']=$message;
			$this->assign('count',$count);
			$this->display();
		}
		// banner相关操作
		public function banner(){
			$map['status']=array('eq',-1);
			$banner=M('Banner')->where($map)->order('id')->select();
			$this->assign(rows,$banner);
			$this->display();
		}
		public function Breback(){
			$id=I('get.id');
			$map['id']=$id;
			$data['status']=1;
			$rst=M('Banner')->where($map)->save($data);
			if($rst){
				return show(1,'恢复成功');
			}else{
				return show(0,'恢复失败');
			}
		}
		public function Bdel(){
			$id=I('get.id');
			$map['id']=$id;
			$data['status']=1;
			$rst=M('Banner')->where($map)->save($data);
			if($rst){
				return show(1,'删除成功');
			}else{
				return show(0,'删除失败');
			}
		}
		public function merchants(){
			$map['status']=array('eq',-1);
			$merchants=M('merchants')->where($map)->field('id,name,image,labelimg')->select();
			$this->assign(rows,$merchants);
			$this->display();
		}

		public function product(){
			$map['status']=array('eq',-1);
			$product=M('product')->where($map)->field('id,name,price,content')->select();
			$this->assign(rows,$product);
			$this->display();
		}

		public function feedback(){
			$map['status']=array('eq',-1);
			$feedback=M('feedback')->where($map)->field('id,content,addtime')->select();
			$this->assign(rows,$feedback);
			$this->display();
		}

		public function userinfo(){
			$map['status']=array('eq',-2);
			$userinfo=M('userinfo')->where($map)->select();
			$this->assign(rows,$userinfo);
			$this->display();
		}

		public function notice(){
			$map['status']=array('eq',-1);
			$notice=M('notice')->where($map)->field('id,title,addtime')->select();
			$this->assign(rows,$notice);
			$this->display();
		}

		public function help(){
			$map['status']=array('eq',-1);
			$help=M('help')->where($map)->field('id,title,addtime')->select();
			$this->assign(rows,$help);
			$this->display();
		}

		public function message(){
			$map['status']=array('eq',-1);
			$message=M('message')->where($map)->select();
			$this->assign(rows,$message);
			$this->display();
		}
}