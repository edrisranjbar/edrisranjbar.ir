<template>
  <div class="pt-16" dir="rtl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-4xl font-bold mb-12 text-center font-vazir">
        <span class="text-primary">وبلاگ</span> من
      </h1>
      
      <!-- Search and Filter -->
      <div class="mb-8 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <div class="relative">
            <input 
              v-model="searchQuery" 
              type="text" 
              placeholder="جستجو در مطالب..." 
              class="w-full bg-black/20 border border-white/10 rounded-lg py-3 px-4 pr-10 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
              @keyup.enter="handleSearch"
            />
            <button 
              class="absolute left-3 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-primary"
              @click="handleSearch"
            >
              <font-awesome-icon icon="search" />
            </button>
          </div>
        </div>
        <div class="w-full md:w-48">
          <div class="relative">
            <select 
              v-model="selectedCategory" 
              class="w-full bg-black/20 border border-white/10 rounded-lg py-3 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50 appearance-none cursor-pointer"
              @change="filterByCategory"
            >
              <option value="">همه دسته‌بندی‌ها</option>
              <option v-for="category in categories" :key="category.id" :value="category.slug">
                {{ category.name }}
              </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-white/50">
              <font-awesome-icon icon="chevron-down" class="h-4 w-4" />
            </div>
          </div>
        </div>
      </div>
      
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
      
      <!-- No results state -->
      <div v-else-if="posts.length === 0" class="flex flex-col items-center justify-center py-12 px-4 bg-black/40 rounded-2xl border border-white/5">
        <div class="w-16 h-16 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4">
          <font-awesome-icon icon="search" class="text-2xl text-orange-500" />
        </div>
        <h3 class="text-xl font-semibold mb-2 font-vazir text-white">نتیجه‌ای یافت نشد</h3>
        <p class="text-white/70 text-center font-vazir max-w-lg">
          متاسفانه با معیارهای جستجوی شما مطلبی یافت نشد. لطفا معیارهای خود را تغییر دهید.
        </p>
      </div>
      
      <!-- Posts grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <PostCard v-for="post in posts" :key="post.id" :post="post" />
      </div>
      
      <!-- Pagination -->
      <div v-if="posts.length > 0 && hasMorePosts" class="flex justify-center mt-10">
        <button 
          @click="loadMorePosts" 
          class="px-6 py-3 bg-primary/10 text-primary hover:bg-primary/20 rounded-lg transition-colors duration-300 font-vazir"
          :disabled="loadingMore"
        >
          <span v-if="loadingMore">در حال بارگذاری...</span>
          <span v-else>مطالب بیشتر</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import PostCard from '@/components/PostCard.vue';
import axios from 'axios';

const posts = ref([]);
const categories = ref([]);
const loading = ref(true);
const loadingMore = ref(false);
const error = ref(null);
const currentPage = ref(1);
const hasMorePosts = ref(false);
const searchQuery = ref('');
const selectedCategory = ref('');

const fetchCategories = async () => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/categories`);
    console.log('Categories response:', response.data);
    
    // Check if response has data property (Laravel API Resource format)
    if (response.data && Array.isArray(response.data.data)) {
      categories.value = response.data.data;
    } else if (Array.isArray(response.data)) {
      categories.value = response.data;
    } else {
      console.error('Unexpected categories response format:', response.data);
    }
  } catch (err) {
    console.error('Error fetching categories:', err);
  }
};

const fetchPosts = async (page = 1, search = '', category = '') => {
  try {
    const params = { page };
    
    if (search) {
      params.search = search;
    }
    
    if (category) {
      params.category = category;
    }
    
    const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/posts`, { params });
    
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
  currentPage.value = 1;
  
  const data = await fetchPosts(1, searchQuery.value, selectedCategory.value);
  
  if (data) {
    if (Array.isArray(data.data)) {
      posts.value = data.data;
      hasMorePosts.value = data.meta && data.meta.current_page < data.meta.last_page;
    } else {
      console.error('Unexpected posts response format:', data);
      error.value = 'فرمت پاسخ API نامعتبر است';
    }
  }
  
  loading.value = false;
};

const loadMorePosts = async () => {
  if (loadingMore.value) return;
  
  loadingMore.value = true;
  currentPage.value++;
  
  const data = await fetchPosts(currentPage.value, searchQuery.value, selectedCategory.value);
  
  if (data && Array.isArray(data.data)) {
    posts.value = [...posts.value, ...data.data];
    hasMorePosts.value = data.meta && data.meta.current_page < data.meta.last_page;
  }
  
  loadingMore.value = false;
};

const handleSearch = () => {
  loadPosts();
};

const filterByCategory = () => {
  loadPosts();
};

onMounted(() => {
  fetchCategories();
  loadPosts();
  
  // Update document title
  document.title = 'وبلاگ | ادیکدز';
});
</script> 