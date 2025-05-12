<template>
  <section class="py-16 px-4 md:px-8 bg-black/40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto">
        <h2 class="text-4xl font-bold mb-8 font-vazir text-center">
          <span class="text-primary">درباره</span> من
        </h2>
        <div class="space-y-12">
          <div>
            <p class="text-white/70 leading-relaxed font-vazir mb-4 text-right text-lg">
              سلام 👋
            </p>
            <p class="text-white/70 leading-relaxed font-vazir text-right text-lg">
              من یک توسعه‌دهنده بک‌اند با تجربه در زبان‌های برنامه‌نویسی PHP و Python هستم. ۷ سال است که در حال کدنویسی هستم و درک عمیقی از توسعه وب دارم. به صورت دورکار به عنوان توسعه‌دهنده فریلنسر کار می‌کنم و همیشه به دنبال فرصت‌های جدید برای ارتقای مهارت‌ها و دانش خود هستم. اگر تمایل به همکاری دارید، لطفاً با من در تماس باشید.
            </p>
          </div>

          <!-- Skills Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Laravel -->
            <div class="bg-black/40 rounded-lg p-6 border border-white/5 hover:border-primary/50 transition-colors group">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                  <font-awesome-icon icon="server" class="text-2xl text-primary" />
                </div>
                <h3 class="text-xl font-bold text-white">لاراول</h3>
              </div>
              <p class="text-white/70">
                توسعه اپلیکیشن‌های وب مقیاس‌پذیر با استفاده از فریم‌ورک لاراول و بهترین شیوه‌های برنامه‌نویسی
              </p>
            </div>

            <!-- Django -->
            <div class="bg-black/40 rounded-lg p-6 border border-white/5 hover:border-primary/50 transition-colors group">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                  <font-awesome-icon icon="database" class="text-2xl text-primary" />
                </div>
                <h3 class="text-xl font-bold text-white">جنگو</h3>
              </div>
              <p class="text-white/70">
                ساخت API‌ها و سرویس‌های وب با استفاده از فریم‌ورک جنگو و DRF
              </p>
            </div>

            <!-- SQL -->
            <div class="bg-black/40 rounded-lg p-6 border border-white/5 hover:border-primary/50 transition-colors group">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                  <font-awesome-icon icon="diagram-project" class="text-2xl text-primary" />
                </div>
                <h3 class="text-xl font-bold text-white">SQL</h3>
              </div>
              <p class="text-white/70">
                طراحی و بهینه‌سازی پایگاه‌های داده با تمرکز بر عملکرد و مقیاس‌پذیری
              </p>
            </div>

            <!-- Vue.js -->
            <div class="bg-black/40 rounded-lg p-6 border border-white/5 hover:border-primary/50 transition-colors group">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                  <font-awesome-icon icon="code" class="text-2xl text-primary" />
                </div>
                <h3 class="text-xl font-bold text-white">ویو جی‌اس</h3>
              </div>
              <p class="text-white/70">
                توسعه رابط‌های کاربری تعاملی و واکنش‌گرا با Vue.js
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// Component logic can be added here if needed
</script> 