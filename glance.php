<?php
/****主页面****

1.提交用户发表的日志
2.显示每个用户发表的所有日志
3.每个登录后的用户可以对每篇日志进行评论
4.分页显示所有日志，每页显示2篇
5.退出博客

*/
session_start();

if(isset($_SESSION['user_name']) && isset($_SESSION['account'])){		//验证用户名和密码是否为空

	if(empty($_SESSION['user_name'])&&empty($_SESSION['account'])){
			
		echo '错误！<br/>';
		echo '<a href=auth.html>重新登录</a>';
		exit;
	}
		$user_name=$_SESSION['user_name'];
		$login=true;
}

if($user_name=='adminer'){		//判断是否为管理员
	$tag=true;
}
else{
	$tag=false;
}
echo '<a href=add.html>添加</a>';
?>

<?php

@$conn=mysql_connect('localhost','root','') or die("连接mysql服务器失败！".mysql_error());		//链接数据库
	mysql_query("set names utf8");

	mysql_select_db('tm_blog');

	$sql="select *from tb_daily";
	$result=mysql_query($sql);

	$num=mysql_num_rows($result);
//分页显示

if(isset($_GET['page'])){
	$page=$_GET['page'];
}
else{
	$page=1;
}

$page_size=5;			//每页显示5条数据
if($num)
{
	if($num<$page_size)	//如果总记录数小于$page_size，那么只有一页
		$page_size=1;

	if($num%$page_size)	//有余数，则总页数等于总记录数除以每页结果数再加一
		$page_count=(int)($num/$page_size)+1;

	else      			//没有余数，则总页数等于总记录数除以每页结果数
	{
		$page_count=$num/$page_size;
	}
}
else
{
	$page_count=0;
}
//翻页连接
//$turn_page='';

if($page==1)
{
	$turn_up_page='首页|上页| ';
}
else
{
	$turn_up_page='<a href=glance.php?page=1>首页</a> | <a href=glance.php?page='.($page-1).'>上一页</a>|';
}

if ($page==$page_count||$page_count==0)
{
	$turn_down_page='下一页|尾页';
}
else
{
	$turn_down_page='<a href=glance.php?page='.($page+1).'>下一页</a>|<a href=glance.php?page='.$page_count.'>尾页</a>';
}

$sql='select *from tb_daily limit '.($page-1)*$page_size.','.$page_size;

$result=mysql_query($sql) or die('sql语句执行失败！'.mysql_error());		//限制每页输出2篇的日志

?>

<?php echo '<a href="myblog.php">个人中心</a>'; 	//用户个人博客文档
															
?>

 	<?php      						
			

			if($num=mysql_num_rows($result))				//遍历出所有的文章
			{

				echo "<br/><br/><br/>----------------------------------------------------------------";
				while ($row=mysql_fetch_assoc($result))
				{
					?>
					<!DOCTYPE html>
					<html>
					<head>
						<title>主页</title>
					</head>
					<body bgcolor="F5F5DC">
						<form>
						<table border="2"  bgcolor="#E0FFFF">
							<tr>
								<td>用户：</td>
								<!-- <td><input type="text" value=<?php echo $row['user_name'];  ?> size="50" ></td> -->
								<td><?php echo $row['user_name'];  ?></td>
							</tr>
							<tr>
								<td>标题：</td>
								<!-- <td><input type="text" value= <?php echo $row['title'];  ?> size="50" ></td> -->
								<td><?php echo $row['title'];  ?></td>
							</tr>
							<tr>
								<td></td>
								<!-- <td><textarea name="content" rows="10" cols="49" style="resize: none;"><?php echo $row['content'].'-----'; ?></textarea></td> -->
								<td><?php echo $row['content'].'-----'; ?></td>
							</tr>
							<tr>
								<td></td>
								<!-- <td><input type="text" value=<?php echo  $row['time']; ?> size="50"></td> --> 
								<td><?php echo  $row['time']; ?></td>
							</tr>
							<tr>
								<td></td>
								<td><?php echo "<a href=delete.php?blog_id=".$row['blog_id']." >删除</a> ";
											echo "<a href=edit.php?blog_id=".$row['blog_id'] .">编辑</a> "; ?></td>
							</tr>
						</table>
						</form>

					</body>
					</html> 
			<?php
				}
				echo '<br/>--------------------------------------------------------------------------';
			}
			echo '<br/><br/>';
			echo $turn_up_page;
			echo $turn_down_page;
			mysql_close($conn);
		?>

<?php          	//退出
	
	echo '<br/><br/><br/>';
	echo '<a href="exit.php">退出</a>';
?>
