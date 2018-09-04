<?php $__env->startSection('title', 'تعديل الصفحة الشخصية'); ?>
<?php $__env->startSection('content'); ?>


    <form method="POST" action="<?php echo e(route('users.updateProfile', $user->id)); ?>" enctype="multipart/form-data"
          data-parsley-validate novalidate id="js-file-validation-example">
    <?php echo e(csrf_field()); ?>

    <?php echo e(method_field('PUT')); ?>


    <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <h4 class="page-title">تعديل المستخدم</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-30">تعديل بيانات المستخدم</h4>

                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="userName">الاسم الكامل*</label>
                            <input type="text" name="name" value="<?php echo e(isset($user->name) ? $user->name : old('name')); ?>" class="form-control" required data-parsley-required-message="هذا الحقل الزامى"  placeholder="اسم المستخدم بالكامل..."/>
                            <p class="help-block" id="error_userName"></p>
                            <?php if($errors->has('name')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('name')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- <div class="col-xs-6">
                        <div class="form-group<?php echo e($errors->has('username') ? ' has-error' : ''); ?>">
                            <label for="usernames">اسم المستخدم*</label>
                            <input type="text" name="username" value="<?php echo e(isset($user->username) ? $user->username : old('username')); ?>"
                                   class="form-control" placeholder="اسم المستخدم..."/>
                            <?php if($errors->has('username')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('username')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div> -->

                    <div class="col-xs-6">
                        <div class="form-group<?php echo e($errors->has('phone') ? ' has-error' : ''); ?>">
                            <label for="userPhone">رقم الجوال*</label>
                            <input type="text" name="phone" value="<?php echo e(isset($user->phone) ? $user->phone : old('phone')); ?>"
                                   class="form-control" required data-parsley-required-message="هذا الحقل الزامى" 
                                   placeholder="رقم الجوال..."/>
                            <?php if($errors->has('phone')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('phone')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-xs-6">
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="emailAddress">البريد الإلكتروني*</label>

                            <input type="email" name="email" parsley-trigger="change" value="<?php echo e(isset($user->email) ? $user->email : old('email')); ?>" class="form-control" required data-parsley-required-message="هذا الحقل الزامى" placeholder="البريد الإلكتروني..." />
                            <?php if($errors->has('email')): ?>
                                <p class="help-block"><?php echo e($errors->first('email')); ?></p>
                            <?php endif; ?>

                        </div>

                    </div>

                    <?php if($user->is_user !=1): ?>
                    <div class="col-xs-6">
                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="pass1">كلمة المرور*</label>

                            <input type="password" name="password" id="pass1"
                                   class="form-control"
                                   placeholder="كلمة المرور..."
                            />

                            <?php if($errors->has('password')): ?>
                                <p class="help-block"><?php echo e($errors->first('password')); ?></p>
                            <?php endif; ?>

                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                            <label for="passWord2">تأكيد كلمة المرور*</label>
                            <input data-parsley-equalto="#pass1" name="password_confirmation" type="password"
                                   placeholder="تأكيد كلمة المرور..." class="form-control" id="passWord2">
                            <?php if($errors->has('password_confirmation')): ?>
                                <p class="help-block"><?php echo e($errors->first('password_confirmation')); ?></p>
                            <?php endif; ?>


                        </div>
                    </div>

                    <?php endif; ?>

                    <div class="col-xs-6">
                    <div class="form-group">
                        <label for="passWord2">العنوان*</label>
                        <input name="address" value="<?php echo e(isset($user->address) ? $user->address : old('address')); ?>" type="text" required
                               placeholder="العنوان..." class="form-control">

                    </div>
                    </div>

                    <div class="form-group text-right m-t-20">
                        <button class="btn btn-primary waves-effect waves-light m-t-20" type="submit">
                            حفظ البيانات
                        </button>
                        <!--<button onclick="window.history.back();return false;" type="reset"-->
                        <!--        class="btn btn-default waves-effect waves-light m-l-5 m-t-20">-->
                        <!--    إلغاء-->
                        <!--</button>-->
                    </div>

                </div>
            </div><!-- end col -->

            <div class="col-lg-4">
                <div class="card-box" style="overflow: hidden;">


                    <h4 class="header-title m-t-0 m-b-30">الصورة الشخصية</h4>

                    <div class="form-group">
                        <div class="col-sm-12">

                            <input type="hidden" value="<?php echo e($user->image); ?>" name="oldImage"/>
                            <input type="file" name="image" class="dropify" data-max-file-size="6M" accept="image/*"
                                   data-default-file="<?php echo e(request()->root().'/files/users/'.$user->image); ?>" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside"/>

                        </div>
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </form>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>