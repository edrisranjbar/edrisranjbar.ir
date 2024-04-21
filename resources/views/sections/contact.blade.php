<section id="contact">
    <div class="form-container">
        <div class="background">
            <div class="screen w-100">
                <div class="screen-header">
                    <div class="screen-header-left">
                        <div class="screen-header-btn close"></div>
                        <div class="screen-header-btn maximize"></div>
                        <div class="screen-header-btn minimize"></div>
                    </div>
                    <div class="screen-header-right">
                        <div class="screen-header-ellipsis"></div>
                        <div class="screen-header-ellipsis"></div>
                        <div class="screen-header-ellipsis"></div>
                    </div>
                </div>
                <div class="screen-body">
                    <div class="screen-body-item">
                        <form autocomplete="off" class="app-form" method="post" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row m-0 p-0">
                                <div class="col-12 col-md-6 p-0 m-0 app-form-group">
                                    <input name="name" class="app-form-control" placeholder="نام و نام خانوادگی"
                                        autocomplete="the-name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <div class="error">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-6 p-0 m-0 app-form-group">
                                    <input name="email" class="app-form-control" placeholder="ایمیل" required
                                        value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row p-0 m-0">
                                <div class="col-12 p-0 m-0 app-form-group message">
                                    <textarea name="message" class="app-form-control" placeholder="متن پیام"
                                        required>{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                    <div class="error">
                                        {{ $errors->first('message') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row p-0 m-0">
                                <div class="col-12 p-0 m-0">
                                    <button id="submit-button" type="submit" class="button button-primary rounded-0 w-100">
                                        ✅ ثبت فرم
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>