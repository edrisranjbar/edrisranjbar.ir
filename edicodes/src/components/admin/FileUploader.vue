<template>
  <div>
    <div 
      v-if="!previewUrl"
      @dragover.prevent="isDragging = true"
      @dragleave.prevent="isDragging = false"
      @drop.prevent="handleFileDrop"
      :class="[
        'bg-black/20 border-2 border-dashed rounded-lg p-6 text-center transition-colors',
        isDragging ? 'border-primary/70 bg-primary/5' : 'border-white/10', 
        isUploading ? 'opacity-70' : ''
      ]"
    >
      <div v-if="!isUploading">
        <font-awesome-icon 
          icon="cloud-upload-alt" 
          class="text-3xl text-white/50 mb-2"
        />
        <p class="text-white/70 font-vazir mb-3">
          فایل خود را در اینجا بکشید یا 
          <label class="text-primary cursor-pointer hover:text-primary-light">
            انتخاب کنید
            <input
              type="file"
              class="hidden"
              :accept="accept"
              @change="handleFileSelect"
            />
          </label>
        </p>
        <p class="text-white/50 text-xs font-vazir">
          پسوندهای مجاز: {{ acceptedExtensions }}
        </p>
      </div>
      
      <div v-else class="flex flex-col items-center justify-center">
        <font-awesome-icon 
          icon="circle-notch" 
          class="text-2xl text-primary mb-2 animate-spin"
        />
        <p class="text-white/70 font-vazir">در حال آپلود ({{ uploadProgress }}%)...</p>
      </div>
    </div>
    
    <!-- Image preview during upload -->
    <div v-if="previewUrl" class="mt-2">
      <div class="relative rounded overflow-hidden h-48 bg-black/50 mb-2">
        <img 
          :src="previewUrl" 
          alt="Preview" 
          class="w-full h-full object-cover"
        />
        
        <!-- Upload progress overlay -->
        <div v-if="isUploading" class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center">
          <div class="w-3/4 bg-black/40 rounded-full h-2.5 mb-2">
            <div 
              class="bg-primary h-2.5 rounded-full" 
              :style="{ width: `${uploadProgress}%` }"
            ></div>
          </div>
          <p class="text-white text-sm font-vazir">
            در حال آپلود ({{ uploadProgress }}%)
          </p>
        </div>
        
        <!-- Buttons for preview control -->
        <div class="absolute top-2 right-2 flex">
          <button 
            @click="cancelUpload" 
            class="bg-red-500/80 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600/80 transition-colors duration-200 ml-2"
            title="لغو آپلود"
          >
            <font-awesome-icon icon="times" />
          </button>
        </div>
      </div>
    </div>
    
    <div v-if="error" class="mt-2 text-red-400 text-sm font-vazir">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  accept: {
    type: String,
    default: 'image/jpeg,image/png,image/gif,image/webp'
  },
  maxSize: {
    type: Number,
    default: 2 * 1024 * 1024 // 2 MB
  },
  uploadEndpoint: {
    type: String,
    required: true
  }
});

const emit = defineEmits(['upload-success', 'upload-error']);

const isDragging = ref(false);
const isUploading = ref(false);
const uploadProgress = ref(0);
const error = ref('');
const previewUrl = ref('');
let cancelTokenSource = null;

// Create a CancelToken source
const CancelToken = axios.CancelToken;

// Convert accept mime types to readable extensions
const acceptedExtensions = computed(() => {
  return props.accept
    .split(',')
    .map(type => {
      const ext = type.split('/')[1];
      return ext === '*' ? 'همه فایل‌ها' : `.${ext}`;
    })
    .join(', ');
});

function handleFileDrop(event) {
  isDragging.value = false;
  const files = event.dataTransfer.files;
  
  if (files.length > 0) {
    validateAndUpload(files[0]);
  }
}

function handleFileSelect(event) {
  const file = event.target.files[0];
  if (file) {
    validateAndUpload(file);
  }
  
  // Reset the input so the same file can be selected again
  event.target.value = '';
}

function validateAndUpload(file) {
  error.value = '';
  
  // Check file type
  const acceptedTypes = props.accept.split(',');
  const isValidType = acceptedTypes.some(type => {
    if (type.includes('*')) {
      return file.type.startsWith(type.split('/')[0]);
    }
    return type === file.type;
  });
  
  if (!isValidType) {
    error.value = 'نوع فایل انتخاب شده مجاز نیست.';
    return;
  }
  
  // Check file size
  if (file.size > props.maxSize) {
    const maxSizeMB = props.maxSize / (1024 * 1024);
    error.value = `حجم فایل باید کمتر از ${maxSizeMB} مگابایت باشد.`;
    return;
  }
  
  // Create a preview URL
  if (file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewUrl.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
  
  uploadFile(file);
}

async function uploadFile(file) {
  isUploading.value = true;
  uploadProgress.value = 0;
  
  // Create a cancel token
  cancelTokenSource = CancelToken.source();
  
  const formData = new FormData();
  formData.append('file', file);
  
  // Get auth token
  const token = localStorage.getItem('admin_token');
  console.log('Auth token:', token ? 'Token exists' : 'No token found');
  
  const headers = {
    'Content-Type': 'multipart/form-data',
    'Authorization': `Bearer ${token}`
  };
  
  console.log('Upload endpoint:', props.uploadEndpoint);
  
  try {
    const response = await axios.post(props.uploadEndpoint, formData, {
      headers,
      onUploadProgress: progressEvent => {
        if (progressEvent.total) {
          uploadProgress.value = Math.round((progressEvent.loaded / progressEvent.total) * 100);
        }
      },
      cancelToken: cancelTokenSource.token
    });
    
    if (response.data && response.data.url) {
      emit('upload-success', response.data.url);
    } else {
      throw new Error('آدرس فایل آپلود شده دریافت نشد.');
    }
  } catch (err) {
    if (axios.isCancel(err)) {
      console.log('Upload canceled');
      // Clean up the preview
      previewUrl.value = '';
    } else {
      console.error('Error uploading file:', err);
      error.value = err.response?.data?.message || 'خطا در آپلود فایل. لطفا دوباره تلاش کنید.';
      emit('upload-error', error.value);
    }
  } finally {
    isUploading.value = false;
    cancelTokenSource = null;
  }
}

function cancelUpload() {
  if (cancelTokenSource) {
    cancelTokenSource.cancel('Upload canceled by user');
  }
  previewUrl.value = '';
  error.value = '';
}
</script> 