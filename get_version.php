<?php
//$connection = mysqli_connect('localhost', 'root', '', 'u479413');
$connection = mysqli_connect('u479413.mysql.masterhost.ru', 'u479413', 's.7nSKI-9sePI', 'u479413');

$query = 'SELECT * FROM versions WHERE branch = \''.$_GET['branch'].'\'';
$result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));

if(mysqli_num_rows($result))
{
    $data = mysqli_fetch_array($result);
    echo $data['last_version'];
} else {
    echo'Unknown branch';
}
mysqli_close($connection);
?>