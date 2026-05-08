<template>
  <PublicLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Rak Buku</h1>
        <p class="text-slate-400 text-sm mt-1">
          {{ rakBuku.length }} buku tersimpan
        </p>
      </div>

      <!-- Grid buku -->
      <div v-if="rakBuku.length > 0"
           class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        <div v-for="item in rakBuku" :key="item.id" class="group relative">

          <!-- Card buku -->
          <Link :href="route('buku.show', item.slug)"
                class="block rounded-xl overflow-hidden border border-slate-100
                       shadow-sm hover:shadow-md transition-all duration-200">
            <div class="aspect-[3/4] bg-slate-100 overflow-hidden">
              <img :src="item.cover_url" :alt="item.judul"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            <div class="p-3 bg-white">
              <p class="text-sm font-semibold text-slate-800 line-clamp-2 leading-tight">
                {{ item.judul }}
              </p>
              <p class="text-xs text-slate-400 mt-1 truncate">
                {{ item.penulis || 'Penulis tidak diketahui' }}
              </p>
            </div>
          </Link>

          <!-- Tombol hapus dari rak -->
          <button @click="hapusDariRak(item.slug)"
                  class="absolute top-2 right-2 w-7 h-7 bg-white rounded-full shadow-md
                         flex items-center justify-center text-red-400 hover:text-red-600
                         hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>

          <!-- Tombol baca -->
          <Link :href="route('reader.show', item.slug)"
                class="mt-2 flex items-center justify-center gap-1.5 w-full py-2
                       bg-teal-600 hover:bg-teal-700 text-white text-xs font-medium
                       rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            Baca
          </Link>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else class="text-center py-20">
        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
          <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
          </svg>
        </div>
        <h3 class="text-slate-600 font-semibold text-lg mb-2">Rak buku masih kosong</h3>
        <p class="text-slate-400 text-sm mb-6">Simpan buku favoritmu agar mudah ditemukan</p>
        <Link :href="route('katalog')"
              class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600
                     hover:bg-teal-700 text-white font-medium rounded-xl transition-colors">
          Jelajahi Katalog
        </Link>
      </div>

    </div>
  </PublicLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineProps({ rakBuku: Array })

const hapusDariRak = (slug) => {
  router.post(route('rak-buku.toggle', slug), {}, {
    preserveState: true,
    preserveScroll: true,
  })
}
</script>
