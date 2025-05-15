<template>
  <div>
    <div v-if="isLoading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
    </div>

    <div v-else>
      <!-- Tabs -->
      <div class="bg-black/50 rounded-lg p-2 mb-6 flex space-x-2 space-x-reverse border border-white/10 max-w-xl">
        <button 
          @click="activeTab = 'profile'" 
          :class="[activeTab === 'profile' ? 'bg-primary/20 text-primary' : 'text-white/70 hover:bg-white/5']"
          class="flex-1 py-2 px-4 text-sm rounded-lg transition-colors duration-200 font-vazir"
        >
          <font-awesome-icon icon="user" class="ml-2" />
          اطلاعات پروفایل
        </button>
        <button 
          @click="activeTab = 'password'" 
          :class="[activeTab === 'password' ? 'bg-primary/20 text-primary' : 'text-white/70 hover:bg-white/5']"
          class="flex-1 py-2 px-4 text-sm rounded-lg transition-colors duration-200 font-vazir"
        >
          <font-awesome-icon icon="lock" class="ml-2" />
          تغییر رمز عبور
        </button>
      </div>

      <!-- Profile Settings -->
      <div v-if="activeTab === 'profile'" class="bg-black/50 rounded-lg border border-white/10 p-6 mb-6 max-w-xl">
        <h2 class="text-lg font-vazir text-white mb-4">اطلاعات پروفایل</h2>
        
        <div v-if="notifications.profile.show" 
          :class="[notifications.profile.type === 'success' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500']" 
          class="p-3 rounded-lg mb-4 text-sm font-vazir">
          {{ notifications.profile.message }}
        </div>

        <form @submit.prevent="updateProfile">
          <div class="mb-4">
            <label for="name" class="block text-white/70 mb-2 text-sm font-vazir">نام</label>
            <input 
              id="name" 
              v-model="profile.name" 
              type="text" 
              class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition"
              required
              :disabled="profileLoading"
            />
            <span v-if="validationErrors.name" class="text-red-500 text-xs mt-1 block">{{ validationErrors.name[0] }}</span>
          </div>
          
          <div class="mb-6">
            <label for="email" class="block text-white/70 mb-2 text-sm font-vazir">ایمیل</label>
            <input 
              id="email" 
              v-model="profile.email" 
              type="email" 
              class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition"
              required
              :disabled="profileLoading"
            />
            <span v-if="validationErrors.email" class="text-red-500 text-xs mt-1 block">{{ validationErrors.email[0] }}</span>
          </div>
          
          <button 
            type="submit" 
            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200 flex items-center text-sm font-vazir"
            :disabled="profileLoading"
          >
            <span v-if="profileLoading" class="inline-block h-4 w-4 border-2 border-t-white/5 border-r-white/5 border-white rounded-full animate-spin ml-2"></span>
            ذخیره تغییرات
          </button>
        </form>
      </div>

      <!-- Password Change -->
      <div v-if="activeTab === 'password'" class="bg-black/50 rounded-lg border border-white/10 p-6 max-w-xl">
        <h2 class="text-lg font-vazir text-white mb-4">تغییر رمز عبور</h2>
        
        <div v-if="notifications.password.show" 
          :class="[notifications.password.type === 'success' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500']" 
          class="p-3 rounded-lg mb-4 text-sm font-vazir">
          {{ notifications.password.message }}
        </div>

        <form @submit.prevent="changePassword">
          <div class="mb-4">
            <label for="current_password" class="block text-white/70 mb-2 text-sm font-vazir">رمز عبور فعلی</label>
            <input 
              id="current_password" 
              v-model="passwordData.current_password" 
              type="password" 
              class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition"
              required
              :disabled="passwordLoading"
            />
            <span v-if="validationErrors.current_password" class="text-red-500 text-xs mt-1 block">{{ validationErrors.current_password[0] }}</span>
          </div>
          
          <div class="mb-4">
            <label for="new_password" class="block text-white/70 mb-2 text-sm font-vazir">رمز عبور جدید</label>
            <input 
              id="new_password" 
              v-model="passwordData.new_password" 
              type="password" 
              class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition"
              required
              :disabled="passwordLoading"
            />
            <span v-if="validationErrors.new_password" class="text-red-500 text-xs mt-1 block">{{ validationErrors.new_password[0] }}</span>
          </div>
          
          <div class="mb-6">
            <label for="new_password_confirmation" class="block text-white/70 mb-2 text-sm font-vazir">تکرار رمز عبور جدید</label>
            <input 
              id="new_password_confirmation" 
              v-model="passwordData.new_password_confirmation" 
              type="password" 
              class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition"
              required
              :disabled="passwordLoading"
            />
          </div>
          
          <button 
            type="submit" 
            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200 flex items-center text-sm font-vazir"
            :disabled="passwordLoading"
          >
            <span v-if="passwordLoading" class="inline-block h-4 w-4 border-2 border-t-white/5 border-r-white/5 border-white rounded-full animate-spin ml-2"></span>
            تغییر رمز عبور
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

// State management
const isLoading = ref(true);
const activeTab = ref('profile');
const profile = reactive({
  name: '',
  email: ''
});

const passwordData = reactive({
  current_password: '',
  new_password: '',
  new_password_confirmation: ''
});

const profileLoading = ref(false);
const passwordLoading = ref(false);
const validationErrors = reactive({});

// Notification system
const notifications = reactive({
  profile: {
    show: false,
    message: '',
    type: 'success',
    timeout: null
  },
  password: {
    show: false,
    message: '',
    type: 'success',
    timeout: null
  }
});

// Show notification with auto-hide
const showNotification = (section, message, type = 'success', duration = 5000) => {
  // Clear any existing timeout
  if (notifications[section].timeout) {
    clearTimeout(notifications[section].timeout);
  }
  
  // Set notification data
  notifications[section].show = true;
  notifications[section].message = message;
  notifications[section].type = type;
  
  // Auto-hide after duration
  notifications[section].timeout = setTimeout(() => {
    notifications[section].show = false;
  }, duration);
};

// Load profile data on component mount
onMounted(async () => {
  try {
    await fetchProfile();
  } finally {
    isLoading.value = false;
  }
});

// Fetch profile data from API
const fetchProfile = async () => {
  try {
    const response = await api.get('/api/admin/profile');
    
    if (response.data.success) {
      profile.name = response.data.admin.name;
      profile.email = response.data.admin.email;
    }
  } catch (error) {
    console.error('Error fetching profile:', error);
    showNotification('profile', 'خطا در دریافت اطلاعات پروفایل', 'error');
  }
};

// Update profile information
const updateProfile = async () => {
  try {
    profileLoading.value = true;
    validationErrors.name = null;
    validationErrors.email = null;
    
    const response = await api.post('/api/admin/update-profile', {
      name: profile.name,
      email: profile.email
    });
    
    if (response.data.success) {
      showNotification('profile', response.data.message);
    }
  } catch (error) {
    const errorMessage = error.response?.data?.message || 'خطایی رخ داد. لطفاً مجدداً تلاش کنید.';
    showNotification('profile', errorMessage, 'error');
    
    // Handle validation errors
    if (error.response?.data?.errors) {
      Object.assign(validationErrors, error.response.data.errors);
    }
  } finally {
    profileLoading.value = false;
  }
};

// Change password
const changePassword = async () => {
  try {
    passwordLoading.value = true;
    validationErrors.current_password = null;
    validationErrors.new_password = null;
    
    const response = await api.post('/api/admin/change-password', {
      current_password: passwordData.current_password,
      new_password: passwordData.new_password,
      new_password_confirmation: passwordData.new_password_confirmation
    });
    
    if (response.data.success) {
      showNotification('password', response.data.message);
      
      // Reset form on success
      passwordData.current_password = '';
      passwordData.new_password = '';
      passwordData.new_password_confirmation = '';
    }
  } catch (error) {
    const errorMessage = error.response?.data?.message || 'خطایی رخ داد. لطفاً مجدداً تلاش کنید.';
    showNotification('password', errorMessage, 'error');
    
    // Handle validation errors
    if (error.response?.data?.errors) {
      Object.assign(validationErrors, error.response.data.errors);
    }
  } finally {
    passwordLoading.value = false;
  }
};
</script> 