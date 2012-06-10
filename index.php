<?php

	if(isset($_POST['submit']))
	{
		include $_SERVER['DOCUMENT_ROOT'].'/socialnet/src/db_man.php';

		$login = $_POST['login'];
		$password = $_POST['password'];		

		if(DBManager::check_login($login, $password))
		{
			setcookie("login", $login, time()+60*60*24*30);
			setcookie("password", $password, time()+60*60*24*30);

			header('Location: main.php');
		}
		else
		{
			$auth_error = true;
		}
	}
	else
		unset($auth_error);

?>

<html>
<head>
	<title> Social Network </title>
	<style type="text/css" media="all">
    		@import url(styles.css);
  	</style>
</head>
<body>
	<div class="header"> 
		<table cellpadding="10"><tr><td><img src="images/logo.png" alt="logo" ></td> <td> <h1> SocialNetwork </h1> </td> </tr></table> 
	</div>

	<div class="body"> 
	<center>
	<h2> Вход </h2>
	<table>
	<form action = "index.php" method="post">
	<tr> <td> Ваш логин: </td> <td> <input type="text" name="login"/> </td> </tr>
	<tr> <td> Ваш пароль: </td> <td> <input type="password" name="password" /> </td> </tr>
	<tr> <td colspan="2" align="center"> <input name="submit" type="submit" value="Вход"/> </td> </tr>
	</form>
	</table>
	
	<?php if (isset($auth_error)) echo '<font color=#ff0000> Неправильный логин или пароль </font>'; ?>

	<br/><a href="register.php"> Регистрация нового пользователя </a>
	</center>
	</div>

</body>
</html>


