<?php
session_start();
$client_id = 'وهنا برضو id';
$redirect_uri = 'http://yourdomain.com/github_callback.php';
$scope = 'user';
header("Location: https://github.com/login/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope");
exit();
?>