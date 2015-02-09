<?php
if(!defined('Execute') && !defined('Administartor')){ exit();}

$ext_arr = array(
	'gif', 'jpg', 'jpeg', 'png', 'bmp',
	'doc','docx','xsl','xslx','ppt','pptx',
	'zip','rar','z7'
);
$result = array('error' => 1, 'message' => '未知错误');
header('Content-type: application/json; charset=UTF-8');

foreach($_FILES as $file){
	if($file['error'] > 0){
		continue;
	}
	$filename = $file['name'];
	$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
	if(!in_array($file_ext, $ext_arr)){
		continue;
	}
	$urlname = md5(mt_rand()).'.'.$file_ext;
	$urlpath = '/file/'.date("Ymd",time());
	if(!file_exists('.'.$urlpath)){
		mkdir('.'.$urlpath);
	}
	copy($file['tmp_name'],'.'.$urlpath.'/'.$urlname);
	$result = array('error' => 0 , 'url' => $urlpath.'/'.$urlname);
}
echo json_encode($result,true);

//输出JSON字符串
?>