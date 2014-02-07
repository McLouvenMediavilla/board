<?php
class User extends AppModel
{
	public $validation = array(
		'username' => array(
			'length' => array(
				'validate_between', 6, 10,
			),
		),
		'password' => array(
			'length' => array(
				'validate_between', 6, 15,
			),
		),
	);

	public function register($user)
	{
		$this->validate();
		if ($this->hasError()) {
		    throw new ValidationException('invalid user');
		}

        $params = array(
        	'username' => $user->username,
        	'password' => md5($user->password)
        );  

		$db = DB::conn();
        $db->insert('user', $params);
	}	

	public function checkUser($username, $password)
    {
        $db = DB::conn();
		$row = $db->row('SELECT id, username FROM user WHERE username = ? AND password = ?',
			array($username, md5($password))
		);
		return $row;		
	}
	
}