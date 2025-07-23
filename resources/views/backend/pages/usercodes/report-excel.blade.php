<table style="text-align: center; width: 100%;">
    <tr>
        <th colspan="10" style="border: 1px solid black;border-collapse: collapse; text-align: center; width: 500px; ">
            تقرير مستخدمي الكوبونات
        </th>
    </tr>
</table>
<table class="text-center">
    <thead>
        <tr class="text-center">
            <th style="border: 1px solid black;border-collapse: collapse; text-align: center; ">  {{trans('back.coupon')}}  </th>
            <th style="border: 1px solid black;border-collapse: collapse; text-align: center; ">  {{trans('back.phone')}}  </th>
            <th style="border: 1px solid black;border-collapse: collapse; text-align: center; ">  {{trans('back.email')}}  </th>
            <th style="border: 1px solid black;border-collapse: collapse; text-align: center; "> الحملة  </th>
            <th style="border: 1px solid black;border-collapse: collapse; text-align: center; ">{{trans('back.Created_at')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usercodes as $usercode)
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center; "> {{$usercode->code}}</td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center; "> {{$usercode->phone??'--'}}</td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center; "> {{$usercode->email??'--'}}</td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center; "> {{$usercode->campaign->name??'--'}}</td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center; ">{{$usercode->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
