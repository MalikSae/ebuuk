<template>
  <div>
    <!-- Preview icon terpilih + tombol buka picker -->
    <div class="flex items-center gap-3 mb-3">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center"
           :class="previewBg">
        <DynamicIcon :name="modelValue || 'book-open'"
                     class="w-6 h-6" :class="previewColor"/>
      </div>
      <div>
        <p class="text-sm font-medium text-slate-700">{{ modelValue || 'book-open' }}</p>
        <button type="button" @click="open = !open"
                class="text-xs text-teal-600 hover:underline mt-0.5">
          {{ open ? 'Tutup picker' : 'Ganti icon' }}
        </button>
      </div>
    </div>

    <!-- Icon picker panel -->
    <div v-if="open"
         class="border border-slate-200 rounded-xl p-4 bg-slate-50">

      <!-- Search -->
      <input v-model="search" type="text"
             placeholder="Cari icon..."
             class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm
                    focus:outline-none focus:ring-2 focus:ring-teal-500 mb-3 bg-white">

      <!-- Grid icon -->
      <div class="grid grid-cols-8 gap-1.5 max-h-48 overflow-y-auto pr-1">
        <button v-for="(path, name) in filteredIcons" :key="name"
                type="button"
                @click="selectIcon(name)"
                :title="name"
                class="flex flex-col items-center gap-1 p-2 rounded-lg
                       transition-all hover:bg-white hover:shadow-sm"
                :class="modelValue === name
                  ? 'bg-teal-50 ring-2 ring-teal-500'
                  : 'bg-transparent'">
          <DynamicIcon :name="name" class="w-5 h-5"
                       :class="modelValue === name ? 'text-teal-600' : 'text-slate-500'"/>
        </button>
      </div>

      <!-- Nama icon terpilih -->
      <p class="text-xs text-slate-400 mt-2 text-center">
        {{ modelValue || 'Pilih icon' }}
      </p>
    </div>

    <!-- Hidden input untuk form -->
    <input type="hidden" :name="inputName" :value="modelValue">
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import DynamicIcon from '@/Components/DynamicIcon.vue'

const props = defineProps({
  modelValue: { type: String, default: 'book-open' },
  inputName: { type: String, default: 'icon' },
})

const emit = defineEmits(['update:modelValue'])

const open = ref(false)
const search = ref('')

// Semua icon tersedia (nama saja)
const allIcons = [
  'book-open', 'book-closed', 'document-text', 'newspaper', 'pencil-square',
  'user', 'users', 'heart', 'face-smile',
  'academic-cap', 'light-bulb', 'beaker', 'globe-alt',
  'computer-desktop', 'device-phone-mobile', 'cpu-chip', 'code-bracket',
  'banknotes', 'chart-bar', 'briefcase',
  'shield-check', 'sparkles', 'sun',
  'paint-brush', 'musical-note', 'film', 'camera',
  'globe-americas', 'leaf',
  'moon', 'star',
  'tag', 'folder', 'home', 'rocket-launch', 'map', 'trophy',
]

const filteredIcons = computed(() => {
  if (!search.value) return allIcons
  return allIcons.filter(name => name.includes(search.value.toLowerCase()))
})

const previewBg = computed(() => {
  const colors = ['bg-teal-100', 'bg-blue-100', 'bg-amber-100', 'bg-purple-100',
                  'bg-pink-100', 'bg-green-100', 'bg-orange-100', 'bg-indigo-100']
  const idx = allIcons.indexOf(props.modelValue) % colors.length
  return colors[Math.max(0, idx)]
})

const previewColor = computed(() => {
  const colors = ['text-teal-600', 'text-blue-600', 'text-amber-600', 'text-purple-600',
                  'text-pink-600', 'text-green-600', 'text-orange-600', 'text-indigo-600']
  const idx = allIcons.indexOf(props.modelValue) % colors.length
  return colors[Math.max(0, idx)]
})

const selectIcon = (name) => {
  emit('update:modelValue', name)
  open.value = false
  search.value = ''
}
</script>
