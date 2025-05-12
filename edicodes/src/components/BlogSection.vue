<template>
  <section id="blog" class="py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-4xl font-bold mb-12 text-center font-vazir">
        <span class="text-primary">وبلاگ</span> من
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <article v-for="post in posts" :key="post.id" class="blog-card">
          <img :src="post.image" :alt="post.title" class="w-full h-48 object-cover rounded-t-lg" />
          <div class="p-6">
            <h2 class="text-xl font-semibold mb-3 font-vazir">{{ post.title }}</h2>
            <p class="text-white/70 mb-4 line-clamp-3 font-vazir">{{ post.excerpt }}</p>
            <div class="flex items-center justify-between">
              <span class="text-sm text-white/50 font-vazir">{{ post.date }}</span>
              <router-link :to="'/blog/' + post.slug" class="text-primary hover:text-primary-light transition-colors duration-200 font-vazir">
                ادامه مطلب
              </router-link>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const posts = ref([
  {
    id: 1,
    title: 'آموزش پایتون برای مبتدیان',
    excerpt: 'در این مقاله به آموزش مقدماتی زبان برنامه‌نویسی پایتون می‌پردازیم...',
    image: 'https://edrisranjbar.ir/images/blog/python-tutorial.jpg',
    date: '۱۴۰۲/۱۲/۱۵',
    slug: 'python-tutorial-for-beginners'
  },
  {
    id: 2,
    title: 'معرفی فریم‌ورک لاراول',
    excerpt: 'لاراول یکی از محبوب‌ترین فریم‌ورک‌های PHP است که امکانات فراوانی را در اختیار توسعه‌دهندگان قرار می‌دهد...',
    image: 'https://edrisranjbar.ir/images/blog/laravel-intro.jpg',
    date: '۱۴۰۲/۱۲/۱۰',
    slug: 'introduction-to-laravel'
  }
])
</script>

<style scoped>
.blog-card {
  @apply bg-white/5 rounded-lg border border-white/10 hover:border-primary/30 transition-all duration-200 overflow-hidden;
}
</style> 