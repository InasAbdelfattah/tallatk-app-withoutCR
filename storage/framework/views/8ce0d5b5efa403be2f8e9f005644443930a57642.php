<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <!-- <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-custom  waves-effect waves-light">
                    <span class="m-l-5">
                        <i class="fa fa-plus"></i> <span>إضافة</span> </span>
                </a> -->

            </div>
            <h4 class="page-title">الرسائل</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <!--<div class="dropdown pull-right">-->
                <!--    <?php if($supports->count()> 0): ?>-->
                <!--        <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">-->
                <!--            <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد-->
                <!--        </a>-->
                <!--    <?php endif; ?>-->
                <!--</div>-->
                

                

                
                
                
                
                
                
                

                

                <h4 class="header-title m-t-0 m-b-30">مشاهدة الرسائل </h4>

<div class="table-responsive">
                
                    <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
                    <thead>
                    <tr>
                        <th>
                            م
                            
                            
                            
                            
                            
                            
                        </th>
                        <th>اسم المستخدم</th>
                        <!--<th>الاسم</th>-->
                        <th>الهاتف</th>
                        <!-- <th>البريد الإلكترونى</th> -->
                        <th>نوع الرسالة</th>
                        <!-- <th>عدد الردور</th> -->
                        <!--<th>الرسالة</th>-->
                        <th>تأريخ الرسالة</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <?php if(count($supports) > 0): ?>
                    <tbody>
                    <?php $i =1; ?>
                    <?php $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i++); ?>

                                <!--<div class="checkbox checkbox-primary checkbox-single">-->
                                <!--    <input type="checkbox" class="checkboxes-items"-->
                                <!--           value="<?php echo e($row->id); ?>"-->
                                <!--           aria-label="Single checkbox Two">-->
                                <!--    <label></label>-->
                                <!--</div>-->
                            </td>
                            <!--<td style="width: 10%;">-->
                            <!--    <?php if($row->user): ?>-->
                            <!--    <a href="<?php echo e(route('users.show',$row->user_id)); ?>">-->
                            <!--        <?php echo e(($row->user->name)?:'الاسم غير موجود'); ?>-->
                            <!--    </a>-->
                            <!--     <?php else: ?>-->
                            <!--        <label class="btn btn-danger">المستخدم غير مسجل</label>-->
                            <!--    <?php endif; ?>-->
                            <!--</td>-->

                            <td><?php echo e($row->name); ?></td>
                            <td><?php echo e($row->phone); ?></td>
                            <!-- <td><?php echo e($row->email); ?></td> -->
                            
                            <td>
                                <?php if($row->type == 1): ?>
                                    <label class="label label-warning">شكاوي</label>
                                <?php elseif($row->type == 2): ?>
                                    <label class="label label-success">إقتراحات</label>
                                <?php elseif($row->type == 3): ?>
                                    <label class="label label-inverse">آخري</label>
                                <?php endif; ?>
                            </td>
                            <!-- <td><?php if($row->parent_id == 0): ?> عدد الردود
                                (<?php echo e(\App\Support::whereParentId($row->id)->count()); ?>) 
                                <?php endif; ?></td> -->

                            <!--<td><?php echo e(str_limit($row->message, 15)); ?></td>-->
                            <td><?php echo e($row->created_at->format('F Y d')); ?></td>
                            <td>
                                <a href="<?php echo e(route('support.show', $row->id)); ?>"
                                   class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i> مشاهدة وإرسال رد
                                </a>
                                <a href="javascript:;" id="elementRow<?php echo e($row->id); ?>" data-id="<?php echo e($row->id); ?>"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    </tbody>
                    <?php else: ?>
                    <tr>
                        <td colspan="10">لا يوجد رسائل</td>
                    </tr>
                    <?php endif; ?>
                </table>
</div>

                

                

                
            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->



<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>


    <script>


        <?php if(session()->has('success')): ?>

        setTimeout(function () {
            showMessage('<?php echo e(session()->get('success')); ?>');
        }, 3000);


        <?php endif; ?>
        $('.getSelected').on('click', function () {
            // var items = $('.checkboxes-items').val();
            var sum = [];
            $('.checkboxes-items').each(function () {
                if ($(this).prop('checked') == true) {
                    sum.push(Number($(this).val()));
                }

            });

            if (sum.length > 0) {
                //var $tr = $(this).closest($('#elementRow' + id).parent().parent());
                swal({
                    title: "هل انت متأكد؟",
                    text: "",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "موافق",
                    cancelButtonText: "إلغاء",
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    closeOnConfirm: true,
                    closeOnCancel: true,
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo e(route('categories.group.delete')); ?>',
                            data: {ids: sum},
                            dataType: 'json',
                            success: function (data) {
                                if (data) {
                                    var shortCutFunction = 'success';
                                    var msg = 'لقد تمت عملية الحذف بنجاح.';
                                    var title = data.title;
                                    toastr.options = {
                                        positionClass: 'toast-top-center',
                                        onclick: null,
                                        showMethod: 'slideDown',
                                        hideMethod: "slideUp",
                                    };
                                    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                    $toastlast = $toast;
                                }

                                $('.checkboxes-items').each(function () {
                                    if ($(this).prop('checked') == true) {
                                        $(this).parent().parent().parent().delay(200).fadeOut();
                                    }
                                });
//                        $tr.find('td').fadeOut(1000, function () {
//                            $tr.remove();
//                        });
                            }
                        });
                    } else {
                        swal({
                            title: "تم الالغاء",
                            text: "انت لغيت عملية الحذف تقدر تحاول فى اى وقت :)",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "موافق",
                            confirmButtonClass: 'btn-info waves-effect waves-light',
                            closeOnConfirm: false,
                            closeOnCancel: false
                        });
                    }
                });
            } else {
                swal({
                    title: "تحذير",
                    text: "قم بتحديد عنصر على الاقل",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "موافق",
                    confirmButtonClass: 'btn-warning waves-effect waves-light',
                    closeOnConfirm: false,
                    closeOnCancel: false

                });
            }


        });


        $('body').on('click', '.removeElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#elementRow' + id).parent().parent());
            swal({
                title: "هل انت متأكد؟",
                text: "",
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "إلغاء",
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('support.delete')); ?>',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            if (data) {
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت عملية الحذف بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-center',
                                    onclick: null,
                                    showMethod: 'slideDown',
                                    hideMethod: "slideUp",
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                            }

                            $tr.find('td').fadeOut(1000, function () {
                                $tr.remove();
                            });
                        }
                    });
                } else {

                    swal({
                        title: "تم الالغاء",
                        text: "انت لغيت عملية الحذف تقدر تحاول فى اى وقت :)",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "موافق",
                        confirmButtonClass: 'btn-info waves-effect waves-light',
                        closeOnConfirm: false,
                        closeOnCancel: false

                    });

                }
            });
        });


        function showMessage(message) {

            var shortCutFunction = 'success';
            var msg = message;
            var title = 'نجاح!';
            toastr.options = {
                positionClass: 'toast-top-center',
                onclick: null,
                showMethod: 'slideDown',
                hideMethod: "slideUp",
            };
            var $toast = toastr[shortCutFunction](msg, title);
            // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;


        }
    </script>



<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>