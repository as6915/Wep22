<?php
$github_username = $_POST['github_username'];
$github_token = $_POST['github_token'];
$url = "https://api.github.com/user/repos";
$options = array(
    'http' => array(
        'header'  => "User-Agent: GitHub API Request\r\nAuthorization: token " . $github_token,
        'method'  => 'GET'
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo "فشل في جلب المشاريع. تأكد من البيانات.";
} else {
    $repos = json_decode($result, true);
    echo "<h3>مشاريعك:</h3>";
    echo "<ul>";
    foreach ($repos as $repo) {
        echo "<li>" . $repo['name'] . " - <a href='" . $repo['html_url'] . "' target='_blank'>عرض على GitHub</a></li>";
    }
    echo "</ul>";
}
?>