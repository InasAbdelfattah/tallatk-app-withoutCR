@extends('admin.layouts.master')

@section('content')
    <form method="POST" action="{{ route('provider.updateProvider' , $user->id) }}" enctype="multipart/form-data" data-parsley-validate
          novalidate>
    {{ csrf_field() }}

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <h4 class="page-title">تعديل مزود خدمة</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">
                    
                    <h4 class="header-title m-t-0 m-b-30">بيانات مزود الخدمة</h4>


                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="userName">اسم مزود الخدمة*</label>
                            <input class="form-control" type="text" name="name" value="{{ $user->name }}" placeholder="اسم مزود الخدمة" required>
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
                            
                            <input class="form-control" type="tel" name="phone" value="{{ $user->phone }}" placeholder="رقم الجوال" required>
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

                            <input type="email" name="email" parsley-trigger="change" value="{{ $user->email }}"
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
                                   placeholder="كلمة المرور..."/>

                            @if($errors->has('password'))
                                <p class="help-block">{{ $errors->first('password') }}</p>
                            @endif

                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="passWord2">تأكيد كلمة المرور*</label>
                            <input data-parsley-equalto="#pass1" name="password_confirmation" type="password" placeholder="تأكيد كلمة المرور..." class="form-control" id="passWord2">
                            @if($errors->has('password_confirmation'))
                                <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                            @endif


                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label>العنوان*</label>
                            <input name="address" value="{{ $user->address }}" type="text" placeholder="العنوان..."
                                   class="form-control">
                            
                            @if($errors->has('address'))
                                <p class="help-block">{{ $errors->first('address') }}</p>
                            @endif
    
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label for="pass1">المدينة *</label>
                        <select class="form-control" name="city">
                            <option value="" disabled>المدينة</option>
                            @if(count($cities) > 0)
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{$user->city == $city->id ? 'selected' : ''}}>{{$city->{'name:ar'} }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    @if($company != null)
                    <div class="form-group">
                        <label for="pass1">نوع مزود الخدمة *</label>
                        <select class="form-control" name="providerType">
                            <option value="" disabled>نوع مزود الخدمة</option>
                            <option value="0" {{$company->type == 0 ? 'selected' : '' }}>فرد</option>
                            <option value="1" {{$company->type == 1 ? 'selected' : '' }}>مركز</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="userName">اسم المركز عربى*</label>
                        <input class="form-control" type="text" name="name_ar" value="{{ $company->{'name:ar'} }}" placeholder="اسم المركز عربى" required>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('name_ar'))
                            <p class="help-block">
                                {{ $errors->first('name_ar') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="userName">اسم المركز انجليزى*</label>
                        <input class="form-control" type="text" name="name_en" value="{{ $company->{'name:en'} }}" placeholder="اسم المركز انجليزى" required>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('name_en'))
                            <p class="help-block">
                                {{ $errors->first('name_en') }}
                            </p>
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="userName">وصف المركز عربى*</label>
                        <textarea class="form-control description" name="description_ar" value="{{ $company->{'description:ar'} }}" placeholder="وصف المركز عربى" >{{ $company->{'description:ar'} }}</textarea>
                        <p class="help-block" id="error_userName"></p>
                        @if($errors->has('description_ar'))
                            <p class="help-block">
                                {{ $errors->first('description_ar') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="userName">وصف المركز انجليزى*</label>
                        <textarea class="form-control description" name="description_en" value="{{ $company->{'description:en'} }}" placeholder="وصف المركز انجليزى" >{{$company->{'description:en'} }}</textarea>
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
                @endif

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
                            
                            <input type="file" name="image" class="dropify" data-max-file-size="6M" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside" data-default-file="{{ request()->root().'/files/users/'.$user->image }}"/>

                        </div>
                    </div>

                </div>
                
                <div class="card-box" style="overflow: hidden;">
                    <h4 class="header-title m-t-0 m-b-30">صورة السجل التجارى</h4>
                    <div class="form-group">
                        <div class="col-sm-12">
                        
                            <input type="file" name="document_photo" class="dropify" data-max-file-size="6M" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside" data-default-file="{{ request()->root().'/files/docs/'.$company->document_photo }}"/>

                        </div>
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </form>
    
     <div class="row">
          <!--assign cards for the center -->
        <div class="col-lg-8">
            <div class="card-box">
                <a style="float: left; margin-right: 15px;" href="#custom-modal{{ $company->id }}"
                data-id="{{ $company->id }}" id="currentRow{{ $company->id }}"
                class="btn btn-success btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10"
                data-animation="fadein" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a">
                    <i class="fa fa-plus" style="margin-left: 5px"></i>
                </a>
                <div id="custom-modal{{ $company->id }}" class="modal-demo"
                     data-backdrop="static">
                    <button type="button" class="close" onclick="Custombox.close();">
                        <span>&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="custom-modal-title">اضافة خدمة</h4>
                    <div class="custom-modal-text text-right" style="text-align: right !important;">
                        <form id="serviceAdd" action="{{ route('provider.saveService') }}" method="post" data-id="{{ $company->id }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="centerId" value="{{ $company->id}}">
                            <div id="cat" class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <label for="pass1"> نوع الخدمة*</label>
                                <select class="form-control select2" name="serviceType_id">
                                    <option value="">برجاء اختيار نوع الخدمة</option>
                                    @forelse($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @empty
                                        <option value="">لا يوجد</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pass1">نوع مستقبل الخدمة*</label>
                                <select class="form-control select2" name="gender">
                                    <option value="male">رجل</option>
                                    <option value="female">امرأة</option>
                                    <option value="both">الاثنين معا</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="pass1">نوع مستقبل الخدمة*</label>
                                <select class="form-control select2" name="service_place">
                                    <option value="center">مركز</option>
                                    <option value="home">منزل</option>
                                </select>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="userName">اسم الخدمة عربى*</label>
                                <input class="form-control name" type="text" name="name_ar" value="{{ old('name_ar') }}" placeholder="اسم الخدمة عربى" required>
                                <p class="help-block" id="error_userName"></p>
                                @if($errors->has('name_ar'))
                                    <p class="help-block">
                                        {{ $errors->first('name_ar') }}
                                    </p>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="userName">اسم الخدمة انجليزى*</label>
                                <input class="form-control name" type="text" name="name_en" value="{{ old('name_en') }}" placeholder="اسم الخدمة انجليزى" required>
                                <p class="help-block" id="error_userName"></p>
                                @if($errors->has('name_en'))
                                    <p class="help-block">
                                        {{ $errors->first('name_en') }}
                                    </p>
                                @endif
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="userName">وصف الخدمة عربى*</label>
                                <textarea class="form-control description" name="description_ar" value="{{ old('description_ar') }}" placeholder="وصف الخدمة عربى" required>{{ old('description_ar') }}</textarea>
                                <p class="help-block" id="error_userName"></p>
                                @if($errors->has('description_ar'))
                                    <p class="help-block">
                                        {{ $errors->first('description_ar') }}
                                    </p>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="userName">وصف الخدمة انجليزى*</label>
                                <textarea class="form-control description" name="description_en" value="{{ old('description_en') }}" placeholder="وصف الخدمة انجليزى" required>{{ old('description_en') }}</textarea>
                                <p class="help-block" id="error_userName"></p>
                                @if($errors->has('description_en'))
                                    <p class="help-block">
                                        {{ $errors->first('description_en') }}
                                    </p>
                                @endif
                            </div>

                            <div class="form-group" id="service_id">
                                <label>سعر الخدمة</label>
                                <input type="text" name="price" class="form-control">

                            </div>
                            
                            <div class="form-group">
                                <label>صورة الخدمة</label>
                                <div class="col-sm-12">
                                    <input type="file" name="image" class="dropify" data-max-file-size="6M" data-show-remove="false" data-allowed-file-extensions="pdf png gif jpg jpeg" data-errors-position="outside" required data-parsley-required-message="هذا الحقل إلزامي" />
        
                                </div>
                            </div>


                            <div class="form-group text-right m-t-20">
                                <button class="btn btn-primary waves-effect waves-light m-t-0"
                                        type="submit">
                                    حفظ البيانات
                                </button>
                                <button onclick="Custombox.close();" type="reset"
                                        class="btn btn-default waves-effect waves-light m-l-5 m-t-0">
                                    إلغاء
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <h4 class="header-title m-t-0 m-b-30">الخدمات : </h4>

                 @if($company->products->count() > 0)
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>صورة الخدمة</th>
                            <th>اسم الخدمة</th>
                            <th>نوع مستقبل الخدمة</th>
                            <th>نوع مزود الخدمة</th>
                            <th>مكان الخدمة</th>
                            <th>السعر</th>
                            <!-- <th>الحى</th> -->
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                        @foreach($company->products  as $row)
                       
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <a data-fancybox="gallery"
                                       href="{{ request()->root().'/files/companies/services/'.$row->photo}}">
                                        <img style="width: 50px; height: 50px; border-radius: 50%"
                                             src="{{ request()->root().'/files/companies/services/'.$row->photo }}"/>
                                    </a>
                                </td>
                                <td>{{ $row->{'name:ar'} }}</td>
                                <td>
                                    @if( $row->gender_type == 'male') رجال 
                                    @elseif($row->gender_type == 'female')نساء
                                    @else كلاهما
                                    @endif
                                </td>
                                <td>{{ $row->provider_type == 'male' ? 'رجال' : 'نساء' }}</td>
                                <td>{{ $row->service_place == 'center' ? 'مركز' : 'منازل' }}</td>
                                <td>{{ $row->price }}</td>
                                <!-- <td> @if($row->district) {{$row->district->{'name:ar'} }} @endif</td> -->
                                <td>
                                    <!-- <a href="javascript:;" id="updateRow{{ $row->id }}" data-id="{{ $row->id }}"
                                       data-url="{{ route('product.update')  }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a> -->

                                    <a href="javascript:;" id="service{{ $row->id }}" data-id="{{ $row->id }}"
                                       data-url="{{ route('product.delete')  }}"
                                       class="btn btn-xs btn-danger removeService">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger text-center">
                                لا توجد خدمات متاحة حالياً للمركز
                            </div>
                        </div>
                    </div>

                @endif


            </div>

        </div>
    </div>

   <div class="row">
          <!--assign workdays for the center -->
    <div class="col-lg-8">
        <div class="card-box">
            <a style="float: left; margin-right: 15px;" href="#custom-modal-workday{{ $company->id }}"
            data-id="{{ $company->id }}" id="currentRow{{ $company->id }}"
            class="btn btn-success btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10"
            data-animation="fadein" data-plugin="custommodal"
            data-overlaySpeed="100" data-overlayColor="#36404a">
                <i class="fa fa-plus" style="margin-left: 5px">اضافة يوم عمل</i>
            </a>

            <div id="custom-modal-workday{{ $company->id }}" class="modal-demo"
                 data-backdrop="static">
                <button type="button" class="close" onclick="Custombox.close();">
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title">اضافة يوم عمل</h4>
                <div class="custom-modal-text text-right" style="text-align: right !important;">
                    <form id="workDayAdd" action="{{ route('provider.saveWorkday') }}" method="post" data-id="{{ $company->id }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="centerId" value="{{ $company->id}}">
                        
                        <div class="form-group">
                            <label for="pass1">يوم العمل :*</label>
                            <select class="form-control select2" name="day">
                                <option value="Sat">السبت</option>
                                <option value="Sun">الأحد</option>
                                <option value="Mon">الإثنين</option>
                                <option value="Tue">الثلاثاء</option>
                                <option value="Wed">الأربعاء</option>
                                <option value="Thu">الخميس</option>
                                <option value="Fri">الجمعة</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="userName">من : *</label>
                            <input class="form-control" type="time" name="from" value="{{ old('from') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="userName">الى :*</label>
                            <input class="form-control" type="time" name="to" value="{{ old('to') }}">
                        </div>
                        
                        <div class="form-group text-right m-t-20">
                            <button class="btn btn-primary waves-effect waves-light m-t-0"
                                    type="submit">
                                حفظ البيانات
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <h4 class="header-title m-t-0 m-b-30">مواعيد العميل</h4>
                @if($company->workDays->count() > 0)
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <!-- <th>صورة المنتج</th> -->
                            <th>اليوم</th>
                            <th>من</th>
                            <th>إلى</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($company->workDays  as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    
                                    <td>{{ day($row->day) }}</td>
                                    <td>{{ $row->from }}</td>
                                    <td>{{ $row->to }}</td>
                                    <td>
                                    <!-- <a href="javascript:;" id="updateRow{{ $row->id }}" data-id="{{ $row->id }}"
                                       data-url="{{ route('product.update')  }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a> -->

                                    <a href="javascript:;" id="workday{{ $row->id }}" data-id="{{ $row->id }}"
                                       data-url="{{ route('workday.delete')  }}"
                                       class="btn btn-xs btn-danger removeWorkday">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                                </tr>
                            @endforeach
                       
                        </tbody>
                    </table>
                @else
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger text-center">
                            غير متوفر مواعيد عمل للمركز
                            </div>
                        </div>
                    </div>
                @endif

        </div>

    </div>
</div>

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
        
        
        $('form#serviceAdd').on('submit', function (e) {
            console.log('service add');
            e.preventDefault();


            var id = $(this).attr('data-id');


            // var $tr = $($('#currentRowOn' + id)).closest($('#currentRow' + id).parent().parent());

            // console.log($tr);


            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.status == true) {
                        var shortCutFunction = 'success';
                        var msg = data.message;
                        var title = 'نجاح';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;
                        Custombox.close();

                        location.reload();



                    }

                    if (data.status == false) {
                        var shortCutFunction = 'error';
                        var msg = data.message;
                        var title = 'خطأ';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;
                    }

                },
                error: function (data) {

                }
            });
        });

        $('form#workDayAdd').on('submit', function (e) {
            console.log('service add');
            e.preventDefault();


            var id = $(this).attr('data-id');


            // var $tr = $($('#currentRowOn' + id)).closest($('#currentRow' + id).parent().parent());

            // console.log($tr);


            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.status == true) {
                        var shortCutFunction = 'success';
                        var msg = data.message;
                        var title = 'نجاح';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;
                        Custombox.close();

                        location.reload();



                    }

                    if (data.status == false) {
                        var shortCutFunction = 'error';
                        var msg = data.message;
                        var title = 'خطأ';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;
                    }

                },
                error: function (data) {

                }
            });
        });
        
        $('body').on('click', '.removeService', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#service' + id).parent().parent());
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
                        url: '{{ route('product.delete') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
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
                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = data.message;
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                            }
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

        $('body').on('click', '.removeWorkday', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#workday' + id).parent().parent());
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
                        url: '{{ route('workday.delete') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
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
                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = data.message;
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                            }
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


    </script>
@endsection