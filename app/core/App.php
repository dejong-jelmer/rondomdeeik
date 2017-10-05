<?php 

class App
{
    protected $controller =  'HomeController';
    protected $method = 'index';
    protected $params = [];
    protected $routes = [];
    protected $csrf = '';


    public function __construct()
    {

        // get array from url
        $url = $this->parseUrl();
        
        
        // get array from routes.php
        $routes = $this->getRoutes($this->stringUrl());

        // separate controller method set in routes uses into controller -> $controller and in method -> $method 
        list($controller, $method) = explode('@', $routes['uses']);
        
        // check if method (GET/POST) is allowed by route
        $this->checkMethod($routes['allow']);

        // check CSRF
        $this->checkCSRF();
        
        // check if controller class form routes array exist and if so set controller
        $controller = ucfirst($controller);            
        if(file_exists( dirname(__DIR__) . '/controllers/' . $controller . '.php'))
        {
            
            $this->controller = $controller;
            unset($controller);           
            
        }

        // load controller class
        require_once  dirname(__DIR__) . '/controllers/' . $this->controller . '.php';

        // create instance of controller class
        $this->controller = new $this->controller;

        // check if method exist in controller class and set method
        if(isset($method))
        {
            if(method_exists($this->controller, $method)) 
            {
                $this->method = $method;
                unset($method);
            }
        }

        $this->checkAcces($routes);
        

        // set params
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    

    }
    
    /**
    * # return a sanitized array from the url 
    * @return array $url 
    */
    private function parseUrl()
    {

        if(isset($_GET['url']))
        {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

            return $url;
        }

    }

    /**
    * # load routes into the routes array
    * @return array $routes
    */
    private function getRoutes($url)
    {
        $routes = require_once dirname(__DIR__) . '/routes.php';

        if(array_key_exists($url, $routes)) {
            return $routes = $routes[$url];
        }
        
        header("HTTP/1.1 404 Not Found");
        include_once dirname(__DIR__) . '/app/views/templates/errors/404.php';
        exit();

    }

    /**
    * # convert $url array into string
    * @return string $url
    */
    private function stringUrl()
    {
        if(is_array($this->parseUrl())) {
           
            return $url = implode('/', $this->parseUrl());
        } else {
            
            return $url = $this->parseUrl();
        }

    }

    /**
    *
    * # check if server method (POST/GET) is set in routes 
    *
    * @return boolean
    */

    private function checkMethod($allow) {
        
        if(!in_array($_SERVER['REQUEST_METHOD'], $allow)) {
            
            header("HTTP/1.1 405 Method Not Allowed");
            include_once dirname(__DIR__) . '../app/views/templates/errors/405.php';
            exit();
        }

        return true;
    }

    /**
    *
    * # check if CSRF token is set and is equal to session CSRF  
    *
    * @return boolean 
    */
    private function checkCSRF()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'GET') {

            if(!isset($_REQUEST['csrf_token']) || $_REQUEST['csrf_token'] !== $_SESSION['CSRF']) {

                header('HTTP/1.1 403 Forbidden');
                include_once dirname(__DIR__) . '../app/views/templates/errors/csrf.php';
                exit();
            }
        }

        return true;
    }
    /**
    *
    * # check if acces set in routes array guest or authenticated user 
    *
    * @ return boolean 
    */
    private function checkAcces($routes)
    {
     
        if(array_key_exists('acces', $routes))
        {   
            if(in_array('auth', $routes['acces']) && !in_array('guest', $routes['acces']))
            {
                if(!isset($_SESSION['user']))
                {
                    header("HTTP/1.1 403 Forbidden");
                    include_once dirname(__DIR__) . '/app/views/templates/errors/403.php';
                    exit();
                } 
            }

            if(in_array('guest', $routes['acces']) && !in_array('auth', $routes['acces']))
            {
                if(isset($_SESSION['user']))
                {
                    if(isset($_SERVER['HTTP_REFERER'])){
                        header('location:' . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("HTTP/1.1 403 Forbidden");
                        include_once dirname(__DIR__) . '/app/views/templates/errors/403.php';
                        exit();
                    }
                    
                }
            }
        }
        
        return true;
    }

    
    
}