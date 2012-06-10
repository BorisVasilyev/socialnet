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
			$subs_id = $_GET['subscribe'];
			
			if($subs_id != null)
			{
				$cur_user = DBManager::get_user($login);			
			
				DBManager::add_club_subscription($cur_user->Id, $subs_id);
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

			echo '<h3> Существующие клубы: </h3>';

			echo '<table>';		
		
			$clubs = DBManager::get_clubs();
		
			foreach($clubs as $i => $value)
			{
				echo '<tr><td> ' . ($i + 1) . '. </td><td><b> <a href = "clubs.php?show=' . $value->Id . '"> ' . $value->Name . '</a> </b></td></tr>';
				echo '<tr><td></td><td> ' . $value->Description. ' </td></tr>';
				echo '<tr><td></td><td> <a href = "clubs.php?subscribe=' . $value->Id . '"> Подписаться </a> </td></tr>';
				echo '<tr><td></td><td><br></td></tr>';
			}	
			
			echo '</table>';
			
			echo '<br><form action = "main.php" method ="post"><input type="submit" name="logout" value="Выход"/></form>';
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


