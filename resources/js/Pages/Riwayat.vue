<template>
  <PublicLayout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Riwayat Bacaan</h1>
        <p class="text-slate-400 text-sm mt-1">
          {{ riwayat.length }} buku pernah dibaca
        </p>
      </div>

      <!-- List riwayat -->
      <div v-if="riwayat.length > 0" class="space-y-4">
        <div v-for="item in riwayat" :key="item.id"
             class="bg-white rounded-xl border border-slate-100 shadow-sm
                    p-4 flex items-center gap-4 hover:shadow-md transition-shadow">

          <!-- Cover -->
          <Link :href="route('buku.show', item.slug)" class="flex-shrink-0">
            <img :src="item.cover_url" :alt="item.judul"
                 class="w-14 h-20 object-cover rounded-lg shadow-sm">
          </Link>

          <!-- Info -->
          <div class="flex-1 min-w-0">
            <Link :href="route('buku.show', item.slug)">
              <h3 class="font-semibold text-slate-800 hover:text-teal-600
                         transition-colors line-clamp-1">
                {{ item.judul }}
              </h3>
            </Link>
            <p class="text-slate-400 text-sm mt-0.5">
              {{ item.penulis || 'Penulis tidak diketahui' }}
            </p>

            <!-- Progress bar -->
            <div class="mt-3">
              <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                <span>Halaman {{ item.halaman_terakhir }}
                  {{ item.halaman_total ? '/ ' + item.halaman_total : '' }}
                </span>
                <span v-if="item.halaman_total">
                  {{ Math.round(item.halaman_terakhir / item.halaman_total * 100) }}%
                </span>
              </div>
              <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-teal-500 rounded-full transition-all"
                     :style="{
                       width: item.halaman_total
                         ? Math.min(item.halaman_terakhir / item.halaman_total * 100, 100) + '%'
                         : '0%'
                     }">
                </div>
              </div>
            </div>

            <p class="text-xs text-slate-300 mt-2">
              Terakhir dibaca {{ item.updated_at }}
            </p>
          </div>

          <!-- Tombol lanjut baca -->
          <div class="flex-shrink-0">
            <Link :href="route('reader.show', item.slug)"
                  class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600
                         hover:bg-teal-700 text-white text-sm font-medium
                         rounded-lg transition-colors">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
              Lanjut Baca
            </Link>
          </div>

        </div>
      </div>

      <!-- Empty state -->
      <div v-else class="text-center py-20">
        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
          <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
          </svg>
        </div>
        <h3 class="text-slate-600 font-semibold text-lg mb-2">Belum ada riwayat</h3>
        <p class="text-slate-400 text-sm mb-6">Mulai membaca dan riwayatmu akan muncul di sini</p>
        <Link :href="route('katalog')"
              class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600
                     hover:bg-teal-700 text-white font-medium rounded-xl transition-colors">
          Mulai Membaca
        </Link>
      </div>

    </div>
  </PublicLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineProps({ riwayat: Array })
</script>
