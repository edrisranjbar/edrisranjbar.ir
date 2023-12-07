@section('title', 'پروفایل کاربری')
@extends('layouts.user')
@section('content')
    <main class="container-lg">

        <h1 class="h3 mb-5 fw-bold">حساب کاربری</h1>
        @include('templates.messages')

        <form action="{{ route('user.update') }}" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="profile-box mx-auto w-75 h-100 d-flex justify-content-center align-items-center">
                        <img class="w-100 rounded-circle" src="{{ $user->profile_photo ? asset('storage/upload/' . $user->profile_photo) : asset('images/profile-placeholder.jpg') }}" alt="{{ $user->name }}">
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">نام و نام خانوادگی</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
        
                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور</label>
                        <input type="password" class="form-control" id="password" name="password" oninput="handlepasswordConfirmationSectionVisibility(this)">
                        <small class="d-block text-info">در صورتی که نمیخواهید رمز را تغییر دهید این فیلد را خالی رها کنید.</small>
                    </div>
                    
                    <div class="mb-3 d-none" id="passwordConfirmationSection">
                        <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">تصویر نمایه</label>
                        <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                    </div>
                    
                    <button class="btn btn-w-icon btn-primary mt-2 me-2" type="submit">
                        <i class="fa-solid fa-fw fa-edit me-1"></i>
                        به روزرسانی حساب کاربری
                    </button>
                </div>
            </div>
            
        </form>
    </main>
    <script>
        const passwordConfirmationSection = document.querySelector("#passwordConfirmationSection");
        const handlepasswordConfirmationSectionVisibility = (element) => {
            if (element && element.value.length > 0) {
                passwordConfirmationSection.classList.remove("d-none");
            }
            else{
                passwordConfirmationSection.classList.add("d-none");
            }
        }
        handlepasswordConfirmationSectionVisibility();
    </script>
@stop