<?php
$connection = mysqli_connect('u479413.mysql.masterhost.ru', 'u479413', 's.7nSKI-9sePI', 'u479413');
mysqli_set_charset($connection, "utf8");

echo 'Zags '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and name like \'Payment screen%\''))['c'];
echo ' '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and name like \'Game\''))['c']."<br>";

echo 'Game1 '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=1 and name like \'Stub screen\''))['c'];
echo ' '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=1 and name like \'Stub payment\''))['c']."<br>";
echo 'Game2 '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=2 and name like \'Stub screen\''))['c'];
echo ' '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=2 and name like \'Stub payment\''))['c']."<br>";
echo 'Game3 '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=3 and name like \'Stub screen\''))['c'];
echo ' '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=3 and name like \'Stub payment\''))['c']."<br>";
echo 'Game4 '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=4 and name like \'Stub screen\''))['c'];
echo ' '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=4 and name like \'Stub payment\''))['c']."<br>";
echo 'Game5 '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=5 and name like \'Stub screen\''))['c'];
echo ' '.mysqli_fetch_array(mysqli_query($connection, 'SELECT count(*) as c FROM events WHERE device_id=60 and time > \'2018-03-04 16:20:00\' and data=5 and name like \'Stub payment\''))['c']."<br>";