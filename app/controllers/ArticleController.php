<?php 
/**
 * Class to handle articles
 */
 
class ArticleController extends Controller
{   
    

    public function index()
    {
        echo 'Fallback to index';
    }
    
    
    public function editArticle()
    {

        // empty feedback array's
        $errors = [];
        $success = [];

        // Set form POST to variables
         // get article id
        $article_id = false;

        if(isset($_POST['selectArticle'])) {
            $article_id = $_POST['selectArticle'];
        } 

         // get inputfields content
        $title = str_replace(' ', '_', $_POST['title']);
        $lead = $_POST['lead'];      
        $content = $_POST['content'];
               
         // get page and user id's
        $page_id = $_POST['selectPage'];       
        $user_id = $this->session()->user['id'];      
        
        // load Article model
        $article = $this->model('Article');

        // edit the article
        switch($_POST['articleFormHandler']) {
            // create new article
            case "newArticle":
                // validate the form
                $errors = $this->formValidation($article, $page_id, false, $title, $content, $user_id, false);
                if(empty($errors)) {
                    // get returned id from created article for image table
                    $article_id = $article->create($page_id, $title, $lead, $content, $user_id, false);
                    if((bool) $article_id) {
                        $success = 'Het artikel is geplaatst.';
                    }
                }
                break;
            // edit existing article 
            case "editArticle":
                // validate the form
                $errors = $this->formValidation(false, $page_id, $article_id, $title, $content, $user_id, false);
                if(empty($errors)) {
                    // get returned id from created article for image table 
                    if((bool) $article->edit($article_id, $page_id, $title, $lead, $content, $user_id, false)) {
                        $success = 'Het artikel is aangepast.';
                    }
                }
                break;
            // delete article
            case "deleteArticle":
                // validate the form
                $errors = $this->formValidation(false, false, $article_id, false, false, $user_id, false);
                if(empty($errors)) {
                    if((bool) $article->delete($user_id, $article_id)) {
                        $success = 'Het artikel is verwijderd.';
                    }
                }
                break;
            // bind page to other article
            case "switchPage":
                $errors = $this->formValidation(false, $page_id, $article_id, false, false, $user_id, false);
                if(empty($errors)) {
                    if((bool) $article->bindPage($page_id, $article_id, $user_id)) {
                        $success = 'Het artikel is naar andere pagina veplaatst.';
                    }
                }
                break;
            default:
                $errors = 'Systeemfout: geen form handler geselecteerd.'; 
                break;
        }
        if(!empty($_FILES)) {
            $image = $_FILES['image'];
            // check upload for errors
            $upload = $this->checkUploadedFileError($image['error']);
            if(!$upload->error) {
                
                $saveImage = $this->saveImage($image, $article_id);

                if(empty($saveImage)) {
                    $success = 'Het bestand is  opgeslagen.';
                    
                } else {
                    $errors = $saveImage;
                }
            } else {
                $errors = $upload->text;
            }
            
        }
        
        if(empty($errors)) {
            
            $_SESSION['success'] = $success;

        } else {

            $_SESSION['error'] = $errors;
        }

        return $this->redirect('admin/edit');
    }

 
 
}
 
