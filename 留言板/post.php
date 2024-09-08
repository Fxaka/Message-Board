<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<title>发布页</title>
<link rel="stylesheet" type="text/css" href="post.css">
</head>
<body>
    <div class="background-image"></div>
    <div class="container">
        <h1>看看大家的留言</h1>
    <?php  
// 数据库连接信息  
$db_host = "localhost";  // 数据库服务器地址  
$db_user = "root";       // 数据库用户名  
$db_password = "123456789"; // 数据库密码  
$db_name = "message board"; // 数据库名  
  
// 创建数据库连接  
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);  
  
// 检查数据库连接是否成功  
if ($mysqli->connect_error) {    
    die("连接失败: " . $mysqli->connect_error);  // 如果连接失败，输出错误信息并终止脚本  
}  
  
// 准备SQL查询语句  
$sql = "SELECT * FROM message_store"; // 从message_store表中选取所有记录  
  
// 执行SQL查询  
$result = $mysqli->query($sql);  
  
// 检查查询是否成功执行  
if ($result) {  
    // 如果查询成功，遍历结果集  
    while ($row = $result->fetch_object()) { // 使用fetch_object()将每行结果作为对象返回  
        // 输出每个消息作为一个单独的<article>元素  
        echo '<article class="message">'; // 开始<article>元素  
        echo "<h3>". htmlspecialchars($row->UserName) . " " . htmlspecialchars($row->Created_at) . "</h3>"; // 输出用户名和创建时间  
        echo "<p>". htmlspecialchars($row->Content) . "</p>"; // 输出内容  
        echo '</article>'; // 结束<article>元素  
    }  
    // 释放结果集内存  
    $result->free();  
} else {  
    // 如果查询失败，输出错误信息  
    echo "查询失败: " . $mysqli->error;  
}  
  
// 关闭数据库连接  
$mysqli->close();  
?>
   </div>
    </body>

    
