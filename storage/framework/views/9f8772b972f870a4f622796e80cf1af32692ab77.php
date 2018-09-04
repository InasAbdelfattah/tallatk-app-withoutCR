<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taletak</title>
    <link rel="shortcut icon" href="<?php echo e(request()->root()); ?>/TaletakWeb/images/Logo.png">
    <link rel="stylesheet" href="<?php echo e(request()->root()); ?>/TaletakWeb/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo e(request()->root()); ?>/TaletakWeb/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="<?php echo e(request()->root()); ?>/TaletakWeb/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo e(request()->root()); ?>/TaletakWeb/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

</head>

<body>
    <div class="illustration">
        <div class="nav">
            <div class="container">
                <?php if(count($errors) > 0): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
                    <div class="alert alert-warning alert-styled-left">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <?php echo e($error); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-styled-left">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <?php echo e(Session::get('success')); ?>

                </div>
            <?php endif; ?>
            
            <?php if(Session::has('fail')): ?>
            
                <div class="alert alert-warning alert-styled-left">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <?php echo e(Session::get('fail')); ?>

                </div>
            
            <?php endif; ?>
                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="logo text-center">
                            <a href="<?php echo e(route('home')); ?>">
                            <img class="img" src="<?php echo e(request()->root()); ?>/TaletakWeb/images/Logo.png" height="100">
                            </a>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>

        <div class="container">
            
            
            
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="downloadApp">
                                <h1>الشروط والأحكام</h1>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="par">
                                <p>
                                <?php echo $setting->getBody('terms'); ?>

                                </p>
                                <!--<p>أكثر من 250 مركز تجميل</p>-->
                                <!--<p>أكثر من 500 متخصص يعتنون بجمالك</p>-->
                                <!--<p id="vertical">تنفيذ أكثر من 85 خدمة للحفاظ على جمالك</p>-->
                            </div>
                        </div>
                        <!--<div class="col-12 text-center">-->
                        <!--    <div class="row no-gutters">-->
                        <!--        <div class="col-6 col-md-3">-->
                        <!--            <div class="googlePlay">-->
                        <!--                <a href="#"><img class="img img-fluid" src="<?php echo e(request()->root()); ?>/TaletakWeb/images/googlePlay.png"></a>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--        <div class="col-6 col-md-3">-->
                        <!--            <div class="googlePlay">-->
                        <!--                <a href="#"><img class="img img-fluid" src="<?php echo e(request()->root()); ?>/TaletakWeb/images/googlePlay.png"></a>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <!--<div class="col-12 text-center">-->
                        <!--    <div class="row no-gutters">-->
                        <!--        <div class="col-9 col-md-8 col-lg-5 offset-lg-4">-->
                        <!--            <div class="row no-gutters">-->
                        <!--                <div class="col-6 col-md-3">-->
                        <!--                    <div class="followUs">-->
                        <!--                        <span>تابع جديدنا</span>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="col-6">-->
                        <!--                    <div class="social">-->
                        <!--                        <a href="#"><i class="fa fa-facebook" style="color: #3b5998"></i></a>-->
                        <!--                    </div>-->
                        <!--                    <div class="social">-->
                        <!--                        <a href="#"><i class="fa fa-instagram" style="color: #3b5998"></i></a>-->
                        <!--                    </div>-->
                        <!--                    <div class="social">-->
                        <!--                        <a href="#"><i class="fa fa-twitter" style="color: #3b5998"></i></a>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="mobileLogo">
                        <img class="img img-fluid" src="<?php echo e(request()->root() . '/' . $setting->getBody('site_image')); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(request()->root()); ?>/TaletakWeb/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="<?php echo e(request()->root()); ?>/TaletakWeb/js/bootstrap.min.js"></script
    

</body>

</html>