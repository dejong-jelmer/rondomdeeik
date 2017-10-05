<?php 
require_once dirname(__DIR__) . '/app/models/Article.php';


$pageId = $_GET['page_id'];

$articles = new Article();
$article = $articles->findByPageId($pageId);

if(count($article))
{
    echo '<option value="">-- Kies een artikel --</option>';

    foreach ($article as $art) {
        echo '<option value="' . $art['id'] . '">' . ucfirst(strtolower($art['title'])) . '</option>';
    }
}
