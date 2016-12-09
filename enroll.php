<?php

if(isset($_POST['account'])&&isset($_POST['user_name'])&&isset($_POST['passwd'])&&isset($_POST['sex'])&&isset($_POST['hobby'])){
	if(empty($_POST['account'])||empty($_POST['user_name'])||empty($_POST['passwd'])||empty($_POST['sex'])){

		echo '有部分表格未填完，请返回<a href=register.html>注册界面</a>查看';
		exit;
	}
	
	if($_POST['passwd']!=$_POST['passwdagain']){
		echo '你两次输入的密码对不！';
		echo '<a href=register.html>返回注册界面</a>';
		exit;
	}

	$account=trim($_POST['account']);
	$user_name=trim($_POST['user_name']);
	$passwd=trim($_POST['passwd']);
	$sex=trim($_POST['sex']);
	$hobby=trim($_POST['hobby']);
}

@$conn=mysql_connect('localhost','root','');
mysql_query('set names utf8');
mysql_select_db('tm_blog');

$sql="insert into user (account,user_name,password,sex,hobby) values("."'".$account."','".$user_name."','".$passwd."','".$sex."','".$hobby."')";

$result=mysql_query($sql);
if(!$result){
	echo '注册失败！';
	echo '<a href=register.html>返回注册界面</a>';
	exit;
}
else{
	echo '注册成功！';
	echo '<a href=auth.html>返回登陆界面</a>';
}

?>
