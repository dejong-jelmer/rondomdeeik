<?php

class BaseController
{
    protected $root;
    protected $routes;
    protected $appName;
    
    function __construct()
    {
        $config = include_once dirname(__DIR__) . '/config.php';
        $route = include dirname(__DIR__) . '/routes.php';
        
        $this->root = $config['root'];
        $this->appName = $config['appname'];

        $this->routes = $route;

    }

    protected function route($name)
    {
       
        foreach($this->routes as $routes => $control) {
            
            if ($name == $control['name']) {

                $route = $this->root . '/' . $routes;
            }  

        }

        return $route;
    }

    protected function checkUserLogin()
    {
        
        if(isset($_SESSION['user'])) {
            return true;
        } 
        
        return false;
        
    }

    protected function checkErrors()
    {
        if(isset($_SESSION['error'])) {
            return true;
        }

        return false;
    }

    protected function checkSuccess()
    {
        if(isset($_SESSION['success'])) {
            return true;
        }

        return false;
    }

    protected function token()
    {
        if(isset($_SESSION['CSRF'])) { 
            
            $csrf = $_SESSION['CSRF'];
            return $csrf;
        }
        // all character which can be in random string
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            // choosing one character from all characters and adding it to random string
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        

        $_SESSION['CSRF'] = hash('sha512',time().''.$randomString);
        $csrf = $_SESSION['CSRF'];
        
        return $csrf;
        
    }

    

}