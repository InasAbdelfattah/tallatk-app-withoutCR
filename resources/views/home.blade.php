<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taletak</title>
    <link rel="shortcut icon" href="{{ request()->root() }}/TaletakWeb/images/Logo.png">
    <link rel="stylesheet" href="{{ request()->root() }}/TaletakWeb/css/bootstrap.css">
    <link rel="stylesheet" href="{{ request()->root() }}/TaletakWeb/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="{{ request()->root() }}/TaletakWeb/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ request()->root() }}/TaletakWeb/css/style.css">

</head>

<body>
<div class="illustration">
    <div class="nav">
        <div class="container">
            @if(count($errors) > 0)
            @foreach($errors->all() as $error)

            <div class="alert alert-warning alert-styled-left">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                {{ $error }}
            </div>
            @endforeach
            @endif

            @if(Session::has('success'))
            <div class="alert alert-success alert-styled-left">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                {{ Session::get('success') }}
            </div>
            @endif

            @if(Session::has('fail'))

            <div class="alert alert-warning alert-styled-left">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                {{ Session::get('fail') }}
            </div>

            @endif
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="logo">
                        <img class="img" src="{{ request()->root() }}/TaletakWeb/images/Logo.png">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="logIn text-right">
                        <button class="btn btn-default" data-toggle="modal" data-target="#logIn">تسجيل مزود الخدمة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="downloadApp">
                    <h1>{{ $setting->getBody('site_title') }}</h1>
                </div>
                <p>{!! $setting->getBody('site_content') !!}</p>
                <a href="{{ $setting->getBody('playstore') }}"><img class="store img-fluid" src="{{ request()->root() }}/TaletakWeb/images/google.png"></a>

                <a href="{{ $setting->getBody('appstore') }}"><img class="store img-fluid" src="{{ request()->root() }}/TaletakWeb/images/apple.png"></a>
                <div class="followUs">
                    <span>تابع جديدنا</span>
                </div>
                <div class="social">
                    <a href="{{ $setting->getBody('facebook') }}"><i class="fa fa-facebook" style="color: #3b5998"></i></a>
                </div>
                <div class="social">
                    <a href="{{ $setting->getBody('instagram') }}"><i class="fa fa-instagram" style="color: #3b5998"></i></a>
                </div>
                <div class="social">
                    <a href="{{ $setting->getBody('twitter') }}"><i class="fa fa-twitter" style="color: #3b5998"></i></a>
                </div>
            </div>

            <div class="col-12 col-md-3 ">
                <div class="mobileLogo hidden-xs">
                    <!--<img class="img img-fluid" src="{{ request()->root() }}/TaletakWeb/images/White.png">-->
                    <img src="{{ request()->root() . '/' . $setting->getBody('site_image') }}" class="img img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{ route('register_provider') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="userType" value="1"/>
<!-- modal logIn -->
<div class="modal fade" id="logIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modalHeader">
                    <p>تسجيل مزود الخدمة</p>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="modalLogo">
                            <img class="img" src="{{ request()->root() }}/TaletakWeb/images/secondaryLogo.png">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/user.png">
                                    <input class="form-control" type="text" name="name" placeholder="اسم مزود الخدمة" required>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/phone.png">
                                    <input class="form-control" type="tel" name="phone" placeholder="رقم الجوال" required>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/lock.png">
                                    <input class="form-control" type="password" name="password" placeholder="كلمة المرور" required>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/lock.png">
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور"
                                           required>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/mail.png">
                                    <input class="form-control" type="email" name="email" placeholder="البريد الالكتروني" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="next">
                                    <a href="#" data-toggle="modal" data-target="#next" data-dismiss="modal">
                                        <button class="btn btn-default">التالي</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal logIn -->

<!-- modal next -->
<div class="modal fade" id="next" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modalHeader">
                    <p>تسجيل مزود الخدمة</p>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="modalLogo">
                            <img class="img" src="{{ request()->root() }}/TaletakWeb/images/secondaryLogo.png">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="input">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">صورة الحساب</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/location.png">
                                    <select class="form-control" name="city">

                                        <option value="" selected disabled>المدينة</option>
                                        @if(count($cities) > 0)
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->{'name:ar'} }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <img class="img" src="{{ request()->root() }}/TaletakWeb/images/gender.png">
                                    <select class="form-control" name="providerType">
                                        <option value="" selected disabled>نوع مزود الخدمة</option>
                                        <option value="0">فرد</option>
                                        <option value="1">مركز</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="input">
                                    <div class="custom-file">
                                        <input type="file" name="document_photo" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">صورة السجل التجاري</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" required class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">الموافقة على <a href="#"
                                                                                                           style="color: white;text-decoration: underline">الشروط
                                        و الأحكام</a> الخاصة بالتطبيق</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="next">
                                    <a href="#">
                                        <button class="btn btn-default">حفظ</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal next -->

<script src="{{ request()->root() }}/TaletakWeb/js/jquery-3.3.1.min.js"></script>
<script src="{{ request()->root() }}/TaletakWeb/js/bootstrap.min.js"></script>

</body>

</html>