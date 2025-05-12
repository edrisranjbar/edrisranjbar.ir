<template>
  <section class="py-16 px-4 md:px-8 bg-slate-900">
    <div class="container mx-auto max-w-6xl">
      <div class="grid md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-slate-800/50 p-8 rounded-2xl">
          <h2 class="text-3xl font-bold mb-8 text-white">ارسال پیام</h2>
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">نام شما</label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-primary transition-colors"
                  placeholder="نام و نام خانوادگی"
                />
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">ایمیل شما</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-primary transition-colors"
                  placeholder="example@domain.com"
                  dir="ltr"
                />
              </div>
            </div>
            <div>
              <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">موضوع</label>
              <input
                type="text"
                id="subject"
                v-model="form.subject"
                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-primary transition-colors"
                placeholder="موضوع پیام"
              />
            </div>
            <div>
              <label for="message" class="block text-sm font-medium text-gray-300 mb-2">پیام</label>
              <textarea
                id="message"
                v-model="form.message"
                rows="4"
                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-primary transition-colors"
                placeholder="پیام خود را بنویسید..."
              ></textarea>
            </div>
            <button
              type="submit"
              class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
            >
              <font-awesome-icon icon="paper-plane" />
              ارسال پیام
            </button>
          </form>
        </div>

        <!-- Contact Information -->
        <div class="space-y-8">
          <div class="bg-slate-800/50 p-8 rounded-2xl">
            <h2 class="text-3xl font-bold mb-8 text-white">اطلاعات تماس</h2>
            <div class="space-y-6">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center text-primary">
                  <font-awesome-icon icon="envelope" size="lg" />
                </div>
                <div>
                  <h3 class="text-gray-400 text-sm mb-1">ایمیل</h3>
                  <a href="mailto:edris.qeshm2@gmail.com" class="text-white hover:text-primary transition-colors" dir="ltr">
                    edris.qeshm2@gmail.com
                  </a>
                </div>
              </div>
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center text-primary">
                  <font-awesome-icon icon="phone" size="lg" />
                </div>
                <div>
                  <h3 class="text-gray-400 text-sm mb-1">تلفن</h3>
                  <a href="tel:+989962933405" class="text-white hover:text-primary transition-colors" dir="ltr">
                    +98 996 293 3405
                  </a>
                </div>
              </div>
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center text-primary">
                  <font-awesome-icon icon="location-dot" size="lg" />
                </div>
                <div>
                  <h3 class="text-gray-400 text-sm mb-1">موقعیت</h3>
                  <p class="text-white">آماده همکاری به صورت دورکاری در سراسر دنیا</p>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-slate-800/50 p-8 rounded-2xl">
            <h2 class="text-3xl font-bold mb-4 text-white">همکاری کنیم</h2>
            <p class="text-gray-300 mb-8">
              همیشه آماده شنیدن ایده‌های جدید، پروژه‌های خلاقانه و فرصت‌های همکاری هستم.
            </p>
            <div class="bg-slate-800/50 p-4 rounded-lg border border-primary/20">
              <h3 class="text-primary font-semibold mb-2">در حال حاضر در دسترس</h3>
              <p class="text-gray-300">
                آماده همکاری به صورت فریلنسری، قراردادی یا تمام وقت هستم. بیایید با هم چیز فوق‌العاده‌ای بسازیم.
                <a href="#donate" @click.prevent="scrollToDonate" class="text-primary hover:text-primary-dark transition-colors mr-1">
                  از طریق حمایت مالی
                </a>
                از من پشتیبانی کنید.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const handleSubmit = async () => {
  // TODO: Implement form submission logic
  console.log('Form submitted:', form.value)
}

const scrollToDonate = () => {
  const donateSection = document.querySelector('#donate')
  if (donateSection) {
    donateSection.scrollIntoView({ behavior: 'smooth' })
  }
}
</script> 