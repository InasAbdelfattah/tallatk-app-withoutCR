@extends('admin.layouts.master')

@section('content')

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
                                <p>{{ $order->username }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>مزود الخدمة :</label>
                                <p>@if(user($order->provider_id)){{ user($order->provider_id)->name }}@endif</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>مدينة الخدمة :</label>
                                <p>@php $city = App\City::find($order->city_id) ; @endphp
                            @if($city){{ $city->{'name:ar'} }}@endif</p>
                            </div>

                            

                           

                            

                            <div class="col-lg-3 col-xs-12">
                                <label>مكان الخدمة :</label>
                                <!--<p>{{ $order->company_place == 0 ? 'منازل' : 'مركز' }} </p>-->
                                <p>{{ $order->place == 'home' ? 'منزل' : 'مركز' }} </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                @php $service = \App\Service::find($order->service_id); @endphp
                                <label>وصف الخدمة :</label>
                                
                                <p>{{$service ? $service->{'description:ar'} : ''}}</p>
                            </div>
                            

                            

                            <div class="col-lg-6 col-xs-12">
                                <label> <p>حالة الطلب :</label>
                                <p>
                                @if($order->status == 0) جديد
                                @elseif($order->status == 1) منتهى
                                @elseif($order->status == 3) مقبول
                                @elseif($order->status == 2) مرفوض
                                @elseif($order->status == 4) مـتأخر
                                @elseif($order->status == 5) ملغى
                                @endif
                                </p>
                                

                            </div>
                            @if($order->status == 2)
                                <div class="col-lg-6 col-xs-12">
                                    <label>سبب رفض الطلب:</label>
                                    <p>{{$order->refuse_reasons}}</p>
                                </div>
                            @endif
                            
                            @if($order->status == 5)
                                <div class="col-lg-6 col-xs-12">
                                    <label>سبب الغاء الطلب:</label>
                                    <p>{{$order->cancel_reason}}</p>
                                </div>
                            @endif
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> تاريخ الطلب :</label>
                                <p>{{$order->created_at ?  $order->created_at->format('Y-m-d') : ''}}</p>

                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label>وقت الطلب :</label>
                                <p>{{ $order->created_at ? $order->created_at->format('H:i:s') : ''}}</p>

                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label>اسم الخدمة :</label>
                                @php $serv = \App\Service::find($order->service_id); @endphp
                                @if($serv)
                                    <p>{{ $serv->{'name:ar'} }}}</p>
                                @endif

                            </div>
                            
                            <!--<div class="col-lg-6 col-xs-12">-->
                            <!--    <label>الخدمات الطلوبة  :</label>-->
                            <!--    @if($order->orderServices)-->
                            <!--    <table class="table table-striped table-hover table-condensed" style="width:100%">-->
                            <!--        <tr>-->
                            <!--            <th>اسم الخدمة</th>-->
                            <!--            <th>السعر</th>-->
                            <!--        </tr>-->
                            <!--        @forelse($order->orderServices as $service)-->
                            <!--            @php $serv = \App\Service::find($service->service_id); @endphp-->
                            <!--            @if($serv)-->
                            <!--                <tr>-->
                            <!--                    <th>{{ $serv->{'name:ar'} }}</th>-->
                            <!--                    <th>{{ $serv->price }}</th>-->
                            <!--                </tr>-->
                                        
                            <!--            @endif-->
                            <!--        @empty-->
                            <!--            <p>لا توجد خدمات مضافة</p>-->
                            <!--        @endforelse-->
                            <!--    </table>-->
                            <!--    @endif-->

                            <!--</div>-->
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> <p> تكلفة الطلب الإجمالية :</label>
                                <p>{{ $order->price }}</p>

                            </div>
                            
                            
                            
                            @if($provider_rate != null)
                            <div class="col-lg-6 col-xs-12">
                                <label> <p>المبلغ المستلم من مزود الخدمة:</label>
                                <p>{{ $provider_rate->price }}</p>

                            </div>
                            @endif
                            
                            @if($user_rate != null)
                            <div class="col-lg-6 col-xs-12">
                                <label> <p> المبلغ المدفوع من طالب الخدمة:</label>
                                <p>{{ $user_rate->price }}</p>

                            </div>
                            @endif
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> <p>التقييم :</label>
                                <p><label class="label label-inverse">@if($order->rates){{ $order->rates->avg('rate') }}@else 'لم يقيم' @endif</label></p>

                            </div>


                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>

    </div>

@endsection
