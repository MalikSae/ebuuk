<template>
  <Link :href="route('buku.show', buku.slug)"
        class="group bg-white rounded-xl border border-slate-100 shadow-sm
               hover:shadow-md transition-all duration-200 overflow-hidden block">

    <!-- Cover -->
    <div class="aspect-[3/4] overflow-hidden bg-slate-100">
      <img :src="buku.cover_url || '/images/cover-default.svg'"
           :alt="buku.judul"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>

    <!-- Info -->
    <div class="p-3">
      <p class="font-semibold text-slate-800 text-sm leading-tight line-clamp-2">
        {{ buku.judul }}
      </p>
      <p class="text-slate-400 text-xs mt-1 truncate">
        {{ buku.penulis || 'Penulis tidak diketahui' }}
      </p>
      <span v-if="buku.kategori"
            class="inline-block mt-2 text-xs px-2 py-0.5 bg-teal-50 text-teal-700 rounded-full">
        {{ buku.kategori }}
      </span>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ buku: Object })
</script>
