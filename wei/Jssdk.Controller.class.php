<?php
namespace Home\Controller;
use Think\Controller;
class JssdkController extends Controller {

    private function appid(){
        return 'wxf2*********846d';
    }

    private function secret(){
        return '8bf969***************97f397a3da72';
    }


    public function wx_get_token() {
        $token = S('access_token');
        if (!$token) {
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret.'');
            $res = json_decode($res, true);
            $token = $res['access_token'];
            // access_token 应该全局存储与更新
            S('access_token', $token, 7000);
        }
        return $token;
    }

    public function wx_get_jsapi_ticket(){
        $ticket = "";
        do{
            $ticket = S('wx_ticket');
            if (!empty($ticket)) {
                break;
            }
            $token = S('access_token');
            if (empty($token)){
                $this->wx_get_token();
            }
            $token = S('access_token');
            if (empty($token)) {
                logErr("get access token error.");
                break;
            }
            $url2 = sprintf("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi",
                    $token);
            $res = file_get_contents($url2);
            $res = json_decode($res, true);
            $ticket = $res['ticket'];
            // 注意：这里需要将获取到的ticket缓存起来（或写到数据库中）
            // ticket和token一样，不能频繁的访问接口来获取，在每次获取后，我们把它保存起来。
            S('wx_ticket', $ticket, 7000);
        }while(0);
        return $ticket;
    }



    public function index(){
        // echo "1";die;
        $this->display();
    }

/**
 * 随机数
 * @param  [type] $length [description]
 * @return [type]         [description]
 */
    function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
    
        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];
        }
    
        return $str;
    }

    public function share(){
        $url = I('url');
        // p($url);
        $url = urldecode($url);
        $timestamp = time();
        $wxnonceStr = $this->getRandChar(5);
        $wxticket = $this->wx_get_jsapi_ticket();
        // p($wxticket);
        $wxOri = sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s",
                $wxticket, $wxnonceStr, $timestamp,$url
        );
        $wxSha1 = sha1($wxOri);
        $this->ajaxReturn(array('status'=>1,'timestamp'=>$timestamp,'nonceStr'=>$wxnonceStr,'signature'=>$wxSha1,'url'=>$url));
    }

}