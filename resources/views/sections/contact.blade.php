<section id="contact">
    <h2 class="title text-center">اگه پروژه یا کاری داشتی👇</h2>
    <div class="form-container">
        <div class="background">
            <div class="screen">
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
                    <div class="screen-body-item left">
                        <div class="app-title">
                            <span>تماس با من</span>
                        </div>
                        <br>
                        <div class="contact-info">
                            <p>
                                اگه کاری داشتی یا به هر دلیلی دلت تنگ شد و خواستی باهام صحبت کنی😂
                                میتونی بهم ایمیل بدی. معمولا زود جواب میدم.
                            </p>
                            <br>
                            <address>
                                ایمیل: <a href="mailto:edris.qeshm2@gmail.com"
                                          class="email-link">edris.qeshm2@gmail.com</a>
                                <br>
                                لینکدین: <a href="https://ir.linkedin.com/in/edris-ranjbar"
                                            class="email-link">edris-ranjbar</a>
                                <br>
                                توییتر: <a href="https://twitter.com/edris__ranjbar" class="email-link">
                                    edris__ranjbar
                                </a>
                            </address>
                        </div>
                    </div>
                    <div class="screen-body-item">
                        <form class="app-form" method="post" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="app-form-group">
                                <input name="name" class="app-form-control" placeholder="نام و نام خانوادگی"
                                       value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <div class="error">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="app-form-group">
                                <input name="email" class="app-form-control" placeholder="ایمیل" required
                                       value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="app-form-group message">
                                <textarea name="message" class="app-form-control" placeholder="متن پیام"
                                          required>{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                    <div class="error">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="button button-sm button-outline-primary">
                                ثبت فرم
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>