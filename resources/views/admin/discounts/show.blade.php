@extends('admin.layouts.master')



@section('content')

    <!-- Page-Title -->

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">تفاصيل الخصم</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">تفاصيل الخصم</h3>

                        <div class="panel-body">

                            <div class="col-lg-3 col-xs-12">
                                <label>اسم المستخدم :</label>
                                <p>{{ $user->name }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم الجوال :</label>
                                <p>{{ $user->phone }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">الخصومات الحاصل عليها</h3>

                        <div class="col-sm-6 col-xs-12 m-t-20">
                            <div class="row">
                        
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>م</th>
                                            <th>عدد المسجلين من خلاله</th>
                                            <th>الخصم</th>
                                            <th> الفترة من : </th>
                                            <th> الفترة إلى : </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1 ; @endphp
                                        @forelse($discounts as $row)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td style="text-align: center;">{{ $row->registered_users_no }}</td>
                                                <td style="text-align: center;">{{$row->discount}}</td>
                                                <td style="text-align: center;">{{ $row->from_date }}</td>
                                                <td style="text-align: center;">{{ $row->to_date }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2"> لا يوجد </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
   
@endsection
