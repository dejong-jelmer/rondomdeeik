<?php 

class AuthController extends Controller
{
    
    public function index()
    {
        if($this->authUser()) {
            $user = $this->model('User');

            $name = $user->name;
            $email = $user->email;
            
            return $this->view('auth/index', ['name' => $name, 'email' => $email]);
            
        } else {
            
            return $this->view('auth/index');
        }
    }

    
    public function userLogin()
    {
        if(!$this->authUser()) {
                            
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->model('User');
            
            $login = $user->login($username, $password);

            if((bool)$login) {
                
                $_SESSION['success'] = 'Je bent ingelogd.';
                return $this->redirect('admin/edit');         
            }

            $_SESSION['error'] = 'email en wachtwoord komen niet overeen.';
            return $this->redirect('admin/login');                           
            
        } 
        
        $_SESSION['error'] = 'Je bent al ingelogd.';
        return $this->redirect('admin/edit');         
    }

    public function userLogout()
    {
        
        $user = $this->model('User');
        $user->logout();

        return $this->redirect('admin/login');
    }
    
    
    public function registerUser()
    {
        $errors = '';

        $username = $_POST['username'];
        $email = $_POST['email'];

        $user = $this->model('User');
        
        $errors = $this->validateRegisteration($user, $username, $email);

        if(empty($errors)) {
            
            if((bool) $user->register($username, $email)) {
                $success = 'Nieuwe gebruiker aangemaakt.'; 
            }
        }

        if(empty($errors)) {
            $_SESSION['success'] = $success;
        } else {
            $_SESSION['error'] = $errors;

        }

        return $this->redirect('admin/account');
    }

    public function editPassword()
    {
        $errors = '';

        $old_password = $_POST['oldPassword'];
        $new_password = $_POST['newPassword'];
        $rep_password = $_POST['repPassword'];

        $user_id = $this->session('user')->id;
        
        // $errors = $this->validatePassword($old_password, $new_password, $rep_password);

        if(empty($errors)) {
            $user = $this->model('User');
            if((bool) $user->editPassword($user_id, $old_password, $new_password)) {
                $success = 'Je wachtwoord is aangepast.'; 
            } else {
                $errors = 'Het is niet gelukt je wachtwoord aan te passen.';
            }
        }

        if(empty($errors)) {
            // log off user (before setting success SESSION = is destroyed in log off)
            $user->logout();
            // restart session
            session_start();
            $_SESSION['success'] = $success;
            
            return $this->redirect('admin/login');
        
        } else {
            $_SESSION['error'] = $errors;
            
            return $this->redirect('admin/account');
        }
        

    }
    
    
}