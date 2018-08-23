<?php
/* 
*Name:QQ发送信息
*Description:使用QQ的3G部分进行操作.最后的测试于:2011年6月10日
*Author:ZY
*Email:cnyzzy@vip.qq.com
*QQ:554387970
*Ps:
*如发生失效的情况,请即时联系ZY
*ZY版权所有
*ZY945.COM
 */
echo QQsend("QQ号","密码","要发送到的QQ","发送的内容");//调用

/////////////////////////////////ZY:Begin!///////////////////////////////////////
function QQsend($qq,$pass,$toqq,$content){
$loginindex	= file_get_contents("http://pt.3g.qq.com/s?aid=nLogin3gqq");//初始化
//取sid
$pattern = '/sid=(.*?)&/';
preg_match_all($pattern,$loginindex	,$result);
$ridd = $result[0][0];
$ridd=str_replace('sid=','',$ridd);
$sid=str_replace('&','',$ridd);
//取sid结束

//取r
$pattern1 = '/r=(.*?)"/';
preg_match_all($pattern1,$loginindex,$result1);
$rr = $result1[0][0];
$rr=str_replace('r=','',$rr);
$r=str_replace('"','',$rr);
//取r结束

//登录开始
$Data = array(
					'sid' 		=> $sid,
					'qq'  		=> $qq ,
					'pwd'		=> $pass,
					'bid_code'		=> '3GQQ',
					'toQQchat'		=> 'true',
					'login_url'		=> 'http%3A%2F%2Fpt.3g.qq.com/s?aid%3DnLoginnew&q_from%3D3GQQ',
					'q_from'		=> '',
					'modifySKey'		=> '0',
					'loginType'		=> '1',
					'aid'		=> 'nLoginHandle',
				);
$login	= post($Data,"http://pt5.3g.qq.com/handleLogin?r=".$r);

//登录结束
//检测登录是否成功
if(strrpos($login,"成功") != false)
{
//OK
//取新的sid
$pattern = '/sid=(.*?)&amp/';
preg_match_all($pattern,$login	,$result);
$sidd = $result[0][0];
$sidd=str_replace('sid=','',$sidd);
$sid=str_replace('&amp','',$sidd);

//结束
//OK
}
else{
//false
return "失败";
//fasle
}


//结束


//开始回复!
$sData = array(
					'msg'  		=> $content ,
					'u'		=> $toqq,
					'saveURL'		=> '0',
					'do'		=> 'send',
					'on'		=> '1',
				);
$send	= post($sData,"http://q16.3g.qq.com/g/s?sid=".$sid."&aid=sendmsg&tfor=qq");
if($send = "消息发送成功")
{
return true;
}else{
return $send;
}

//结束!
}

/*
 *POST方式
 *By:ThinkSAAS-QiuJun
 */

		function post($arrData,$apiUrl){

			$data = http_build_query($arrData);

			$opts = array(
				'http'	=>array(
					'method'	=>"POST",
					'header'		=>"Content-type: application/x-www-form-urlencoded\r\n".
							   "Content-length:".strlen($data)."\r\n" .
							   "Cookie: foo=bar\r\n" .
							   "Content-type: text/html; charset=utf-8\r\n".
							   "\r\n",
					'content' 	=> $data,
				)
			);

			$cxContext = stream_context_create($opts);

			$Data	= file_get_contents($apiUrl,false,$cxContext);

			return $Data;
			}
/////////////////////////////////ZY:End!///////////////////////////////////////
?>