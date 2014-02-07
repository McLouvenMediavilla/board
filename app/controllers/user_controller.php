<?php
class UserController extends AppController
{
	public function register()
	{
		$user = new User;
		$page = Param::get('page_next', 'register');

		switch ($page) {
		case 'register':
		    break;
		case 'register_end':
		    $user->username = Param::get('username');
		    $user->password = Param::get('password');
		    try {
		    	$user->register($user);
		    } catch (ValidationException $e) {
		    	$page = 'register';
		    }
		    break;
		default:
		    throw new NotFoundException("{$page} is not found");
		    break;
		}

		$this->set(get_defined_vars());
		$this->render($page);
	}

	public function login()
	{
		$user = new User;
		$page = Param::get('page_next', 'login');

		switch ($page) {
		case 'login':
            break;
        case 'login_end':
            $user->username = Param::get('username');
		    $user->password = Param::get('password');
            try {
            	$account = $user->checkUser($user);
            	$_SESSION['username'] = $user->username;
            } catch (ValidationException $e) {
		    	$page = 'login';
            }
            break;
        default:
            throw new NotFoundException("{$page} is not found");
		    break;
		}
		
		$this->set(get_defined_vars());
		$this->render($page);
	}

	public function logout()
	{
		$page = Param::get('page_next', 'logout');

        switch ($page) {
        case 'logout':
            session_destroy();
            break;
        default:
            throw new NotFoundException("{$page} is not found");
		    break;
        }

        $this->render($page);
	}
}
