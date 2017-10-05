<?php
require_once 'Database.php';

class Model
{
    
//------------------------- Authentication -------------------------------

    public function login($username, $password)
    {
        return $this->loginUser($username, $password);
    }

    private function loginUser($username, $password)
    {
        
        $database = new Database();
                
        $sql = "SELECT * FROM `users` WHERE username=?";
                
        $query = $database->getResult($sql, array($username));
        if(isset($query['id'])) {

            if(password_verify($password, $query['password'])) {
                $_SESSION['user'] = $query;
                
                return (object) $query;
            } 
        }
        
        unset($query);                
        return false;
        
    }

    public function logout()
    {
        $this->logoutUser();
    }
    

    private function logoutUser()
    {
        if($this->checkLogin()) {
            session_destroy();
        }
    }

   
    protected function checkLogin()
    {
        if(isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }

    protected function getUserInfo()
    {
        if($this->checkLogin()) {
            return (object) $_SESSION['user'];
        }
    }

    protected function registerNewUser($username, $email)
    {
        $database = new Database();
                
        
        $password = $this->generatePassword();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // $code = hash('sha512', 'register'.$email.''.time());
        
        $created_at = new DateTime();
        $created_at = $created_at->format('Y-m-d H:i:s');
        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "INSERT INTO `users` (username,password,email,created_at,updated_at) VALUES(?,?,?,?,?)";
        $query = $database->prepare($sql, array($username, $hashed_password, $email, $created_at, $updated_at));
        
        if($query['rowCount']) {

            $this->sendRegisterEmail($email, $username, $password);
        }


        return $query['rowCount'];


    }

    protected function changePassword($user_id, $old_password, $new_password)
    {

        $database = new Database();
       
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $sql = "SELECT password FROM `users` WHERE id=?";
                
        $password = $database->getResult($sql, array($user_id));
        
        if(isset($password['password'])) {

            if(password_verify($old_password, $password['password'])) {
                
                $sql = "UPDATE `users` SET password=?,updated_at=? WHERE id=?";
                
                $query = $database->prepare($sql, array($hashed_password, $updated_at, $user_id));
                
                return $query['rowCount'];
            } 
        }

        return false;
    }

    // i'm not using this method, but might later on so left it for now
    private function getUserData($email)
    {
        $database = new Database();

        $sql = "SELECT id FROM `users` WHERE email = ?";
                
        $query = $database->getResults($sql, array($email));  

        return (bool) $query;
    }

    protected function getAllUsers()
     {
        $database = new Database();

        $sql = "SELECT id, username, email, created_at, updated_at FROM `users`";
                
        $query = $database->getResults($sql, array());  

        return (object) $query;
     }  

    private function generatePassword()
    {
        // all character which can be in random string
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&*';

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            // choosing one character from all characters and adding it to random string
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $password = $randomString;

        return $password;
        
    }

    private function sendRegisterEmail($email, $username, $password)
    {

        require_once dirname(__DIR__) . '/phpmailer/PHPMailerAutoload.php';
        
        $mail = new PHPMailer;       
        
        require_once dirname(__DIR__) . '/mailconfig.php';
                
        
        $mail->Subject = 'Je account voor Rondom de eik.';
        $mail->Body    = 'Hallo '. $username . ', <br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= 'Er is een account voor je aangemaakt voor het beheerders gedeelte van de rondom de Eik website. <br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= 'Ga naar <b><a href="www.rondomdeeik.nl/admin/login" target="_blank">www.rondomdeeik.nl/admin/login</a></b>,<br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= 'en log in met je wachtwoord: <b>' . $password . '</b> <br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= 'Onder het kopje account beheer (<small><a href="www.rondomdeeik.nl/admin/login" target="_blank">www.rondomdeeik.nl/admin/account</a></small>), <br>';
        $mail->Body    .= 'kun je je wachtwoord aanpassen.';
        $mail->Body    .= '<br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= 'Groeten, <br>';
        $mail->Body    .= '<br>';
        $mail->Body    .= 'Wijkvereniging Rondom de Eik';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        $mail->addAddress($email, $username);                       // Add a recipient
        // $mail->addAddress('ellen@example.com');                  // Name is optional
        $mail->addReplyTo('noreply@rondomdeeik.nl', 'Wijkvereniging Rondom de eik');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       // Optional name
        $mail->isHTML(true);                                        // Set email format to HTML

        $mail->send();  
        
    }


//------------------------- Pages -------------------------------

    protected function getAllPages()
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `pages` WHERE `deleted` = '0' ORDER BY `id` ASC";
        
        
        $query = $database->getResults($sql);

        if(count($query)) {

            return $test = (object) $query;

        } else {

            $_SESSION['error'] = 'page database error.';
        }
    }
    
    protected function findPage($id)
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `pages` WHERE id=? AND `deleted` = '0'";
        
        $query = $database->getResult($sql, array($id));

        if(isset($query['id'])) {

            return $page = (object) $query;

        } else {

            $_SESSION['error'] = 'database article error.';
        }
    }


    protected function createNewPage($user_id, $page_name)
    {
        $database = new Database();
                       
        $created_at = new DateTime();
        $created_at = $created_at->format('Y-m-d H:i:s');
        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "INSERT INTO `pages` (name,created_by,created_at,updated_at) VALUES(?,?,?,?)";
        
        return $query = $database->prepare($sql, array($page_name, $user_id, $created_at, $updated_at));

    }

    protected function deletePage($user_id, $page_id)
    {
        $database = new Database();
                        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "UPDATE `pages` SET deleted='1',updated_by=?,updated_at=? WHERE id=?";
        
        $query = $database->prepare($sql, array($user_id, $updated_at, $page_id));

        return $query['rowCount'];
    } 

// ------------------------- Articles  -------------------------------
    
    protected function getAllArticles()
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `articles` WHERE `deleted` = '0' ORDER BY `id` ASC";
        
        
        $query = $database->getResults($sql);

        if(count($query)) {

            return $articles = (object) $query;

        } else {

            $_SESSION['error'] = 'article database error.';
        }
    }

    protected function getArticle($id)
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `articles` WHERE id=? AND `deleted` = '0'";
        
        $query = $database->getResult($sql, array($id));

        if(isset($query['id'])) {

            return $article = (object) $query;

        } else {

            $_SESSION['error'] = 'database article error.';
        }
    }

    protected function getArticleByPageId($pageId)
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `articles` WHERE page_id=? AND `deleted` = '0'";
        
        $query = $database->getResults($sql, array($pageId));

        if(count($query)) {

            return $articles = $query;

        } else {

            $_SESSION['error'] = 'database article error.';
        }
    } 


       
    /**
    *
    * # create an new articel and return the last updated article id 
    *
    * @return int $lastInsertId 
    */
    protected function createNewArticle($page_id, $title, $lead, $content, $user_id)
    {
        $database = new Database();
                       
        $created_at = new DateTime();
        $created_at = $created_at->format('Y-m-d H:i:s');
        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "INSERT INTO `articles` (page_id,title,lead,content,updated_by,created_at,updated_at) VALUES(?,?,?,?,?,?,?)";
        
        $query = $database->prepare($sql, array($page_id, $title, $lead, $content, $user_id, $created_at, $updated_at));

        return $lastInsertId = $query['lastInsertId'];
    }

   
    protected function editArticle($article_id, $page_id, $title, $lead, $content, $user_id)
    {
        $database = new Database();
                        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "UPDATE `articles` SET page_id=?,title=?,lead=?,content=?,updated_by=?,updated_at=? WHERE id=?";
        
        $query = $database->prepare($sql, array($page_id, $title, $lead, $content, $user_id, $updated_at, $article_id));

        return $query['rowCount'];
    }

    
    protected function deleteArticle($user_id, $article_id)
    {
        $database = new Database();
                        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "UPDATE `articles` SET deleted='1',updated_by=?,updated_at=? WHERE id=?";
        
        $query = $database->prepare($sql, array($user_id, $updated_at, $article_id));

        return $query['rowCount'];
    } 

    protected function bindArticleToPage($page_id, $article_id, $user_id)
    {
        $database = new Database();
                        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "UPDATE `articles` SET page_id=?,updated_by=?,updated_at=? WHERE id=?";
        
        $query = $database->prepare($sql, array($page_id, $user_id, $updated_at, $article_id));

        return $query['rowCount'];
    }

    protected function checkIfArticleHasImages($id)
    {
        $database = new Database();
                  
        $sql = "SELECT * FROM `images` WHERE article_id=? AND `deleted` = '0'";
        
        $query = $database->prepare($sql, array($id));

        if(count($query['rowCount'])) {

            return $query['rowCount'];
        }
        return false;
    }

// ------------------------- Images  -------------------------------
   
    protected function getAllImages()
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `images` WHERE `deleted` = '0' ORDER BY `id` ASC";
        
        
        $query = $database->getResults($sql);

        if(count($query)) {

            return $images = (object) $query;

        } else {

            $_SESSION['error'] = 'image database error.';
        }
    }
    
       
    protected function createNewImage($article_id, $name, $type, $size, $location)
    {
        $database = new Database();
        $created_at = new DateTime();
        $created_at = $created_at->format('Y-m-d H:i:s');
        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');

        $sql = "INSERT INTO `images` (article_id,name,type,size,location,created_at,updated_at) VALUES(?,?,?,?,?,?,?)";
        
        $query = $database->prepare($sql, array($article_id, $name, $type, $size, $location, $created_at, $updated_at));
    }

    protected function getImageByArtikleId($article_id)
    {
        $database = new Database();
                
        $sql = "SELECT * FROM `images` WHERE article_id=? AND `deleted` = '0'";
        
        $query = $database->getResults($sql, array($article_id));

        if(count($query)) {

            return $images = $query;

        }
    }

    protected function deleteAnImage($image_id, $user_id)
    {
        $database = new Database();
                        
        $updated_at = new DateTime();
        $updated_at = $updated_at->format('Y-m-d H:i:s');
        
        $sql = "UPDATE `images` SET deleted='1',updated_by=?,updated_at=? WHERE id=?";
        
        $query = $database->prepare($sql, array($user_id, $updated_at, $image_id));

        return $query['rowCount'];
    } 




}