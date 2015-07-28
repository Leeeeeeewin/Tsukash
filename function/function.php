<?php


/**
 * 函数扩展
 */

/**
 * 打印输出数据|show的别名
 * @param void $var
 */
function p($var)
{
    if (is_bool($var)) {
        var_dump($var);
    } else if (is_null($var)) {
        var_dump(NULL);
    } else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
    }
}

/**
 * 获得扩展模型
 * @param       $name  模型名不加Model后缀
 * @param bool $full 是否为全表名
 * @param array $param 参数
 * @return mixed
 */
function K($name, $full = null, $param = array(), $driver = null)
{
    $class = ucfirst($name) . "Model";
    return new $class(strtolower($name), $full, $param);
}


/**
 * [alertDiv 提示页面]主要是前台页面展示，自定义div
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function alertDiv($name,$url){
    header("Content-Type: text/html; charset=utf-8");
    echo "<html style='background:url(/Public/admin/img/backgrounds/bg.jpg); background-size: cover;' ><body style='background:url(/Public/admin/img/backgrounds/bg.jpg);background-size: cover;'><div style='width:400px;height:200px;position:absolute;top:50%;left:50%;margin-top:-100px;margin-left:-200px;background:#fff;font-size:20px;color:#428BCA;border:2px solid #428BCA;line-height:30px;z-index:999999;'><div style='width:100%;height:50px;background:#428BCA;color:#fff;text-align:center;font-size:20px;line-height:50px;text-align:left;'> &nbsp;温馨提示</div><div style='padding:10px 5px 0 5px;'>".$name."</div></div><div style='width:100%;height:100%;background:none; position:absolute; z-index:1;top:0;left:0;z-index:9999;'></div></body></html>";
    echo "<meta http-equiv=\"refresh\" content=\"1; url='".$url."'\">";

 
}


/**
 * [alertDiv 提示页面2]手机页面提示，依附于jQuery->AmazeUI实现手机端自适应跳转页面
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function alertDiv_phone($name,$url){
    header("Content-Type: text/html; charset=utf-8");
	echo "<meta http-equiv=\"refresh\" content=\"1; url='".$url."'\">";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="/Public/AmazeUI-2.3.0/assets/css/amazeui.min.css">';
    echo '<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="modall"><div class="am-modal-dialog"><div class="am-modal-hd">'.$name.'</div><div class="am-modal-bd"><span class="am-icon-spinner am-icon-spin"></span></div></div></div>';
	echo '<script src="/Public/AmazeUI-2.3.0/assets/js/jquery.min.js"></script><script src="/Public/AmazeUI-2.3.0/assets/js/amazeui.js"></script>';
    echo '<script>$(function(){$("#modall").modal()})</script>';
}

/**
 * 邮件发送函数
 */
function sendMail($to, $title, $content) {
 
    // Vendor('PHPMailer.PHPMailerAutoload');     
    vendor('phpmailer.class#phpmailer');
    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户,你的密码是");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}