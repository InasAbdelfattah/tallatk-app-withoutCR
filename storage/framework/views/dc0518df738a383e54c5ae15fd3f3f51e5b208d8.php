<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <?php if( isset($type) && $type == 1): ?>
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(route('orders.financial_reports')); ?>"
                   class="btn btn-custom  waves-effect waves-light">
                    <span class="m-l-5">
                        <i class="fa fa-eye"></i> <span>مشاهدة التقارير المالية</span></span>
                </a>

            </div>
            <?php endif; ?>
           
            <h4 class="page-title">التقارير المالية</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="dropdown pull-right">
                    
                    <!--<a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">-->
                    <!--    <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد-->
                    <!--</a>-->
                </div>

                <form action="<?php echo e(route('orders.search_reports')); ?>" method="get">
                    <?php echo e(csrf_field()); ?>

                    <div class="row form-group">
                        <!--<div class="col-lg-3">-->
                        <!--    نوع الخدمة : -->
                            <!--<input type="text" name="service_type" class="form-control"/>-->
                        <!--    <select name="service_type" class="form-control">-->
                        <!--        <option value="">نوع الخدمة</option>-->
                        <!--    <?php if(count($cats)>0): ?>-->
                        <!--        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
                                
                        <!--        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name_ar); ?></option>-->
                        <!--        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
                        <!--    <?php endif; ?>-->
                        <!--</select>-->
                        
                        <!--</div>-->
                        <div class="col-lg-6">
                            مزود الخدمة : 
                            <input type="text" name="service_provider" class="form-control" placeholder="اسم مزود الخدمة"/>
                        </div>
                        
                    </div>
                    <div class="row">
                            <div class="col-lg-3">وقت الخدمة : </div>
                    </div>
                    <div class="row form-group">
                            
                        <div class="col-lg-3">
                            من : 
                            <input type="date" name="from" class="form-control"/>
                        </div>

                        <div class="col-lg-3">
                            إلى : 
                            <input type="date" name="to" class="form-control"/>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">بحث</button>
                        </div>
                    </div>
                </form>
                    
                
              
                <h4 class="header-title m-t-0 m-b-30">عرض التقارير المالية</h4>

<div class="table-responsive">
                <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>تاريخ الطلب </th>
                        <th>رقم الطلب</th>
                        <th>مزود الخدمة</th>
                        <th>طالب الخدمة</th>
                        <!--<th>سعر الخدمات الثابتة</th>-->
                        <!--<th>الحد الادنى للسعر</th>-->
                        <!--<th>الحد الاقصى</th>-->
                        <th>اسم الخدمة</th>
                        <th>سعر الطلب</th>
                        <th>نسبة التطبيق من الخدمة</th>
                        <!--<th>الخيارات</th>-->

                    </tr>
                    </thead>
                    <tbody>

                    <?php if(count($orders) > 0): ?>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>

                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="<?php echo e($row->id); ?>"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>
                            </td>

                            <td><?php echo e($row->created_at); ?></td>
                            <td><?php echo e($row->id); ?></td>

                            
                            
                            <td><?php if(user($row->provider_id)): ?><?php echo e(user($row->provider_id)->name); ?><?php endif; ?></td>
                            <td><?php echo e($row->username); ?></td>
                            <!--<td><?php echo e($row->company_name); ?></td>-->
                            <?php $service = App\Service::find($row->service_id) ; ?>
                            <td> <?php if($service): ?> <?php echo e($service->{'name:ar'}); ?> <?php endif; ?></td>
                            <td><?php echo e($row->price); ?></td>
                            <!--<td><?php echo e($row->min_cost); ?></td>-->
                            <!--<td><?php echo e($row->max_cost); ?></td>-->
                            <!--<td>
                                <?php 
                                    $provider_rate = \App\Rate::where('order_id',$row->id)->where('rate_from','provider')->first();
                                ?>
                                <?php if($provider_rate): ?>
                                    <?php echo e($provider_rate->price); ?>

                                <?php else: ?>
                                    ---
                                <?php endif; ?>
                            </td> -->
                            <td>
                                
                                    <?php if($setting && $provider_rate): ?>
                                     
                                        <?php echo e($setting->getBody('commission') * $provider_rate->price /100); ?>

                                        
                                    <?php endif; ?>
                                
                            </td>
                            <!--<td>
                                 <a href="<?php echo e(route('orders.show', $row->id)); ?>"
                                  class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i>
                                </a> 

                                <a href="javascript:;" id="elementRow<?php echo e($row->id); ?>"
                                   data-id="<?php echo e($row->id); ?>"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td> -->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
</div>
            </div>
            </div>
        </div><!-- end col -->

  
    <!-- end row -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <script>

        $('body').on('click', '.removeElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#elementRow' + id).parent().parent());
            swal({
                title: "هل انت متأكد؟",
                text: "يمكنك استرجاع المحذوفات مرة اخرى لا تقلق.",
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
                        url: '<?php echo e(route('orders.delete')); ?>',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {

                            if (data.status == true) {
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت عملية الحذف بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;

                                $tr.find('td').fadeOut(1000, function () {
                                    $tr.remove();
                                });
                            }

                            // if (data.status == false) {
                            //     var shortCutFunction = 'error';
                            //     var msg = 'عفواً, لا يمكنك حذف العضوية الان نظراً لوجود 3 شركات مسجلين بها.';
                            //     var title = data.title;
                            //     toastr.options = {
                            //         positionClass: 'toast-top-left',
                            //         onclick: null
                            //     };
                            //     var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                            //     $toastlast = $toast;
                            // }


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
                    text: "يمكنك استرجاع المحذوفات مرة اخرى لا تقلق.",
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
                            url: '<?php echo e(route('orders.group.delete')); ?>',
                            data: {ids: sum},
                            dataType: 'json',
                            success: function (data) {
                                $('#catTrashed').html(data.trashed);
                                if (data) {
                                    var shortCutFunction = 'success';
                                    var msg = 'لقد تمت عملية الحذف بنجاح.';
                                    var title = data.title;
                                    toastr.options = {
                                        positionClass: 'toast-top-left',
                                        onclick: null
                                    };
                                    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                    $toastlast = $toast;
                                }

                                $('.checkboxes-items').each(function () {
                                    if ($(this).prop('checked') == true) {
                                        $(this).parent().parent().parent().fadeOut();
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

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>