<?php

/*--------------------------------
���Žӿ���վhttp://www.sms.cn
--------------------------------*/
/*--------------------------------
����:		HTTP�ӿ� ���Ͷ���
�޸�����:	2011-03-04
˵��:		http://api.sms.cn/mt/?uid=�û��˺�&pwd=MD5λ32����&mobile=����&mobileids=������&content=����
״̬:
	100 ���ͳɹ�
	101 ��֤ʧ��
	102 ���Ų���
	103 ����ʧ��
	104 �Ƿ��ַ�
	105 ���ݹ���
	106 �������
	107 Ƶ�ʹ���
	108 �������ݿ�
	109 �˺Ŷ���
	110 ��ֹƵ����������
	112 ���벻��ȷ
	120 ϵͳ����
--------------------------------*/
$http = 'http://api.sms.cn/mt/';		//���Žӿ�
$uid = 'test';							//�û��˺�
$pwd = 'test';							//����
$mobile	 = '13900001111,13900001112,13900001113';	//����
$mobileids	 = '1390000111112345666688,139000011121112345666688,139000011131112345666688';	//����Ψһ���
$content = 'PHPHTTP�ӿ�';		//����
//��ʱ����
$res = sendSMS($http,$uid,$pwd,$mobile,$content,$mobileids);
echo $res;

//��ʱ����
/*
$time = '2010-05-27 12:11';
$res = sendSMS($uid,$pwd,$mobile,$content,$time);
echo $res;
*/
function sendSMS($http,$uid,$pwd,$mobile,$content,$mobileids,$time='',$mid='')
{
	
	$data = array
		(
		'uid'=>$uid,					//�û��˺�
		'pwd'=>md5($pwd.$uid),			//MD5λ32����,������û���ƴ���ַ�
		'mobile'=>$mobile,				//����
		'content'=>$content,			//����
		'mobileids'=>$mobileids,
		'time'=>$time,					//��ʱ����
		);
	$re= postSMS($http,$data);			//POST��ʽ�ύ
	if( trim($re) == '100' )
	{
		return "���ͳɹ�!";
	}
	else 
	{
		return "����ʧ��! ״̬��".$re;
	}
}

function postSMS($url,$data='')
{
	$row = parse_url($url);
	$host = $row['host'];
	$port = $row['port'] ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) 
	{
		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	if (!$fp) {
		return "$errstr ($errno)\n";
	} else {
		$receive = '';
		$out = "POST $file HTTP/1.1\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Content-Length: $len\r\n\r\n";
		$out .= $post;		
		fwrite($fp, $out);
		while (!feof($fp)) {
			$receive .= fgets($fp, 128);
		}
		fclose($fp);
		$receive = explode("\r\n\r\n",$receive);
		unset($receive[0]);
		return implode("",$receive);
	}
}
?>
