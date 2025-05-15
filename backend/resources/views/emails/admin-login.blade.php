@extends('emails.layout')

@section('content')
<div style="text-align: right;">
    <h2>سلام {{ $admin->name }}</h2>
    
    <p>یک ورود جدید به حساب مدیریتی شما در سایت ادیکدز ثبت شد.</p>
    
    <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p><strong>زمان ورود:</strong> {{ $loginTime }}</p>
        <p><strong>ایمیل:</strong> {{ $admin->email }}</p>
    </div>
    
    <p>اگر این ورود توسط شما انجام نشده است، لطفاً بلافاصله رمز عبور خود را تغییر دهید.</p>
    
    <div style="margin-top: 30px;">
        <p>با احترام،<br>تیم ادیکدز</p>
    </div>
</div>
@endsection

@section('footer')
این ایمیل برای امنیت حساب کاربری شما ارسال شده است.
@endsection 