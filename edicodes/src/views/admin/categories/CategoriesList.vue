<template>
  <div>
    <!-- Header with actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
      <h1 class="text-xl font-vazir text-white mb-4 sm:mb-0">مدیریت دسته‌بندی‌ها</h1>
      <div class="flex space-x-3 space-x-reverse">
        <router-link 
          to="/admin/categories/create" 
          class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200 flex items-center text-sm font-vazir"
        >
          <font-awesome-icon icon="plus" class="ml-1" />
          دسته‌بندی جدید
        </router-link>
      </div>
    </div>
    
    <!-- Loading state -->
    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
    </div>
    
    <!-- Categories Table -->
    <div v-else-if="categories.length" class="bg-black/50 border border-white/10 rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="text-right bg-black/60 border-b border-white/10">
              <th class="py-3 pr-6 text-sm font-vazir text-white/60 font-normal">نام</th>
              <th class="py-3 px-3 text-sm font-vazir text-white/60 font-normal">نامک (Slug)</th>
              <th class="py-3 px-3 text-sm font-vazir text-white/60 font-normal">تعداد مطالب</th>
              <th class="py-3 pl-6 text-sm font-vazir text-white/60 font-normal">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categories" :key="category.id" class="text-right border-b border-white/5 hover:bg-white/5">
              <td class="py-4 pr-6">
                <div class="font-vazir text-white text-sm">{{ category.name }}</div>
              </td>
              <td class="py-4 px-3">
                <div class="font-vazir text-white/70 text-sm" dir="ltr">{{ category.slug }}</div>
              </td>
              <td class="py-4 px-3">
                <div class="inline-flex px-2 py-1 bg-primary/10 text-primary text-xs rounded-full font-vazir">
                  {{ category.posts_count || 0 }}
                </div>
              </td>
              <td class="py-4 pl-6">
                <div class="flex items-center space-x-2 space-x-reverse">
                  <router-link :to="`/admin/categories/edit/${category.id}`" class="text-blue-400 hover:text-blue-300">
                    <font-awesome-icon icon="edit" />
                  </router-link>
                  <button 
                    @click="confirmDelete(category)" 
                    class="text-red-400 hover:text-red-300 mr-3"
                    :disabled="category.posts_count > 0"
                    :class="{'opacity-50 cursor-not-allowed': category.posts_count > 0}"
                    :title="category.posts_count > 0 ? 'برای حذف ابتدا مطالب این دسته‌بندی را حذف کنید' : 'حذف'"
                  >
                    <font-awesome-icon icon="trash-alt" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Empty state -->
    <div v-else class="bg-black/50 border border-white/10 rounded-lg p-12 text-center">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 mb-4">
        <font-awesome-icon icon="folder" class="text-primary h-8 w-8" />
      </div>
      <h3 class="text-lg font-vazir text-white mb-2">دسته‌بندی‌ای یافت نشد</h3>
      <p class="text-white/60 font-vazir mb-6">
        برای شروع دسته‌بندی جدیدی ایجاد کنید.
      </p>
      <router-link 
        to="/admin/categories/create" 
        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200 inline-flex items-center text-sm font-vazir"
      >
        <font-awesome-icon icon="plus" class="ml-1" />
        ایجاد دسته‌بندی جدید
      </router-link>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/70" @click="showDeleteModal = false"></div>
      <div class="relative bg-black/90 rounded-lg border border-white/10 p-6 w-full max-w-md">
        <h3 class="text-xl font-vazir text-white mb-4">تایید حذف</h3>
        <p class="font-vazir text-white/70 mb-6">
          آیا از حذف دسته‌بندی <span class="text-white font-bold">"{{ categoryToDelete?.name }}"</span> اطمینان دارید؟
          این عمل قابل بازگشت نیست.
        </p>
        <div class="flex justify-end space-x-3 space-x-reverse">
          <button 
            @click="showDeleteModal = false" 
            class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200 text-sm font-vazir"
          >
            انصراف
          </button>
          <button 
            @click="deleteCategory" 
            :disabled="isDeleting"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 text-sm font-vazir flex items-center"
          >
            <font-awesome-icon v-if="isDeleting" icon="circle-notch" class="animate-spin h-4 w-4 ml-2" />
            <font-awesome-icon v-else icon="trash-alt" class="ml-2" />
            {{ isDeleting ? 'در حال حذف...' : 'حذف' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loading = ref(true);
const categories = ref([]);
const showDeleteModal = ref(false);
const categoryToDelete = ref(null);
const isDeleting = ref(false);

const fetchCategories = async () => {
  try {
    loading.value = true;
    
    const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/admin/categories`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
      }
    });
    
    if (response.data && Array.isArray(response.data.data)) {
      categories.value = response.data.data;
    } else if (Array.isArray(response.data)) {
      categories.value = response.data;
    }
  } catch (error) {
    console.error('Error fetching categories:', error);
  } finally {
    loading.value = false;
  }
};

const confirmDelete = (category) => {
  if (category.posts_count > 0) return;
  
  categoryToDelete.value = category;
  showDeleteModal.value = true;
};

const deleteCategory = async () => {
  if (!categoryToDelete.value) return;
  
  try {
    isDeleting.value = true;
    
    await axios.delete(`${import.meta.env.VITE_API_BASE_URL}/admin/categories/${categoryToDelete.value.id}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
      }
    });
    
    // Remove category from the list
    categories.value = categories.value.filter(category => category.id !== categoryToDelete.value.id);
    
    // Close modal
    showDeleteModal.value = false;
    categoryToDelete.value = null;
  } catch (error) {
    console.error('Error deleting category:', error);
    // You can add an error alert/notification here
  } finally {
    isDeleting.value = false;
  }
};

onMounted(() => {
  fetchCategories();
});
</script> 