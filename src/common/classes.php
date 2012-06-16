<?php

	class User
	{
		public $Id;
		public $Login;
		public $Full_name;
		public $Reg_date;
		
		function __construct($id, $login, $full_name, $reg_date)
		{
			$this->Id = $id;
			$this->Login = $login;
			$this->Full_name = $full_name;
			$this->Reg_date = $reg_date;
		}
	}
	
	class Club
	{
		public $Id;
		public $Name;
		public $Description;
		
		function __construct($id, $name, $description)
		{
			$this->Id = $id;
			$this->Name = $name;
			$this->Description = $description; 
		}
	}	
	
	class Post
	{
		public $Id;
		public $User_id;
		public $Club_id;
		public $Title;
		public $Text;
		
		function __construct($id, $user_id, $club_id, $title, $text)
		{
			$this->Id = $id;
			$this->User_id = $user_id;
			$this->Club_id = $club_id;
			$this->Title = $title;
			$this->Text = $text;
		}
	}	
	
	class Comment
	{
		public $Id;
		public $Post_id;
		public $User_id;
		public $Text;
		
		function __construct($id, $post_id, $user_id, $text)
		{
			$this->Id = $id;
			$this->Post_id = $post_id;
			$this->User_id = $user_id;
			$this->Text = $text;
		}
	}

?>