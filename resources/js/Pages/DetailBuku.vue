<template>
  <PublicLayout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
        <Link :href="route('landing')" class="hover:text-teal-600">Beranda</Link>
        <span>/</span>
        <Link :href="route('katalog')" class="hover:text-teal-600">Katalog</Link>
        <span>/</span>
        <span class="text-slate-600 truncate max-w-xs">{{ buku.judul }}</span>
      </nav>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- KOLOM KIRI: Cover + CTA -->
        <div class="md:col-span-1">

          <!-- Cover -->
          <div class="rounded-2xl overflow-hidden shadow-xl aspect-[3/4] bg-slate-100 mb-5">
            <img :src="buku.cover_url" :alt="buku.judul"
                 class="w-full h-full object-cover">
          </div>

          <!-- CTA Buttons -->
          <div class="space-y-3">

            <!-- Sudah login: tombol baca -->
            <Link v-if="sudahLogin"
                  :href="route('reader.show', buku.slug)"
                  class="flex items-center justify-center gap-2 w-full py-3 bg-teal-600
                         hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
              </svg>
              Baca Sekarang
            </Link>

            <!-- Belum login: tombol ke login -->
            <Link v-else
                  :href="route('login')"
                  class="flex items-center justify-center gap-2 w-full py-3 bg-teal-600
                         hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors">
              Masuk untuk Membaca
            </Link>

            <!-- Tombol rak buku (hanya jika sudah login) -->
            <button v-if="sudahLogin"
                    @click="toggleRak"
                    :disabled="rakLoading"
                    class="flex items-center justify-center gap-2 w-full py-3 border-2
                           font-semibold rounded-xl transition-colors"
                    :class="diRak
                      ? 'border-teal-600 text-teal-600 hover:bg-teal-50'
                      : 'border-slate-200 text-slate-600 hover:border-teal-300 hover:text-teal-600'">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
              </svg>
              {{ diRak ? 'Tersimpan di Rak' : 'Simpan ke Rak' }}
            </button>

          </div>
        </div>

        <!-- KOLOM KANAN: Info detail -->
        <div class="md:col-span-2">

          <!-- Kategori badge -->
          <span v-if="buku.kategori"
                class="inline-block bg-teal-50 text-teal-700 text-xs font-medium
                       px-3 py-1 rounded-full mb-3">
            {{ buku.kategori }}
          </span>

          <!-- Judul -->
          <h1 class="text-3xl font-bold text-slate-900 leading-tight mb-2">
            {{ buku.judul }}
          </h1>

          <!-- Penulis -->
          <p class="text-slate-500 text-base mb-6">
            oleh <span class="font-medium text-slate-700">{{ buku.penulis || 'Tidak diketahui' }}</span>
          </p>

          <!-- Stats row -->
          <div class="flex items-center gap-6 py-4 border-y border-slate-100 mb-6">
            <div class="text-center">
              <p class="text-lg font-bold text-slate-800">{{ buku.halaman || '-' }}</p>
              <p class="text-xs text-slate-400 mt-0.5">Halaman</p>
            </div>
            <div class="w-px h-8 bg-slate-200"></div>
            <div class="text-center">
              <p class="text-lg font-bold text-slate-800">PDF</p>
              <p class="text-xs text-slate-400 mt-0.5">Format</p>
            </div>
            <div class="w-px h-8 bg-slate-200"></div>
            <div class="text-center">
              <p class="text-lg font-bold text-teal-600">Gratis</p>
              <p class="text-xs text-slate-400 mt-0.5">Akses</p>
            </div>
          </div>

          <!-- Deskripsi -->
          <div v-if="buku.deskripsi" class="mb-8">
            <h2 class="text-base font-semibold text-slate-800 mb-3">Tentang Buku</h2>
            <p class="text-slate-500 leading-relaxed text-sm whitespace-pre-line">
              {{ buku.deskripsi }}
            </p>
          </div>

          <!-- Info tidak login -->
          <div v-if="!sudahLogin"
               class="bg-teal-50 border border-teal-100 rounded-xl p-5 mt-4">
            <p class="text-teal-800 font-medium text-sm mb-1">
              Daftar gratis untuk membaca buku ini
            </p>
            <p class="text-teal-600 text-xs">
              Akses ribuan ebook tanpa biaya, kapan saja dan di mana saja.
            </p>
            <div class="flex gap-2 mt-3">
              <Link :href="route('register')"
                    class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700">
                Daftar Gratis
              </Link>
              <Link :href="route('login')"
                    class="px-4 py-2 border border-teal-200 text-teal-700 text-sm font-medium rounded-lg hover:bg-white">
                Sudah Punya Akun
              </Link>
            </div>
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

const props = defineProps({
  buku: Object,
  diRak: Boolean,
  sudahLogin: Boolean,
})

const rakLoading = ref(false)
const isdiRak = ref(props.diRak)

const toggleRak = () => {
  rakLoading.value = true
  router.post(route('rak-buku.toggle', props.buku.slug), {}, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (page) => {
      isdiRak.value = !isdiRak.value
      rakLoading.value = false
    },
    onError: () => { rakLoading.value = false }
  })
}
</script>
