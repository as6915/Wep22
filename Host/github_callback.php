<?php
session_start();
$client_id = 'YOUR_GITHUB_CLIENT_ID';
$client_secret = 'YOUR_GITHUB_CLIENT_SECRET';
$redirect_uri = 'http://yourdomain.com/github_callback.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    $token_url = 'https://github.com/login/oauth/access_token';
    $post_fields = http_build_query(array(
        'client_id' => $Elakreb,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri
    ));
    
    $response = file_get_contents($token_url, false, stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $post_fields
        )
    )));
    
    parse_str($response, $response_params);
    $access_token = $response_params['access_token'];
    
    
    $user_url = 'https://api.github.com/user';
    $user_response = file_get_contents($user_url, false, stream_context_create(array(
        'http' => array(
            'header' => "Authorization: token $access_token\r\nUser-Agent: MyApp"
        )
    )));
    
    $user = json_decode($user_response, true);
    
    $conn = new mysqli('localhost', 'اسم_المستخدم', 'كلمة_المرور', 'اسم_قاعدة_البيانات');
    
    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }
    
    $username = $user['login'];
    $email = $user['email'];
    $github_id = $user['id'];
    
    $sql = "INSERT INTO users (github_id, username, email) VALUES ('$github_id', '$username', '$email')
            ON DUPLICATE KEY UPDATE username='$username', email='$email'";
    
    if ($conn->query($sql) === TRUE) {
        echo "تم تسجيل الدخول بنجاح! <br>";
        echo "مرحبا بك، $username! <br>";
        echo "<img src='{$user['avatar_url']}' alt='GitHub Profile Picture' style='border-radius: 50%; width: 100px; height: 100px;'><br>";
        echo "يمكنك الآن إدارة مشاريعك عبر <a href='dashboard.php'>لوحة التحكم</a>.";
    } else {
        echo "حدث خطأ أثناء تسجيل الدخول. إذا استمرت المشكلة، يرجى التواصل مع المطور";
    }
    
    $conn->close();
} else {
    echo "لم يتم توفير رمز التحقق. يرجى محاولة تسجيل الدخول مرة أخرى.";
}
?>