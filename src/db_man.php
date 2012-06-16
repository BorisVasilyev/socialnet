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
		
		public function get_user_by_id($user_id)
		{	
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, login, full_name, reg_date from ". self::$db_name . ".users 
								where id = '%s'", 
							mysql_real_escape_string($user_id));
	
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
		
		public function add_user_subscription($user_id, $subs_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("insert into ". self::$db_name . ".user_subscriptions values('%s', '%s')",
										mysql_real_escape_string($user_id),
										mysql_real_escape_string($subs_id));
	
				$result = mysql_query($query);
	
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
		
		public function add_club_subscription($user_id, $subs_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("insert into ". self::$db_name . ".club_subscriptions values('%s', '%s')",
										mysql_real_escape_string($user_id),
										mysql_real_escape_string($subs_id));
	
				$result = mysql_query($query);
	
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

				mysql_query("SET NAMES utf8");	
	
				$result = mysql_query($query);
	
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
		
		public function get_club_by_id($club_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, name, description from ". self::$db_name . ".clubs where id = '%s'", 
										mysql_real_escape_string($club_id));

				mysql_query("SET NAMES utf8");	
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					if($row = mysql_fetch_assoc($result))
					{
						$c = new Club($row['id'],
									$row['name'], 
									$row['description']);
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $c;
		}
	
		public function get_publisher_clubs($user_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, name, description from ". self::$db_name . ".clubs 
										where id in (select club_id from ". self::$db_name .".club_subscriptions where subscriber_id = '%s')",
										mysql_real_escape_string($user_id));

				mysql_query("SET NAMES utf8");	
	
				$result = mysql_query($query);
	
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
	
		public function get_publisher_users($user_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, login, full_name, reg_date from ". self::$db_name . ".users 
										where id in (select publisher_id from " . self::$db_name . ".user_subscriptions where subscriber_id = '%s') ",
										mysql_real_escape_string($user_id));
	
				$result = mysql_query($query);
	
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
		
		public function add_post($post_title, $post_text, $user_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("insert into ". self::$db_name . ".posts(user_id, club_id, title, text) 
										values ('%s', NULL, '%s', '%s')",
										mysql_real_escape_string($user_id),
										mysql_real_escape_string($post_title),
										mysql_real_escape_string($post_text));
	
				$result = mysql_query($query);
	
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

		public function get_post_by_id($post_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, user_id, club_id, title, text from ". self::$db_name . ".posts 
										where id = '%s'",
										mysql_real_escape_string($post_id));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					if($row = mysql_fetch_assoc($result))
					{
						$p = new Post($row['id'], 
											$row['user_id'],
											$row['club_id'],
											$row['title'],
											$row['text']);
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $p;
		}		
		
		public function get_posts($user_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, user_id, club_id, title, text from ". self::$db_name . ".posts 
										where user_id in (select publisher_id from " . self::$db_name . ".user_subscriptions where subscriber_id = '%s') ",
										mysql_real_escape_string($user_id));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					while($row = mysql_fetch_assoc($result))
					{
						$p = new Post($row['id'], 
											$row['user_id'],
											$row['club_id'],
											$row['title'],
											$row['text']);
									
						$posts[] = $p;
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $posts;
		}
		
		public function get_user_posts($user_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, user_id, club_id, title, text from ". self::$db_name . ".posts 
										where user_id = '%s' and club_id is null",
										mysql_real_escape_string($user_id));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					while($row = mysql_fetch_assoc($result))
					{
						$p = new Post($row['id'], 
											$row['user_id'],
											$row['club_id'],
											$row['title'],
											$row['text']);
									
						$posts[] = $p;
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $posts;
		}
		
		public function get_club_posts($club_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, user_id, club_id, title, text from ". self::$db_name . ".posts 
										where club_id = '%s'",
										mysql_real_escape_string($user_id));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					while($row = mysql_fetch_assoc($result))
					{
						$p = new Post($row['id'], 
											$row['user_id'],
											$row['club_id'],
											$row['title'],
											$row['text']);
									
						$posts[] = $p;
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $posts;
		}
		
		public function get_comments_by_post($post_id)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("select id, post_id, user_id, text from ". self::$db_name . ".comments
										where post_id = '%s'",
										mysql_real_escape_string($post_id));
	
				$result = mysql_query($query);
	
				if(!$result)
				{
					die('Query error: ' . mysql_error());
				}
				else 
				{
					while($row = mysql_fetch_assoc($result))
					{
						$c = new Comment($row['id'], 
									$row['post_id'], 
									$row['user_id'],
									$row['text']);
									
						$comments[] = $c;
	
					}
				}
	
				mysql_free_result($result);
			}
	
			mysql_close($link);
	
			return $comments;
		}
		
		public function add_comment($post_id, $user_id, $text)
		{
			$link = mysql_connect(self::$db_host, self::$db_login, self::$db_password);	
		
			if(!$link)
			{
				die('Ошибка соединения: ' . mysql_error());
			}
			else
			{
				$query = sprintf("insert into ". self::$db_name . ".comments(post_id, user_id, text)
										values('%s', '%s', '%s')",
										mysql_real_escape_string($post_id),
										mysql_real_escape_string($user_id),
										mysql_real_escape_string($text));
	
				$result = mysql_query($query);
	
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
	}
?>