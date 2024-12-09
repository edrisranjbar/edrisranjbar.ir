@section('title', 'دانش آموزان')
@extends('layouts.admin')
@section('content')
<div class="container">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>نام</th>
                <th>ایمیل</th>
                <th>دوره های ثبت‌نام شده</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>
                    @foreach ($student->tutorials as $tutorial)
                    {{ $tutorial->title }}<br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection