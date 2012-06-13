<?php
	if(isset($_POST['logout']))
	{
		setcookie("login", "", time() - 3600*24*30*12);
      setcookie("password", "", time() - 3600*24*30*12);
		header("Location: index.php");
	}

	if (isset($_COOKIE['login']))
	{
		include $_SERVER['DOCUMENT_ROOT'].'/socialnet/src/db_man.php';

		$login = $_COOKIE['login'];
		$password = $_COOKIE['password'];

		if(DBManager::check_login($login, $password))
		{			
			$cur_user = DBManager::get_user($login);

			unset($add_err);	
			unset($post_added);		
			
			if(isset($_POST['add_post']))
			{
				$post_title = $_POST['post_title'];
				$post_text = $_POST['post_text'];
				
				if($post_title != '' and $post_text != '')
				{
					$post_added = DBManager::add_post($post_title, $post_text, $cur_user->Id);
					
				}
				else 
					$add_err = true;	
			}
		?>

		<html>
		<head>
			<title> Social Network </title>
			<style type="text/css" media="all">
		    		@import url(css/styles.css);
		  	</style>
		</head>
		<body>		

		<?php
			
			echo '<div class="header"> 
					<table cellpadding="10"><tr><td><img src="images/logo.png" alt="logo" ></td> <td> <h1> SocialNetwork </h1> </td> </tr></table> 
				</div>';
				
			echo '<div class="menu"> 
					<a href="main.php" class="menu_text"> Лента </a> 
					<a href="clubs.php" class="menu_text"> Клубы </a> 
					<a href="users.php" class="menu_text"> Пользователи </a> 
				</div>';
			
			echo '<div class="body">';
			
			if(!isset($post_added))
			{			
				echo '<h3> Новый пост в личный блог </h3>';
				
				echo '<form action = "new_post.php" method ="post">';
				
				echo '<b>Заголовок:</b>';
				echo '<br><input type="text" name="post_title" style="width:50%;" />';
				
				echo '<br><br><b>Текст:</b>';
				echo '<br><textarea name="post_text" style="width:50%; height:30%;" /></textarea>';
				
				echo '<br><br><input type="submit" name="add_post" value="Написать!"/><br>';
				
				if (isset($add_err))
				{
					echo '<font color=#ff0000> Заголовок и текст поста не могут быть пустыми. </font>';
				}
				
				echo '</form>';
			}
			else 
			{
				echo '<h3> Пост успешно добавлен! </h3>
				<a href = "new_post.php">Написать еще один</a>
				<br> <a href = "main.php">Вернуться на главную страницу</a><br>';
				
			}

			echo '<form action = "main.php" method ="post"><input type="submit" name="logout" value="Выход"/></form>';
		}
		else
		{
			setcookie("login", "", time() - 3600*24*30*12);

        	setcookie("password", "", time() - 3600*24*30*12);

			echo 'Необходима авторизация!';
			?>

			</div>
			</body>
			</html>	

			<?php
		}
	}
	else
	{
		echo 'Необходима авторизация!';
	}

?>


