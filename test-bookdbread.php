<a href="menu.php">back</a>
<form action="test-bookdbread.php" >
	阅读百分比<
	<input type="text" name="readprogress">

	文件存在性检测
	<select name="readfile" id="">
		<option value="1">yes</option>
		<option value="0" selected='true'>no</option>
	</select>
	<input type="submit">
</form>
<?php
date_default_timezone_set('Asia/Shanghai'); 
define("FILEROOT","e:/webproject/bookmamger-with-ireader");
if ((isset($_GET['readprogress']))&&($_GET['readprogress']>0))
{$readprogress=$_GET['readprogress']*0.01;}
else
{$readprogress=0.1;}
if (isset($_GET['readfile']))
{$readfile=$_GET['readfile']>0;}
else
{$readfile=false;}
  try {
  $dbh = new PDO('sqlite:'.FILEROOT.'/bookdb.sqlite');
  $q=$dbh->query('
  SELECT 
  book_filepath,
  book_readtotalprogress,
  book_downloaddate
  from books 
  where '." 
  book_readtotalprogress <=  ".$readprogress.
  " order by book_downloaddate desc");
//echo  var_dump(html_entity_decode(htmlentities('e:/webproject/temp/bookfiles/某妹子英灵的综漫游.umd',ENT_QUOTES,'UTF-8'),ENT_QUOTES,'936'));
  ?>
  <table>
	<tr>
		<td>名称</td>
		<td>阅读进度</td>
		<td>添加时间</td>
		<td>文件有效性</td>
	</tr>

  <?php
	 foreach ($q->fetchAll() as $row) {
	  clearstatcache();

		if (($readfile)&&(file_exists(iconv('utf-8', 'gbk', FILEROOT.'/bookfiles/'.$row['book_filepath'])))){}
		

		else
			{echo '<tr>';
		echo '<td>'.$row['book_filepath'].'</td>';
		echo '<td>'.($row['book_readtotalprogress']*100).'% </td>';
		echo '<td>'.(date('y-m-d',strtotime($row['book_downloaddate']))).' </td>';
		
			echo '<td>'.'x'.'</td>';
		echo'</tr>';}
  }
  ?>
  </table>
  <?php
  $dbh = null;
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
  ?>