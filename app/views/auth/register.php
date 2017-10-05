<?php  require '/../templates/header.php'; ?>

<!-- include sidemenu -->
<?php  include '/../templates/sidemenu.php'; ?>

<!-- main page content starts here -->
<div id="wrapper">
    <button type="button" class="btn btn-default btn-sm" onClick="openNav()">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
    </button>
    <div class="row">
        <div style="height:100px;">
            <!-- include messages -->
            <?php  include '/../templates/messages.php'; ?>
        </div>
    </div>
           
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-5">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#password">Wachtwoord</a></li>
                    <li><a data-toggle="tab" href="#create">Account</a></li>
                </ul>
            </div>
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="tab-content">
                    <div id="password" class="tab-pane fade in active">
                        <form action="<?php echo $this->route('auth/editpassword'); ?>" method="POST">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Wachtwoord aanpassen
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                    <label class="form-group" for="oldPassword">Oud wachtwoord:</label>
                                        <input id="oldPassword" type="text" class="form-control" name="oldPassword" placeholder="Oud wachtwoord">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-group" for="newPassword">Nieuw wachtwoord:</label>
                                        <input id="newPassword" type="text" class="form-control" name="newPassword" placeholder="Nieuw wachtwoord">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-group" for="repPassword">Herhaal wachtwoord:</label>
                                        <input id="repPassword" type="text" class="form-control" name="repPassword" placeholder="Herhaal wachtwoord">
                                    </div>
                                    <button type="submit" class="btn btn-default pull-right">Verstuur</button>
                                </div>
                            </div>
                            <!-- hidden inputs -->
                            <input type="hidden" name="csrf_token" value="<?php echo $this->token(); ?>">
                        </form> <!-- end of form -->
                    </div>
                    <div id="create" class="tab-pane fade in">
                        <form action="<?php echo $this->route('auth/register'); ?>" method="POST">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Aanmaak gebruikersaccount
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                    <label class="form-group" for="username">Inlognaam van de nieuwe gebruiker:</label>
                                        <input id="username" type="text" class="form-control" name="username" placeholder="Inlognaam">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-group" for="email">Emailadres van de nieuwe gebruiker:</label>
                                        <input id="email" type="email" class="form-control" name="email" placeholder="Emailadres">
                                    </div>
                                    <button type="submit" class="btn btn-default pull-right">Verstuur</button>
                                </div>
                            </div>
                            <!-- hidden inputs -->
                            <input type="hidden" name="csrf_token" value="<?php echo $this->token(); ?>">
                        </form> <!-- end of form -->
                    </div>          
                </div> <!-- end of tab-content -->
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of wrapper -->
<!-- include footer -->
<?php include '/../templates/footer.php';?>

