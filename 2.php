<?php
define("FILEROOT","e:/webproject/bookmamger-with-ireader");
ob_start();

$filename = FILEROOT.'/test.txt';
//$handle = fopen($filename, 'a');
for($i=8791;$i<8802;$i++)
{
	$bookinfo=file_get_contents('http://wap.16kbook.org/Wap/Book/Show.aspx?id='.$i.'&lmid=0&uid=0&ups=0');

	$smstart=strpos($bookinfo,'title="',1)+7;
	$smend=strpos($bookinfo,'"',$smstart);
	$sm=substr($bookinfo,$smstart,$smend-$smstart);

	$zsstart=strpos($bookinfo,'完成:',1)+6;
	$zsend=strpos($bookinfo,'千字',$zsstart);
	$zs=substr($bookinfo,$zsstart+1,$zsend-$zsstart-1);
	echo  str_pad('<div>'.$sm.'-'.$zs.'000</div>',4096 );

	//fwrite($handle, $zs.'<br/>');
	ob_flush();
    flush();
    sleep(1);
} 
//fclose($handle);