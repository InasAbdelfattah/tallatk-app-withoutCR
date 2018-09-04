@extends('admin.layouts.master')

@section('content')
    <form method="POST" action="{{ route('provider.storeProvider') }}" enctype="multipart/form-data" data-parsley-validate
          novalidate>
    {{ csrf_field() }}

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <h4 class="page-title">إضافة مزود خدمة</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">
                    
                    <h4 class="header-title m-t-0 m-b-30">بيانات مزود الخدمة</h4>


                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="userName">اسم مزود الخدمة*</label>
                            <input class="form-control name" type="text" name="name" value="{{ old('name') }}" placeholder="اسم مزود الخدمة" required>
                            <p class="help-block" id="error_userName"></p>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                    </div>

                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="userPhone">رقم الجوال*</label>
                            
                            <input class="form-control phoneCenter" type="tel" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال" required>
                            <span class="phone errorValidation"></span>
                            @if($errors->has('phone'))
                                <p class="help-block">
                                    {{ $errors->first('phone') }}
                                </p>
                            @endif
                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="emailAddress">البريد الإلكتروني*</label>

                            <input type="email" name="email" parsley-trigger="change" value="{{ old('email') }}"
                                   class="form-control"
                                   placeholder="البريد الإلكتروني..." required/>
                            @if($errors->has('email'))
                                <p class="help-block">{{ $errors->first('email') }}</p>
                            @endif

                        </div>

                    </div>

                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="pass1">كلمة المرور*</label>


                            <input type="password" name="password" id="pass1" value="{{ old('password') }}"
                                   class="form-control"
                                   placeholder="كلمة المرور..."
                                   required/>

                            @if($errors->has('password'))
                                <p class="help-block">{{ $errors->first('password') }}</p>
                            @endif

                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="passWord2">تأكيد كلمة المرور*</label>
                            <input data-parsley-equalto="#pass1" name="password_confirmation" type="password" required
                                   placeholder="تأكيد كلمة المرور..." class="form-control" id="passWord2">
                            @if($errors->has('password_confirmation'))
                                <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                            @endif


                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="passWord2">العنوان*</label>
                        <input name="address" value="{{ old('address') }}" type="text" required placeholder="العنوان..."
                               class="form-control">
                        
                        @if($errors->has('address'))
                            <p class="help-block">{{ $errors->first('address') }}</p>
                        @endif

                    </div>

                    

                    <div class="form-group">
                        <label for="pass1">المدينة *</label>
                        <select class="form-control" name="city">
                            <option value="" selected disabled>المدينة</option>
                            @if(count($cities) > 0)
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->{'name:ar'} }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pass1">نوع مزود الخدمة *</label>
                        <select class="form-control" name="providerType">
                            <option value="" selected disabled>نوع مزود الخدمة</option>
                            <option value="0">فرد</option>
                            <option value="1">مركز</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="userName">اسم المركز عربى*</label>
                        <input class="form-control name" type="text" name="name_ar" value="{{ old('name_ar') }}" placeholder="اسم المركز عربى" required>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('name_ar'))
                            <p class="help-block">
                                {{ $errors->first('name_ar') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="userName">اسم المركز انجليزى*</label>
                        <input class="form-control name" type="text" name="name_en" value="{{ old('name_en') }}" placeholder="اسم المركز انجليزى" required>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('name_en'))
                            <p class="help-block">
                                {{ $errors->first('name_en') }}
                            </p>
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="userName">وصف المركز عربى*</label>
                        <textarea class="form-control description" name="description_ar" value="{{ old('description_ar') }}" placeholder="وصف المركز عربى" required>{{ old('description_ar') }}</textarea>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('description_ar'))
                            <p class="help-block">
                                {{ $errors->first('description_ar') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="userName">وصف المركز انجليزى*</label>
                        <textarea class="form-control description" name="description_en" value="{{ old('description_en') }}" placeholder="وصف المركز انجليزى" required>{{ old('description_en') }}</textarea>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('description_en'))
                            <p class="help-block">
                                {{ $errors->first('description_en') }}
                            </p>
                        @endif
                    </div>

                    
                    <!--<div class="form-group" id="service">-->
                    <!--    <label>الخدمات</label><br/>-->
                    <!--    <div class="row" id="row0">-->
                    <!--        <div class="col-lg-1"> #1 : </div>-->
                    <!--        <div class="col-lg-5">-->
                                
                    <!--            <select class="form-control select2" name="service[0]">-->
                    <!--                <option value="" disabled>يرجى اختيار الخدمة</option>-->
                    <!--                @forelse($services as $service)-->
                    <!--                    <option value="{{ $service->id }}">{{ $service->name }}</option>-->
                    <!--                @empty-->
                    <!--                    <option value="">لا توجد بيانات</option>-->
                    <!--                @endforelse-->
                    <!--            </select>-->
                    <!--        </div>-->
                    <!--        <a class="col-lg-1 removeService" data-id="0"><i class="fa fa-remove"></i></a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <!--<div class="form-group text-right m-b-0 ">-->
                    <!--    <button id="mydiv" data-myval="0" class="btn btn-primary waves-effect waves-light m-l-5 m-t-20">-->
                    <!--        إضافة خدمة</button>-->
                    <!-- </div>-->

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
                    <h4 class="header-title m-t-0 m-b-30">صورة الحساب</h4>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="file" name="image" class="dropify" data-max-file-size="6M" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside" required data-parsley-required-message="هذا الحقل إلزامي" />

                        </div>
                    </div>

                </div>
                
                <div class="card-box" style="overflow: hidden;">
                    <h4 class="header-title m-t-0 m-b-30">صورة السجل التجارى او وثيقة الهوية</h4>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="file" name="document_photo" class="dropify" data-max-file-size="6M" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside" required data-parsley-required-message="هذا الحقل إلزامي" />

                        </div>
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </form>
@endsection
@section('scripts')
    <script>
        //$(document).ready(function () {

        var services = @json($services);
        //var json = JSON.parse(data)
        console.log('services');
        var arr = [];
        $.each(services, function(key, val) {
            console.log('inas');
            arr.push('<option value="' + val.id + '">' + val.name + '</option>');
        });
         $('#mydiv').on('click', function (e) {
            console.log('inas');
            e.preventDefault();
            var a = $('#mydiv').data('myval');
            var v = a + 1;
            $('#mydiv').data('myval', a + 1);
        
            $('#service').append('<div class="row" id="row'+v+'" data-id="row' + v + '"><div class="col-lg-1"># '+(v+1)+' : </div> <div class="col-lg-5"><select class="form-control" name="service[' + v + ']" id="serviceId">'+arr+'</div><div class="col-lg-2"><a class="col-lg-1 removeService" data-id="'+ v + '"><i class="fa fa-remove"></i></a></div></div>');
        });
        
        //$('document').on('click', '.removeElement', function () {
          $('.removeService').on('click', function (e) {
             console.log('inasssss');
             e.preventDefault();
            console.log('ayhaga');
            var id = $(this).attr('data-id');
            console.log("#row"+id);
            //$("#row"+id).remove();
            $("#row"+id).fadeOut(1000, function () {
                $("#row"+id).remove();
            });

        });
    </script>
@endsection