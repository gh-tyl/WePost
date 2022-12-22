<?php include "../config/config.php"; ?>
<?php
class user
{
	private $id;
	private $first_name;
	private $last_name;
	private $email;
	private $password;
	private $gender;
	private $age;
	private $country;
	private $img_path;
	private $role;
	function __construct($id, $first_name, $last_name, $email, $password, $gender, $age, $country, $img_path, $role)
	{
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->password = $password;
		$this->gender = $gender;
		$this->age = $age;
		$this->country = $country;
		$this->img_path = $img_path;
		$this->role = $role;
	}

	function login()
	{
		//Miku
	}
	function register()
	{
		//Jun
	}
	function logout()
	{
		session_destroy();
	}
}
?>