<?php
session_start();  //设置session


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $UserName = $_POST["UserName"];
    $PassWord = $_POST["PassWord"];


$db_host = "localhost";
$db_user = "root";
$db_password = "123456789";
$db_name = "message board";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
$mysqli->query("set names utf8");

$sql = "SELECT * FROM user WHERE UserName = ? AND PassWord = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $UserName, $PassWord);

$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_object()){
    $_SESSION["UserID"] = $user->ID; //存储用户id
    $_SESSION["UserName"] = $user->UserName;  //存储用户的用户名
    header("Location:message.php"); 
}
else 
{
    header("Location:index.php");
}

$stmt->close(); 
$mysqli->close();
}

/*关于session的用法:
在用户登录前设置"session_start();"用来开启会话
等到用户输入完毕,确认登录成功后,使用"$_SESSION["UserID"] = $user->ID;"类似的语句进行session的存储
到这一步基本的session就设置完毕了*/
?>

