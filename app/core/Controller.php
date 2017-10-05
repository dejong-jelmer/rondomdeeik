<?php 
require_once 'BaseController.php';

class Controller extends BaseController
{
        
    protected function model($model)
    {
        if(file_exists(dirname(__DIR__) . '/models/' . $model . '.php'))
        {
            require_once dirname(__DIR__) . '/models/' . $model . '.php';

            return new $model();
        }
    }

    protected function view($view, $data = [])
    {      
        require_once dirname(__DIR__) . '/views/' . $view . '.php';
    }

    protected function redirect($url, $permanent = false)
    {   
        if($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
            include_once dirname(__DIR__) . '/views/templates/errors/301.php';
        }   
        
        header('location:' . $this->root . '/' . $url);
        exit();
    }
    
    protected function authUser()
    {
        return $this->checkUserLogin();
    }

    protected function session($args = false)
    {
        if(isset($_SESSION)) {

            if($args !== false) {
                return (object) $_SESSION[$args];

            } else {

                return (object) $_SESSION;
            }
        }

        return false;
    } 

    protected function sessionErrors()
    {
        return $this->checkErrors();
    }

    protected function sessionSuccess()
    {
        return $this->checkSuccess();
    }


    /**
    *
    * # Save image to public/img folder. Check format/size/exits
    *
    * @return boolean true / string $errors 
    */

    protected function saveImage($image, $articleId)
    {
        $error = '';
        $imgName = strtolower($image['name']);
        $imgSize = $image['size'];
        $imgTmp = $image['tmp_name'];
        $imgType = $image['type'];
        $tmp = explode('.', $imgName);
        $imgExt = end($tmp);
        $targetLocation = "public/img/articleImages/".$imgName;

        $expresions = ['jpg', 'jpeg', 'png', 'gif'];
            
        if(!in_array($imgExt, $expresions)) {
            $error = "Het bestantstype is niet toegestaan. Kies een .jpg/.jpeg/.png/.gif bestand.";
        }

        if($imgSize > 2097152) {
            $error = "Het bestand is te groot. Max. 2 MB.";
        }

        if(file_exists('../'.$targetLocation)) {
            
            $error = "Het bestand bestaat al en is al geüpload.";
        }

        if(empty($error)) {
            if(move_uploaded_file($imgTmp,'../'.$targetLocation)) {

                $image = $this->model('Image');
                $image->create($articleId, $imgName, $imgType, $imgSize, $targetLocation);
               
                
            }  else {
                $error = "Het is niet gelukt het bestand op te slaan.";
            }
        }

        return $error;
    }

    protected function formValidation($article, $page_id, $article_id, $title, $content, $user_id, $page_name)
    {
        
        $errors = [];
        
        if($article !== false) {
            foreach ($article->articles as $article) {
                $articleTitles[] = $article['title'];
            }

            if((bool) in_array($title, $articleTitles)) {
                $errors = $this->editArticleErrors('titleExists');
            }
        }
        if($page_id !== false) {
            if(empty($page_id)) {
                $errors = $this->editArticleErrors('emptyPageId');
            }
        }        
        if($article_id !== false) {
            if(empty($article_id)) {
                $errors = $this->editArticleErrors('emptyArticleId');
            }
        }
        if($title !== false) {
            if(empty($title)) {
                $errors = $this->editArticleErrors('emptyTitle');
            }
        }
        if($content !== false) {
            if(empty($content)) {
                $errors = $this->editArticleErrors('emptyContent');
            } 
        }
        if($user_id !== false) {
            if(!isset($user_id)) {
                $errors = $this->editArticleErrors('emptyUserId');
            }
        }

        if($page_name !== false) {
            if(!isset($page_name)) {
                $errors = $this->editArticleErrors('emptyPageName');
            }
        }

       
        return $errors;

    }

    protected function validateRegisteration($user, $username, $email)
    {
        $errors = [];
        
        if($username !== false) {
            if(!isset($username)) {
                $errors = $this->registrationErrors('emptyUsername');
            }

            if(strlen($username) <= '3' || strlen($username) >= '16') {
                $errors = $this->registrationErrors('invalidLenghtUsername');
            }

            if(!preg_match('/^[a-z0-9 .\-]+$/i', $username)) {
                $errors = $this->registrationErrors('invalidCharUsername');
            }

            foreach ($user->users as $userData) {
                $userUsernames[] = $userData['username'];
            }

            if((bool) in_array($username, $userUsernames)) {
                $errors = $this->registrationErrors('usernameExists');
            }
            unset($userData);
        }

        if($email !== false) {
            if(!isset($email)) {
                $errors = $this->registrationErrors('emptyEmail');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors = $this->registrationErrors('invalidEmail');
            }

            foreach ($user->users as $userData) {
                $userEmails[] = $userData['email'];
            }

            if((bool) in_array($email, $userEmails)) {
                $errors = $this->registrationErrors('emailExists');
            }
            unset($userData);
        }


        return $errors;

    }

    protected function validatePassword($oldPassword, $newPassword, $repPassword) 
    {
        $errors = [];
        
        if($newPassword !== false) {
            if(empty($newPassword)) {
                $errors = $this->passwordErrors('emptyNewPassword');
            }

            if(strlen($newPassword) <= '5' || strlen($newPassword) >= '16') {
                $errors = $this->passwordErrors('invalidLenghtPassword');
            }

            if(!preg_match("#[0-9]+#", $newPassword)) {
                $errors = $this->passwordErrors('numberCheckFail');
            }

            
        }

        if($repPassword !== false) {

            if(empty($repPassword)) {
                $errors = $this->passwordErrors('emptyRepPassword');
            }

            if($repPassword !== $newPassword) {
                $errors = $this->passwordErrors('passwordCheckFail');
            }
        }
            

        if($oldPassword !== false) {

            if(empty($oldPassword)) {
                $errors = $this->passwordErrors('emptyOldPassword');
            }

            if(!password_verify($oldPassword, $this->session('user')->password)) {
                $errors = $this->passwordErrors('wrongPassword');
            } 
        }

        return $errors;
    }

    private function registrationErrors($error)
    {
        switch ($error) {
            case 'emptyUsername':
                $response = 'Gebruikersnaam mag niet leeg zijn.';
                break;
            case 'invalidLenghtUsername':
                $response = 'Gebruikersnaam moet minstens 3 en maximaal 16 tekens lang zijn.';
                break;
            case 'invalidCharUsername':
                $response = 'Gebruikersnaam mag alleen uit letters en spaties bestaan.';
                break;
            case 'usernameExists':
                $response = 'Gebruikersnaam is al in gebruik.';
                break;
            case 'emptyEmail':
                $response = 'Email mag niet leeg zijn.';
                break;
            case 'invalidEmail':
                $response = 'Geen geldige email ingevoerd';
                break;
            case 'emailExists':
                $response = 'Email is al in gebruik.';
                break;
            
            default:
                $response = 'Er is iets misgegaan.';
                break;
        }

        return $response;
    }

    private function editArticleErrors($error)
    {
        switch ($error) {
            case 'emptyArticleId':
                $response = 'Er is geen artikel geselecteerd.';
                break;
            case 'emptyPageId':
                $response = 'Er is geen pagina voor het artikel geselecteerd.';
                break;
            case 'emptyContent':
                $response = 'Tekst mag niet leeg zijn.';
                break;
            case 'editFail':
                $response = 'Het is niet gelukt het artikel aan te passen.';
                break;
            case 'titleExists':
                $response = 'Het title van het artikel bestaat al.';
                break;
            case 'emptyTitle':
                $response = 'Titel mag niet leeg zijn.';
                break;
            case 'emptyPageName':
                $response = 'Pagina naam mag niet leeg zijn.';
                break;
            case 'imageFail':
                $response = 'Er is iets mis met het bestand. Hierdoor is hij niet toegevoegd.';
                break;
            case 'deleteFail':
                $response = 'Het verwijderen van het artikel is niet gelukt.';
                break;
            case 'emptyUserId':
                $response = 'Geen geldige gebruiker.';
                break;
            default:
                $response = 'Er is iets misgegaan.';
                break;
        }

        return $response;
    }

    private function passwordErrors($error)
    {
        switch ($error) {
            case 'emptyOldPassword':
                $response = 'Vul een oud wachtwoord in.';
                break;
            case 'emptyNewPassword':
                $response = 'Vul een nieuw wachtwoord in.';
                break;
            case 'emptyRepPassword':
                $response = 'Herhaal je nieuwe wachtwoord.';
                break;
            case 'passwordCheckFail':
                $response = 'Wachtworden komen niet overeen.';
                break;
            case 'wrongPassword':
                $response = 'Het opgegeven wachtword is niet juist.';
                break;
            case 'invalidLenghtPassword':
                $response = 'Het wachtword moet minstens 5 en maximaal 16 tekens lang zijn.';
                break;
            case 'numberCheckFail':
                $response = 'Het wachtword moet minstens 1 nummer bevatten.';
                break;
            default:
                $response = 'Er is iets misgegaan.';
                break;
        }
        
        return $response;
    } 

    protected function checkUploadedFileError($errorCode)
    {
        switch ($errorCode) {
            case 0:
                $text = 'There is no error, the file uploaded with success.';
                $error = false;
                break;
            case 1:
                $text = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                $error = true;
                break;
            case 2:
                $text = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                $error = true;
                break;
            case 3:
                $text = 'The uploaded file was only partially uploaded.';
                $error = true;
                break;
            case 4:
                $text = 'No file was uploaded.';
                $error = true;
                break;
            case 6:
                $text = 'Missing a temporary folder.';
                $error = true;
                break;
            case 7:
                $text = 'Failed to write file to disk.';
                $error = true;
                break;
            case 8:
                $text = 'A PHP extension stopped the file upload.';
                $error = true;
                break;                                              
              default:
                $text = 'Onbekende fout bij uploaden bestand.';
                $error = true;
                break;
        } 
        
        $response = ['error' => $error, 'text' => $text];

        return (object) $response;
    }

    

    
}
