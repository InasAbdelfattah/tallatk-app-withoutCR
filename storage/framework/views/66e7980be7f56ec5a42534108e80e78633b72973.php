<?php $__env->startSection('title','اضافة مدينة'); ?>
<?php $__env->startSection('content'); ?>

    <div id="messageError"></div>
    <form data-parsley-validate novalidate method="POST" action="<?php echo e(route('cities.store')); ?>"
          enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <a href="<?php echo e(route('cities.index')); ?>" type="button" class="btn btn-custom waves-effect waves-light"
                       aria-expanded="false"> مشاهدة جميع المدن
                        <span class="m-l-5">
                        <i class="fa fa-backward"></i>
                    </span>
                    </a>

                </div>
                <h4 class="page-title">المدن</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">إضافة مدينة جديدة</h4>

                    <div class="form-group<?php echo e($errors->has('name_ar') ? ' has-error' : ''); ?>">
                        <label for="userName">اسم المدينة عربى*</label>
                        <input type="text" name="name_ar" parsley-trigger="change" required
                               placeholder=" ادخل اسم المدينة عربى..." class="form-control" value="<?php echo e(old('name')); ?>"
                               id="userName"
                               data-parsley-required-message="هذا الحقل إلزامي" data-parsley-maxlength="50"
                               data-parsley-maxlength-message="تجاوزت الحد الأقصى لعدد الحروف المسموحة وهى 50 ">

                        <?php if($errors->has('name_ar')): ?>
                            <span class="help-block">
                                        <strong><?php echo e($errors->first('name_ar')); ?></strong>
                                    </span>
                        <?php endif; ?>

                    </div>


                    <div class="form-group<?php echo e($errors->has('name_en') ? ' has-error' : ''); ?>">
                        <label for="userName">اسم المدينة انجليزى*</label>
                        <input type="text" name="name_en" parsley-trigger="change" required
                               placeholder=" ادخل اسم المدينة انجليزى.." class="form-control" value="<?php echo e(old('name')); ?>"
                               id="userName"
                               data-parsley-required-message="هذا الحقل إلزامي" data-parsley-maxlength="50"
                               data-parsley-maxlength-message="تجاوزت الحد الأقصى لعدد الحروف المسموحة وهى 50 ">

                        <?php if($errors->has('name_en')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name_en')); ?></strong>
                            </span>
                        <?php endif; ?>

                    </div>

                    <div class="form-group text-right m-b-0">
                        <button class="btn btn-primary waves-effect waves-light" type="submit"> حفظ البيانات
                        </button>
                        <!--<button onclick="window.history.back();return false;"-->
                        <!--        class="btn btn-default waves-effect waves-light m-l-5"> إلغاء-->
                        <!--</button>-->
                    </div>

                </div>
            </div><!-- end col -->


        </div>
        <!-- end row -->
    </form>


<?php $__env->stopSection(); ?>










































<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>