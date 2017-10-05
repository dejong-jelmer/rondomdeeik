<?php 
require_once dirname(__DIR__) . '/core/Model.php';

// article model
class Article extends Model
{
        
    public $articles;

    function __construct()
    {
        
        $this->articles = $this->getAllArticles();   
     
    }

   
    public function find($id)
    {
        return $this->getArticle($id);
        
    }

    public function findByPageId($pageId)
    {
        return $this->getArticleByPageId($pageId);
    }
    

    public function create($page_id, $title, $lead, $content, $user_id)
    {
        return $this->createNewArticle($page_id, $title, $lead, $content, $user_id);
    }

    public function edit($article_id, $page_id, $title, $lead, $content, $user_id)
    {
        return $this->editArticle($article_id, $page_id, $title, $lead, $content, $user_id);
    }
    
    public function delete($user_id, $article_id)
    {
        return $this->deleteArticle($user_id, $article_id);
    }

    public function bindPage($page_id, $article_id, $user_id)
    {
        return $this->bindArticleToPage($page_id, $article_id, $user_id);
    }

    public function hasImages($id)
    {
        return $this->checkIfArticleHasImages($id);
    }
    
    
}

