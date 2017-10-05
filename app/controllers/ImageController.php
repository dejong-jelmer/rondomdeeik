<?php 
/**
 * Class to handle images
 */
 
class ImageController extends Controller
{  

    public function index()
    {
        echo 'Fallback to index';
    }

    public function deleteImage()
    {

        $image_id = $_POST['imageId'];
        $user_id = $this->session()->user['id'];

        // var_dump($user_id);
        // die();

        $image = $this->model('Image');
        
        if((bool) $image->delete($image_id, $user_id)) {

            $_SESSION['success'] = 'Afbeelding is verwijderd.';
        } else {
            $_SESSION['error'] = 'Er is iets misgegaan met het verwijderen van de afbeelding.';
        }
        

        return $this->redirect('admin/edit');

    }


}
