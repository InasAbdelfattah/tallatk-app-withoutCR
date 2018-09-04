<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="<?php echo e(route('admin.home')); ?>" class="logo">
                    <span>طلت<span>ك</span></span>
                </a>
            </div>
            <!-- End Logo container-->


            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">
                    
                    
                    
                    
                    
                    
                    <li>
                        <!-- Notification -->
                        <!--<div class="notification-box">-->
                        <!--    <ul class="list-inline m-b-0">-->
                        <!--        <li>-->
                        <!--            <a href="javascript:void(0);" class="right-bar-toggle">-->
                        <!--                <i class="zmdi zmdi-notifications-none"></i>-->
                        <!--            </a>-->
                        <!--            <div class="noti-dot">-->
                        <!--                <span class="dot"></span>-->
                        <!--                <span class="pulse"></span>-->
                        <!--            </div>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                        <!-- End Notification bar -->
                    </li>

                    <li class="dropdown user-box">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown"
                           aria-expanded="true">
                            <img src="<?php echo e(url('files/users/' . auth()->user()->image)); ?>" alt="user-img"
                                 class="img-circle user-img">
                            <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="<?php echo e(route('users.profile',['id'=>auth()->user()->id])); ?>"><i class="ti-user m-r-5"></i> الملف الشخصى</a></li>
                            <li><a href="<?php echo e(route('users.editProfile',['id'=>auth()->user()->id])); ?>"><i class="ti-settings m-r-5"></i> تعديل بياناتى</a></li>
                            <!-- <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> غلق التطبيق </a></li> -->


                            <li>
                                <a href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ti-power-off m-r-5"></i> تسجيل خروج
                                </a>
                            </li>


                        </ul>
                    </li>
                </ul>
                <form id="logout-form" action="<?php echo e(route('administrator.logout')); ?>" method="POST"
                      style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>


                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

        </div>
    </div>

    <div class="navbar-custom">
        <div class="container">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu" style="font-size: 14px;">

                    <li>
                        <a href="<?php echo e(route('admin.home')); ?>"><i class="zmdi zmdi-view-dashboard"></i>
                            <span> الرئيسية </span> </a>
                    </li>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-settings"></i><span>  الإعدادات </span> </a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    
                                        <li><a href="<?php echo e(route('settings.commission')); ?>">إعدادات عامة</a></li>
                                       <li><a href="<?php echo e(route('categories.index')); ?>">أنواع الخدمات</a></li>
                                        <li><a href="<?php echo e(route('cities.index')); ?>">المدن</a></li>
                                         <li><a href="<?php echo e(route('districts.index')); ?>">الأحياء</a></li>                                 
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-invert-colors"></i> <span> إدارة التطبيق </span> </a>

                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    
                                        <li><a href="<?php echo e(route('users.index')); ?>">مديرى التطبيق</a></li>
                                        <li><a href="<?php echo e(route('roles.index')); ?>">الأدوار والصلاحيات</a></li>
                                                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('content_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-settings"></i><span>  إدارة المحتوى </span> </a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <!-- <li><a href="<?php echo e(route('administrator.settings.comments')); ?>">إدارة ضبط
                                                المراكز</a>
                                        </li> -->
                                        <li><a href="<?php echo e(route('settings.terms')); ?>">بنود الإستخدام</a></li>
                                        <li><a href="<?php echo e(route('settings.aboutus')); ?>">عن التطبيق</a></li>
                                        <li><a href="<?php echo e(route('settings.socials')); ?>">روابط تواصل معنا</a></li> 
                                        
                                        <li><a href="<?php echo e(route('settings.site')); ?>">إدارة محتوى الموقع</a></li> 
                                        <!-- <li><a href="<?php echo e(route('new-notif')); ?>">ارسال اشعار</a></li> -->
                                
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-invert-colors"></i> <span>مستخدمي التطبيق </span> </a>

                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    
                                        <li><a href="<?php echo e(route('users.app_providers')); ?>">مزودى الخدمات</a></li>
                                        <li><a href="<?php echo e(route('users.app_users')); ?>">طالبى الخدمات</a></li>
                                        <!--<li><a href="<?php echo e(route('companies.index')); ?>">المراكز</a></li>-->
                                                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contact_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-invert-colors"></i> <span>التواصل مع التطبيق</span> </a>

                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    
                                        <li><a href="<?php echo e(route('notifs')); ?>">الاشعارات </a></li>
                                            <li>
                                                <a href="<?php echo e(route('support.index')); ?>">رسائل تواصل معنا</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo e(route('abuses.index')); ?>">بلاغات الإساءة</a>
                                            </li>

                                        <li><a href="<?php echo e(route('user_discounts.index')); ?>">الخصومات</a></li>
                                                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-invert-colors"></i> <span>التقارير</span> </a>

                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                    
                                        <li><a href="<?php echo e(route('orders.index')); ?>">الحجوزات</a></li>
                                        <li><a href="<?php echo e(route('user_discounts.all')); ?>">الخصومات </a></li>
                                        <li><a href="<?php echo e(route('orders.financial_reports')); ?>">التقارير المالية</a></li>
                                        <li><a href="<?php echo e(route('orders.financial_accounts')); ?>">الحسابات المالية</a></li>
                                                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                   
                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('companies_manage')): ?>
                        <li class="has-submenu">
                            <a href="<?php echo e(route('companies.index')); ?>"><i class="zmdi zmdi-view-list"></i>
                                <span>  المراكز </span>
                            </a>
                            <ul class="submenu">
                                <li style="padding:  0 25px"><a href="<?php echo e(route('companies.index')); ?>">مشاهدة المراكز</a></li>
                                <li style="padding:  0 25px"><a href="<?php echo e(route('companies.orders')); ?>"> طلبات تسجيل المراكز </a></li>
                            </ul>
                        </li>
                    <?php endif; ?> -->

                    <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('userDiscount_manage')): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="zmdi zmdi-view-dashboard"></i>
                                <span> الخصومات </span> </a>
                            <ul class="submenu">

                                <li style="padding:  0 25px"><a href="<?php echo e(route('user_discounts.index')); ?>">الخصومات </a></li>

                                <li style="padding:  0 25px"><a href="<?php echo e(route('user_discounts.all')); ?>">تقارير الخصومات </a></li>

                            </ul>
                        </li>     
                    <?php endif; ?> -->
  
                </ul>
                <!-- End navigation menu  -->
            </div>
        </div>
    </div>
</header>
<!-- End Navigation Bar-->


<div class="wrapper">
    <div class="container">