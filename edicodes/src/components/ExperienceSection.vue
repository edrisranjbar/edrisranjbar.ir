<template>
  <section class="py-16 px-4 md:px-8">
    <div class="container mx-auto">
      <h2 class="text-3xl font-bold mb-8 text-center">تجربیات حرفه‌ای</h2>
      <p class="text-lg text-center text-gray-600 mb-12">
        مسیر حرفه‌ای من در دنیای برنامه‌نویسی و توسعه نرم‌افزار
      </p>

      <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute h-full w-0.5 bg-gray-200 left-1/2 transform -translate-x-1/2"></div>

        <!-- Timeline Items -->
        <div class="space-y-12">
          <!-- Itadbir -->
          <div class="relative flex items-center justify-between">
            <div class="w-5/12 pl-8">
              <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold mb-2">هم‌بنیانگذار و مهندس نرم‌افزار</h3>
                <p class="text-primary font-semibold mb-2">آی‌تدبیر</p>
                <p class="text-gray-600 mb-2">خرداد ۱۴۰۱ - اکنون</p>
                <ul class="text-gray-700 space-y-2 list-disc list-inside">
                  <li>هدایت استراتژی فنی و توسعه</li>
                  <li>طراحی معماری پلتفرم اصلی برای ارائه خدمات SaaS</li>
                  <li>مدیریت تیم و تعیین استانداردهای فنی</li>
                </ul>
              </div>
            </div>
            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
            <div class="w-5/12"></div>
          </div>

          <!-- Freelancer -->
          <div class="relative flex items-center justify-between">
            <div class="w-5/12"></div>
            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
            <div class="w-5/12 pr-8">
              <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold mb-2">توسعه‌دهنده بک‌اند</h3>
                <p class="text-primary font-semibold mb-2">فریلنسر</p>
                <p class="text-gray-600 mb-2">تیر ۱۳۹۹ - ۱۴۰۱</p>
                <ul class="text-gray-700 space-y-2 list-disc list-inside">
                  <li>توسعه و نگهداری سرویس‌های API</li>
                  <li>توسعه و پیاده‌سازی وب اپلیکیشن‌ها</li>
                  <li>همکاری با تیم‌های مختلف به عنوان توسعه‌دهنده فول‌استک</li>
                </ul>
              </div>
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

<style scoped>
.container {
  max-width: 1200px;
}

@media screen and (max-width: 768px) {
  .relative.flex {
    flex-direction: column;
    align-items: flex-start;
  }

  .w-5\/12 {
    width: 100%;
    padding: 0;
    margin-bottom: 2rem;
  }

  .absolute.left-1\/2 {
    left: 0;
    transform: none;
  }

  .absolute.h-full.w-0\.5 {
    left: 0;
    transform: none;
  }
}
</style> 