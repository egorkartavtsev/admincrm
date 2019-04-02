<style>
    .error{
        color: #902b2b;
    }
    .success{
        color: #006400;
    }
</style>
<?php foreach($errors as $err){ ?>
    <p class="error"><?php echo $err;?></p>
<?php }?>
<br><hr><br>
<?php foreach($success as $suc){ ?>
    <p class="succ"><?php echo $suc;?></p>
<?php }?>
<h3>Через 3 секунды произойдёт переход в документы!</h3>