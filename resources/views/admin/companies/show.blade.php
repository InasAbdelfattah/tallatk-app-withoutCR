@extends('admin.layouts.master')

@section('content')

<?php 
    if(isset($_GET['commentId'])){
        $comment_id = $_GET['commentId'];
    }else{
        $comment_id = null;
    }
    
    if(isset($_GET['abusement'])){
        $abusement = $_GET['abusement'];
    }else{
        $abusement = null;
    }
?>

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            @if($abusement == null)
            <h3 class="page-title">بيانات مزود الخدمة</h3>
            @else
            <h3 class="page-title">تفاصيل بلاغ الإساءة</h3>
            @endif
        </div>

        
                        <div class="m-t-15 col-xs-6 col-md-8 col-sm-8 text-right">
                        <!--    <a href="profile_edit.html">
                                     <button type="button" class="btn btn-success">تعديل البيانات</button>
                                </a> -->
                        
                        
                <a class="btn btn-success waves-effect waves-light" onclick="window.history.back(); return false;">
                     رجوع
                </a>
        
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        {{--<h3 class="m-t-0 m-b-0">بيانات المركز</h3>--}}

                        <!--<div class="m-t-20 text-center">-->
                        <!--    @if($company->image)-->
                        <!--    <a data-fancybox="gallery"-->
                        <!--       href="{{ url('files/companies/' . $company->image) }}">-->
                        <!--        <img class="img-thumbnail" src="{{ url('files/companies/' . $company->image) }}"/>-->
                        <!--    </a>-->
                        <!--    @else-->
                        <!--    <img class="img-thumbnail" src="{{ request()->root().'/assets/admin/custom/images/default.png' }}"/>-->
                        <!--    @endif-->
                        <!--</div>-->

                        <div class="panel-body">
                            @if($abusement != null)
                            @php $abuse = \App\Abuse::find($abusement); @endphp
                            
                                @if($abuse)
                                <!--<div class="col-lg-4 col-xs-12">-->
                                <!--    <label>نص البلاغ:</label>-->
                                <!--    <p>{{ $abuse->text }}</p>-->
                                <!--</div>-->
                                
                                <div class="col-lg-4 col-xs-12">
                                    <label>بيانات صاحب التعليق</label>
                                    @php $usr = \App\User::find($abuse->user_id); @endphp
                                    @if($usr)
                                    <p>الاسم :{{ $usr->name }}</p>
                                    <p>الهاتف: {{ $usr->phone }}</p>
                                    @endif
                                </div>
                                @endif
                            @endif
                            
                           
                            
                            <div class="col-lg-4 col-xs-12">
                                <label>اسم مزود الخدمة:</label>
                                <p>@if($company->user){{ $company->user->name }} @else -- @endif</p>
                            </div>

                            <div class="col-lg-4 col-xs-12">
                                <label>رقم الجوال :</label>
                                <p>@if($company->user) {{ $company->user->phone }} @else -- @endif </p>
                            </div>

                            <!--<div class="col-lg-3 col-xs-12">-->
                            <!--    <label>رقم جوال المركز :</label>-->
                            <!--    <p>{{ $company->phone }}</p>-->
                            <!--</div>-->

                            <div class="col-lg-4 col-xs-12">
                                <label>البريد الالكتروني :</label>
                                <p>@if($company->user) {{ $company->user->email }} @else -- @endif </p>
                            </div>

                            <!--<div class="col-lg-4 col-xs-12">-->
                            <!--    <label>  مكان الخدمة :</label>-->
                            <!--    <p>{{ $company->place == 0 ? 'منازل' : 'مركز' }}</p>-->
                            <!--</div>-->

                            <div class="col-lg-4 col-xs-12">
                                <label> نوع مزود الخدمة :</label>
                                <p>{{ $company->type == 0 ? 'فرد' : 'مركز' }}</p>
                            </div>

                            <!-- <div class="col-lg-3 col-xs-12">
                                <label>العضوية :</label>
                                <p> {{ $company->membership['name'] }}</p>
                            </div> -->

                            <div class="col-lg-4 col-xs-12">
                                <label>المدينة :</label>
                                <p>@if($company->city){{ $company->city->{'name:ar'} }}@endif</p>
                            </div>
                            
                             @if($comment_id == null)
                            <!-- <div class="row">-->
                            <!--<div class="col-lg-6 col-xs-12">-->
                            <!--    <form action="{{ route('company.activation') }}" method="post" data-id="{{ $company->id }}">-->

                            <!--        {{ csrf_field() }}-->
                            <!--         <input type="hidden" value="{{ $company->id }}" name="companyId" id="companyID"/>-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="pass1">حالة المركز</label>-->
                            <!--        <select class="form-control select2" name="agree">-->
                            <!--            <option value="" {{$company->is_agree == 0 ? 'selected' : ''}}>جديد</option>-->
                            <!--            <option value="1" {{$company->is_agree == 1 ? 'selected' : ''}}>قبول</option>-->
                            <!--            <option value="0" {{$company->is_agree == 2 ? 'selected' : ''}}>رفض</option>-->
                            <!--        </select>-->
                            <!--    </div>-->
                            <!--    <div class="form-group text-right m-t-20">-->
                            <!--        <button class="btn btn-primary waves-effect waves-light m-t-0" type="submit">-->
                            <!--            حفظ البيانات-->
                            <!--        </button>-->
                                                
                            <!--    </div>-->
                                
                            <!--    </form>-->
                            <!--</div>-->
                            <!--</div>-->
                            @endif

                        </div>
                        
                    </div>
                    
                    <!-- end card-box-->


                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card-box" style="overflow: hidden;">

                         @if($abusement == null)
                            <div style="height:200px; margin-bottom:20px;">
                                <label>صورة المركز</label>
                                @if($company->image)
                            <a data-fancybox="gallery"
                               href="{{ url('files/companies/' . $company->image) }}">
                                <img class="img-thumbnail" src="{{ url('files/companies/' . $company->image) }}" style="width:50; height:50 !important;"/>
                            </a>
                            @else
                            <img class="img-thumbnail" src="{{ request()->root().'/assets/admin/custom/images/default.png' }}"style="width:50; height:50 !important; "/>
                            @endif
                            </div>
                            @endif
                                        
                            @if($abusement == null)
                            <div style="height:200px; margin-top:40px !important">
                                <label> {{ $company->type == 0 ? 'وثيقة الهوية' : 'وثيقة السجل التجارى' }} : </label>
                                @if($company->document_photo != '')
                                    <a data-fancybox="gallery" href="{{ url('files/docs/' . $company->document_photo) }}">
                                        <img class="img-thumbnail" src="{{ url('files/docs/' . $company->document_photo) }}" style="width:50; height:50 !important;"/>
                                    </a>
                                @else
                                    <img class="img-thumbnail" src="{{request()->root().'/assets/admin/custom/images/default.png'}}" style="width:50; height:50 !important;"/>
                                @endif
            
                            </div>
                            @endif
                    
            </div>    
        </div>
    </div>

    @if($comment_id == null)
    <div class="row">

        <div class="col-lg-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">الخدمات</h4>

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
                                <!--<td>{{ $row->service_place == 'center' ? 'مركز' : 'منازل' }}</td>-->
                                <td>
                                    @if($row->service_place == 'center')
                                        المركز
                                    @elseif($row->service_place == 'home')
                                        المنزل
                                    @else
                                        المنزل والمركز
                                    @endif
                                </td>
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

        <div class="col-lg-6">
            <div class="card-box">

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
    @endif

    <div class="row">
        <div class="col-sm-12 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التعليقات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                @if($company->comments->count() > 0)
                                <!-- <table class="table m-0  table-striped table-hover table-condensed" > -->
                                    <table class="table table table-hover m-0" id="datatable-fixed-header">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th> نص التعليق </th>
                                            <th>حالة التعليق</th>
                                            <th>  الخيارات </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                        @foreach($company->comments as $comment)
                                            @if($comment_id != null && $comment->id == $comment_id )
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>@if($comment->user) {{ $comment->user->name }} @else --- @endif</td>
                                                <td>{{ $comment->comment }}</td>
                                                <!-- <td>{{ $comment->created_at }}</td> -->
                                                <td>
                                                    <a id="ban{{$comment->id}}" href="javascript:;" id="commentSuspend{{ $comment->id }}" data-id="{{$comment->id}}" class="suspendElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5" data-overlayColor="#36404a"> @if($comment->is_suspend == 0)حظر التعليق @else رفع الحظر @endif
                                                    </a>
                                                </td>
                                                <td>

                                        <a href="javascript:;" id="commentDelete{{ $comment->id }}" data-id="{{$comment->id}}" class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>@if($comment->user) {{ $comment->user->name }} @else --- @endif</td>
                                                <td>{{ $comment->comment }}</td>
                                                <!-- <td>{{ $comment->created_at }}</td> -->
                                                <td>
                                                    <a id="ban{{$comment->id}}" href="javascript:;" id="commentSuspend{{ $comment->id }}" data-id="{{$comment->id}}" class="suspendElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5" data-overlayColor="#36404a"> @if($comment->is_suspend == 0)حظر التعليق @else رفع الحظر @endif
                                                    </a>
                                                </td>
                                                <td>

                                        <a href="javascript:;" id="commentDelete{{ $comment->id }}" data-id="{{$comment->id}}" class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                
                                @else
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            لا توجد تعليقات متاحة حالياً للمركز
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->

                </div>
            </div>
        </div>
    </div>
@if($comment_id == null)
    <div class="row">

        <div class="col-sm-6 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التقييمات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                @if($company->rates->count() > 0)
                                    <table class="table table table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th> التقييم </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                        @foreach($company->rates as $rate)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>@if( $rate->user ){{ $rate->user->name  or $rate->user->username}} @else
                                                                -- @endif</td>
                                                <td>{{ $rate->rate }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                <div class="col-xs-12">
                                    <div class="alert alert-success">
                                        متوسط تقييم المركز : {{$company->rates->avg('rate')}}
                                    </div>
                                </div>
                                @else
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            لا توجود تقييمات حالياً للمركز
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>
    </div>
@endif
  
@endsection

@section('scripts')

    <script>
    
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


        $('body').on('click', '.removeElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#commentDelete' + id).parent().parent());
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
                        url: '{{ route('companies.deleteComment') }}',
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

        $('body').on('click', '.suspendElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#commentSuspend' + id).parent().parent());
            var $td = $(this).closest($('#ban' + id));
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
                        url: '{{ route('companies.suspendComment') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log('suspend : ', data.data.suspend);
                            
                            if (data.status == true) {
                                if(data.data.suspend == 1){
                                    // $td.removeClass('btn-danger');
                                    // $td.addClass('btn-success');
                                    $td.text('رفع الحظر');
                                }else{
                                    $td.text(' حظر');
                                }
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت العملية بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                                   
                                // $tr.find('td').fadeOut(1000, function () {
                                //     $tr.find('td:first').text('inas');
                                //     //$("#myDiv table table td:first").text("Picked")
                                // });
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
                        text: "انت لغيت عملية الحذر تقدر تحاول فى اى وقت :)",
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
        
        $('form').on('submit', function (e) {
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

                        $("#currentRow" + data.id).html('تم التفعيل');
                        $("#currentRow" + data.id).addClass('btn-danger').removeClass('btn-success');
                        setTimeout(function () {
                            $('#currentRowOn' + data.id).parents('table').DataTable()
                                .row($('#currentRowOn' + data.id))
                                .remove()
                                .draw();
                        }, 2000);




                        {{--setTimeout(function () {--}}
                        {{--window.location.href = '{{ route('categories.index') }}';--}}
                        {{--}, 3000);--}}
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