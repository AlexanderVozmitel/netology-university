<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	function Parse($p1, $p2, $p3) 
	{
		$num1 = strpos($p1, $p2);
		if ($num1 === false) return 0;
		$num2 = substr($p1, $num1);
		return (substr($num2, 0, strpos($num2, $p3)));
	}
	$json = array();
	if ($_GET['id']) 
	{
		$result = file_get_contents('https://habrahabr.ru/post/'.$_GET['id'].'/');
		$json['title'] = Parse($result, '<meta property="og:title"       content="', '" />');
		$json['title'] = str_replace('<meta property="og:title"       content="', '', $json['title']);
		$json['text'] = Parse($result, 'property="og:description" content="', '" />');
		$json['text'] = str_replace('property="og:description" content="', '', $json['text']);
		
		$json['date'] = strip_tags(Parse($result, '<span class="post__time_published">', '</span>'));
		$json['date'] = str_replace("\n", '', $json['date']);
		$json['date'] = str_replace("     ", "", $json['date']);
		$json['date'] = str_replace("  ", "", $json['date']);
		
		$json['rating'] = strip_tags(Parse($result, '<span class="voting-wjt__counter-score js-score"', '</span>'));
		$json['stars'] = strip_tags(Parse($result, '<span class="favorite-wjt__counter js-favs_count"', '</span>'));
		$json['views'] = strip_tags(Parse($result, '<div class="views-count_post"', '</div>'));
		
		$json['tags'][] = strip_tags(Parse($result, '<a href="/sandbox/"', '</a>'));
		$json['tags'][] = strip_tags(Parse($result, '<span class="flag flag_tutorial"', '</span>'));
	}
	else 
	{
		$json['status'] = 'error';
	}
	echo json_encode($json);
	//var_dump($json);
	
?>