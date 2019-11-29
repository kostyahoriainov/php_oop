<?php

$sql = "SELECT * FROM news WHERE user_id = {$_SESSION['auth']['id']} ORDER BY updated_at DESC, created_at DESC";

require_once PUBLIC_PATH . '/../views/news.phtml';
