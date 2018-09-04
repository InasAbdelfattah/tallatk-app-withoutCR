@extends('admin.layouts.master')
@section('title', 'إدارة المستخدمين')
@section('content')

    <!-- Page-Title -->
    <div class="row zoomIn">
        <div class="col-sm-12">
            <!-- <div class="btn-group pull-right m-t-15">

                <a href="{{ route('users.createProvider') }}" type="button" class="btn btn-custom waves-effect waves-light"
                   aria-expanded="false"> إضافة
                    <span class="m-l-5">
                        <i class="fa fa-user"></i>
                    </span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </div> -->
            
            <h4 class="page-title">مشاهدة مزودى الخدمة</h4>
        </div>
    </div>

    <div class="row zoomIn">
        <div class="col-sm-12">
            <div class="card-box">

                <div class="row">
                    <div class="col-sm-4 col-xs-8 m-b-30" style="display: inline-flex">
                        مشاهدة مزودى الخدمة
                    </div>
                    
                    <div class="col-sm-4 btn-group">
                        
                        <a href="{{ route('users.providers_requests') }}" type="button" class="btn btn-custom waves-effect waves-light" aria-expanded="false"> طلبات مزودى الخدمات
                            <span class="m-l-5">
                                <i class="fa fa-user"></i>
                            </span>
                        </a>
            
                        <a href="{{ route('users.createProvider') }}" type="button" class="btn btn-custom waves-effect waves-light"
                           aria-expanded="false"> إضافة مزود خدمة
                            <span class="m-l-5">
                                <i class="fa fa-user"></i>
                            </span>
                        </a>
                    </div>

                    <div class="col-sm-4 col-sm-offset-4 pull-left">
                        <a style="float: left; margin-right: 15px;    margin-bottom: 20px;"
                           class="btn btn-danger btn-sm getSelected">
                            <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                        </a>

                        <!-- <a style="float: left;" class="btn btn-info btn-sm getSelectedAndSuspend">
                            <i class="fa fa-users" style="margin-left: 5px"></i> حظر المستخدمين
                        </a> -->
                    </div>
                </div>

                {{--<div class="col-sm-4 col-xs-8 m-b-30" style="display: inline-flex">--}}
                {{--<input type="text" name="filter" class="filteriTems form-control" placeholder="بحث..."--}}
                {{--id="filterItems"--}}
                {{--data-url="{{ route('users.filter') }}"/>--}}

                {{--<select id="recordNumber" class="filteriTems form-control"--}}
                {{--data-url="{{ route('users.filter') }}" style="width: 80px;margin-right: 10px">--}}

                {{--<option value="10">10</option>--}}
                {{--<option value="15">15</option>--}}
                {{--<option value="20">20</option>--}}
                {{--<option value="25">25</option>--}}
                {{--<option value="50">50</option>--}}
                {{--<option value="100">100</option>--}}

                {{--</select>--}}
                {{--</div>--}}



                {{--<div class="table-rep-plugin">--}}
                {{--<div class="articles">--}}
                {{--@include('admin.users.load')--}}
                {{--</div>--}}
                {{--</div>--}}


<div class="table-responsive">
                <table id="datatable-fixed-header" class="table  table-striped">
                    <thead>
                    <tr>
                        <th>
                            <div class="checkbox checkbox-primary checkbox-single">
                                <input type="checkbox" style="margin-bottom: 0px;" name="check"
                                       onchange="checkSelect(this)"
                                       value="option2"
                                       aria-label="Single checkbox Two">
                                <label></label>
                            </div>
                        </th>
                        <th>الصورة</th>
                        <th>الاسم </th>
                        <!--<th>تفاصيل المركز</th>-->
                        <th>البريد الإلكتروني</th>
                        <th>رقم الجوال</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                        <!--<th>حالة الحذر</th>-->
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)

                        <tr>
                            <td>
                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" style="margin-bottom: 0px;" class="checkboxes-items"
                                           value="{{ $user->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>
                            </td>
                            <td style="width: 10%;">
                                @if($user->image != '')
                                <a data-fancybox="gallery"
                                   href="{{ request()->root().'/files/users/'.$user->image }}">
                                    <img style="width: 50%; border-radius: 50%; height: 49px;"
                                         src="{{ request()->root().'/files/users/'.$user->image }}"/>
                                </a>
                                @else ---
                                @endif

                            </td>

                            <td>{{ $user->name }}</td>
                            <!--<td><a target="_blank" href="{{ route('companies.show', $user->company_id) }}">تفاصيل المركز: {{ $user->company_name }}</a></td>-->
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td> {{$user->gender == 'male' ? 'رجال' : 'نساء'}} </td>

                            <td>
                                <!--@if($user->is_active == 1)-->
                                <!--    <label class="label label-success label-xs">مفعل</label>-->
                                <!--@else-->
                                <!--    <label class="label label-danger label-xs">غير مفعل</label>-->
                                <!--@endif-->
                                
                                <a href="javascript:;" id="activateRow{{ $user->id }}" data-id="{{ $user->id }}" data-status="{{$user->is_suspend}}"
                                   class="elementStatus btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                @if($user->is_suspend != 1)
                                    <label class="label label-danger label-xs">تعطيل</label>
                                @else
                                    <label class="label label-success label-xs">تفعيل</label>
                                @endif
                            </a>
                            </td>

                            <!--<td>-->
                            <!--    @if($user->is_suspend == 0)-->
                            <!--        <label class="label label-success label-xs">غير محذور</label>-->
                            <!--    @else-->
                            <!--        <label class="label label-danger label-xs"> محذور</label>-->
                            <!--    @endif-->
                            <!--</td>-->


                            <td>
                                <a href="{{ route('companies.show', $user->company_id) }}"class="btn btn-icon btn-xs waves-effect btn-default m-b-5">
                                    <i class="fa fa-eye"></i></a>
                                
                                <a href="{{ route('users.editProvider',$user->id) }}"
                                   class="btn btn-icon btn-xs waves-effect btn-default m-b-5">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @if($user->id != 1)
                                <a href="javascript:;" id="elementRow{{ $user->id }}" data-id="{{ $user->id }}"
                                   class="removeElement btn-xs btn-icon btn-trans btn-sm waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>

                                </a>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
</div>
            </div>
        </div>
    </div>
    <!-- End row -->
@endsection

@section('scripts')

    <script>
    
    $('body').on('click', '.elementStatus', function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            
            if(status != 1){
                var type = 'success';
            }else{
                var type = 'error';
            }
            
            console.log(status);
            var $tr = $(this).closest($('#activateRow' + id).parent().parent());
            swal({
                title: "هل انت متأكد؟",
                text: "",
                type: type,
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
                        url: '{{ route('user.activateProvider') }}',
                        data: {id: id , status: status},
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            if (data.status == true) {
                                var shortCutFunction = 'success';
                                var msg = data.message;
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-center',
                                    onclick: null,
                                    showMethod: 'slideDown',
                                    hideMethod: "slideUp",
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                                location.reload();

                                // $tr.find('td').fadeOut(1000, function () {
                                //     $tr.remove();
                                // });

                            } else {
                                var shortCutFunction = 'error';
                                var msg = data.message;
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



        @if(session()->has('success'))
        setTimeout(function () {
            showMessage('{{ session()->get('success') }}');
        }, 3000);
        @endif

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
                        url: '{{ route('user.delete') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            $('#catTrashed').html(data.trashed);
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
                            url: '{{ route('users.group.delete') }}',
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
                                    
                                    location.reload();
                                   
                                }

                                $('.checkboxes-items').each(function () {
                                    if ($(this).prop('checked') == true) {
                                        $(this).parent('tr').remove();
                                    }
                                });
                        // $tr.find('td').fadeOut(1000, function () {
                        //     $tr.remove();
                        // });
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

        $('.getSelectedAndSuspend').on('click', function () {

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
                            url: '{{ route('users.group.suspend') }}',
                            data: {ids: sum},
                            dataType: 'json',
                            success: function (data) {
                                $('#catTrashed').html(data.trashed);
                                if (data) {
                                    var shortCutFunction = 'success';
                                    var msg = 'لقد تمت عملية الحظر بنجاح.';
                                    var title = data.title;
                                    toastr.options = {
                                        positionClass: 'toast-top-left',
                                        onclick: null
                                    };
                                    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                    $toastlast = $toast;

                                    location.reload();
                                }

                        //         $('.checkboxes-items').each(function () {
                        //             if ($(this).prop('checked') == true) {
                        //                 $(this).parent().parent().parent().remove();
                        //             }
                        //         });
                        // $tr.find('td').fadeOut(1000, function () {
                        //     $tr.remove();
                        // });
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

@endsection