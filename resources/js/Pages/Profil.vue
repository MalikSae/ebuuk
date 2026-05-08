<template>
  <PublicLayout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Profil Saya</h1>
        <p class="text-slate-400 text-sm mt-1">Kelola informasi akun kamu</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- KOLOM KIRI: Info + Stats -->
        <div class="md:col-span-1 space-y-5">

          <!-- Card profil -->
          <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6 text-center">
            <img v-if="user.avatar && user.gender"
                 :src="`/images/${user.gender === 'laki-laki' ? 'man' : 'woman'}/${user.avatar}.png`"
                 class="w-16 h-16 object-contain rounded-full mx-auto mb-3">
            <div v-else
                 class="w-16 h-16 rounded-full bg-teal-100 flex items-center
                        justify-center mx-auto mb-3 overflow-hidden">
              <span class="text-teal-700 font-bold text-2xl">
                {{ user.name.charAt(0).toUpperCase() }}
              </span>
            </div>
            <h2 class="font-semibold text-slate-800 text-lg">{{ user.name }}</h2>
            <p class="text-slate-400 text-sm mt-0.5">{{ user.email }}</p>
            <p class="text-xs text-slate-300 mt-3">
              Bergabung {{ user.created_at }}
            </p>
          </div>

          <!-- Stats card -->
          <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-4">Statistik</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <div class="w-7 h-7 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                  </div>
                  <span class="text-sm text-slate-600">Buku Dibaca</span>
                </div>
                <span class="font-bold text-slate-800">{{ stats.totalDibaca }}</span>
              </div>
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                    </svg>
                  </div>
                  <span class="text-sm text-slate-600">Rak Buku</span>
                </div>
                <span class="font-bold text-slate-800">{{ stats.totalRak }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- KOLOM KANAN: Form edit -->
        <div class="md:col-span-2 space-y-5">

          <!-- Flash success -->
          <div v-if="$page.props.flash?.success"
               class="bg-green-50 border border-green-200 text-green-700
                      rounded-xl px-4 py-3 text-sm">
            {{ $page.props.flash.success }}
          </div>

          <!-- Form info akun -->
          <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-semibold text-slate-800 mb-5">Informasi Akun</h3>
            <form @submit.prevent="updateProfil">
              <div class="space-y-4">
                <!-- Gender selector -->
                <div class="mb-5">
                  <label class="block text-sm font-medium text-slate-700 mb-2">
                    Jenis Kelamin
                  </label>
                  <div class="flex gap-3">
                    <button type="button"
                            @click="profilForm.gender = 'laki-laki'; profilForm.avatar = ''"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg border-2
                                   text-sm font-medium transition-all"
                            :class="profilForm.gender === 'laki-laki'
                              ? 'border-teal-500 bg-teal-50 text-teal-700'
                              : 'border-slate-200 text-slate-500 hover:border-slate-300'">
                      <img src="/images/man/001-man.png" class="w-6 h-6 object-contain">
                      Laki-laki
                    </button>
                    <button type="button"
                            @click="profilForm.gender = 'perempuan'; profilForm.avatar = ''"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg border-2
                                   text-sm font-medium transition-all"
                            :class="profilForm.gender === 'perempuan'
                              ? 'border-teal-500 bg-teal-50 text-teal-700'
                              : 'border-slate-200 text-slate-500 hover:border-slate-300'">
                      <img src="/images/woman/003-woman.png" class="w-6 h-6 object-contain">
                      Perempuan
                    </button>
                  </div>
                </div>

                <!-- Avatar grid -->
                <div v-if="profilForm.gender" class="mb-5">
                  <label class="block text-sm font-medium text-slate-700 mb-2">
                    Pilih Avatar
                  </label>
                  <div class="grid grid-cols-5 gap-2">
                    <button type="button"
                            v-for="av in profilForm.gender === 'laki-laki' ? manAvatars : womanAvatars"
                            :key="av"
                            @click="profilForm.avatar = av"
                            class="relative rounded-xl p-1 border-2 transition-all hover:border-teal-300"
                            :class="profilForm.avatar === av
                              ? 'border-teal-500 bg-teal-50'
                              : 'border-transparent'">
                      <img :src="`/images/${profilForm.gender === 'laki-laki' ? 'man' : 'woman'}/${av}.png`"
                           class="w-full aspect-square object-contain rounded-lg">
                      <div v-if="profilForm.avatar === av"
                           class="absolute -top-1 -right-1 w-4 h-4 bg-teal-500 rounded-full
                                  flex items-center justify-center shadow">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                      </div>
                    </button>
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nama Lengkap
                  </label>
                  <input v-model="profilForm.name" type="text" required
                         class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                                text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                                focus:border-transparent">
                  <p v-if="profilErrors.name" class="text-red-500 text-xs mt-1">
                    {{ profilErrors.name }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                  <input v-model="profilForm.email" type="email" required
                         class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                                text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                                focus:border-transparent">
                  <p v-if="profilErrors.email" class="text-red-500 text-xs mt-1">
                    {{ profilErrors.email }}
                  </p>
                </div>
              </div>
              <div class="flex justify-end mt-5 pt-4 border-t border-slate-100">
                <button type="submit" :disabled="profilForm.processing"
                        class="px-5 py-2 bg-teal-600 hover:bg-teal-700 disabled:opacity-50
                               text-white text-sm font-medium rounded-lg transition-colors">
                  {{ profilForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
              </div>
            </form>
          </div>

          <!-- Form ubah password -->
          <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-semibold text-slate-800 mb-1">Ubah Password</h3>
            <p class="text-slate-400 text-xs mb-5">Minimal 8 karakter</p>
            <form @submit.prevent="updatePassword">
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Password Saat Ini
                  </label>
                  <input v-model="passwordForm.password_lama" type="password" required
                         class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                                text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                                focus:border-transparent"
                         placeholder="••••••••">
                  <p v-if="passwordErrors.password_lama" class="text-red-500 text-xs mt-1">
                    {{ passwordErrors.password_lama }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Password Baru
                  </label>
                  <input v-model="passwordForm.password_baru" type="password" required
                         class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                                text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                                focus:border-transparent"
                         placeholder="••••••••">
                  <p v-if="passwordErrors.password_baru" class="text-red-500 text-xs mt-1">
                    {{ passwordErrors.password_baru }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Konfirmasi Password Baru
                  </label>
                  <input v-model="passwordForm.password_baru_confirmation" type="password" required
                         class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                                text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                                focus:border-transparent"
                         placeholder="••••••••">
                </div>
              </div>
              <div class="flex justify-end mt-5 pt-4 border-t border-slate-100">
                <button type="submit" :disabled="passwordForm.processing"
                        class="px-5 py-2 bg-teal-600 hover:bg-teal-700 disabled:opacity-50
                               text-white text-sm font-medium rounded-lg transition-colors">
                  {{ passwordForm.processing ? 'Menyimpan...' : 'Ubah Password' }}
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'

const props = defineProps({ user: Object, stats: Object })

const manAvatars = [
  '001-man', '002-old man', '006-man', '007-man', '011-man',
  '012-man', '013-man', '016-man', '017-old man', '020-man'
]
const womanAvatars = [
  '003-woman', '004-woman', '005-woman', '008-woman', '009-woman',
  '010-woman', '014-woman', '015-woman', '018-woman', '019-woman'
]

const profilForm = useForm({
  name: props.user.name,
  email: props.user.email,
  gender: props.user.gender || '',
  avatar: props.user.avatar || '',
})

const passwordForm = useForm({
  password_lama: '',
  password_baru: '',
  password_baru_confirmation: '',
})

const profilErrors = computed(() => profilForm.errors)
const passwordErrors = computed(() => passwordForm.errors)

const updateProfil = () => {
  profilForm.put(route('profil.update'))
}

const updatePassword = () => {
  passwordForm.put(route('profil.password'), {
    onSuccess: () => passwordForm.reset(),
  })
}
</script>
