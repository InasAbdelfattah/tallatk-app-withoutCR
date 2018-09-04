<?php $__env->startSection('content'); ?>


    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">استعادة ضبط كلمة المرور</h4>


        </div>
        <div class="panel-body">

            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <!--<?php echo e(session('status')); ?>-->
                    تم ارسال رابط استعادة كلمة المرور
                </div>
            <?php endif; ?>
            <form class="form-horizontal m-t-20" method="POST" action="<?php echo e(route('administrator.password.email')); ?>">
                <?php echo e(csrf_field()); ?>



                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>"
                               required placeholder="البريد الإلكتروني...">

                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group text-center m-t-20 m-b-0">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">
                            إرسال البريد
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- end card-box -->

    
    
    
    
    

    
    
    
    
    
    

    
    
    

    
    

    
    
    

    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>