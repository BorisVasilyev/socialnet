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

		unset($add_err);

		if(DBManager::check_login($login, $password))
		{
			if(isset($_POST['add_comment']))
			{
				$text = $_POST['comment_text'];
				
				if($text != '')
				{
					$cur_user = DBManager::get_user($login);			
					
					$post_id = $_GET['show'];
					
					DBManager::add_comment($post_id, $cur_user->Id, $text);
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
	
			if(!isset($_GET['show']))
			{
				echo '<h3> Не выбран пост для просмотра </h3>';
			}
			else 
			{
				$post_id = $_GET['show'];
								
				$post = DBManager::get_post_by_id($post_id);
				
				if(isset($post))
				{
					echo '<h3>' . $post->Title . '</h3>';
					
					echo $post->Text;

					$user = DBManager::get_user_by_id($post->User_id);					
					
					echo '<br><br><b> Написал <a href = "users.php?show=' . $user->Id . '">' . $user->Full_name . '</a>';
					
					if(isset($post->Club_id))
					{
						$club = DBManager::get_club_by_id($post->Id);
						
						echo 'в блог клуба ' . $club->Name;
					}
					else 
					{
						echo ' в личный блог';
					}		
					
					echo '</b><br>';
					
					$comments = DBManager::get_comments_by_post($post->Id);
					
					if(isset($comments))
					{			
						echo '<br><b> Комментарии: </b>';
						
						foreach($comments as $i => $value)
						{
							$com_user = DBManager::get_user_by_id($value->User_id);
							
							echo '<br><a href = "users.php?show=' . $com_user->Id . '">' . $com_user->Full_name . ':</a>';
							
							echo '<br>' . $value->Text . '<br>';
						}
					}
					
					echo '<br><b> Новый комментарий: </b>';
					echo '<form action="post.php?show=' . $post->Id . '" method="post">
							<textarea name="comment_text" style="width:50%; height:30px%;" /></textarea>
							<br><input type="submit" name="add_comment" value="Добавить комментарий"/>							
							</form>';
							
					if(isset($add_err))
						echo '<font color=#ff0000> Нужно ввести текст комментария </font>';
				}
				else 
				{
					echo '<font color=#ff0000> Поста с таким номером не существует </font><br>';
				}

				echo '<br><form action = "main.php" method ="post"><input type="submit" name="logout" value="Выход"/></form>';
			}
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