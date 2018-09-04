@extends('admin.layouts.master')

@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            @if( isset($type) && $type == 1)
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('orders.financial_reports') }}"
                   class="btn btn-custom  waves-effect waves-light">
                    <span class="m-l-5">
                        <i class="fa fa-eye"></i> <span>مشاهدة التقارير المالية</span></span>
                </a>

            </div>
            @endif
           
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

                <form action="{{route('orders.search_reports')}}" method="get">
                    {{csrf_field()}}
                    <div class="row form-group">
                        <!--<div class="col-lg-3">-->
                        <!--    نوع الخدمة : -->
                            <!--<input type="text" name="service_type" class="form-control"/>-->
                        <!--    <select name="service_type" class="form-control">-->
                        <!--        <option value="">نوع الخدمة</option>-->
                        <!--    @if(count($cats)>0)-->
                        <!--        @foreach($cats as $cat)-->
                                
                        <!--        <option value="{{$cat->id}}">{{$cat->name_ar}}</option>-->
                        <!--        @endforeach-->
                        <!--    @endif-->
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

                    @if(count($orders) > 0)
                    @foreach($orders as $row)
                        <tr>
                            <td>

                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="{{ $row->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>
                            </td>

                            <td>{{ $row->created_at }}</td>
                            <td>{{$row->id}}</td>

                            
                            
                            <td>@if(user($row->provider_id)){{ user($row->provider_id)->name }}@endif</td>
                            <td>{{ $row->username }}</td>
                            <!--<td>{{ $row->company_name }}</td>-->
                            @php $service = App\Service::find($row->service_id) ; @endphp
                            <td> @if($service) {{$service->{'name:ar'} }} @endif</td>
                            <td>{{ $row->price }}</td>
                            <!--<td>{{$row->min_cost}}</td>-->
                            <!--<td>{{$row->max_cost}}</td>-->
                            <!--<td>
                                @php 
                                    $provider_rate = \App\Rate::where('order_id',$row->id)->where('rate_from','provider')->first();
                                @endphp
                                @if($provider_rate)
                                    {{$provider_rate->price}}
                                @else
                                    ---
                                @endif
                            </td> -->
                            <td>
                                {{--  <label class="label label-inverse">  --}}
                                    @if($setting && $provider_rate)
                                     
                                        {{ $setting->getBody('commission') * $provider_rate->price /100}}
                                        
                                    @endif
                                {{--  </label>  --}}
                            </td>
                            <!--<td>
                                 <a href="{{ route('orders.show', $row->id) }}"
                                  class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i>
                                </a> 

                                <a href="javascript:;" id="elementRow{{ $row->id }}"
                                   data-id="{{ $row->id }}"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td> -->
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
</div>
            </div>
            </div>
        </div><!-- end col -->

  
    <!-- end row -->
@endsection


@section('scripts')

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
                        url: '{{ route('orders.delete') }}',
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
                            url: '{{ route('orders.group.delete') }}',
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

@endsection
