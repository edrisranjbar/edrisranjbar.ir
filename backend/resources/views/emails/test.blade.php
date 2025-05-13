@extends('emails.layout', ['title' => 'تست ارسال ایمیل با Resend'])

@section('content')
<div style="background-color: #f0f9ff; border: 1px solid #bae6fd; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <h2 style="color: #0369a1; margin-top: 0;">تست ارسال ایمیل با Resend</h2>
    <p>این یک ایمیل آزمایشی است که با استفاده از Resend API ارسال شده است.</p>
    <p>تاریخ و زمان: <strong>{{ now()->format('Y-m-d H:i:s') }}</strong></p>
    <p>دامنه ارسال: <strong>{{ config('resend.domain', 'mail.edrisranjbar.ir') }}</strong></p>
</div>

<div style="background-color: #f0f9ff; border: 1px solid #bae6fd; padding: 20px; border-radius: 8px;">
    <h3 style="color: #0369a1; margin-top: 0;">اطلاعات سرور</h3>
    <ul>
        <li>نسخه PHP: {{ phpversion() }}</li>
        <li>محیط اجرا: {{ app()->environment() }}</li>
        <li>نسخه Laravel: {{ app()->version() }}</li>
    </ul>
</div>
@endsection

@section('footer')
این ایمیل به منظور تست ارسال ایمیل از طریق Resend API ارسال شده است.
@endsection 