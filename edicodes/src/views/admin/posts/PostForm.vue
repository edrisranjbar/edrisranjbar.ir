<template>
  <div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
      <h1 class="text-xl font-vazir text-white mb-4 sm:mb-0">
        {{ isEditing ? 'ویرایش مطلب' : 'ایجاد مطلب جدید' }}
      </h1>
      <div class="flex space-x-2 space-x-reverse">
        <button 
          type="button" 
          @click="router.push('/admin/posts')" 
          class="px-3 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200 text-sm font-vazir"
        >
          انصراف
        </button>
        <button 
          type="button" 
          @click="savePost" 
          :disabled="isSaving"
          class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200 flex items-center text-sm font-vazir"
        >
          <font-awesome-icon v-if="isSaving" icon="circle-notch" class="animate-spin ml-1" />
          <font-awesome-icon v-else icon="save" class="ml-1" />
          {{ isSaving ? 'در حال ذخیره...' : 'ذخیره مطلب' }}
        </button>
      </div>
    </div>
    
    <!-- Alert for errors -->
    <div v-if="error" class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 font-vazir">
      {{ error }}
    </div>
    
    <!-- Blog post form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main content column -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Title and slug -->
        <div class="bg-black/50 rounded-lg border border-white/10 p-6">
          <div class="mb-4">
            <label for="title" class="block text-white font-vazir mb-2">عنوان مطلب</label>
            <input 
              v-model="post.title" 
              type="text" 
              id="title" 
              class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
              placeholder="عنوان مطلب را وارد کنید"
            />
          </div>
          
          <div>
            <label for="slug" class="block text-white font-vazir mb-2">نامک (slug)</label>
            <div class="flex">
              <input 
                v-model="post.slug" 
                type="text" 
                id="slug" 
                class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
                placeholder="نامک-مطلب"
                dir="ltr"
              />
              <button 
                @click="generateSlug" 
                type="button"
                class="bg-white/10 hover:bg-white/20 text-white px-3 rounded-lg mr-2"
                title="ساخت خودکار از عنوان"
              >
                <font-awesome-icon icon="magic" />
              </button>
            </div>
            <p class="mt-1 text-white/50 text-xs font-vazir">
              نامک در URL مطلب استفاده می‌شود، مثال: example.com/blog/{{ post.slug || 'نامک-مطلب' }}
            </p>
          </div>
        </div>
        
        <!-- Content -->
        <div class="bg-black/50 rounded-lg border border-white/10 p-6">
          <div class="mb-4">
            <label for="summary" class="block text-white font-vazir mb-2">خلاصه مطلب</label>
            <textarea 
              v-model="post.summary" 
              id="summary" 
              rows="3"
              class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50 resize-none"
              placeholder="خلاصه‌ای از مطلب را وارد کنید"
            ></textarea>
          </div>
          
          <div>
            <label for="content" class="block text-white font-vazir mb-2">متن مطلب</label>
            <p class="text-white/50 text-xs mb-2 font-vazir">
              متن مطلب را به صورت HTML وارد کنید. از تگ‌های p، h2، ul، li و... استفاده کنید.
            </p>
            <textarea 
              v-model="post.content" 
              id="content" 
              rows="20"
              class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
              placeholder="<p>متن مطلب را اینجا وارد کنید...</p>"
            ></textarea>
          </div>
        </div>
      </div>
      
      <!-- Sidebar column -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Status and Publish -->
        <div class="bg-black/50 rounded-lg border border-white/10 p-6">
          <h3 class="text-white font-vazir mb-4">انتشار</h3>
          
          <div class="mb-4">
            <div class="flex items-center">
              <input 
                v-model="post.published" 
                type="checkbox" 
                id="published" 
                class="w-5 h-5 bg-black/20 border border-white/10 rounded text-primary focus:ring-primary focus:ring-opacity-25"
              />
              <label for="published" class="text-white font-vazir mr-2">منتشر شده</label>
            </div>
            <p class="mt-1 text-white/50 text-xs font-vazir">
              اگر این گزینه را انتخاب نکنید، مطلب به صورت پیش‌نویس ذخیره می‌شود.
            </p>
          </div>
          
          <div class="mb-4">
            <label for="published_at" class="block text-white font-vazir mb-2">تاریخ انتشار</label>
            <input 
              v-model="post.published_at" 
              type="datetime-local" 
              id="published_at" 
              class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
              dir="ltr"
            />
          </div>
        </div>
        
        <!-- Category -->
        <div class="bg-black/50 rounded-lg border border-white/10 p-6">
          <h3 class="text-white font-vazir mb-4">دسته‌بندی</h3>
          
          <div class="relative">
            <select 
              v-model="post.category_id" 
              class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50 appearance-none"
            >
              <option :value="null">بدون دسته‌بندی</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-white/50">
              <font-awesome-icon icon="chevron-down" class="h-4 w-4" />
            </div>
          </div>
          
          <div class="mt-4 flex justify-end">
            <router-link 
              to="/admin/categories/create" 
              class="text-primary text-sm hover:text-primary-light transition-colors duration-150 font-vazir flex items-center"
            >
              <font-awesome-icon icon="plus" class="ml-1" />
              افزودن دسته‌بندی جدید
            </router-link>
          </div>
        </div>
        
        <!-- Featured Image -->
        <div class="bg-black/50 rounded-lg border border-white/10 p-6">
          <h3 class="text-white font-vazir mb-4">تصویر شاخص</h3>
          
          <div class="mb-4">
            <label for="image" class="block text-white font-vazir mb-2">آدرس تصویر</label>
            <input 
              v-model="post.image" 
              type="url" 
              id="image" 
              class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
              placeholder="https://example.com/image.jpg"
              dir="ltr"
            />
            <p class="mt-1 text-white/50 text-xs font-vazir">
              آدرس اینترنتی تصویر را وارد کنید.
            </p>
          </div>
          
          <div v-if="post.image" class="mt-4">
            <p class="block text-white font-vazir mb-2">پیش‌نمایش:</p>
            <div class="relative rounded overflow-hidden h-48 bg-black/50">
              <img 
                :src="post.image" 
                alt="Preview" 
                class="w-full h-full object-cover"
                @error="imageError = true"
              />
              <div v-if="imageError" class="absolute inset-0 flex items-center justify-center">
                <span class="text-red-400 text-sm font-vazir">خطا در بارگذاری تصویر</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const error = ref('');
const isSaving = ref(false);
const imageError = ref(false);
const categories = ref([]);

// Form state
const post = ref({
  title: '',
  slug: '',
  summary: '',
  content: '',
  image: '',
  published: false,
  published_at: formatDateTime(new Date()),
  category_id: null
});

// Check if we're editing
const isEditing = computed(() => !!route.params.id);

// Format date for datetime-local input
function formatDateTime(date) {
  const d = new Date(date);
  // Adjust for timezone offset
  const localDate = new Date(d.getTime() - d.getTimezoneOffset() * 60000);
  return localDate.toISOString().slice(0, 16);
}

// Generate slug from title
function generateSlug() {
  if (!post.value.title) {
    error.value = 'ابتدا عنوان مطلب را وارد کنید.';
    return;
  }
  
  error.value = '';
  
  // Convert to lowercase, replace spaces with hyphens, remove special chars
  const slug = post.value.title
    .toLowerCase()
    .replace(/[\s_]+/g, '-')
    .replace(/[^\u0600-\u06FF\uFB8A\u067E\u0686\u06AF\u200C\u200Fa-z0-9-]/g, '')
    .replace(/-+/g, '-')
    .replace(/^-+|-+$/g, '');
  
  post.value.slug = slug;
}

// Fetch categories
async function fetchCategories() {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/categories`);
    
    if (response.data && Array.isArray(response.data.data)) {
      categories.value = response.data.data;
    } else if (Array.isArray(response.data)) {
      categories.value = response.data;
    }
  } catch (err) {
    console.error('Error fetching categories:', err);
  }
}

// Fetch post data if editing
async function fetchPost(id) {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/posts/${id}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
      }
    });
    
    const postData = response.data;
    
    // Format the date for the input
    if (postData.published_at) {
      postData.published_at = formatDateTime(postData.published_at);
    } else {
      postData.published_at = formatDateTime(new Date());
    }
    
    // Set category_id if it exists
    if (postData.category) {
      postData.category_id = postData.category.id;
    }
    
    post.value = postData;
  } catch (err) {
    console.error('Error fetching post:', err);
    error.value = 'خطا در بارگذاری اطلاعات مطلب. لطفا دوباره تلاش کنید.';
  }
}

// Save the post
async function savePost() {
  try {
    if (!post.value.title) {
      error.value = 'عنوان مطلب الزامی است.';
      return;
    }
    
    if (!post.value.slug) {
      generateSlug();
    }
    
    isSaving.value = true;
    error.value = '';
    
    // Prepare data for API
    const postData = {
      title: post.value.title,
      slug: post.value.slug,
      summary: post.value.summary,
      content: post.value.content,
      image: post.value.image,
      published: post.value.published,
      published_at: post.value.published_at,
      category_id: post.value.category_id
    };
    
    let response;
    
    if (isEditing.value) {
      // Update existing post
      response = await axios.put(
        `${import.meta.env.VITE_API_URL}/api/posts/${route.params.id}`, 
        postData,
        {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
          }
        }
      );
    } else {
      // Create new post
      response = await axios.post(
        `${import.meta.env.VITE_API_URL}/api/posts`, 
        postData,
        {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
          }
        }
      );
    }
    
    // Redirect to posts list
    router.push('/admin/posts');
  } catch (err) {
    console.error('Error saving post:', err);
    error.value = err.response?.data?.message || 'خطا در ذخیره مطلب. لطفا دوباره تلاش کنید.';
  } finally {
    isSaving.value = false;
  }
}

// Reset image error when image URL changes
watch(() => post.value.image, () => {
  imageError.value = false;
});

onMounted(async () => {
  await fetchCategories();
  
  if (isEditing.value) {
    await fetchPost(route.params.id);
  }
});
</script> 