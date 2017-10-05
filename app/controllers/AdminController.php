<?php 

class AdminController extends Controller
{
    

    public function index()
    {
        echo 'Fallback to index';        
    }

        
    public function getAdminLogin()
    {
        return $this->view('auth/login');
        
    }

    public function getAdminEdit()
    {
        if(!$this->authUser()) {
            return $this->redirect('admin/login');
        }

        $pages = $this->model('Page');
        

        return $this->view('admin/edit', ['pages' => $pages]);
    }
    
    public function adminAccount()
    {
        if(!$this->authUser()) {
            return $this->redirect('admin/login');
        }

        return $this->view('auth/register');

    }
    

    
    


    
}