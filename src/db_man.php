<?php
	
	include $_SERVER['DOCUMENT_ROOT'].'/socialnet/src/common/classes.php';

	class DBManager
	{
		private static $db_host = 'localhost';
		private static $db_name = 'socialnet_db';
		private static $db_login = 'root';
		private static $db_password = '1234';

		public function check_login($login, $password)
		{
			$res = false;		
	
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select * from ". self::$db_name . ".users where login = '%s' and password = '%s'", 
							mysql_real_escape_string($login),
							md5(mysql_real_escape_string($password)));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else if(mysql_num_rows($result))
				{
					$res = true;
				}
	
				mysql_free_result($result);
			}
	
	
			mysql_close($link);
	
			return $res;
		}
		
		public function check_login_exists($login)
		{
			$res = false;		
	
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select * from ". self::$db_name . ".users where login = '%s'", 
							mysql_real_escape_string($login));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else if(mysql_num_rows($result))
				{
					$res = true;
				}
	
				mysql_free_result($result);
			}
	
	
			mysql_close($link);
	
			return $res;
		}
		
		public function add_user($login, $password, $full_name)
		{
			$res = false;		
	
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("insert into ". self::$db_name . ".users (login, password, full_name, reg_date) 
								values ('%s', '%s', '%s', '%s')", 
							mysql_real_escape_string($login),
							md5(mysql_real_escape_string($password)),
							mysql_real_escape_string($full_name),
							date('Y-m-d H:m:s'));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else if(mysql_num_rows($result))
				{
					$res = true;
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $res;
		}
		
		public function get_user($login)
		{	
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, login, full_name, reg_date from ". self::$db_name . ".users 
								where login = '%s'", 
							mysql_real_escape_string($login));
	
				$result = mysql_query($query);
				
				$u = null;
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					if($row = mysql_fetch_assoc($result))
					{
						$u = new User($row['id'], 
									$row['login'], 
									$row['full_name'],
									$row['reg_date']);
	
					}
				}
	
				mysql_free_result($result);
			}
	
	
			mysql_close($link);
	
			return $u;
		}
		
		public function get_users()
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, login, full_name, reg_date from ". self::$db_name . ".users");
	
				$result = mysql_query($query);
				
				$u = null;
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					while($row = mysql_fetch_assoc($result))
					{
						$u = new User($row['id'], 
									$row['login'], 
									$row['full_name'],
									$row['reg_date']);
									
						$users[] = $u;
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $users;
		}
		
		public function add_subscribe($user_id, $subs_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("insert into ". self::$db_name . ".subscriptions values('%s', '%s')",
										mysql_real_escape_string($user_id),
										mysql_real_escape_string($subs_id));
	
				$result = mysql_query($query);
				
				$u = null;
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					$res = true;
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $res;
		}
		
		public function get_clubs()
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, name, description from ". self::$db_name . ".clubs");
	
				$result = mysql_query($query);
				
				$u = null;
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					while($row = mysql_fetch_assoc($result))
					{
						$c = new Club($row['id'],
									$row['name'], 
									$row['description']);
									
						$clubs[] = $c;
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $clubs;
		}
	}
?>