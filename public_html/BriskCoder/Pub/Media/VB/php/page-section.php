<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	include("class_html_dom.php");
	function getGuid(){
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	$content = file_get_contents('http://localhost/templates/_View/Home.html');
	$header = file_get_contents('http://localhost/templates/_View/_inc/header.html');
	$footer = file_get_contents('http://localhost/templates/_View/_inc/footer.html');
	$html = str_get_html($content);
	$main = $html->find('body')[0]->outertext();
	$block = array(
		array('id' => getGuid(), url => '', html => $header),
		array('id' => getGuid(), url => '', html => $content),
		array('id' => getGuid(), url => '', html => $footer));
	$page_arr = array(
		"blockList"	=>	$block,
		"screen" => "desktop"
	);
	exit(json_encode($page_arr));
?>