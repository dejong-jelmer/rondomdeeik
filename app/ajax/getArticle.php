<?php 
require_once dirname(__DIR__) . '/app/models/Article.php';
require_once dirname(__DIR__) . '/app/models/Image.php';


$articleId = $_GET['article_id'];

$articles = new Article();
$article = $articles->find($articleId);


$image = new Image();
$images = $image->findByArticleId($articleId);

$response = [ 'article' => $article, 'images' => $images ];
// $response = json_encode($article) . json_encode($images);

echo json_encode($response);
 