<?php


session_start();
if(isset($_POST['title'])&&isset($_POST['content'])){
	if(empty($_POST['title'])&&empty($_POST['content'])){
		echo '输入的标题或内容为空！</a>';
		echo '<a href=add.html>返回</a>';
		exit;
	}
	$title=$_POST['title'];
	$content=$_POST['content'];
}
$user_name=$_SESSION['user_name'];
$time=date('Y-m-d H:i:s');




//连接数据库

@$conn=mysql_connect('localhost','root','');
mysql_query('set names utf8');
mysql_select_db('tm_blog');

//获取user表中的user_id值
// $sql="select user_id from where user_name="."'".$_SESSION['user_name']."'";

// $result=mysql_query($sql);
// if(!$result){
// 	echo '出现异常！';
// 	echo '<a href=add.html>重新添加<a>';
// }

// $num=mysql_fetch_assoc($result);
// $user_id=$num['user_id'];
$user_id=$_SESSION['user_id'];


//向数据库中添加内容

$sql="insert into tb_daily(user_id,user_name,title,content,time) values(".$user_id.",'".$user_name."','".$title."','".$content."','".$time."')";

$result=mysql_query($sql);
if(!$result){
	echo '出现异常！';
	echo '<a href=add.html>重新添加<a>';
}
else{
	header('location:glance.php');
}

?>