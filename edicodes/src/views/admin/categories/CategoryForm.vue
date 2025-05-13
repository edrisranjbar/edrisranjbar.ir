<template>
  <div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
      <h1 class="text-xl font-vazir text-white mb-4 sm:mb-0">
        {{ isEditing ? 'ویرایش دسته‌بندی' : 'ایجاد دسته‌بندی جدید' }}
      </h1>
      <div class="flex space-x-2 space-x-reverse">
        <button 
          type="button" 
          @click="router.push('/admin/categories')" 
          class="px-3 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200 text-sm font-vazir"
        >
          انصراف
        </button>
        <button 
          type="button" 
          @click="saveCategory" 
          :disabled="isSaving"
          class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200 flex items-center text-sm font-vazir"
        >
          <font-awesome-icon v-if="isSaving" icon="circle-notch" class="animate-spin ml-1" />
          <font-awesome-icon v-else icon="save" class="ml-1" />
          {{ isSaving ? 'در حال ذخیره...' : 'ذخیره' }}
        </button>
      </div>
    </div>
    
    <!-- Alert for errors -->
    <div v-if="error" class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 font-vazir">
      {{ error }}
    </div>
    
    <!-- Category form -->
    <div class="bg-black/50 rounded-lg border border-white/10 p-6">
      <div class="mb-4">
        <label for="name" class="block text-white font-vazir mb-2">نام دسته‌بندی</label>
        <input 
          v-model="category.name" 
          type="text" 
          id="name" 
          class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
          placeholder="نام دسته‌بندی را وارد کنید"
        />
      </div>
      
      <div>
        <label for="slug" class="block text-white font-vazir mb-2">نامک (slug)</label>
        <div class="flex">
          <input 
            v-model="category.slug" 
            type="text" 
            id="slug" 
            class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-4 font-vazir text-white/90 focus:outline-none focus:border-primary/50"
            placeholder="نامک-دسته-بندی"
            dir="ltr"
          />
          <button 
            @click="generateSlug" 
            type="button"
            class="bg-white/10 hover:bg-white/20 text-white px-3 rounded-lg mr-2"
            title="ساخت خودکار از نام"
          >
            <font-awesome-icon icon="magic" />
          </button>
        </div>
        <p class="mt-1 text-white/50 text-xs font-vazir">
          نامک در URL دسته‌بندی استفاده می‌شود، مثال: example.com/blog?category={{ category.slug || 'نامک-دسته-بندی' }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const error = ref('');
const isSaving = ref(false);

// Form state
const category = ref({
  name: '',
  slug: '',
});

// Check if we're editing
const isEditing = computed(() => !!route.params.id);

// Generate slug from name
function generateSlug() {
  if (!category.value.name) {
    error.value = 'ابتدا نام دسته‌بندی را وارد کنید.';
    return;
  }
  
  error.value = '';
  
  // Convert to lowercase, replace spaces with hyphens, remove special chars
  const slug = category.value.name
    .toLowerCase()
    .replace(/[\s_]+/g, '-')
    .replace(/[^\u0600-\u06FF\uFB8A\u067E\u0686\u06AF\u200C\u200Fa-z0-9-]/g, '')
    .replace(/-+/g, '-')
    .replace(/^-+|-+$/g, '');
  
  category.value.slug = slug;
}

// Fetch category data if editing
async function fetchCategory(id) {
  try {
    const response = await axios.get(`${import.meta.env.VITE_API_URL}/api/categories/${id}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
      }
    });
    
    const categoryData = response.data;
    
    // Check if data is nested in a data property (Laravel API Resource)
    if (categoryData.data) {
      category.value = categoryData.data;
    } else {
      category.value = categoryData;
    }
  } catch (err) {
    console.error('Error fetching category:', err);
    error.value = 'خطا در بارگذاری اطلاعات دسته‌بندی. لطفا دوباره تلاش کنید.';
  }
}

// Save the category
async function saveCategory() {
  try {
    if (!category.value.name) {
      error.value = 'نام دسته‌بندی الزامی است.';
      return;
    }
    
    if (!category.value.slug) {
      generateSlug();
    }
    
    isSaving.value = true;
    error.value = '';
    
    // Prepare data for API
    const categoryData = {
      name: category.value.name,
      slug: category.value.slug,
    };
    
    let response;
    
    if (isEditing.value) {
      // Update existing category
      response = await axios.put(
        `${import.meta.env.VITE_API_URL}/api/categories/${route.params.id}`, 
        categoryData,
        {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
          }
        }
      );
    } else {
      // Create new category
      response = await axios.post(
        `${import.meta.env.VITE_API_URL}/api/categories`, 
        categoryData,
        {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
          }
        }
      );
    }
    
    // Redirect to categories list
    router.push('/admin/categories');
  } catch (err) {
    console.error('Error saving category:', err);
    error.value = err.response?.data?.message || 'خطا در ذخیره دسته‌بندی. لطفا دوباره تلاش کنید.';
  } finally {
    isSaving.value = false;
  }
}

onMounted(() => {
  if (isEditing.value) {
    fetchCategory(route.params.id);
  }
});
</script> 