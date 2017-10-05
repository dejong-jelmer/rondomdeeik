<?php 
require_once dirname(__DIR__) . '/core/Model.php';

// user model
class User extends Model
{
    
    function __construct()
    {
        $this->users = $this->getAllUsers();
    }

    public function register($username, $email)
    {
        return  $this->registerNewUser($username, $email);
    }
    

    public function editPassword($user_id, $old_password, $new_password)
    {
        return  $this->changePassword($user_id, $old_password, $new_password);
        
    }
    
    


}