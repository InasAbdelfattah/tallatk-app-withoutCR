@extends('admin.layouts.master')
@section('title', 'الصفحة الرئيسية')
@section('styles')
    <style>


        /*
 _____   _           _         _                        _
|_   _| | |         | |       | |                      | |
  | |   | |__   __ _| |_ ___  | |_ ___  _ __ ___   __ _| |_ ___   ___  ___
  | |   | '_ \ / _` | __/ _ \ | __/ _ \| '_ ` _ \ / _` | __/ _ \ / _ \/ __|
 _| |_  | | | | (_| | ||  __/ | || (_) | | | | | | (_| | || (_) |  __/\__ \
 \___/  |_| |_|\__,_|\__\___|  \__\___/|_| |_| |_|\__,_|\__\___/ \___||___/

Oh nice, welcome to the stylesheet of dreams.
It has it all. Classes, ID's, comments...the whole lot:)
Enjoy responsibly!



        @ihatetomatoes

 */

        /* ==========================================================================
           Chrome Frame prompt
           ========================================================================== */

        .chromeframe {
            margin: 0.2em 0;
            background: #ccc;
            color: #000;
            padding: 0.2em 0;
        }

        /* ==========================================================================
           Author's custom styles
           ========================================================================== */
        p {
            line-height: 1.33em;
            color: #7E7E7E;
        }

        h1 {
            color: #EEEEEE;
        }

        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;

            height: 100%;
            z-index: 1050;

            width: calc(100% + 17px);
        }

        #loader {
            display: block;
            position: relative;
            right: 46%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #3498db;

            -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */

            z-index: 1001;
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #e74c3c;

            -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #f9c922;

            -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg); /* IE 9 */
                transform: rotate(0deg); /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg); /* IE 9 */
                transform: rotate(360deg); /* Firefox 16+, IE 10+, Opera */
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg); /* IE 9 */
                transform: rotate(0deg); /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg); /* IE 9 */
                transform: rotate(360deg); /* Firefox 16+, IE 10+, Opera */
            }
        }

        #loader-wrapper .loader-section {
            position: fixed;
            top: 0;
            width: 51%;
            height: 100%;
            background: #222222;
            z-index: 1000;
            -webkit-transform: translateX(0); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(0); /* IE 9 */
            transform: translateX(0); /* Firefox 16+, IE 10+, Opera */
        }

        #loader-wrapper .loader-section.section-left {
            left: 0;
        }

        #loader-wrapper .loader-section.section-right {
            right: 0;
        }

        /* Loaded */
        .loaded #loader-wrapper .loader-section.section-left {
            -webkit-transform: translateX(-100%); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(-100%); /* IE 9 */
            transform: translateX(-100%); /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded #loader-wrapper .loader-section.section-right {
            -webkit-transform: translateX(100%); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(100%); /* IE 9 */
            transform: translateX(100%); /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded #loader {
            opacity: 0;
            -webkit-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .loaded #loader-wrapper {
            visibility: hidden;

            -webkit-transform: translateY(-100%); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateY(-100%); /* IE 9 */
            transform: translateY(-100%); /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.3s 1s ease-out;
            transition: all 0.3s 1s ease-out;
        }

        /* JavaScript Turned Off */
        .no-js #loader-wrapper {
            display: none;
        }

        .no-js h1 {
            color: #222222;
        }

        #content {
            margin: 0 auto;
            padding-bottom: 50px;
            width: 80%;
            max-width: 978px;
        }

        /* ==========================================================================
           Helper classes
           ========================================================================== */

        /*
         * Image replacement
         */

        .ir {
            background-color: transparent;
            border: 0;
            overflow: hidden;
            /* IE 6/7 fallback */
            *text-indent: -9999px;
        }

        .ir:before {
            content: "";
            display: block;
            width: 0;
            height: 150%;
        }

        /*
         * Hide from both screenreaders and browsers: h5bp.com/u
         */

        .hidden {
            display: none !important;
            visibility: hidden;
        }

        /*
         * Hide only visually, but have it available for screenreaders: h5bp.com/v
         */

        .visuallyhidden {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        /*
         * Extends the .visuallyhidden class to allow the element to be focusable
         * when navigated to via the keyboard: h5bp.com/p
         */

        .visuallyhidden.focusable:active,
        .visuallyhidden.focusable:focus {
            clip: auto;
            height: auto;
            margin: 0;
            overflow: visible;
            position: static;
            width: auto;
        }

        /*
         * Hide visually and from screenreaders, but maintain layout
         */

        .invisible {
            visibility: hidden;
        }

        /*
         * Clearfix: contain floats
         *
         * For modern browsers
         * 1. The space content is one way to avoid an Opera bug when the
         *    `contenteditable` attribute is included anywhere else in the document.
         *    Otherwise it causes space to appear at the top and bottom of elements
         *    that receive the `clearfix` class.
         * 2. The use of `table` rather than `block` is only necessary if using
         *    `:before` to contain the top-margins of child elements.
         */

        .clearfix:before,
        .clearfix:after {
            content: " "; /* 1 */
            display: table; /* 2 */
        }

        .clearfix:after {
            clear: both;
        }

        /*
         * For IE 6/7 only
         * Include this rule to trigger hasLayout and contain floats.
         */

        .clearfix {
            *zoom: 1;
        }

        /* ==========================================================================
           EXAMPLE Media Queries for Responsive Design.
           These examples override the primary ('mobile first') styles.
           Modify as content requires.
           ========================================================================== */

        @media only screen and (min-width: 35em) {
            /* Style adjustments for viewports that meet the condition */
        }

        @media print,
        (-o-min-device-pixel-ratio: 5/4),
        (-webkit-min-device-pixel-ratio: 1.25),
        (min-resolution: 120dpi) {
            /* Style adjustments for high resolution devices */
        }

        /* ==========================================================================
           Print styles.
           Inlined to avoid required HTTP connection: h5bp.com/r
           ========================================================================== */

        @media print {
            * {
                background: transparent !important;
                color: #000 !important; /* Black prints faster: h5bp.com/s */
                box-shadow: none !important;
                text-shadow: none !important;
            }

            a,
            a:visited {
                text-decoration: underline;
            }

            a[href]:after {
                content: " (" attr(href) ")";
            }

            abbr[title]:after {
                content: " (" attr(title) ")";
            }

            /*
             * Don't show links for images, or javascript/internal links
             */
            .ir a:after,
            a[href^="javascript:"]:after,
            a[href^="#"]:after {
                content: "";
            }

            pre,
            blockquote {
                border: 1px solid #999;
                page-break-inside: avoid;
            }

            thead {
                display: table-header-group; /* h5bp.com/t */
            }

            tr,
            img {
                page-break-inside: avoid;
            }

            img {
                max-width: 100% !important;
            }

            @page {
                margin: 0.5cm;
            }

            p,
            h2,
            h3 {
                orphans: 3;
                widows: 3;
            }

            h2,
            h3 {
                page-break-after: avoid;
            }
        }

        /*
            Ok so you have made it this far, that means you are very keen to on my code.
            Anyway I don't really mind it. This is a great way to learn so you actually doing the right thing:)
            Follow me


        @ihatetomatoes
 */
        .scroll-hidden {
            position: fixed;
        }

        .fade-scale {
            transform: scale(0);
            opacity: 0;
            -webkit-transition: all .5s linear;
            -o-transition: all .5s linear;
            transition: all .5s linear;
        }

        .fade-scale.in {
            opacity: 1;
            transform: scale(1);
        }

        .fade-scale.out {
            opacity: 1;
            transform: scale(1);
        }

        /*.modal {*/
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*transform: translate(-50%, -50%);*/
        /*}*/

        /*@keyframes slideInFromLeft {*/
        /*0% {*/
        /*transform: translateX(-100%);*/
        /*}*/
        /*100% {*/
        /*transform: translateX(0);*/
        /*}*/
        /*}*/

        /*.page-title {*/
        /*!* This section calls the slideInFromLeft animation we defined above *!*/
        /*animation: 2s ease-out 0s 3 slideInFromLeft;*/

        /*background: #333;*/
        /*padding: 30px;*/
        /*}*/


    </style>
@endsection
@section('content')

    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">لوحة التحكم</h4>
        </div>
    </div>


    @if(auth()->user()->can('statistics_manage'))


        <div class="row">
            
            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">مستخدمى التطبيق</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{ $data['usersCount'] }}<i
                                                 class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">     {{ $data['usersCount'] }} </h2>
                            <p class="text-muted m-b-25">عدد مستخدمى التطبيق</p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['usersCount']}}%;">
                                <!-- <span class="sr-only">77% Complete</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30"> عدد مزودى الخدمات</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{ $data['providersCount'] }}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">  {{ $data['providersCount'] }} </h2>
                            <p class="text-muted m-b-25">عدد مزودى الخدمات </p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['providersCount']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">الرجال بالتطبيق</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{$data['mens_count']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['mens_count']}}</h2>
                            <p class="text-muted m-b-25">عدد الرجال</p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['mens_count']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">النساء بالتطبيق</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{$data['womens_count']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['womens_count']}}</h2>
                            <p class="text-muted m-b-25">عدد النساء</p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['womens_count']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">أنواع الخدمات </h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{ $data['categoriesCount'] }}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0"> {{ $data['categoriesCount'] }} </h2>
                            <p class="text-muted m-b-25">عدد أنواع الخدمات </p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['categoriesCount']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <!--<div class="col-lg-3 col-md-6">-->
            <!--    <div class="card-box">-->
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <!--<h4 class="header-title m-t-0 m-b-30">المراكز بالتطبيق</h4>-->

                    <!--<div class="widget-box-2">-->
                    <!--    <div class="widget-detail-2">-->
                    <!--                 <span class="badge badge-pink pull-left m-t-20">{{$data['centersCount']}}<i class="zmdi zmdi-trending-up"></i> </span>-->
                    <!--        <h2 class="m-b-0">{{$data['centersCount']}}</h2>-->
                    <!--        <p class="text-muted m-b-25">عدد المراكز </p>-->
                    <!--    </div>-->
                    <!--    <div class="progress progress-bar-pink-alt progress-sm m-b-0">-->
                    <!--        <div class="progress-bar progress-bar-pink" role="progressbar"-->
                    <!--             aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"-->
                    <!--             style="width: {{$data['centersCount']}}%;">-->
                    <!--            <span class="sr-only">77% Complete</span>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30"> الخدمات بالتطبيق </h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{$data['services_app']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['services_app']}}</h2>
                            <p class="text-muted m-b-25">عدد الخدمات</p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['services_app']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">إبلاغات الإساءة الغير معتمدة</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{$data['notadoptedreports']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['notadoptedreports']}}</h2>
                            <p class="text-muted m-b-25">إبلاغات الإساءة الغير معتمدة</p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['notadoptedreports']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">الحجوزات</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-primary pull-left m-t-20">{{  $data['orders'] }}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0"> {{  $data['orders'] }} </h2>
                            <p class="text-muted m-b-25">عدد الحجوزات </p>
                        </div>
                        <div class="progress progress-bar-primary-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['orders']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->
                    <h4 class="header-title m-t-0 m-b-30">الرسائل المقروءة</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-primary pull-left m-t-20">{{$data['read_contacts']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['read_contacts']}}</h2>
                            <p class="text-muted m-b-25">عدد الرسائل المقروءة </p>
                        </div>
                        <div class="progress progress-bar-primary-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['read_contacts']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-30">البريد الغير مقروء</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-primary pull-left m-t-20">{{$data['notread_contacts']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['notread_contacts']}}</h2>
                            <p class="text-muted m-b-25">عدد البريد الغير المقروء </p>
                        </div>
                        <div class="progress progress-bar-primary-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['notread_contacts']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


        </div>
        <!-- end row -->



    @else



        <div class="alert alert-info fade in">

            <strong>مرحباً بك!</strong>
            <b style="color: #000;">{{ auth()->user()->name }}</b>
            مرحبا بك فى لوحة تحكم تطبيق طلتك
            </a>

        </div>



    @endif


@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('body').addClass('loaded');
                $('body').removeClass('scroll-hidden');
            }, 500);
        });
    </script>
@endsection