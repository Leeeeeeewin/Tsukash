<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
  private $app_id = 'wx**********234d6d';

  private $app_secret = 'a0545d***************e4833d9558';

  public  function code_callback(){
  	if (cookie('uid')) {
  		$this->redirect('Index/index');
  	}
    $code = I('code');
      if(empty($code)){
        $redirect_uri = urlencode("http://58lazy.activity.11space.cn/Home/Index/callback");
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header("Location:$url");
      }else{
        $this->callback();
      }

  }

  public function callback(){
    $refresh_token = session('refresh_token');
    $code = I('get.code');
    if (!$refresh_token) {
            if (!$code) {
                $this->redirect('Index/code_callback');
            }
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->app_id."&secret=".$this->app_secret."&code=".$code."&grant_type=authorization_code";
            $json_content = file_get_contents($url);
            $json_obj = json_decode($json_content, true);
            $access_token = $json_obj['access_token'];
            $openid = $json_obj['openid'];
            session(array('name'=>'access_token_id', 'expire'=>$json_obj['expires_in']));
            session('refresh_token', $json_obj['refresh_token']);
        }else {
            $url ="https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$this->app_id."&grant_type=refresh_token&refresh_token=".$refresh_token;
            $json_content = file_get_contents($url);
            $json_obj = json_decode($json_content, true);
            $access_token = $json_obj['access_token'];
            $openid = $json_obj['openid'];
        }

        $userinfostr = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
        $userinfo = json_decode($userinfostr, true);



        dump($userinfo);die;
       
        
        
  }




    public function index(){
        $this->display();
    }





}