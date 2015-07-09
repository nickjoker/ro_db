<?php
$race_arg = array(0 => "Formless", 1 => "Undead", 2 => "Brute", 3 => "Plant", 4 => "Insect", 5 => "Fish", 6 => "Demon",  7 => "Demi Human", 8 => "Angel", 9 => "Dragon");

function get_element($elem)
{
	$element_arg = array(0 => "Neutral", 1 => "Water", 2 => "Earth", 3 => "Fire", 4 => "Wind", 5 => "Poison", 6 => "Holy", 7 => "Dark", 8 => "Ghost", 9 => "Undead",);
	$tmp =  $element_arg[$elem%10];
	if ($elem > 60 ) $tmp .= " (4)";
	else if ($elem > 40 ) $tmp .= " (3)";
	else if ($elem > 20 ) $tmp .= " (2)";
	else $tmp .= " (1)";
	return $tmp;
}
function percent($rate)
{
	$rate /= 100;
	return number_format($rate,2,".","");
}
function get_item_name($item_id)
{
	$sql = "SELECT `name_japanese` FROM `item_db` WHERE `id` = '$item_id'";
	$res = mysql_query($sql);
	$r = mysql_fetch_array($res);
	return $r[0];
}
?>