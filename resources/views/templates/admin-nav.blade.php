<nav class="navbar navbar-expand bg-light mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-light d-md-none btn-circle">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav d-flex align-items-center w-100">
        <div class="d-flex justify-content-between w-100">
            <h1 class="text-dark fs-4 my-0 py-0 d-flex align-items-center">@yield('title')</h1>
            <div class="d-flex align-items-center">
                <!-- Notification Bell -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw text-dark"></i>
                        <span class="badge badge-danger badge-counter">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-light shadow animated--grow-in"
                        aria-labelledby="notificationDropdown">
                        <h6 class="dropdown-header text-right">نوتیفیکیشن‌ها</h6>
                        <div class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">امروز ساعت 12:00</div>
                                <span class="font-weight-bold">یک نظر جدید دریافت کردید!</span>
                            </div>
                        </div>
                        <div class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-user-plus text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">دیروز ساعت 14:00</div>
                                <span class="font-weight-bold">کاربر جدید ثبت نام کرده است!</span>
                            </div>
                        </div>
                        <div class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">امروز ساعت 10:00</div>
                                <span class="font-weight-bold">توجه: به روزرسانی در دسترس است!</span>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="#">نمایش همه نوتیفیکیشن‌ها</a>
                    </div>
                </li>
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="d-flex align-items-center btn dropdown-toggle ml-2 border rounded" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fas fa-user fa-sm fa-fw text-gray-600"></i>
                        <span class="mr-2 d-none d-lg-inline">
                            {{ auth('admin')->user()->fullName }}
                        </span>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu animated--grow-in text-right mt-2" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="fas fa-user fa-sm fa-fw ml-2 text-gray-600"></i>
                            حساب کاربری
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw ml-2 text-gray-600"></i>
                            خروج
                        </a>
                    </div>
                </li>
            </div>
        </div>
    </ul>
</nav>