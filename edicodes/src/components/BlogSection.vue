<template>
  <section id="blog" class="py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-4xl font-bold mb-12 text-center font-vazir">
        <span class="text-primary">وبلاگ</span> من
      </h2>
      
      <!-- Loading state -->
      <div v-if="loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
      </div>
      
      <!-- Error state -->
      <div v-else-if="error" class="flex flex-col items-center justify-center py-12 px-4 bg-black/40 rounded-2xl border border-white/5">
        <div class="w-16 h-16 bg-red-500/10 rounded-lg flex items-center justify-center mb-4">
          <font-awesome-icon icon="exclamation-circle" class="text-2xl text-red-500" />
        </div>
        <h3 class="text-xl font-semibold mb-2 font-vazir text-white">خطایی رخ داد</h3>
        <p class="text-white/70 text-center font-vazir max-w-lg">
          متاسفانه در بارگذاری مطالب مشکلی پیش آمد. لطفا دوباره تلاش کنید.
        </p>
      </div>
      
      <!-- Empty state -->
      <div v-else-if="posts.length === 0" class="flex flex-col items-center justify-center py-12 px-4 bg-black/40 rounded-2xl border border-white/5">
        <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
          <font-awesome-icon icon="book" class="text-2xl text-primary" />
        </div>
        <h3 class="text-xl font-semibold mb-2 font-vazir text-white">هنوز مطلبی منتشر نشده</h3>
        <p class="text-white/70 text-center font-vazir max-w-lg">
          در حال آماده‌سازی مطالب آموزشی و مقالات جذاب هستم. به زودی با محتوای مفید در خدمت شما خواهم بود.
        </p>
      </div>
      
      <!-- Posts grid - showing only the latest 3 posts -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <PostCard v-for="post in posts.slice(0, 3)" :key="post.id" :post="post" />
      </div>
      
      <!-- View all posts button -->
      <div v-if="posts.length > 0" class="flex justify-center mt-10">
        <router-link 
          to="/blog" 
          class="px-6 py-3 bg-primary/10 text-primary hover:bg-primary/20 rounded-lg transition-colors duration-300 font-vazir"
        >
          مشاهده همه مطالب
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import PostCard from '@/components/PostCard.vue';
import axios from 'axios';

const posts = ref([]);
const loading = ref(true);
const loadingMore = ref(false);
const error = ref(null);
const currentPage = ref(1);
const hasMorePosts = ref(false);

const fetchPosts = async (page = 1) => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/posts`, {
      params: {
        page
      }
    });
    
    return response.data;
  } catch (err) {
    console.error('Error fetching posts:', err);
    error.value = err.message;
    return null;
  }
};

const loadPosts = async () => {
  loading.value = true;
  error.value = null;
  
  const data = await fetchPosts();
  
  if (data) {
    posts.value = data.data;
    hasMorePosts.value = data.meta.current_page < data.meta.last_page;
  }
  
  loading.value = false;
};

const loadMorePosts = async () => {
  if (loadingMore.value) return;
  
  loadingMore.value = true;
  currentPage.value++;
  
  const data = await fetchPosts(currentPage.value);
  
  if (data) {
    posts.value = [...posts.value, ...data.data];
    hasMorePosts.value = data.meta.current_page < data.meta.last_page;
  }
  
  loadingMore.value = false;
};

onMounted(() => {
  loadPosts();
});
</script>

<style scoped>
/* Empty state styling */
</style> 