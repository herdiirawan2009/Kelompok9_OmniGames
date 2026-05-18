<?php
$query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
$separator = $query !== '' ? '&' : '';
header('Location: ../index.php?route=katalog' . $separator . $query);
exit;
