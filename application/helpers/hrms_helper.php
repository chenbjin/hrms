<?php 

function bing_pic()
{
	$mkt=array( "en-US", "zh-CN", "ja-JP", "en-AU", "en-UK", "de-DE", "en-NZ", "en-CA");
	$url="http://www.bing.com/HPImageArchive.aspx?format=XML&idx=".mt_rand(0,9)."&n=1&mkt=".$mkt[mt_rand(0,7)];
	$content =file_get_contents($url);
	$p = xml_parser_create();
	xml_parse_into_struct($p,$content,$vals,$index);
	xml_parser_free($p);
	$url='http://www.bing.com'. $vals[5]['value'];
	return $url;
}

