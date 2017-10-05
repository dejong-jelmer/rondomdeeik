<?php 
   
$pages = null;
$articles = null;
$images = null;

if(array_key_exists('pages', $data)) {

    $pages = $data['pages']->pages;
}

if(array_key_exists('articles', $data)) {

    $articles = $data['articles']->articles;
}

if(array_key_exists('images', $data)) {

    $images = $data['images']->images;
}

require_once '/../templates/header.php';
include_once '/../templates/navbar.php';

?>


<?php  include_once '/../templates/messages.php'; ?>

<?php
    if($this->authUser()) {
        // include sidemenu
        include_once '/../templates/sidemenu.php'; 
    }
    ?>
<div id="wrapper">
    <?php 
        if($this->authUser()) { 
        ?>
            <button type="button" class="btn btn-default btn-sm" onClick="openNav()">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
            </button>
        <div class="row">
            <div style="height:100px;">
                   
                <!-- include messages -->
                <?php  include_once '/../templates/messages.php'; ?>
            </div>
        </div>
          
        
    <?php 
        } 
        ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding:0px;">
                <div class="tab-content" id="tab-content">
                <?php
                    // load pages
                    foreach ($pages as $page) {   
                    ?>
                        <div class="tab-pane fade" id="<?php echo $page['name']; ?>">
                        <?php
                            // load articles
                            foreach ($articles as $article) {    
                                // only articles that belong to the page
                                if($article['page_id'] == $page['id']) {
                                    $countImages = $data['articles']->hasImages($article['id']);
                                    // articel title
                                    echo '<div class="row page">';
                                    echo '<div class="article ';
                                    if($countImages) { echo 'col-sm-6 col-sm-push-6';} else { echo 'col-md-12'; }
                                    echo '">';
                                        // article title
                                        echo '<h2>'.str_replace('_', ' ', ucfirst(strtolower($article['title']))) .'</h2>';
                                        // article lead
                                        echo '<b>'.$article['lead'].'</b>';
                                         // show article content
                                        echo '<p>'.$article['content'].'</p>';
                                    echo '</div>'; // end of article
                                    
                                    // load images
                                    if($countImages) {
                                        echo '<div class="col-sm-6 col-sm-pull-6">';
                                        echo '<div id="myCarousel'.$article['id'].'" class="carousel slide article-img" data-ride="carousel">';
                                            if($countImages > 1) {
                                                echo '<ol class="carousel-indicators">';
                                                $i = 0;
                                                foreach ($images as $image) {
                                                    // only images that belong to the article
                                                    if($image['article_id'] == $article['id']) {      
                                                        echo '<li data-target="#myCarousel'.$article['id'].'" data-slide-to="'.$i.'" class="';
                                                        if($i == 0) {echo 'active';} 
                                                        echo '"></li>';
                                                    $i++;
                                                    }
                                                }
                                                echo '</ol>';
                                            }
                                            echo '<div class="carousel-inner">';
                                        
                                            $i = 0;
                                            
                                            foreach ($images as $image) {
                                                 // only images that belong to the article
                                                if($image['article_id'] == $article['id']) {   
                                                                               
                                                    echo '<div class="item'; 
                                                        if ($i == 0) { echo ' active'; }
                                                        echo  '">';
                                                        echo '<img class="img-responsive" src="';
                                                        echo $image['location'];
                                                        echo '" alt="';
                                                        echo $image['name'];
                                                        echo '" style="width:100%">';
                                                    echo '</div>';
                                                    $i++;
                                                }
                                            }
                                            echo '</div>';
                                            if($countImages > 1) {
                                                echo '<a class="left carousel-control" href="#myCarousel'.$article['id'].'" data-slide="prev">';
                                                    echo '<span class="glyphicon glyphicon-chevron-left"></span>';
                                                    echo '<span class="sr-only">Previous</span>';
                                                echo '</a>';
                                                echo '<a class="right carousel-control" href="#myCarousel'.$article['id'].'" data-slide="next">';
                                                    echo '<span class="glyphicon glyphicon-chevron-right"></span>';
                                                    echo '<span class="sr-only">Next</span>';
                                                echo '</a>';
                                            }
                                        echo '</div>'; // end of carousel
                                        echo '</div>';
                                        } 
                                       
                                    
                                    echo '</div>'; // end of row
                                } 
                            }
                        ?>

                        </div> <!--  end of tab-pane-->
                <?php 
                
                    } 
                    ?>
                </div> <!-- end of tab-content-->
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div>

<?php     include_once '/../templates/footer.php'; ?>

<script type="text/javascript">
    window.onload = function() {
        var nav = document.getElementById("menu");
        var firstLi = nav.children[0];
        var active = firstLi.classList.add("active");


        var tabContent = document.getElementById("tab-content");
        var firstDiv = tabContent.children[0];
        
        var firstPage = firstDiv;
        
        firstPage.classList.add("active");
        firstPage.classList.add("in");
    }

   

</script>