<?php
session_start();
$conn = new mysqli('localhost', 'اسم_المستخدم', 'كلمة_المرور', 'اسم_قاعدة_البيانات');

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "كلمة المرور غير صحيحة.";
    }
} else {
    echo "اسم المستخدم غير موجود.";
}

$conn->close();
?>