<?php

$sql = "INSERT INTO news (user_id, title, text) VALUES ({$_SESSION['auth']['id']}, '{$_POST['title']}', '{$_POST['text']}')";

mysqli_query($GLOBALS['main_connection'], $sql);

header('Location: /news');
