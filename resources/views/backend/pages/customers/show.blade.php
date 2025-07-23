@extends('backend.layouts.master')

@section('title_page')
    {{trans('back.Customer_cars')}} :
    {{ $customer->name }}
@endsection

@section('title')
    {{trans('back.Customer_cars')}} :
    {{ $customer->name }}
@endsection

@section('content')

    <div class="col-md-12 mb-1">
        @can('Cars')
            <a class="btn btn-secondary btn-sm" href="{{route('Cars.index')}}" >
                <i class="fas fa-car"></i>
                {{trans('back.Back_to_cars')}}
            </a>
        @endcan

        @can('Customers')
            <a class="btn btn-secondary btn-sm" href="{{route('customers.index')}}" >
                <i class="fas fa-users"></i>
                {{trans('back.Back_to_Customers')}}
            </a>
        @endcan
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th width="50">#</th>
                            <th width="200">
                                {{trans('back.Customer_name')}}
                                <br>
                                {{trans('back.Customer_phone')}}
                            </th>

                            <th width="150">
                                {{trans('back.brands_car')}}
                                <br>
                                {{trans('back.car_model')}}
                                <br>
                                {{trans('back.registration_type')}}
                            </th>

                            <th width="150">{{trans('back.car_number')}}</th>

                            <th width="100">{{trans('back.car_color')}}</th>
                            <th width="100">{{trans('back.manufacturing_year')}}</th>
                            <th width="100">{{trans('back.chassis_no')}}</th>
                            <th width="100">{{trans('back.serial_number')}}</th>
                            <th width="100">{{trans('back.cylinders_no')}}</th>

                            <th width="200">{{trans('back.Action')}}</th>

                            <th width="100">{{trans('back.number_invoices')}}</th>
                            <th width="100">{{trans('back.Total_amount')}}</th>
                            <th width="100">{{trans('back.Paid')}}</th>
                            <th width="100">{{trans('back.rest_amount')}}</th>

                            <th width="150">{{trans('back.car_license')}}</th>
                            <th width="150">{{trans('back.Other_file')}}</th>

                            <th width="100">{{trans('back.Created_at')}}</th>
                            <th width="120">{{trans('back.Action')}}</th>
                            <th width="100">{{trans('back.User')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cars as $key => $car)
                            <tr>
                                <td>{{$key+ $cars->firstItem()}}</td>
                                <td>
                                    {{ $car->Customer->name ?? "" }}
                                    <br>
                                    <a href="https://wa.me/{{ $car->Customer->phone ?? "" }}" target="_blank"> {{ $car->Customer->phone ?? "" }}</a>
                                </td>

                                <td>
                                    @if(app()->getLocale() == 'ar')
                                        {{ $car->CarsBrand->name_ar ?? "" }}
                                    @else
                                        {{ $car->CarsBrand->name_en ?? "" }}
                                    @endif
                                    <br>

                                    @if(app()->getLocale() == 'ar')
                                        {{ $car->CarsModel->name_ar ?? "" }}
                                    @else
                                        {{ $car->CarsModel->name_en ?? "" }}
                                    @endif
                                    <br>

                                    @if(app()->getLocale() == 'ar')
                                        {{ $car->RegistrationType->name_ar ?? "" }}
                                    @else
                                        {{ $car->RegistrationType->name_en ?? "" }}
                                    @endif
                                    <br>
                                </td>

                                <td>
                                    <table class="table table-bordered pb-0 mb-0 ">
                                        <td id="car_number" style="font-size: 14px; font-weight: bold; padding:5px; background-color: #eed2d2">{{$car->car_number}}</td>
                                    </table>
                                </td>

                                <td>{{ $car->car_color }}</td>
                                <td>{{ $car->manufacturing_year }}</td>
                                <td>{{ $car->chassis_no }}</td>
                                <td>{{ $car->serial_number }}</td>
                                <td>{{ $car->cylinders_no }} </td>

                                <td>
                                    @can('new_invoice')
                                        <a class="btn btn-purple btn-xs mb-1 btn-block" href="{{route('create_invoice', $car->id)}}">
                                            {{trans('back.new_invoice')}}
                                        </a>
                                    @endcan

                                    @can('new_quotation')
                                        <a class="btn btn-secondary btn-xs mb-1 btn-block" href="{{route('create_quotation', $car->id)}}">
                                            {{trans('back.new_quotation')}}
                                        </a>
                                    @endcan

                                    @can('jobCard_add')
                                        <a class="btn btn-success btn-xs mb-1 btn-block" href="{{route('create_jobCard', $car->id)}}">
                                            {{trans('back.job_card')}}
                                        </a>
                                    @endcan
                                </td>
                                <td>{{ $car->invoices->count() }}</td>
                                <td>{{ number_format($car->invoices->sum('total_amount'), 3) }}</td>
                                <td>{{ number_format($car->payments->sum('payment_amount'), 3) }}</td>
                                <td>{{ number_format($car->invoices->sum('total_amount') - $car->payments->sum('payment_amount'), 3) }}</td>

                                <td>
                                    @if ($car->car_license)
                                        <a href="{{asset($car->car_license)}}" class="btn btn-secondary btn-xs" target="_blank"> {{trans('back.car_license')}}</a>
                                    @else
                                        {{trans('back.none')}}
                                    @endif
                                </td>

                                <td>
                                    @if ($car->Other_file)
                                        <a href="{{asset($car->Other_file)}}" class="btn btn-secondary btn-xs" target="_blank"> {{trans('back.Other_file')}}</a>
                                    @else
                                        {{trans('back.none')}}
                                    @endif
                                </td>

                                <td>{{ $car->created_at }}</td>

                                <td>
                                    @can('Car_edit')
                                        <a class="btn btn-success btn-xs " href="{{route('Cars.edit', $car->id)}}" >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('Car_delete')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_car{{$car->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.pages.cars.delete')
                                    @endcan
                                </td>

                                <td>{{ $car->User->name ?? "" }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $cars->appends(Request::all())->links() !!}
                </div>

            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


