<?php 
require_once dirname(__DIR__) . '/core/Model.php';


/**
* # image model
*/
class Page extends Model
{

    public $pages;

    function __construct()
    {
        $this->pages = $this->getAllPages();        
    }

    public function find($id)
    {
        return $this->findPage($id);
        
    }

    public function create($user_id, $page_name)
    {
        return $this->createNewPage($user_id, $page_name);
    }

    public function delete($user_id, $page_id)
    {
        return $this->deletePage($user_id, $page_id);
    }
    
}