<template>
  <PublicLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Katalog Ebook</h1>
        <p class="text-slate-400 text-sm mt-1">
          {{ buku.total }} ebook tersedia
        </p>
      </div>

      <div class="flex flex-col lg:flex-row gap-8">

        <!-- SIDEBAR FILTER (kiri) -->
        <aside class="w-full lg:w-56 flex-shrink-0">

          <!-- Search -->
          <div class="mb-6">
            <form @submit.prevent="applySearch">
              <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input v-model="searchQuery" type="text"
                       placeholder="Cari judul, penulis..."
                       class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm
                              focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
              </div>
            </form>
          </div>

          <!-- Filter Kategori -->
          <div>
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">
              Kategori
            </h3>
            <ul class="space-y-1">
              <li>
                <button @click="selectKategori('')"
                        class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors flex items-center justify-between"
                        :class="filters.kategori === '' ? 'bg-teal-50 text-teal-700 font-medium' : 'text-slate-600 hover:bg-slate-50'">
                  <span>Semua Kategori</span>
                  <span class="text-xs text-slate-400">{{ buku.total }}</span>
                </button>
              </li>
              <li v-for="k in kategoris" :key="k.id">
                <button @click="selectKategori(k.slug)"
                        class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors flex items-center justify-between"
                        :class="filters.kategori === k.slug ? 'bg-teal-50 text-teal-700 font-medium' : 'text-slate-600 hover:bg-slate-50'">
                  <div class="flex items-center gap-2">
                    <DynamicIcon :name="k.icon" class="w-4 h-4" />
                    <span>{{ k.nama }}</span>
                  </div>
                  <span class="text-xs text-slate-400">{{ k.buku_count }}</span>
                </button>
              </li>
            </ul>
          </div>
        </aside>

        <!-- GRID BUKU (kanan) -->
        <div class="flex-1">

          <!-- Active filters -->
          <div v-if="filters.search || filters.kategori"
               class="flex items-center gap-2 mb-5 flex-wrap">
            <span class="text-sm text-slate-500">Filter aktif:</span>
            <span v-if="filters.search"
                  class="inline-flex items-center gap-1 px-3 py-1 bg-teal-50 text-teal-700
                         text-xs rounded-full">
              "{{ filters.search }}"
              <button @click="clearSearch" class="ml-1 hover:text-teal-900">×</button>
            </span>
            <span v-if="filters.kategori"
                  class="inline-flex items-center gap-1 px-3 py-1 bg-teal-50 text-teal-700
                         text-xs rounded-full">
              {{ kategoris.find(k => k.slug === filters.kategori)?.nama }}
              <button @click="selectKategori('')" class="ml-1 hover:text-teal-900">×</button>
            </span>
          </div>

          <!-- Grid -->
          <div v-if="buku.data.length > 0"
               class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
            <BukuCard v-for="item in buku.data" :key="item.id" :buku="item" />
          </div>

          <!-- Empty -->
          <div v-else class="text-center py-20">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
              </svg>
            </div>
            <p class="text-slate-500 font-medium">Buku tidak ditemukan</p>
            <p class="text-slate-400 text-sm mt-1">Coba kata kunci atau kategori lain</p>
          </div>

          <!-- Pagination -->
          <div v-if="buku.last_page > 1"
               class="flex items-center justify-center gap-2 mt-10">
            <Link v-for="link in buku.links" :key="link.label"
                  :href="link.url || '#'"
                  :class="[
                    'px-3 py-2 text-sm rounded-lg transition-colors',
                    link.active ? 'bg-teal-600 text-white font-medium' : 'text-slate-600 hover:bg-slate-100',
                    !link.url ? 'opacity-40 cursor-not-allowed' : ''
                  ]"
                  v-html="link.label" />
          </div>

        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BukuCard from '@/Components/BukuCard.vue'
import DynamicIcon from '@/Components/DynamicIcon.vue'

const props = defineProps({
  buku: Object,
  kategoris: Array,
  filters: Object,
})

const searchQuery = ref(props.filters.search || '')

const applySearch = () => {
  router.get(route('katalog'), {
    search: searchQuery.value,
    kategori: props.filters.kategori,
  }, { preserveState: true, replace: true })
}

const selectKategori = (slug) => {
  router.get(route('katalog'), {
    search: props.filters.search,
    kategori: slug,
  }, { preserveState: true, replace: true })
}

const clearSearch = () => {
  searchQuery.value = ''
  applySearch()
}
</script>
