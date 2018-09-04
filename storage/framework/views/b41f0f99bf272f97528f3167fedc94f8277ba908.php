<?php $__env->startSection('title', 'إدارة المستخدمين'); ?>
<?php $__env->startSection('content'); ?>


    <form method="POST" action="<?php echo e(route('users.update', $user->id)); ?>" enctype="multipart/form-data"
          data-parsley-validate novalidate>
    <?php echo e(csrf_field()); ?>

    <?php echo e(method_field('PUT')); ?>


    <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">


                    <button type="button" class="btn btn-custom  waves-effect waves-light"
                            onclick="window.history.back();return false;"> رجوع <span class="m-l-5"><i
                                    class="fa fa-reply"></i></span>
                    </button>


                </div>
                
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
                            <input type="text" name="name" value="<?php echo e(isset($user->name) ? $user->name : old('name')); ?>" class="form-control" placeholder="اسم المستخدم بالكامل..."/>
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
                                   class="form-control" 
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

                            <input type="email" name="email" parsley-trigger="change"
                                   value="<?php echo e(isset($user->email) ? $user->email : old('email')); ?>"
                                   class="form-control" placeholder="البريد الإلكتروني..." />
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
                    <br/>

                    <?php endif; ?>
<!-- 
                    <div class="col-xs-6">
                    <div class="form-group">
                        <label for="passWord2">العنوان*</label>
                        <input name="address" value="<?php echo e(isset($user->address) ? $user->address : old('address')); ?>" type="text" required
                               placeholder="العنوان..." class="form-control">

                    </div>
                    </div>
 -->
                    <?php if($user->is_user !=1): ?>
                    <div class="form-group<?php echo e($errors->has('roles') ? ' has-error' : ''); ?>">
                        <label for="passWord2">الصلاحيات *</label>
                        <select multiple="multiple" class="multi-select" id="my_multi_select1" name="roles[]" 
                                data-plugin="multiselect">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <!--<option value="<?php echo e($value->name); ?>"><?php echo e($value->name); ?></option>-->
                                <option value="<?php echo e($value->name); ?>"
                                        <?php if(count($user->roles)>0): ?> <?php $__currentLoopData = $user->roles->pluck('name', 'name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($roleUser == $value->name): ?> selected <?php else: ?> ''<?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?> ><?php echo e($value->name); ?></option>
                            

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php if($errors->has('roles')): ?>
                            <p class="help-block"> <?php echo e($errors->first('roles')); ?></p>
                        <?php endif; ?>

                    </div>
                    
                    
                
                    <?php endif; ?>
                    
                    <div class="col-xs-6">
                    <div class="form-group">
                        <label for="pass1">الحالة *</label>
                        <select class="form-control select2" name="is_active">
                            <option value="1" <?php echo e($user->is_active == 1 ? 'selected' : ''); ?>>مفعل</option>
                            <option value="0" <?php echo e($user->is_active == 0 ? 'selected' : ''); ?>>غير مفعل</option>
                        </select>
                    </div>
                    </div>

                    <!-- <?php if($user->id != 1): ?> -->
                    <!-- <div class="form-group">
                        <label for="pass1">الحالة *</label>
                        <select class="form-control select2" name="is_active">
                            <option value="1" <?php echo e($user->is_active == 1 ? 'selected' : ''); ?>>مفعل</option>
                            <option value="0" <?php echo e($user->is_active == 0 ? 'selected' : ''); ?>>غير مفعل</option>
                        </select>
                    </div>
 -->
                    <!--<div class="form-group">-->
                    <!--    <label for="pass1">حالة الحذر *</label>-->
                    <!--    <select class="form-control select2" name="is_suspend">-->
                    <!--        <option value="1" <?php echo e($user->is_suspend == 1 ? 'selected' : ''); ?>>محذور</option>-->
                    <!--        <option value="0" <?php echo e($user->is_suspend == 0 ? 'selected' : ''); ?>>غير محذور </option>-->
                    <!--    </select>-->
                    <!--</div>-->
                    <!-- <?php endif; ?> -->

                    <div class="form-group text-right m-t-20">
                        <button class="btn btn-primary waves-effect waves-light m-t-20" type="submit">
                            حفظ البيانات
                        </button>
                        <button onclick="window.history.back();return false;" type="reset"
                                class="btn btn-default waves-effect waves-light m-l-5 m-t-20">
                            إلغاء
                        </button>
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
                                   data-default-file="<?php echo e(request()->root().'/files/users/'.$user->image); ?>"/>

                        </div>
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </form>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>