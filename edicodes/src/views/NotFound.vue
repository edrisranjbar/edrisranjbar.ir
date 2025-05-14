<template>
  <div class="min-h-screen flex items-center justify-center bg-dark px-4" dir="rtl">
    <div class="text-center max-w-lg">
      <h1 class="text-9xl font-bold text-primary mb-4 font-vazir">404</h1>
      <h2 class="text-3xl md:text-4xl font-bold mb-4 font-vazir">صفحه مورد نظر پیدا نشد!</h2>
      <p class="text-white/70 mb-8 font-vazir">متأسفانه صفحه‌ای که به دنبال آن هستید وجود ندارد یا حذف شده است.</p>
      
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <router-link to="/" class="btn-primary font-vazir">
          <font-awesome-icon icon="home" class="ml-2" />
          بازگشت به خانه
        </router-link>
        <router-link to="/blog" class="btn-secondary font-vazir">
          <font-awesome-icon icon="newspaper" class="ml-2" />
          مشاهده وبلاگ
        </router-link>
      </div>
      
      <div class="mt-12 border-t border-white/10 pt-6">
        <p class="text-white/50 text-sm font-vazir">شاید بخواهید یکی از این بخش‌ها را ببینید:</p>
        <div class="mt-4 flex flex-wrap gap-3 justify-center">
          <router-link to="/#about" class="text-primary hover:text-primary-light transition-colors font-vazir text-sm">درباره من</router-link>
          <router-link to="/#portfolio" class="text-primary hover:text-primary-light transition-colors font-vazir text-sm">نمونه کارها</router-link>
          <router-link to="/#contact" class="text-primary hover:text-primary-light transition-colors font-vazir text-sm">تماس با من</router-link>
          <router-link to="/blog" class="text-primary hover:text-primary-light transition-colors font-vazir text-sm">وبلاگ</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.btn-primary {
  @apply px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-200 font-medium inline-flex items-center;
}

.btn-secondary {
  @apply px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors duration-200 font-medium inline-flex items-center;
}
</style> 