@extends('backend.layouts.master')

@section('title_page')
    {{trans('back.Customers_Reports')}}
@endsection

@section('title')
    {{trans('back.Customers_Reports')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class=" justify-content-between pb-2">
                {{-- فورم البحث بين تاريخين --}}
                <form action="{{ route('reports_Customers') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-md-2">
                            <label >{{trans('back.start_date')}}</label>
                            <input name="start_date" class="form-control form-control-sm " type="date" value="{{ $start_date??"" }}">
                        </div>
                        <div class="col-md-2">
                            <label > {{trans('back.end_date')}}</label>
                            <input name="end_date" class="form-control form-control-sm " type="date" value="{{ $end_date??"" }}">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-sm " style="margin-top: 25px" type="submit" formaction="{{ route('reports_Customers') }}"> {{trans('back.Search')}}  </button>
                            <button class="btn btn-secondary  btn-sm " style="margin-top: 25px" type="submit" formaction="{{route('export_Customers_Excel')}}"> Excel </button>
                            <a href="{{ route('reports_Customers') }}" style="margin-top: 25px" class="btn btn-success btn-sm " type="button" title="Reload">
                                <span class="fas fa-sync-alt"></span>
                            </a>
                        </div>
                    </div>
                </form>
                {{--نهاية فورم البحث بين تاريخين --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table  class="table text-center  table-striped  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('back.Customer_Name')}}</th>
                            <th> {{trans('back.company_name')}}</th>
                            <th> {{trans('back.Customer_ID')}}</th>
                            <th> {{trans('back.phone')}}</th>
                            <th> {{trans('back.nationality')}}</th>
                            <th> {{trans('back.license_number')}}</th>
                            <th> {{trans('back.place_of_issue')}}</th>
                            <th> {{trans('back.date_of_issue')}}</th>
                            <th> {{trans('back.expiry_date')}}</th>
                            <th> {{trans('back.number_invoices')}}</th>
                            <th> {{trans('back.Total_amount')}}</th>
                            <th> {{trans('back.Paid')}}</th>
                            <th> {{trans('back.rest_amount')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($customers as $key => $customer)
                            <tr>
                                <td>{{$key+ $customers->firstItem()}}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->Company_name }}</td>
                                <td>{{ $customer->id_no }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->nationality }}</td>
                                <td>{{ $customer->license_number }}</td>

                                <td>{{ $customer->place_of_issue }}</td>
                                <td>{{ $customer->date_of_issue }}</td>
                                <td>{{ $customer->expiry_date }}</td>

                                <td>{{ $customer->CarsContracts->count() }}</td>
                                <td>{{ number_format($customer->CarsContracts->sum('total_amount'), 3) }}</td>
                                <td>{{ number_format($customer->payments->sum('payment_amount'), 3) }}</td>
                                <td>{{ number_format($customer->CarsContracts->sum('total_amount') - $customer->payments->sum('payment_amount'), 3) }}</td>
                                <td>{{ $customer->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $customers->appends(Request::all())->links() !!}
            </div>
        </div>
    </div>

@endsection

