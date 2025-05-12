<template>
  <div class="pt-16" dir="rtl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <article class="max-w-4xl mx-auto">
        <!-- Post Header -->
        <header class="mb-12">
          <h1 class="text-4xl font-bold mb-6 font-vazir">{{ post.title }}</h1>
          <div class="flex items-center gap-4 text-white/50 font-vazir">
            <time>{{ post.date }}</time>
            <span>•</span>
            <span>{{ post.readTime }} دقیقه مطالعه</span>
          </div>
        </header>

        <!-- Post Image -->
        <img :src="post.image" :alt="post.title" class="w-full h-96 object-cover rounded-lg mb-12" />

        <!-- Post Content -->
        <div class="prose prose-invert prose-lg max-w-none font-vazir" v-html="post.content"></div>

        <!-- Post Footer -->
        <footer class="mt-12 pt-8 border-t border-white/10">
          <div class="flex justify-between items-center">
            <router-link to="/#blog" class="text-primary hover:text-primary-light transition-colors duration-200 font-vazir">
              ← بازگشت به وبلاگ
            </router-link>
            <div class="flex gap-4">
              <a href="#" class="text-white/50 hover:text-white transition-colors duration-200">
                <span class="sr-only">اشتراک در توییتر</span>
                <!-- Twitter Icon -->
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                </svg>
              </a>
              <a href="#" class="text-white/50 hover:text-white transition-colors duration-200">
                <span class="sr-only">اشتراک در لینکدین</span>
                <!-- LinkedIn Icon -->
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                </svg>
              </a>
            </div>
          </div>
        </footer>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const post = ref({
  title: 'آموزش پایتون برای مبتدیان',
  date: '۱۴۰۲/۱۲/۱۵',
  readTime: '۱۰',
  image: 'https://edrisranjbar.ir/images/blog/python-tutorial.jpg',
  content: `
    <p>در این مقاله به آموزش مقدماتی زبان برنامه‌نویسی پایتون می‌پردازیم. پایتون یکی از محبوب‌ترین زبان‌های برنامه‌نویسی است که به دلیل سادگی و خوانایی بالا، برای شروع برنامه‌نویسی بسیار مناسب است.</p>
    <h2>چرا پایتون؟</h2>
    <p>پایتون دارای ویژگی‌های منحصر به فردی است که آن را به یک انتخاب عالی برای مبتدیان تبدیل می‌کند:</p>
    <ul>
      <li>سینتکس ساده و خوانا</li>
      <li>کتابخانه‌های متنوع و قدرتمند</li>
      <li>جامعه کاربری بزرگ و فعال</li>
      <li>مستندات کامل و دقیق</li>
    </ul>
  `
})

onMounted(async () => {
  // TODO: Fetch post data based on route.params.slug
  console.log('Post slug:', route.params.slug)
})
</script>

<style>
.prose {
  @apply text-white/90;
}

.prose h2 {
  @apply text-2xl font-bold mb-4 mt-8 font-vazir;
}

.prose p {
  @apply mb-4 leading-relaxed font-vazir;
}

.prose ul {
  @apply list-disc list-inside mb-4 font-vazir;
}

.prose li {
  @apply mb-2 font-vazir;
}
</style> 