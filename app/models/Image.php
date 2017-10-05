<?php 
require_once dirname(__DIR__) . '/core/Model.php';


/**
* # image model
*/
class Image extends Model
{
    
    public function __construct()
    {
        $this->images = $this->getAllImages();
        
    }

    public function create($article_id, $name, $type, $size, $location)
    {
        $this->createNewImage($article_id, $name, $type, $size, $location);
    }

    public function findByArticleId($article_id)
    {
        return $this->getImageByArtikleId($article_id);
    }

    public function delete($image_id, $user_id)
    {
        return $this->deleteAnImage($image_id, $user_id);
    }
    
}