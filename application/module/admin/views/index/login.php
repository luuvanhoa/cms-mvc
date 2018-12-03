<?php
    $linkAction = URL::createLink('admin', 'index', 'login'); 
    $username   = @$this->arrParam['form']['username'];
    $password   = @$this->arrParam['form']['password'];
?>
<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    <form action="<?php echo $linkAction; ?>" method="post">
        <div class="body bg-gray">
            <?php if(!empty($this->errors)) echo $this->errors; ?>
            <!-- USERNAME -->
            <div class="form-group">
                <input type="text" name="form[username]" class="form-control" placeholder="Username" value="<?php echo $username ?>" />
            </div>
             <!-- PASSWORD -->
            <div class="form-group">
                <input type="password" name="form[password]" class="form-control" placeholder="Password" value="<?php echo $password ?>" />
            </div>          
            <!-- TOKEN -->
            <input name="form[token]" type="hidden" value="<?php echo time();?>" />
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Sign me in</button>
        </div>
    </form>   
</div>