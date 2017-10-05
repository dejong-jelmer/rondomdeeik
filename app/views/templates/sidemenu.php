<div id="sideNav" class="sidenav">
    <div id="sideNavContent">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="<?php echo $this->route('home'); ?>">Home</a>
        <a href="<?php echo $this->route('admin/edit'); ?>">Editor</a>
        <a href="<?php echo $this->route('admin/account'); ?>">Account&nbsp;beheer</a>
        <a href="<?php echo $this->route('auth/logout'); ?>">Logout</a>
    </div>
</div>