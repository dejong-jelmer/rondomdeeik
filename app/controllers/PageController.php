<?php 
/**
 * Class to handle pages
 */
 
class PageController extends Controller
{  

    public function index()
    {
        echo 'Fallback to index';
    }

    public function createPage()
    {

        // empty feedback array's
        $errors = [];
        $success = [];

        // Set form POST to variables
         // get page name 
        $page_name = str_replace(' ', '_', $_POST['pageName']);

         // get page id
        $page_id = $_POST['deletePage'];
        
         // get user id
        $user_id = $this->session()->user['id'];

        // Load page model
        $page = $this->model('Page');

        switch ($_POST['pageFormHandler']) {
            case 'newPage':
                // validate the form
                $errors = $this->formValidation(false, false, false, false, false, $user_id, $page_name);
                if(empty($errors)) {
                    if((bool) $page->create($user_id, $page_name)) {
                        $success = 'De pagina is aangemaakt.';
                    } 
                }
                 
                break;
            case 'deletePage':
                $errors = $this->formValidation(false, $page_id, false, false, false, $user_id, false);
                if(empty($errors)) {
                    if((bool) $page->delete($user_id, $page_id)) {
                        $success = 'De pagina is verwijderd.';
                    } 
                }
                break;
            
            default:
                $errors = 'Systeemfout: geen form handler geselecteerd.'; 
                break;
        }
               
        if(empty($errors)) {
            $_SESSION['success'] = $success;
        } else {
            $_SESSION['error'] = $errors;
        }

        return $this->redirect('admin/edit');

    }


}
