<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">بيانات الطلب</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                       

                        <div class="panel-body">

                            <div class="col-lg-3 col-xs-12">
                                <label>اسم طالب الخدمة :</label>
                                <p><?php echo e($order->username); ?></p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>مزود الخدمة :</label>
                                <p><?php if(user($order->provider_id)): ?><?php echo e(user($order->provider_id)->name); ?><?php endif; ?></p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>مدينة الخدمة :</label>
                                <p><?php $city = App\City::find($order->city_id) ; ?>
                            <?php if($city): ?><?php echo e($city->{'name:ar'}); ?><?php endif; ?></p>
                            </div>

                            

                           

                            

                            <div class="col-lg-3 col-xs-12">
                                <label>مكان الخدمة :</label>
                                <!--<p><?php echo e($order->company_place == 0 ? 'منازل' : 'مركز'); ?> </p>-->
                                <p><?php echo e($order->place == 'home' ? 'منزل' : 'مركز'); ?> </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <?php $service = \App\Service::find($order->service_id); ?>
                                <label>وصف الخدمة :</label>
                                
                                <p><?php echo e($service ? $service->{'description:ar'} : ''); ?></p>
                            </div>
                            

                            

                            <div class="col-lg-6 col-xs-12">
                                <label> <p>حالة الطلب :</label>
                                <p>
                                <?php if($order->status == 0): ?> جديد
                                <?php elseif($order->status == 1): ?> منتهى
                                <?php elseif($order->status == 3): ?> مقبول
                                <?php elseif($order->status == 2): ?> مرفوض
                                <?php elseif($order->status == 4): ?> مـتأخر
                                <?php elseif($order->status == 5): ?> ملغى
                                <?php endif; ?>
                                </p>
                                

                            </div>
                            <?php if($order->status == 2): ?>
                                <div class="col-lg-6 col-xs-12">
                                    <label>سبب رفض الطلب:</label>
                                    <p><?php echo e($order->refuse_reasons); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($order->status == 5): ?>
                                <div class="col-lg-6 col-xs-12">
                                    <label>سبب الغاء الطلب:</label>
                                    <p><?php echo e($order->cancel_reason); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> تاريخ الطلب :</label>
                                <p><?php echo e($order->created_at ?  $order->created_at->format('Y-m-d') : ''); ?></p>

                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label>وقت الطلب :</label>
                                <p><?php echo e($order->created_at ? $order->created_at->format('H:i:s') : ''); ?></p>

                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label>اسم الخدمة :</label>
                                <?php $serv = \App\Service::find($order->service_id); ?>
                                <?php if($serv): ?>
                                    <p><?php echo e($serv->{'name:ar'}); ?>}</p>
                                <?php endif; ?>

                            </div>
                            
                            <!--<div class="col-lg-6 col-xs-12">-->
                            <!--    <label>الخدمات الطلوبة  :</label>-->
                            <!--    <?php if($order->orderServices): ?>-->
                            <!--    <table class="table table-striped table-hover table-condensed" style="width:100%">-->
                            <!--        <tr>-->
                            <!--            <th>اسم الخدمة</th>-->
                            <!--            <th>السعر</th>-->
                            <!--        </tr>-->
                            <!--        <?php $__empty_1 = true; $__currentLoopData = $order->orderServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>-->
                            <!--            <?php $serv = \App\Service::find($service->service_id); ?>-->
                            <!--            <?php if($serv): ?>-->
                            <!--                <tr>-->
                            <!--                    <th><?php echo e($serv->{'name:ar'}); ?></th>-->
                            <!--                    <th><?php echo e($serv->price); ?></th>-->
                            <!--                </tr>-->
                                        
                            <!--            <?php endif; ?>-->
                            <!--        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>-->
                            <!--            <p>لا توجد خدمات مضافة</p>-->
                            <!--        <?php endif; ?>-->
                            <!--    </table>-->
                            <!--    <?php endif; ?>-->

                            <!--</div>-->
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> <p> تكلفة الطلب الإجمالية :</label>
                                <p><?php echo e($order->price); ?></p>

                            </div>
                            
                            
                            
                            <?php if($provider_rate != null): ?>
                            <div class="col-lg-6 col-xs-12">
                                <label> <p>المبلغ المستلم من مزود الخدمة:</label>
                                <p><?php echo e($provider_rate->price); ?></p>

                            </div>
                            <?php endif; ?>
                            
                            <?php if($user_rate != null): ?>
                            <div class="col-lg-6 col-xs-12">
                                <label> <p> المبلغ المدفوع من طالب الخدمة:</label>
                                <p><?php echo e($user_rate->price); ?></p>

                            </div>
                            <?php endif; ?>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> <p>التقييم :</label>
                                <p><label class="label label-inverse"><?php if($order->rates): ?><?php echo e($order->rates->avg('rate')); ?><?php else: ?> 'لم يقيم' <?php endif; ?></label></p>

                            </div>


                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>