#function.php
会持续更新的函数扩展，自己平时工作需要，慢慢积累

	/**
	 * 打印，相当于 dump()
	 * 只是更耐看一些
	 * @return {[type]} [description]
	 */
	public function index(){
		p('打印');
	}




	/**
	 * 弹出框
	 * 自定义跳转页面弹框
	 * @return {[type]} [description]
	 */

	public function index(){
		$name = 'success/error';
		$url = 'url';
		if('手机端'){
			alertDiv_phone($name,$url);
		}else{
			//电脑端
			alertDiv($name,$url);
		}
	}



	/**
	 * 发送邮件
	 * 参考文件夹里面的 Library/Vendor/phpmailer
	 * @return {[type]} [description]
	 */

	public function send_email(){
		$sendEmail = '562882813@qq.com';
	    $title = '中电国际展览信息平台,确认您的密码';
	    $content = "避免泄漏您的密码，请确认您现在的密码 ".I('post.password')." 后进行删除邮件";
	    sendMail($sendEmail,$title,$content);
	}