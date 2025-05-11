<div id="donate-page">
    <section id="donate">
        <div class="container">
            <h2 class="donate-page-title">💗 حمایت مالی</h2>
            <div class="breaker mx-auto"></div>
            <p class="donate-page-description">
                ساختن آموزش خوب و باکیفیت زمان‌بر و هزینه برداره. اگر دوست دارین توی این کار مشارکت داشته باشین
                و به تولید محتوای باکیفیت آموزشی درحوزه برنامه نویسی به زبان فارسی کمک کنین
                میتونین به نوبه خودتون سهمی در این پروسه داشته باشین
                و البته یه دلخوشی کوچیک و فانی هم برا منه😍
            </p>

            <div class="donate-options">
                <h2>مبلغ پرداختی شما:</h2>
                @if (session('error'))
                    <p class="text-danger text-center">{{ session('error') }}</p>
                @endif
                <div class="d-flex flex-column gap-2 mx-auto">
                    <div class="d-flex gap-2">
                        <button class="button button-outline-primary" value="10000">10,000</button>
                        <button class="button button-outline-primary active" value="100000">100,000</button>
                        <button class="button button-outline-primary" value="500000">500,000</button>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="button button-outline-primary" value="1000000">1,000,000</button>
                        <button class="button button-outline-primary" value="2000000">2,000,000</button>
                        <button class="button button-outline-primary" id="custom-amount-btn" value="250000">مبلغ دلخواه</button>
                    </div>
                    <form action="{{ route('donation.request') }}" method="POST" id="donate-form">
                        @csrf
                        <input form="donate-form" value="100000" name="amount" type="number" min="1000"
                            class="form-control d-none" id="custom-amount-field">
                        <input type="text" name="name" class="form-control mb-2" placeholder="نام: اختیاری" maxlength="20">
                        <textarea name="description" maxlength="500" class="form-control" placeholder="اگه دوست داشتی میتونی اینجا توضیحاتی که میخوای رو بنویسی"></textarea>
                        <button type="submit" id="donate-button" class="button button-primary w-100 mt-3">
                            همین الان پرداخت کن
                        </button>
                    </form>
                </div>
            </div>

            <div class="ton-qr">
                <img src="{{ asset('images/ton.png') }}" alt="TON QR Code" loading="lazy">
                <p id="copyText" class="mb-0">UQCUB98e5ZwK0bdyHYueeqxWAS_c_72LoIovZNiXYOVJpre-</p>
            </div>

            <div class="buy-coffee-section">
                <a href="http://www.coffeete.ir/edris" target="_blank" rel="noopener noreferrer">
                    <img src="http://www.coffeete.ir/images/buttons/lemonchiffon.png" alt="Buy me a coffee" style="height:80px; width: 280px;">
                </a>
            </div>
        </div>
    </section>

    <div class="background-effects">
        <div class="rectangle-1"></div>
        <div class="rectangle-2"></div>
    </div>
</div>