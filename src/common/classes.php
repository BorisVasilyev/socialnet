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

?>