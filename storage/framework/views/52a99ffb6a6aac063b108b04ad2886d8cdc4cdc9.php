<?php $__env->startSection('content'); ?>


    <div class="container">
    <?php if(isset($series)&& count($series)): ?>
            <h1> Vous <i class="fa fa-heart-o coeur"></i>ces séries :</h1>
            <div class="row">
            <?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xs-3 mosaique" id="self-<?php echo e($serie->id_Serie); ?>">
                    <div  href="<?php echo e(url('serie/'.$serie->id_Serie.'/'.str_replace(" ", "-", $serie->name))); ?>" class="thumbnail">
                        <img src="<?php echo $serie->image_link; ?>" alt="<?php echo ucfirst(strtolower($serie->name)); ?>"
                             class="img-responsive image"/>
                        <div class="overlay">
                            <div class="text"><?php echo ucfirst(strtolower($serie->name)); ?></div>
                            <div class="delete" onclick="javascript:Supprimer(<?php echo e($serie->id_Serie); ?>)"><i class="fa fa-trash fa-3x"></i></div>

                            <?php ($id = $serie->id_Serie); ?>
                            <?php if(auth()->guard()->check()): ?>
                                <div class="rating">
                                    <div id='series-<?php echo e($id); ?>'><script type='text/javascript'>CreateListeEtoile('series-<?php echo e($id); ?>',<?php echo e($serie->note); ?>);</script></div>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="moyenne">
                        <?php switch($serie->moyenne):
                            case (0): ?>
                            <img src="images\notation\0.png">
                            <?php break; ?>
                            <?php case (0.5): ?>
                            <img src="images\notation\05.png">
                            <?php break; ?>
                            <?php case (1): ?>
                            <img src="images\notation\1.png">
                            <?php break; ?>
                            <?php case (1.5): ?>
                            <img src="images\notation\15.png">
                            <?php break; ?>
                            <?php case (2): ?>
                            <img src="images\notation\2.png">
                            <?php break; ?>
                            <?php case (2.5): ?>
                            <img src="images\notation\25.png">
                            <?php break; ?>
                            <?php case (3): ?>
                            <img src="images\notation\3.png">
                            <?php break; ?>
                            <?php case (3.5): ?>
                            <img src="images\notation\35.png">
                            <?php break; ?>
                            <?php case (4): ?>
                            <img src="images\notation\4.png">
                            <?php break; ?>
                            <?php case (4.5): ?>
                            <img src="images\notation\45.png">
                            <?php break; ?>
                            <?php case (5): ?>
                            <img src="images\notation\5.png">
                            <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <?php echo e($series->links()); ?>

    <?php else: ?>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title"> Aucun favoris est associé à votre compte <i class="fa fa-frown-o smiley"></i></div>
                <div class="title"> Il vous suffit de cliquer sur <i class="fa fa-heart-o coeur"></i> pour en ajouter</div>
            </div>
        </div>
    <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <?php if(auth()->guard()->check()): ?>
        <script src="<?php echo e(asset('js/notation.js')); ?>"></script>
        <script src="<?php echo e(asset('js/favoris.js')); ?>"></script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>