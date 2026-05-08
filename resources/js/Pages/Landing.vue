<template>
  <PublicLayout>

    <!-- HERO SECTION -->
    <section class="bg-gradient-to-br from-teal-50 via-white to-white py-16 lg:py-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

          <!-- Teks kiri -->
          <div>
            <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold
                         px-3 py-1.5 rounded-full mb-4 tracking-wide uppercase">
              Platform Ebook Digital Gratis
            </span>
            <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight mb-4">
              Baca. Belajar.<br>
              <span class="text-teal-600">Kapan saja, di mana saja.</span>
            </h1>
            <p class="text-slate-500 text-lg leading-relaxed mb-8 max-w-lg">
              Ribuan ebook berkualitas untuk menambah ilmu, mengembangkan diri,
              dan menginspirasi hidupmu. Gratis, tanpa syarat.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-wrap gap-3 mb-10">
              <Link :href="route('katalog')"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600
                           hover:bg-teal-700 text-white font-semibold rounded-xl
                           transition-colors shadow-sm shadow-teal-200">
                Jelajahi Koleksi
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
              </Link>
              <Link :href="route('katalog')"
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-slate-200
                           text-slate-700 font-semibold rounded-xl hover:border-teal-300
                           hover:text-teal-600 transition-colors">
                Lihat Kategori
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
              </Link>
            </div>

            <!-- Stats -->
            <div class="flex items-center gap-8">
              <div>
                <p class="text-2xl font-bold text-slate-800">{{ totalBuku.toLocaleString('id') }}+</p>
                <p class="text-sm text-slate-400 mt-0.5">Koleksi Ebook</p>
              </div>
              <div class="w-px h-10 bg-slate-200"></div>
              <div>
                <p class="text-2xl font-bold text-slate-800">{{ totalKategori }}+</p>
                <p class="text-sm text-slate-400 mt-0.5">Kategori</p>
              </div>
              <div class="w-px h-10 bg-slate-200"></div>
              <div>
                <p class="text-2xl font-bold text-slate-800">100%</p>
                <p class="text-sm text-slate-400 mt-0.5">Gratis</p>
              </div>
            </div>
          </div>

          <!-- Visual kanan: grid cover buku -->
          <div class="hidden lg:block">
            <div class="grid grid-cols-3 gap-3">
              <template v-for="(buku, i) in bukuTerbaru.slice(0, 6)" :key="buku.id">
                <Link :href="route('buku.show', buku.slug)"
                      class="group block rounded-xl overflow-hidden shadow-md
                             hover:shadow-xl transition-all duration-300"
                      :class="i === 0 || i === 4 ? 'mt-6' : ''">
                  <img :src="buku.cover_url" :alt="buku.judul"
                       class="w-full aspect-[3/4] object-cover
                              group-hover:scale-105 transition-transform duration-300">
                </Link>
              </template>
              <!-- Placeholder jika buku kurang dari 6 -->
              <template v-for="i in Math.max(0, 6 - bukuTerbaru.length)" :key="'ph-' + i">
                <div class="rounded-xl overflow-hidden bg-slate-100 aspect-[3/4]"></div>
              </template>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- FITUR UNGGULAN -->
    <section class="py-8 border-y border-slate-100 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
              </svg>
            </div>
            <div>
              <p class="font-semibold text-slate-800 text-sm">Koleksi Lengkap</p>
              <p class="text-slate-400 text-xs mt-0.5">Berbagai genre dan kategori</p>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
              </svg>
            </div>
            <div>
              <p class="font-semibold text-slate-800 text-sm">Aman & Terpercaya</p>
              <p class="text-slate-400 text-xs mt-0.5">Konten terverifikasi</p>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
              </svg>
            </div>
            <div>
              <p class="font-semibold text-slate-800 text-sm">Baca Instan</p>
              <p class="text-slate-400 text-xs mt-0.5">Langsung di browser</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- KATEGORI POPULER -->
    <section class="py-14 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="text-2xl font-bold text-slate-900">Kategori Populer</h2>
            <p class="text-slate-400 text-sm mt-1">Temukan buku sesuai minatmu</p>
          </div>
          <Link :href="route('katalog')"
                class="text-teal-600 text-sm font-medium hover:underline flex items-center gap-1">
            Lihat semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </Link>
        </div>

        <!-- Kategori pills/cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
          <Link v-for="kategori in kategoris" :key="kategori.id"
                :href="route('katalog', { kategori: kategori.slug })"
                class="flex flex-col items-center gap-2 p-3 rounded-xl border border-slate-100
                       hover:border-teal-200 hover:bg-teal-50 transition-all group text-center">
            <!-- Icon placeholder berdasarkan nama kategori -->
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 :class="getCategoryColor(kategori.nama)">
              <DynamicIcon :name="kategori.icon || 'book-open'"
                           class="w-5 h-5"/>
            </div>
            <span class="text-xs font-medium text-slate-600 group-hover:text-teal-700 leading-tight">
              {{ kategori.nama }}
            </span>
            <span class="text-xs text-slate-400">{{ kategori.buku_count }} buku</span>
          </Link>
        </div>
      </div>
    </section>

    <!-- BUKU TERBARU -->
    <section class="py-14 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="text-2xl font-bold text-slate-900">Pilihan Terbaru</h2>
            <p class="text-slate-400 text-sm mt-1">Ebook yang baru saja ditambahkan</p>
          </div>
          <Link :href="route('katalog')"
                class="text-teal-600 text-sm font-medium hover:underline flex items-center gap-1">
            Lihat semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </Link>
        </div>

        <div v-if="bukuTerbaru.length > 0"
             class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
          <BukuCard v-for="buku in bukuTerbaru" :key="buku.id" :buku="buku" />
        </div>

        <div v-else class="text-center py-16">
          <p class="text-slate-400">Belum ada buku tersedia</p>
          <p class="text-slate-300 text-sm mt-1">Admin sedang menambahkan koleksi</p>
        </div>
      </div>
    </section>

    <!-- CTA BANNER -->
    <section class="pt-36 pb-14 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Wrapper dengan overflow visible agar ilustrasi bisa keluar -->
        <div class="relative">

          <!-- Card CTA -->
          <div class="bg-gradient-to-r from-teal-600 to-teal-500 rounded-2xl
                      overflow-visible relative min-h-[180px] md:min-h-[200px]">

            <!-- Background decorative -->
            <div class="absolute inset-0 rounded-2xl overflow-hidden pointer-events-none">
              <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full
                          -translate-y-1/2 translate-x-1/4"></div>
              <div class="absolute bottom-0 left-1/3 w-40 h-40 bg-white/5 rounded-full
                          translate-y-1/2"></div>
              <div class="absolute top-1/2 left-1/2 w-24 h-24 bg-white/5 rounded-full
                          -translate-x-1/2 -translate-y-1/2"></div>
            </div>

            <!-- Konten: teks + tombol -->
            <div class="flex flex-col md:flex-row items-center justify-between
                        px-6 md:pl-72 md:pr-12
                        pt-28 pb-8 md:py-12 gap-6 relative z-10">

              <!-- Teks -->
              <div class="text-white text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold mb-2 leading-tight">
                  Mulai Membaca<br class="hidden md:block"> Sekarang
                </h2>
                <p class="text-teal-100 text-sm md:text-base mt-2">
                  Daftar gratis dan akses ribuan ebook<br class="hidden md:block">
                  tanpa batas. Baca kapan saja.
                </p>
              </div>

              <!-- Tombol -->
              <div class="flex-shrink-0 md:ml-6">
                <Link v-if="!$page.props.auth.user"
                      :href="route('register')"
                      class="inline-flex items-center gap-2 px-5 md:px-7 py-3
                             bg-white text-teal-700 font-semibold rounded-xl
                             hover:bg-teal-50 transition-colors shadow-sm
                             whitespace-nowrap text-sm md:text-base">
                  Daftar Gratis →
                </Link>
                <Link v-else
                      :href="route('katalog')"
                      class="inline-flex items-center gap-2 px-5 md:px-7 py-3
                             bg-white text-teal-700 font-semibold rounded-xl
                             hover:bg-teal-50 transition-colors shadow-sm
                             whitespace-nowrap text-sm md:text-base">
                  Jelajahi Koleksi →
                </Link>
              </div>
            </div>

            <!-- Ilustrasi: absolute, sebagian keluar ke atas dari card -->
            <div class="absolute left-1/2 md:left-8 top-0 md:top-auto md:bottom-0 z-20
                        -translate-x-1/2 md:translate-x-0 -translate-y-[40%] md:-translate-y-12
                        pointer-events-none select-none">
              <img src="/images/book.png"
                   alt="Ilustrasi membaca"
                   class="w-40 md:w-64 h-auto object-contain drop-shadow-2xl">
            </div>

          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import BukuCard from '@/Components/BukuCard.vue'
import DynamicIcon from '@/Components/DynamicIcon.vue'

const props = defineProps({
  bukuTerbaru: Array,
  kategoris: Array,
  totalBuku: Number,
  totalKategori: Number,
})

const categoryColors = [
  'bg-teal-100 text-teal-600',
  'bg-blue-100 text-blue-600',
  'bg-amber-100 text-amber-600',
  'bg-purple-100 text-purple-600',
  'bg-pink-100 text-pink-600',
  'bg-green-100 text-green-600',
  'bg-orange-100 text-orange-600',
  'bg-indigo-100 text-indigo-600',
]

const getCategoryColor = (nama) => {
  const idx = props.kategoris
    ? props.kategoris.findIndex(k => k.nama === nama)
    : 0
  return categoryColors[Math.abs(idx) % categoryColors.length]
}
</script>
