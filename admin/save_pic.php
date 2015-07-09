<?php
if(@!$_GET['m_id']) $_GET['m_id'] = 1001;

$i= $_GET['m_id'];
$url = 'http://ratemyserver.net/mobs/'.$i.'.gif';
$img = 'images/mob/'.$i.'.gif';
file_put_contents($img, file_get_contents($url));

?>
<!--META HTTP-EQUIV="Refresh" CONTENT="2;URL=?m_id=<?=++$i?>"-->
<title><?=$i-1?></title>
<img src="images/mob/<?=$i-1?>.gif">