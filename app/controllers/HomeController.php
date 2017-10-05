<?php 

class HomeController extends Controller
{
    

    public function index()
    {
        $pages = $this->model('Page');
        // $pages = $page->pages;

        $articles = $this->model('Article');
        // $articles = $article->articles;

        $images = $this->model('Image');
        // $images = $image->images;    
        
        return $this->view('home/index', ['pages' => $pages, 'articles' => $articles, 'images' => $images]);
    }

        
    


    
}