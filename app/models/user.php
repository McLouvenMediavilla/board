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
		$user->validate();
		if ($this->hasError() || $user->hasError()) {
		    throw new ValidationException('invalid user');
		}

        $params = array(
        	'username' => $user->username,
        	'password' => md5($user->password)
        );  

		$db = DB::conn();
        $db->insert('user', $params);
	}	

	public function checkUser($user)
    {
    	$this->validate();
		$user->validate();
		if ($this->hasError() || $user->hasError()) {
		    throw new ValidationException('invalid user');
		}

        $db = DB::conn();
		$row = $db->row('SELECT * FROM user WHERE username = ? AND password = ?',
			array($user->username, md5($user->password))
		);

		return new self($row);		
	}
    
    public static function getUserId($username)
    {
		$db = DB::conn();
		$user_id = $db->value('SELECT id FROM user WHERE username = ?', array($username));
		return $user_id;   	
    }
}