<!DOCTYPE html>
<html lang="ar">
<head>
    <title>{{App\Models\Setting::first()->company_name_ar}}</title>

    <style>
        body, h2, h1, h3, h4{
            color: black;
        }
        table {
            width: 500px;
            border-collapse: collapse;
            color: black;
        }
        table, td, th {
            border: 1px solid;
            color: black;
            padding: 3px;
            text-align: center;
        }
    </style>
</head>


<body dir="rtl">

    <h2 style="text-align: right">
        {{App\Models\Setting::first()->company_name_ar}}
    </h2>

    <h3 style="text-align: right">
        مرحبا تم استلام طلبك بنجاح
    </h3>

    <table>
        <tr>
            <td>{{trans('back.chalet')}}</td>
            <td>{{ $order->Chalet->name }}</td>
        </tr>

        <tr>
            <td>{{trans('back.booking_number')}}</td>
            <td>{{ $order->booking_number }}</td>
        </tr>

        <tr>
            <td>{{trans('back.name')}}</td>
            <td>{{ $order->name }}</td>
        </tr>

        <tr>
            <td>{{trans('back.email')}}</td>
            <td>{{ $order->email }}</td>
        </tr>

        <tr>
            <td>{{trans('back.country')}}</td>
            <td>{{ $order->country }}</td>
        </tr>

        <tr>
            <td>{{trans('back.phone_number')}}</td>
            <td>
                <a href="https://wa.me/{{ $order->country . $order->phone_number }}" target="_blank">
                    {{ $order->phone_number }}
                </a>
            </td>
        </tr>

        <tr>
            <td>{{trans('back.messages')}}</td>
            <td>{{ $order->message }}</td>
        </tr>

        <tr>
            <td>{{trans('back.bookingType')}}</td>
            <td>{{ $order->bookingType }} / {{ $order->nights_number ?? __('back.not_saved') }}</td>
        </tr>

        <tr>
            <td>{{trans('front.paymentmethod')}}</td>
            <td> {{app()->getLocale() == 'ar' ? $order->PaymentMethod->name_ar : $order->PaymentMethod->name_en}}</td>
        </tr>

    </table>

    <h3 style="text-align: right">
        تفاصيل الحجز والسعر:
    </h3>

    <table>
        <thead>
        <tr>
            <th width="50%">{{ __('front.date') }}</th>
            <th width="50%">{{ __('front.cost') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->dates as $date => $cost)
            <tr>
                <td width="50%">{{ $date }}</td>
                <td width="50%">{{ $cost . ' ' . __('front.s_omr') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3 style="text-align: right">
        {{ __('front.total') }} /
        {{ $order->total . ' ' . __('front.omr') }}
        <br>
        {{trans('back.thank_you')}}
    </h3>

</body>
</html>
