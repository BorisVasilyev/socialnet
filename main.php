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
				
			$cur_user = DBManager::get_user($login);
			
			echo '<div class="body"> <h3> Добро пожаловать, ' . $cur_user->Full_name . '!</h3>';

			echo '<a href="new_post.php"> <b> Написать новый пост</b></a>';			
			
			$clubs = DBManager::get_publisher_clubs($cur_user->Id);		
			
			echo '<br><br> <b> Вы подписаны на следующие клубы: </b>';
			
			foreach($clubs as $i => $value)
			{
				echo '<br> '. ($i + 1) . '. <a href = "clubs.php?show=' . $value->Id . '">' . $value->Name . '</a>';
			}	
			
			echo '<br><br> <b> Вы подписаны на следующих пользователей: </b> ';
			
			$users = DBManager::get_publisher_users($cur_user->Id);		
			
			foreach($users as $i => $value)
			{
				echo '<br> '. ($i + 1) . '. <a href = "users.php?show=' . $value->Id . '">' . $value->Full_name . '</a>';
			}	

			echo '<br><br> <b> Новые посты: </b> ';			
			
			$posts = DBManager::get_posts($cur_user->Id);
			
			foreach($posts as $i => $value)
			{
				echo '<br><br><a href="post.php?show=' . $value->Id . '"><b>' . $value->Title . '</b></a><br><br>';
				
				echo $value->Text;
				
				echo '<br><br>';
				
				$user = DBManager::get_user_by_id($value->User_id);
				
				if(isset($user))
				{
					echo 'Написал <a href="users.php?show=' . $user->Id . '">' . $user->Full_name . '</a>';
				}
				
				if(isset($value->Club_id))
				{
					$club = DBManager::get_club_by_id($value->Club_id);
					
					if(isset($club))
					{
						echo ' в блог клуба <a href="clubs.php?show=' . $club->Id . '">' . $club->Name . '</a>';
					}
				}
				else 
					echo ' в личный блог ';
			}
			
			echo '<br><br><form action = "main.php" method ="post"><input type="submit" name="logout" value="Выход"/></form>';
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


