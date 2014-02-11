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
        'password_reg' => array(
            'match' => array(
                'match_password',
            ),
        ),        
        'username_reg' => array(
            'match' => array(
                'check_username',
            ),
        ),
    );

    public function register($user)
    {
        // Variables must be manually inserted to the validation
        $this->validation['password_reg']['match'][] = $this->password;
        $this->validation['password_reg']['match'][] = $this->password_reg;
        $this->username_reg = $this->getUsername();
        $this->validation['username_reg']['match'][] = $this->username;
        $this->validation['username_reg']['match'][] = $this->username_reg;

        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid user');
        }

        $params = array(
            'username' => $this->username,
            'password' => md5($this->password)
        );  

        $db = DB::conn();
        $db->insert('user', $params);
    }	

    public function authenticateUser()
    {
        $db = DB::conn();
        $row = $db->row('SELECT id, username FROM user WHERE username = ? AND password = ?',
            array($this->username, md5($this->password))
        );

        return $row;
    }
	
    public function getUsername()
    {
        $db = DB::conn();
        $username = $db->value('SELECT username FROM user WHERE username = ? ',
            array($this->username)
        );
        return $username;
    }
}