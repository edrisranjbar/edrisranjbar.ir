<template>
  <section id="skills" class="py-24 relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl sm:text-4xl font-bold text-center mb-16 font-vazir">
        <span class="text-primary">مهارت‌های</span> فنی
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <div v-for="skill in skills" :key="skill.name" class="skill-card">
          <div class="flex items-start gap-4">
            <div class="shrink-0">
              <font-awesome-icon :icon="skill.icon" class="w-8 h-8 text-primary" />
            </div>
            <div>
              <h3 class="text-lg font-semibold mb-2 font-vazir">{{ skill.name }}</h3>
              <p class="text-sm text-white/70 font-vazir">{{ skill.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const skills = [
  {
    name: 'توسعه بک‌اند',
    icon: ['fas', 'server'],
    description: 'طراحی و پیاده‌سازی معماری‌های مقیاس‌پذیر سمت سرور، API های RESTful و میکروسرویس‌ها'
  },
  {
    name: 'طراحی دیتابیس',
    icon: ['fas', 'database'],
    description: 'بهینه‌سازی ساختار پایگاه داده، عملکرد کوئری‌ها و پیاده‌سازی استراتژی‌های ذخیره‌سازی داده'
  },
  {
    name: 'معماری سیستم',
    icon: ['fas', 'diagram-project'],
    description: 'تجربه در طراحی سیستم‌های توزیع شده، زیرساخت‌های ابری و پیاده‌سازی DevOps'
  }
]
</script>

<style scoped>
.skill-card {
  @apply bg-white/5 p-6 rounded-lg border border-white/10 hover:border-primary/30 transition-all duration-200;
}
</style> 