
<?php 
if($this->sessionErrors() || $this->sessionSuccess()) {
    ?>

    <div class="alert <?php if($this->sessionErrors()) {echo 'alert-danger alert-dismissable';} elseif ($this->sessionSuccess()) {echo 'alert-success alert-dismissable';} ?>" role="alert">
    <?php
    if($this->sessionErrors()) {
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '<span class="glyphicon glyphicon-remove-circle"></span> '; 
        if(is_array($_SESSION['error'])) {
            echo '<p style="text-align:left;">Er is iets misgegaan:</p>';
            echo '<ul style="text-align:left;">';
            foreach ($_SESSION['error'] as $error) {
                echo "<li>".$error."</li>";
            }
            echo '</ul>';

        } else {
            echo $_SESSION['error'];
        }
        unset($_SESSION['error']);
    }
        ?>
    <?php if($this->sessionSuccess()) { 
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '<span class="glyphicon glyphicon-ok-circle"></span> '; 
        if(is_array($_SESSION['success'])) {
                echo '<ul style="text-align:left;">';
                foreach ($_SESSION['success'] as $success) {
                    echo "<li>".$success."</li>";
                }
                echo '</ul>';

            } else {
                echo $_SESSION['success'];
            }
            unset($_SESSION['success']);
        }?>
    </div>
        
<?php 

} ?>

