<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پیام جدید از وبسایت</title>
    <style>
        body {
            font-family: Tahoma, Arial, sans-serif;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #3B82F6;
            color: white;
            padding: 15px 20px;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px;
        }
        h1 {
            font-size: 24px;
            margin: 0;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-name {
            font-weight: bold;
            color: #3B82F6;
        }
        .message-content {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-top: 5px;
            white-space: pre-line;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>پیام جدید از وبسایت</h1>
        </div>
        
        <div class="field">
            <span class="field-name">نام:</span>
            <span>{{ $data['name'] }}</span>
        </div>
        
        <div class="field">
            <span class="field-name">ایمیل:</span>
            <span>{{ $data['email'] }}</span>
        </div>
        
        <div class="field">
            <span class="field-name">موضوع:</span>
            <span>{{ $data['subject'] }}</span>
        </div>
        
        <div class="field">
            <span class="field-name">پیام:</span>
            <div class="message-content">{{ $data['message'] }}</div>
        </div>
        
        <div class="field">
            <span class="field-name">تاریخ ارسال:</span>
            <span>{{ \Carbon\Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s') }}</span>
        </div>
        
        <div class="footer">
            <p>این ایمیل به صورت خودکار ارسال شده است.</p>
        </div>
    </div>
</body>
</html> 