<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ایمیل از طرف ادریس رنجبر' }}</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            direction: rtl;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4a6cf7;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .domain-info {
            margin-top: 10px;
            font-size: 11px;
            color: #999;
        }
        .logo {
            max-width: 100px;
            margin: 0 auto 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="https://edrisranjbar.ir/logo.png" alt="ادریس رنجبر" />
            <h1>{{ $title ?? 'ایمیل از طرف ادریس رنجبر' }}</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            <p>@yield('footer', 'این ایمیل به صورت خودکار ارسال شده است.')</p>
            <div class="domain-info">
                ارسال شده از <a href="https://edrisranjbar.ir">edrisranjbar.ir</a>
            </div>
        </div>
    </div>
</body>
</html> 