<?php

	if(isset($_POST['register']))
	{
		unset($reg_err);		
		unset($login_err);	
		
		$login = $_POST['login'];
		$full_name =$_POST['fullName'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];	

		if($login != '' and $full_name != '' and $password_1 != '' and $password_2 != '' and $password_1 == $password_2)
		{	
			include $_SERVER['DOCUMENT_ROOT'].'/socialnet/src/db_man.php';

			if(!DBManager::check_login_exists($login))
			{
				DBManager::add_user($login, $password_1, $full_name);

				header('Location: index.php ');
			}
			else
				$login_err = true;
		}
		else
			$reg_err = true;
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

	<div class="header"> 
		<table cellpadding="10"><tr><td><img src="images/logo.png" alt="logo" ></td> <td> <h1> SocialNetwork </h1> </td> </tr></table> 
	</div>
	
	<div class="body">
	<h3> Регистрация нового пользователя </h3>
	<table>
	<form action = "register.php" method="post">
	<tr><td> Логин: </td> <td> <input type = "text" name="login"/> </td></tr>
	<tr><td> Ваше полное имя: </td> <td> <input type = "text" name="fullName"/> </td></tr>
	<tr><td> Пароль: </td> <td> <input type = "password" name="password_1" /> </td></tr>
	<tr><td> Пароль еще раз: </td> <td> <input type = "password" name="password_2" /> </td></tr>
	<tr><td> <input type = "submit" name="register" value="Зарегистрироваться" /> </td></tr>
	</form>
	</table>

	<?php if(isset($reg_err)) echo '<font color=#ff0000> Все поля должны быть заполнены и пароли совпадать. </font>' ?>	
	<?php if(isset($login_err)) echo '<font color=#ff0000> Пользователь с таким именем уже существует. </font>' ?>
	
	<p><a href="index.php"> Возвратиться на главную страницу </a></p>
	</div>
	
</body>
</html>


