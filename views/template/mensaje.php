<?php if($exito !== null) :?>
    <?php if(!$exito) :?>
        <p class="mensaje error"><?php echo $mensaje ?></p>
    <?php endif ?>

    <?php if($exito) :?>
        <p class="mensaje exito"><?php echo $mensaje ?></p>
    <?php endif ?>
<?php endif ?>