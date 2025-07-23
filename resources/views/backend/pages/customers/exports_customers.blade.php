<table style="text-align: center; vertical-align: middle">
    <tr>
        <th colspan="13" style="text-align: center; vertical-align: middle">
            {{trans('back.Customers_Reports')}}
            من
            {{request()->start_date}}
            إلى تاريخ
            {{request()->end_date}}
        </th>
    </tr>
</table>

<table class="text-center">
    <thead>
    <tr>
        <th style="text-align: center; vertical-align: middle">#</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.Customer_Name')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.company_name')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.Customer_ID')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.phone')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.nationality')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.license_number')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.place_of_issue')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.date_of_issue')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.expiry_date')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.number_invoices')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.Total_amount')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.Paid')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.rest_amount')}}</th>
        <th style="text-align: center; vertical-align: middle"> {{trans('back.Created_at')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customers as $key => $customer)
        <tr>
            <td style="text-align: center; vertical-align: middle">{{$key+1}}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->name }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->Company_name }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->id_no }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->phone }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->nationality }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->license_number }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->place_of_issue }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->date_of_issue }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->expiry_date }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->CarsContracts->count() }}</td>
            <td style="text-align: center; vertical-align: middle">{{ number_format($customer->CarsContracts->sum('total_amount'), 3) }}</td>
            <td style="text-align: center; vertical-align: middle">{{ number_format($customer->payments->sum('payment_amount'), 3) }}</td>
            <td style="text-align: center; vertical-align: middle">{{ number_format($customer->CarsContracts->sum('total_amount') - $customer->payments->sum('payment_amount'), 3) }}</td>
            <td style="text-align: center; vertical-align: middle">{{ $customer->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


