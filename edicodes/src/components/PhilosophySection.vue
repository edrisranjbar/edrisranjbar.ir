<template>
  <section class="py-16 px-4 md:px-8 bg-white/5">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold mb-4 font-vazir">
            <span class="text-primary">فلسفه</span> کاری من
          </h2>
          <p class="text-white/70 max-w-3xl mx-auto">
            اصول و ارزش‌هایی که در توسعه و طراحی نرم‌افزار به آن‌ها پایبند هستم.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Clean Architecture -->
          <div class="bg-white/5 rounded-lg p-6 border border-white/10 hover:border-primary/50 transition-colors group">
            <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary/30 transition-colors">
              <font-awesome-icon icon="code" class="text-2xl text-primary" />
            </div>
            <h3 class="text-xl font-bold text-white mb-3">معماری تمیز</h3>
            <p class="text-white/70">
              استفاده از اصول SOLID و الگوهای طراحی برای ساخت نرم‌افزارهای قابل نگهداری و توسعه‌پذیر
            </p>
          </div>

          <!-- Performance First -->
          <div class="bg-white/5 rounded-lg p-6 border border-white/10 hover:border-orange-400/50 transition-colors group">
            <div class="w-12 h-12 bg-orange-400/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-400/30 transition-colors">
              <font-awesome-icon icon="bolt" class="text-2xl text-orange-400" />
            </div>
            <h3 class="text-xl font-bold text-orange-400 mb-3">عملکرد محور</h3>
            <p class="text-white/70">
              بهینه‌سازی عملکرد و سرعت با استفاده از بهترین شیوه‌ها و تکنیک‌های کش‌گذاری
            </p>
          </div>

          <!-- Security Focused -->
          <div class="bg-white/5 rounded-lg p-6 border border-white/10 hover:border-primary/50 transition-colors group">
            <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary/30 transition-colors">
              <font-awesome-icon icon="shield" class="text-2xl text-primary" />
            </div>
            <h3 class="text-xl font-bold text-white mb-3">امنیت محور</h3>
            <p class="text-white/70">
              پیاده‌سازی بهترین شیوه‌های امنیتی و محافظت از داده‌های حساس
            </p>
          </div>
          
          <!-- Fun and Challenging -->
          <div class="bg-white/5 rounded-lg p-6 border border-white/10 hover:border-orange-400/50 transition-colors group">
            <div class="w-12 h-12 bg-orange-400/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-400/30 transition-colors">
              <font-awesome-icon icon="rocket" class="text-2xl text-orange-400" />
            </div>
            <h3 class="text-xl font-bold text-orange-400 mb-3">لذت و چالش</h3>
            <p class="text-white/70">
              اگر کار جذاب و چالش‌برانگیز نباشه، انجامش نمی‌دم! کدنویسی برای من فقط یک شغل نیست، بلکه عشق و هنره
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.philosophy-card {
  @apply bg-white/5 p-8 rounded-lg border border-white/10 hover:border-primary/30 transition-all duration-200;
}
</style> 