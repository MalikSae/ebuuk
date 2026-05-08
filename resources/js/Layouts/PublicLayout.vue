<template>
  <div class="min-h-screen flex flex-col bg-white" style="font-family: 'Inter', sans-serif;">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white border-b border-slate-100 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

          <!-- Logo -->
          <Link :href="route('landing')" class="flex items-center">
            <img src="/images/logo_ebuuk_light.png"
                 alt="ebuuk.id" class="h-8 w-auto">
          </Link>

          <!-- Menu tengah -->
          <div class="hidden md:flex items-center gap-1">
            <Link :href="route('landing')"
                  class="px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                  :class="isActive('landing') ? 'text-teal-600 bg-teal-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
              Beranda
            </Link>
            <Link :href="route('katalog')"
                  class="px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                  :class="isActive('katalog') ? 'text-teal-600 bg-teal-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
              Katalog
            </Link>
            <template v-if="$page.props.auth.user">
              <Link :href="route('rak-buku.index')"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                    :class="isActive('rak-buku.index') ? 'text-teal-600 bg-teal-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
                Rak Buku
              </Link>
              <Link :href="route('riwayat.index')"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                    :class="isActive('riwayat.index') ? 'text-teal-600 bg-teal-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
                Riwayat
              </Link>
            </template>
          </div>

          <!-- Kanan: Auth buttons -->
          <div class="flex items-center gap-3">
            <template v-if="$page.props.auth.user">
              <!-- User dropdown -->
              <div class="relative" ref="dropdownRef">
                <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg
                               hover:bg-slate-50 transition-colors">
                  <div class="w-7 h-7 rounded-full overflow-hidden bg-teal-100 flex items-center justify-center flex-shrink-0">
                    <img v-if="$page.props.auth.user?.avatar && $page.props.auth.user?.gender"
                         :src="`/images/${$page.props.auth.user.gender === 'laki-laki' ? 'man' : 'woman'}/${$page.props.auth.user.avatar}.png`"
                         class="w-full h-full object-contain">
                    <span v-else class="text-teal-700 font-semibold text-xs">
                      {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                    </span>
                  </div>
                  <span class="text-sm font-medium text-slate-700 hidden sm:block">
                    {{ $page.props.auth.user.name }}
                  </span>
                  <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>

                <!-- Dropdown menu -->
                <div v-if="dropdownOpen"
                     class="absolute right-0 top-full mt-1 w-48 bg-white rounded-xl
                            shadow-lg border border-slate-100 py-1 z-50">
                  <Link :href="route('profil.index')"
                        class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600
                               hover:bg-slate-50 hover:text-slate-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    Profil Saya
                  </Link>
                  <Link :href="route('rak-buku.index')"
                        class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600
                               hover:bg-slate-50 hover:text-slate-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                    </svg>
                    Rak Buku
                  </Link>
                  <div class="border-t border-slate-100 my-1"></div>
                  <Link :href="route('logout')" method="post" as="button"
                        class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-500
                               hover:bg-red-50 w-full text-left">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Keluar
                  </Link>
                </div>
              </div>
            </template>

            <template v-else>
              <Link :href="route('login')"
                    class="px-4 py-2 text-sm font-medium text-slate-600
                           hover:text-slate-900 transition-colors">
                Masuk
              </Link>
              <Link :href="route('register')"
                    class="px-4 py-2 text-sm font-semibold text-white bg-teal-600
                           hover:bg-teal-700 rounded-lg transition-colors">
                Daftar
              </Link>
            </template>
          </div>

        </div>
      </div>
    </nav>

    <!-- KONTEN -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-white mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

          <!-- Brand -->
          <div class="md:col-span-1">
            <img src="/images/logo_ebuuk_dark.png"
                 alt="ebuuk.id"
                 class="h-8 w-auto mb-4">
            <p class="text-slate-400 text-sm leading-relaxed">
              Platform baca buku digital. Ringan, aman, dan nyaman untuk semua.
            </p>
            <p class="text-teal-400 text-sm font-medium mt-2">
              Baca. Belajar. Bertumbuh.
            </p>
          </div>

          <!-- Jelajahi -->
          <div>
            <h4 class="font-semibold text-white mb-4 text-sm">Jelajahi</h4>
            <ul class="space-y-2">
              <li><Link :href="route('landing')" class="text-slate-400 text-sm hover:text-white transition-colors">Beranda</Link></li>
              <li><Link :href="route('katalog')" class="text-slate-400 text-sm hover:text-white transition-colors">Katalog</Link></li>
            </ul>
          </div>

          <!-- Akun -->
          <div>
            <h4 class="font-semibold text-white mb-4 text-sm">Akun</h4>
            <ul class="space-y-2">
              <template v-if="$page.props.auth.user">
                <li><Link :href="route('profil.index')" class="text-slate-400 text-sm hover:text-white transition-colors">Profil</Link></li>
                <li><Link :href="route('rak-buku.index')" class="text-slate-400 text-sm hover:text-white transition-colors">Rak Buku</Link></li>
                <li><Link :href="route('riwayat.index')" class="text-slate-400 text-sm hover:text-white transition-colors">Riwayat</Link></li>
              </template>
              <template v-else>
                <li><Link :href="route('login')" class="text-slate-400 text-sm hover:text-white transition-colors">Masuk</Link></li>
                <li><Link :href="route('register')" class="text-slate-400 text-sm hover:text-white transition-colors">Daftar</Link></li>
              </template>
            </ul>
          </div>

          <!-- Info -->
          <div>
            <h4 class="font-semibold text-white mb-4 text-sm">Info</h4>
            <ul class="space-y-2">
              <li><span class="text-slate-400 text-sm">ebuuk.id</span></li>
              <li><span class="text-slate-400 text-sm">Indonesia</span></li>
            </ul>
          </div>

        </div>

        <!-- Copyright -->
        <div class="border-t border-slate-800 mt-10 pt-6 flex flex-col sm:flex-row
                    items-center justify-between gap-4">
          <p class="text-slate-500 text-sm">
            © {{ new Date().getFullYear() }} ebuuk.id. Semua hak dilindungi.
          </p>
          <p class="text-slate-500 text-sm">
            Dibuat dengan ❤️ untuk pengalaman membaca terbaik.
          </p>
        </div>
      </div>
    </footer>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const dropdownOpen = ref(false)
const dropdownRef = ref(null)

const isActive = (routeName) => {
  try {
    return route().current(routeName)
  } catch {
    return false
  }
}

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    dropdownOpen.value = false
  }
}

onMounted(() => document.addEventListener('click', handleClickOutside))
onUnmounted(() => document.removeEventListener('click', handleClickOutside))
</script>
