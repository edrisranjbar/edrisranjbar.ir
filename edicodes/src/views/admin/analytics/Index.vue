<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-vazir text-white">آمار بازدید</h1>
      
      <!-- Period selector -->
      <div class="flex items-center space-x-2 space-x-reverse">
        <button 
          v-for="period in periods" 
          :key="period.value"
          @click="selectedPeriod = period.value"
          :class="[
            'px-3 py-1.5 rounded-md text-sm font-vazir transition-colors',
            selectedPeriod === period.value 
              ? 'bg-primary text-white' 
              : 'bg-white/5 text-white/70 hover:bg-white/10'
          ]"
        >
          {{ period.label }}
        </button>
      </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="eye" class="text-xl text-blue-500" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">بازدید کل</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ analytics.totalViews || 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="users" class="text-xl text-green-500" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">بازدیدکننده</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ analytics.uniqueVisitors || 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-purple-500/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="chart-line" class="text-xl text-purple-500" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">میانگین بازدید روزانه</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ averageDailyViews }}</h3>
          </div>
        </div>
      </div>

      <div class="bg-black/30 rounded-lg p-5 border border-white/10">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-lg bg-yellow-500/20 flex items-center justify-center ml-3">
            <font-awesome-icon icon="newspaper" class="text-xl text-yellow-500" />
          </div>
          <div>
            <p class="text-white/70 text-sm font-vazir">میانگین بازدید هر مطلب</p>
            <h3 class="text-white text-2xl font-vazir font-bold mt-1">{{ averageViewsPerPost }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Daily views chart -->
    <div class="bg-black/30 rounded-lg border border-white/10 p-6 mb-8">
      <h2 class="text-lg font-vazir text-white mb-6">بازدید روزانه</h2>
      
      <div v-if="loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
      </div>
      
      <div v-else-if="!analytics.dailyViews || analytics.dailyViews.length === 0" class="text-center py-12 text-white/50 font-vazir">
        داده‌ای برای نمایش وجود ندارد.
      </div>
      
      <div v-else class="h-80">
        <LineChart 
          :data="chartData" 
          :options="chartOptions"
        />
      </div>
    </div>

    <!-- Top viewed posts -->
    <div class="bg-black/30 rounded-lg border border-white/10 p-6 mb-8">
      <h2 class="text-lg font-vazir text-white mb-6">پربازدیدترین مطالب</h2>
      
      <div v-if="loading" class="flex justify-center py-6">
        <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-primary"></div>
      </div>
      
      <div v-else-if="!analytics.topPosts || analytics.topPosts.length === 0" class="text-center py-6 text-white/50 font-vazir">
        داده‌ای برای نمایش وجود ندارد.
      </div>
      
      <div v-else class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="text-right border-b border-white/10">
              <th class="py-3 pr-3 text-sm font-vazir text-white/60 font-normal">عنوان</th>
              <th class="py-3 px-3 text-sm font-vazir text-white/60 font-normal">دسته‌بندی</th>
              <th class="py-3 px-3 text-sm font-vazir text-white/60 font-normal">تعداد بازدید</th>
              <th class="py-3 pl-3 text-sm font-vazir text-white/60 font-normal">بازدیدکنندگان منحصر به فرد</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in analytics.topPosts" :key="post.id" class="text-right border-b border-white/5 hover:bg-white/5">
              <td class="py-4 pr-3">
                <div class="font-vazir text-white text-sm truncate max-w-xs">{{ post.title }}</div>
              </td>
              <td class="py-4 px-3">
                <span class="inline-flex px-2 py-1 bg-primary/10 text-primary text-xs rounded-full font-vazir">
                  {{ post.category?.name || 'بدون دسته‌بندی' }}
                </span>
              </td>
              <td class="py-4 px-3">
                <div class="font-vazir text-white text-sm">{{ post.views_count }}</div>
              </td>
              <td class="py-4 pl-3">
                <div class="font-vazir text-white text-sm">{{ post.unique_visitors_count || 0 }}</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import { Line as LineChart } from 'vue-chartjs'
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js'
import moment from 'moment-jalaali'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend)

// Persian month names
const persianMonths = {
  'Farvardin': 'فروردین',
  'Ordibehesht': 'اردیبهشت',
  'Khordad': 'خرداد',
  'Tir': 'تیر',
  'Mordad': 'مرداد',
  'Shahrivar': 'شهریور',
  'Mehr': 'مهر',
  'Aban': 'آبان',
  'Azar': 'آذر',
  'Dey': 'دی',
  'Bahman': 'بهمن',
  'Esfand': 'اسفند'
}

// Convert English digits to Persian
const toPersianDigits = (str) => {
  const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹']
  return str.toString().replace(/[0-9]/g, (w) => persianDigits[+w])
}

export default {
  name: 'AnalyticsPage',
  components: {
    LineChart
  },
  setup() {
    const loading = ref(true)
    const analytics = ref({})
    const selectedPeriod = ref('week')
    
    const periods = [
      { label: 'امروز', value: 'today' },
      { label: 'هفته', value: 'week' }
    ]
    
    const fetchAnalytics = async () => {
      loading.value = true
      try {
        const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/admin/analytics?period=${selectedPeriod.value}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
          }
        })
        analytics.value = response.data
      } catch (error) {
        console.error('Error fetching analytics:', error)
      } finally {
        loading.value = false
      }
    }
    
    const formatDate = (dateString) => {
      const date = moment(dateString)
      
      switch (selectedPeriod.value) {
        case 'today':
          return `${toPersianDigits(date.format('jHH'))}:${toPersianDigits(date.format('jmm'))}`
        case 'week':
          const day = toPersianDigits(date.format('jD'))
          const month = persianMonths[date.format('jMMMM')]
          return `${day} ${month}`
        case 'month':
          return toPersianDigits(date.format('jD'))
        case 'year':
          return persianMonths[date.format('jMMMM')]
        default:
          return dateString
      }
    }
    
    const chartData = computed(() => {
      const defaultData = {
        labels: [],
        datasets: [
          {
            label: 'بازدیدها',
            data: [],
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'بازدیدکنندگان منحصر به فرد',
            data: [],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
          }
        ]
      }

      if (!analytics.value?.dailyViews?.length) {
        return defaultData
      }
      
      const data = {
        labels: analytics.value.dailyViews.map(item => formatDate(item.date)),
        datasets: [
          {
            label: 'بازدیدها',
            data: analytics.value.dailyViews.map(item => item.views),
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'بازدیدکنندگان منحصر به فرد',
            data: analytics.value.dailyViews.map(item => item.unique_visitors),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
          }
        ]
      }
      
      return data
    })
    
    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
          labels: {
            font: {
              family: 'Vazirmatn'
            },
            color: 'rgba(255, 255, 255, 0.7)'
          }
        },
        tooltip: {
          mode: 'index',
          intersect: false,
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          titleColor: '#fff',
          bodyColor: '#fff',
          borderColor: 'rgba(255, 255, 255, 0.1)',
          borderWidth: 1,
          callbacks: {
            title: (items) => {
              return items[0].label
            },
            label: (context) => {
              const label = context.dataset.label || ''
              const value = context.parsed.y
              return `${label}: ${toPersianDigits(value)}`
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(255, 255, 255, 0.1)'
          },
          ticks: {
            color: 'rgba(255, 255, 255, 0.7)',
            callback: (value) => toPersianDigits(value)
          }
        },
        x: {
          grid: {
            color: 'rgba(255, 255, 255, 0.1)'
          },
          ticks: {
            color: 'rgba(255, 255, 255, 0.7)',
            maxRotation: 45,
            minRotation: 45
          }
        }
      }
    }
    
    const averageDailyViews = computed(() => {
      if (!analytics.value.dailyViews || analytics.value.dailyViews.length === 0) {
        return 0
      }
      
      const totalViews = analytics.value.dailyViews.reduce((sum, item) => sum + item.views, 0)
      return Math.round(totalViews / analytics.value.dailyViews.length)
    })
    
    const averageViewsPerPost = computed(() => {
      if (!analytics.value.topPosts || analytics.value.topPosts.length === 0) {
        return 0
      }
      
      const totalViews = analytics.value.topPosts.reduce((sum, post) => sum + post.views_count, 0)
      return Math.round(totalViews / analytics.value.topPosts.length)
    })
    
    // Watch for changes in selectedPeriod
    watch(selectedPeriod, () => {
      fetchAnalytics()
    })
    
    onMounted(() => {
      fetchAnalytics()
    })
    
    return {
      loading,
      analytics,
      selectedPeriod,
      periods,
      chartData,
      chartOptions,
      averageDailyViews,
      averageViewsPerPost
    }
  }
}
</script> 