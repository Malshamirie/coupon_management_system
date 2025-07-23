

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta charset="UTF-8"/>
    <title>{{ $mailData['title'] }}</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            text-align: right;
            background-color: #f6f6f6;
            line-height: 1.6em;
            margin: 0;
            direction: rtl;
        }

        .body-wrap {
            width: 100%;
            background-color: #f6f6f6;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            display: block;
        }

        .content {
            font-size: 14px;
        }

        .main {
            width: 100%;
            background-color: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
        }

        .header {
            text-align: center;
            background-color: #351928;
            color: #fff;
            padding: 15px;
            border-radius: 3px 3px 0 0;
        }

        .content-wrap {
            padding: 10px;
        }

        .content-block {
            padding: 0 0 10px;
        }

        .otp-code {
            font-size: 15px;
            font-weight: bold;
            color: #351928;
        }

        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
            padding: 20px;
            margin: auto;
        }

        .aligncenter {
            text-align: center;
        }
        p{text-align: right;padding: 0;margin: 0;}
        strong{font-size: 17px;font-weight: 600;}
    </style>

</head>
<body dir="rtl">
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container">
                <div class="content">
                    <table class="main" style="text-align: center">
                        <tr>
                            <td class="header">
                                <a href="https://user.sultanbinsalmanaward.com" style="text-decoration: none;color: #fff">
                                    {{ App\Models\Setting::first()->company_name }}
                                    {{-- <img src="{{asset(App\Models\Setting::first()->logo)}}" width="150" alt="{{ App\Models\Setting::first()->company_name_en }}"> --}}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-wrap">
                                <table>
                                    <tr>
                                        <td class="content-block">
                                            <strong> {{ $mailData['title'] }} </strong>
                                            <p>{{ $mailData['message'] }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
</body>
</html>
