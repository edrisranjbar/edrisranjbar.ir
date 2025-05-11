<section id="contact" class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="text-center mb-4 text-light">تماس با من</h2>
            <form method="post" action="{{ route('contact.store') }}" class="bg-dark p-4 rounded-3">
                @csrf
                @honeypot
                @include('templates.messages')
                
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="ایمیل" required value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <textarea name="message" class="form-control" rows="5" placeholder="متن پیام" required>{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('message') }}
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-paper-plane me-1"></i>
                    ارسال پیام
                </button>
            </form>
        </div>
    </div>
</section>