<?php
require_once 'config.php';

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
	$sql = "SELECT `name_japanese`, `slots` FROM `item_db` WHERE `id` = '$item_id'";
	$res = mysql_query($sql);
	$r = mysql_fetch_array($res);
	return $r[0].($r[1]?"[$r[1]]":"");
}
?>

<!doctype html>
<html lang=''>
<head>
<meta charset="UTF-8">
<title>Ro Mob db</title>
</head>
<body>
<?php
if( @$_GET['mob_id'] )
{
	$sql = "SELECT * FROM `mob_db` WHERE `ID` = '$_GET[mob_id]'";
	$res = mysql_query($sql);
	$row=mysql_fetch_array($res);
?>
<form action="" method="post">
<table border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/mob/<?=$row['ID']?>.gif"></td>
		<td>
        	<table>
            <tr>
            <td colspan="2"><?=$row['kName']?><?=$row['ID']?></td>
            <td><?=get_element($row['Element'])?> | <?=$race_arg[$row['Race']]?></td>
            </tr>
            </table>
            
            <table border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <td>Level</td><td><?=$row['LV']?></td>
                    <td>STR</td><td><?=$row['STR']?></td>
                    <td>Exp</td><td><?=number_format($row['EXP'])?></td>
                </tr>
                <tr>
                    <td>HP</td><td><?=number_format($row['HP'])?></td>
                    <td>AGI</td><td><?=$row['AGI']?></td>
                    <td>Job Exp</td><td><?=number_format($row['JEXP'])?></td>
                </tr>
                <tr>
                    <td>SP</td><td><?=number_format($row['SP'])?></td>
                    <td>VIT</td><td><?=$row['VIT']?></td>
                    <td>Size</td><td><?=$row['Scale']?></td>
                </tr>
                <tr>
                    <td>Atk</td><td><?=$row['ATK1']?>-<?=$row['ATK2']?></td>
                    <td>INT</td><td><?=$row['INT']?></td>
                    <td>Walk</td><td><?=$row['Speed']?></td>
                </tr>
                <tr>
                    <td>Def</td><td><?=$row['DEF']?></td>
                    <td>DEX</td><td><?=$row['DEX']?></td>
                    <td>Range</td><td><?=$row['Range1']?> Cell</td>
                </tr>
                
                <tr>
                    <td>mDef</td><td><?=$row['MDEF']?></td>
                    <td>LUK</td><td><?=$row['LUK']?></td>
                    <td>sRange</td><td><?=$row['Range2']?> Cell</td>
                </tr>
            </table>
		</td>
	  <td>
			<table>
            <tr>
            <td colspan="2">mode</td>
            </tr>
            <tr>
            <td>
				<input type="checkbox" value="1"<?=$row['Mode']&1?" checked":""?>>canMove<br>
                <input type="checkbox" value="128"<?=$row['Mode']&128?" checked":""?>>canAttack<br>
                <input type="checkbox" value="32"<?=$row['Mode']&32?" checked":""?>>Boss<br>
                <input type="checkbox" value="64"<?=$row['Mode']&64?" checked":""?>>plant<br>
                <input type="checkbox" value="16"<?=$row['Mode']&16?" checked":""?>>castsensor<br>
                <input type="checkbox" value="8"<?=$row['Mode']&8?" checked":""?>>assist<br>
                <input type="checkbox" value="4"<?=$row['Mode']&4?" checked":""?>>aggresive<br>
                <input type="checkbox" value="2"<?=$row['Mode']&2?" checked":""?>>looter<br>
                <input type="checkbox" value="256"<?=$row['Mode']&256?" checked":""?>>detector<br>
                <input type="checkbox" value="521"<?=$row['Mode']&512?" checked":""?>>changetarget<br>
                <!--input type="checkbox" value="8192"<?=$row['Mode']&8192?" checked":""?>>unknow1<br>
                <input type="checkbox" value="4096"<?=$row['Mode']&4096?" checked":""?>>unknow2<br>
                <input type="checkbox" value="2048"<?=$row['Mode']&2048?" checked":""?>>unknow3<br>
                <input type="checkbox" value="1024"<?=$row['Mode']&1024?" checked":""?>>unknow4<br-->
			</td>
            </tr>
            </table>

      </td>
      <td>
     	<table border="1" cellpadding="0" cellspacing="0">
        <tr>
        <td colspan="2">ดรอบไอเทม</td><td>เรท</td>
        </tr>
        <tr>
        <?php
        for($i=1;$i<10;$i++)
        {
            if($row['Drop'.$i.'id'] ==0 ) continue;
        ?>
        <td><img src="images/item/icons/<?=$row['Drop'.$i.'id']?>.png"></td><td><?=get_item_name($row['Drop'.$i.'id'])?></td><td><?=percent($row['Drop'.$i.'per'])?></td>
        </tr>
        
        <?php } ?>
        <tr>
        <td><img src="images/item/icons/<?=$row['DropCardid']?>.png"></td><td><?=get_item_name($row['DropCardid'])?></td><td><?=percent($row['DropCardper'])?></td>
        </tr>
        </table>
    	</td>
<?php
	if ( $row['Mode']&32 ) { ?>
        <td>
     	<table border="1" cellpadding="0" cellspacing="0">
        <tr>
        <td colspan="2">บอสไอเทม</td><td>เรท</td>
        </tr>
        <tr>
        <?php
        for($i=1;$i<3;$i++)
        {
            if($row['Drop'.$i.'id'] ==0 ) continue;
        ?>
        <td><img src="images/item/icons/<?=$row['MVP'.$i.'id']?>.png"></td><td><?=get_item_name($row['MVP'.$i.'id'])?></td><td><?=percent($row['MVP'.$i.'per'])?></td>
        </tr>
        <?php } ?>
        </table>
    	</td>
<?php } ?>
    </tr>
</table>
</form>
<?php
}else{
?>
<table>
<?php
$sql = "SELECT `id`, `kName`, `LV` FROM `mob_db` LIMIT 0, 10";
$res = mysql_query($sql);

while($row=mysql_fetch_array($res))
{
?>
<tr>
<td><img src="images/mob/<?=$row[0]?>.gif"></td>
<td><a href="?mob_id=<?=$row[0]?>"><?=$row[1]?></a> (<?=$row[2]?>)</td>
</tr>
<?php
}
}
?>
</table>
</body>
</html>
