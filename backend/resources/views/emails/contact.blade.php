@extends('emails.layout', ['title' => 'پیام جدید از وبسایت'])

@section('content')
<div class="contact-item">
    <div class="contact-label">نام:</div>
    <div class="contact-value">{{ $data['name'] }}</div>
</div>

<div class="contact-item">
    <div class="contact-label">ایمیل:</div>
    <div class="contact-value">{{ $data['email'] }}</div>
</div>

<div class="contact-item">
    <div class="contact-label">موضوع:</div>
    <div class="contact-value">{{ $data['subject'] }}</div>
</div>

<div class="contact-item">
    <div class="contact-label">پیام:</div>
    <div class="message-box">{{ $data['message'] }}</div>
</div>

@if(isset($data['timestamp']))
    <div class="contact-item">
        <div class="contact-label">زمان ارسال:</div>
        <div class="contact-value">{{ \Carbon\Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s') }}</div>
    </div>
@endif

<style>
.contact-item {
    margin-bottom: 15px;
}
.contact-label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    color: #4a6cf7;
}
.contact-value {
    margin: 0;
    padding: 10px;
    background-color: #f5f5f5;
    border-radius: 5px;
}
.message-box {
    background-color: #f5f5f5;
    padding: 15px;
    border-radius: 5px;
    margin-top: 10px;
    white-space: pre-line;
}
</style>
@endsection

@section('footer')
این ایمیل به صورت خودکار از طریق فرم تماس وبسایت ارسال شده است.
@endsection 