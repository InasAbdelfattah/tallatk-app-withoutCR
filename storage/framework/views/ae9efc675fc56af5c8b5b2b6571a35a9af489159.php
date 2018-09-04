<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">إرسال إشعار</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">إرسال إشعار</h3>

                        <div class="panel-body">

                            <form action="<?php echo e(route('notif-send')); ?>" method="post">
                                <!-- Highlighting rows and columns -->
                                <div class="panel panel-flat">

                                    <br>
                                    <div style="width: 80%; margin: 20px auto;">

                                         <div class="form-group">
                                             <label>المستخدم</label>
                                             <select class="form-control select" name="device_id" required data-parsley-required-message="هذا الحقل الزامى">
                                                 <option value="">-- يرجي اختيار المستخدم --</option>
                                                 <?php if(count($users) > 0): ?>
                                                     <option value="all">الكل</option>
                                                     <option value="users">جميع طالبى الخدمة </option>
                                                     <option value="providers">جميع مزودى الخدمة</option>

                                                 <?php endif; ?>

                                                 
                                                 
                                                 
                                             </select>
                                        </div>

                                        <div class="form-group">

                                            <label>عنوان اللإشعار</label>
                                            <input type="text" class="form-control" rows="10" cols="9" name="title" placeholder="عنوان الإشعار" value="<?php echo e(old('title')); ?>" required data-parsley-required-message="هذا الحقل الزامى"/>

                                        </div>
                                        
                                        <div class="form-group">

                                            <label>نص الإشعار</label>
                                            <textarea class="form-control" rows="10" cols="9" name="msg" placeholder="نص الرسالة" required data-parsley-required-message="هذا الحقل الزامى"> <?php echo e(old('msg')); ?> </textarea>

                                        </div>

                                        <input type="hidden" value="إرسال" name="type">

                                        <?php echo e(csrf_field()); ?>


                                        <button type="submit" style="padding: 10px 30px; margin-top: 20px;" class="btn btn-lg btn-primary">
                                            ارسال
                                        </button>

                                    </div>


                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>