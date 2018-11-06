<?php
//$connection = mysqli_connect('localhost', 'root', '', 'u479413');
$connection = mysqli_connect('u479413.mysql.masterhost.ru', 'u479413', 's.7nSKI-9sePI', 'u479413');
mysqli_set_charset( $connection , "utf8" );

$nonce=isset($_GET['nonce'])?'\''.$_GET['nonce'].'\'':'NULL';
$query = 'SELECT * FROM u479413.events WHERE device_id=\''.$_GET['id'].'\' and time=\''.$_GET['time'].'\' and name=\''.rawurldecode($_GET['name']).'\' and data=\''.rawurldecode($_GET['data']).'\' and nonce='.$nonce;
$result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));

if(!mysqli_num_rows($result)) {
    $query = 'INSERT INTO u479413.events (device_id, time, name, data, nonce)  VALUES (\'' . $_GET['id'] . '\',\'' . $_GET['time'] . '\',\'' . rawurldecode($_GET['name']) . '\',\'' . rawurldecode($_GET['data']) . '\',' . $nonce . ');';
    $result = mysqli_query($connection, $query) or die('Bad request1: ' . mysqli_error($connection));
}
echo 'Added';

mysqli_close($connection);