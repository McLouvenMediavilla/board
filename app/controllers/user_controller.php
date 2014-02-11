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
            $user->password_reg = Param::get('password_reg');

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
        $valid = true;        

        switch ($page) {
        case 'login':
            break;
        case 'login_end':
            $user->username = Param::get('username');
            $user->password = Param::get('password');
            $account = $user->authenticateUser();
            
            if ($account) {
                $_SESSION['username'] = $account['username'];
                $_SESSION['id'] = $account['id'];
            } else {
                $valid = false;
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
        session_destroy();
    }
}
