<?php $__env->startSection('content'); ?>

    <div id="messageError"></div>
    <form data-parsley-validate novalidate method="POST" action="<?php echo e(route('categories.store')); ?>"
          enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">


                    <!--<button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"-->
                    <!--        data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i-->
                    <!--                class="fa fa-cog"></i></span>-->
                    <!--</button>-->


                </div>
                <h4 class="page-title">أنواع الخدمات</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">إضافة نوع جديد</h4>

                    <div class="form-group<?php echo e($errors->has('name_ar') ? ' has-error' : ''); ?>">
                        <label for="userName"> الاسم باللغة العربية*</label>
                        <input type="text" name="name_ar" parsley-trigger="change" required
                               placeholder="ادخل الاسم لنوع الخدمة..." class="form-control title"
                               id="userName">
                        
                        <?php if($errors->has('name_ar')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name_ar')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group<?php echo e($errors->has('name_en') ? ' has-error' : ''); ?>">
                        <label for="userName">الاسم باللغة الانجليزية*</label>
                        <input type="text" name="name_en" parsley-trigger="change" required
                               placeholder="ادخل الاسم لنوع الخدمة..." class="form-control title"
                               id="userName">
                        <?php if($errors->has('name_en')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name_en')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group <?php echo e($errors->has('description_ar') ? 'has-error' : ''); ?>">
                        <label for="description_ar">وصف الخدمة بالعربى</label>
                        <textarea name="description_ar" class="form-control"
                        data-parsley-required-message="هذا الحقل إلزامي" data-parsley-maxlength="1000"
                               data-parsley-maxlength-message="تجاوزت الحد الأقصى لعدد الحروف المسموحة وهى 1000 ">
                            <?php echo e(old('description_ar')); ?>

                        </textarea>
                        <?php if($errors->has('description_ar')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('description_ar')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group <?php echo e($errors->has('description_en') ? 'has-error' : ''); ?>">
                        <label for="description_en">وصف الخدمة بالانجليزى</label>
                        <textarea name="description_en" class="form-control" data-parsley-required-message="هذا الحقل إلزامي" data-parsley-maxlength="1000"
                               data-parsley-maxlength-message="تجاوزت الحد الأقصى لعدد الحروف المسموحة وهى 1000 ">
                            <?php echo e(old('description_en')); ?>

                        </textarea>
                        
                        <?php if($errors->has('description_en')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('description_en')); ?></strong>
                            </span>
                        <?php endif; ?>
                        
                    </div>


                    <!-- <div class="form-group">
                        <label for="pass1">الرئيسي*</label>
                        <select class="form-control select2" name="parent">
                            <option value="">الرئيسيى</option> -->
                             
                               
                            

                        <!-- </select>
                    </div> -->

                    <div class="form-group<?php echo e($errors->has('target_gender') ? ' has-error' : ''); ?>">
                        <label for="pass1">نوع المستقبل*</label>
                        <select class="form-control select2" name="target_gender">
                            <option value="0">رجال</option>
                            <option value="1">نساء</option>
                            <option value="2">كليهما معا</option>
                        </select>
                        
                        <?php if($errors->has('target_gender')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('target_gender')); ?></strong>
                            </span>
                        <?php endif; ?>
                        
                    </div>

                    <div class="form-group<?php echo e($errors->has('is_active') ? ' has-error' : ''); ?>">
                        <label for="pass1"> الحالة*</label>
                        <select class="form-control select2" name="is_active">
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                        
                        <?php if($errors->has('is_active')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('is_active')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>


                    <div class="form-group text-right m-b-0 ">
                        <button class="btn btn-primary waves-effect waves-light m-t-20" type="submit"> حفظ البيانات
                        </button>
                        <!--<button onclick="window.history.back();return false;"-->
                        <!--        class="btn btn-default waves-effect waves-light m-l-5 m-t-20"> إلغاء-->
                        <!--</button>-->
                    </div>

                </div>
            </div><!-- end col -->

            <div class="col-lg-4">
                <div class="card-box" style="overflow: hidden;">

                    <h4 class="header-title m-t-0 m-b-30">الصورة</h4>

                    <div class="form-group">
                        <input type="file" name="image" class="dropify" data-max-file-size="6M" accept="image/*" required data-parsley-required-message="هذا الحقل إلزامي" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside"/>
                    </div>

                </div>
            </div>

            <!-- end col -->
        </div>
        <!-- end row -->
    </form>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    

    
    
    
    
    
    
    
    
    
    
    

    

    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    

    
<?php $__env->stopSection(); ?>





<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>