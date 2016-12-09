<?php
//验证用户是否存在
session_start();

if(isset($_POST['account'])&&isset($_POST['passwd'])){

	
	if(empty($_POST['account'])){

		echo "您输入的用户名为空，请重新输入！";
		echo "<a href=auth.html>返回登录界面</a>";
		exit;
	}
	else if(empty($_POST['passwd'])){

		echo "您输入的密码为空，请重新输入！";
		echo '<a href=auth.html>返回登录界面</a>';
		exit;
	}
	$account=trim($_POST['account']);
	$passwd=trim($_POST['passwd']);

}

@$conn=mysql_connect('localhost','root','') or die("连接mysql服务器失败！".mysql_error());

mysql_query("set names utf8");
mysql_select_db('tm_blog');
$sql="select *from user where account="."'".$account."' ";

$result=mysql_query($sql);
if(!$result){
	echo '错误！';
	echo '<a href=auth.html>返回</a>';
	exit;
}

$num=mysql_fetch_assoc($result);



if(!$num){
	echo "您输入的用户不存在！";
	echo "<a href=auth.html>返回登陆界面</a>";

}else{

	$_SESSION['user_name']=$num['user_name'];
	$_SESSION['account']=$num['account'];
	$_SESSION['user_id']=$num['user_id'];
	header("location: glance.php");
}

?>
