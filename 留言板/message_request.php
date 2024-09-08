<?php  
session_start();  
  
// 检查用户是否已登录  
if (!isset($_SESSION['UserID'])) {  
    header("Location: index.php"); // 重定向到登录页面  
    exit;  
}  
  
// 获取用户ID和用户名（从session中）以及留言内容（从POST请求中）在登录脚本中已经设置过session了  
$userID = $_SESSION['UserID']; // 注意变量名的设置要在脚本中保持一致
$userName = $_SESSION['UserName']; 
$content = isset($_POST['message']) ? trim($_POST['message']) : '';  //检查 POST 请求中是否存在名为 'message' 的字段，并且如果存在，则去除该字段值两端的空白字符（如空格、换行符等），然后将处理后的值赋给变量 $content
  
// 输入验证  
if (empty($content)) {  
    header("Location: error.php?msg=留言内容不能为空"); // 重定向到错误页面  
    exit;  
}  
  
// 数据库连接信息  
$db_host = "localhost";  
$db_user = "root";  
$db_password = "123456789";  
$db_name = "message board"; // 注意：这里使用了 message_board 作为数据库名  
  
// 创建数据库连接  
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);  
  
// 检查连接  
if ($mysqli->connect_error) {  
    die("连接失败: " . $mysqli->connect_error);  
}  
  
// 准备SQL语句（注意：这里不需要为ID指定值，因为它是自增的）  
$sql = "INSERT INTO message_store (User_id, UserName, Content, Created_at) VALUES (?, ?, ?, NOW())";  
  
// 预处理SQL语句  
$stmt = $mysqli->prepare($sql);  
  
// 绑定参数（注意：这里使用了正确的变量名）  
$stmt->bind_param("iss", $userID, $userName, $content); // 使用 $userID, $userName, $content (定义变量名在接收的session那里)
  
// 执行预处理语句  
if ($stmt->execute()) {  
    // 如果执行成功，则重定向到成功页面  
    header("Location: post.php?msg=留言发布成功");  
} else {  
    // 如果执行失败，则处理错误  
    echo "错误: " . $stmt->error;  
}  
  
// 关闭预处理语句和数据库连接  
$stmt->close();  
$mysqli->close();  
?>