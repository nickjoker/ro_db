<?php
require_once '../config.php';
require_once '../CMySql.php';
require_once '../function.php';

//$_POST = $_GET;
if( @$_POST['m_id']){
}else{
	$limit = $_POST['limit'];
	$page = $_POST['page'];
	$search_str = @$_POST['str'];
	
	if(@strlen($_POST['str']) ) $search_str = "`kName` like '".$_POST['str']."%'";
	$cmysql = new CMySql($host, $user, $pass);
	$res = $cmysql->select($db_game,"mob_db","`id`, `kName`, `LV`", $search_str);
	$num_row = $cmysql->num_rows();
	$t_data["all_rows"] = $num_row;
	$t_data["max_page"] = ceil($num_row / $limit);
	
	if( $num_row ){
		$row= $cmysql->select($db_game,"mob_db","`id`, `kName`, `LV`", $search_str,null, ($page-1)*$limit.", ".$limit);
	
		$t_data["msg"] = "";
		//while($row=mysql_fetch_array($res))
		$c = count($row);
		for($i=0; $i < $c; $i++)
			$t_data["msg"] .= '<tr><td class="text-center"><img src="images/mob/'.$row[$i]['id'].'.gif"><br>'.$row[$i]['id'].'</td><td class="text-center vert-align"><a href="?mob_id='.$row[$i]['id'].'">'.$row[$i]['kName'].'</a> ('.$row[$i]['LV'].')</td></tr>';
	
		$t_data["msg"] = '<table class="table table-bordered table-hover"><thead><tr><th class="text-center">Pic</th><th class="text-center">Name (Level)</th></tr></thead><tbody>'.$t_data["msg"] ."</tbody></table>";
	}
	else
		$t_data["msg"] = '<table class="table table-bordered table-hover"><thead><tr>
		<th class="text-center">Pic</th><th class="text-center">Name (Level)</th></tr></thead>
		<tbody><tr><td colspan="2" class="text-center">Not Found</td></tr></tbody</table>';
	$t_data["info"] = "Showing ". ((($page-1)*$limit)+1) ." to ".($page)*$limit. " of ".$num_row." rows";
	echo json_encode($t_data);
}
?>