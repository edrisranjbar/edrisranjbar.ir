<template>
  <div class="min-h-screen flex items-center justify-center bg-dark" dir="rtl">
    <div class="text-center">
      <h1 class="text-9xl font-bold text-primary mb-4 font-vazir">404</h1>
      <h2 class="text-4xl font-bold mb-4 font-vazir">صفحه مورد نظر پیدا نشد!</h2>
      <p class="text-white/70 mb-8 font-vazir">متأسفانه صفحه‌ای که به دنبال آن هستید وجود ندارد.</p>
      <router-link to="/" class="btn-primary font-vazir">
        بازگشت به خانه
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.btn-primary {
  @apply px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors duration-200 font-medium;
}
</style> 