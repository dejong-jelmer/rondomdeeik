<?php 
require '/../templates/header.php';
   

?>
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div style="height:100px;">
                <!-- include messages -->
                <?php  include '/../templates/messages.php'; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <form action="<?php echo $this->route('auth/login'); ?>" method="POST">
                    <div class="panel panel-default login-field">
                        <div class="panel-body">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="username" type="text" class="form-control" name="username" placeholder="Gebruikersnaam">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                       
                        <div class="form-group">
                            <button class="btn btn-default pull-right" type="submit">Login</button>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo $this->route('home'); ?>"><span class="glyphicon glyphicon-home"></span> Naar de pagina </a>
                        </div>
                        <!-- hidden inputs -->
                        <input type="hidden" name="csrf_token" value="<?php echo $this->token(); ?>">
                        </div> <!-- end of panel body -->
                    </div> <!-- end of panel -->
                </form> <!-- end of form -->
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div>


<br>
<br>

<?php 
    include '/../templates/footer.php';
 ?>