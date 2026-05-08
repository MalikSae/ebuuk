<template>
  <div class="min-h-screen bg-teal-50 flex items-center justify-center p-4"
       style="font-family: 'Inter', sans-serif;">
    <div class="w-full max-w-lg">

      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- Header progress -->
        <div class="px-8 pt-8 pb-0">
          <!-- Logo -->
          <div class="text-center mb-6">
            <Link :href="route('landing')">
              <img src="/images/logo_ebuuk_light.png" alt="ebuuk.id"
                   class="h-9 w-auto mx-auto">
            </Link>
          </div>

          <!-- Step indicator -->
          <div class="flex items-center gap-0 mb-6">
            <template v-for="(label, i) in steps" :key="i">
              <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold transition-all"
                     :class="currentStep > i
                       ? 'bg-teal-600 text-white'
                       : currentStep === i
                         ? 'bg-teal-600 text-white ring-4 ring-teal-100'
                         : 'bg-slate-100 text-slate-400'">
                  <svg v-if="currentStep > i" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                  <span v-else>{{ i + 1 }}</span>
                </div>
                <span class="text-xs font-medium hidden sm:block"
                      :class="currentStep >= i ? 'text-slate-700' : 'text-slate-300'">
                  {{ label }}
                </span>
              </div>
              <div v-if="i < steps.length - 1"
                   class="flex-1 h-px mx-2 transition-all"
                   :class="currentStep > i ? 'bg-teal-400' : 'bg-slate-200'">
              </div>
            </template>
          </div>
        </div>

        <!-- Body -->
        <div class="px-8 pb-8">

          <!-- ━━━ STEP 0: Pilih Gender ━━━ -->
          <div v-if="currentStep === 0">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Halo! 👋</h2>
            <p class="text-slate-400 text-sm mb-6">Pilih jenis kelaminmu untuk memulai</p>

            <div class="grid grid-cols-2 gap-4">
              <!-- Laki-laki -->
              <button @click="selectGender('laki-laki')"
                      class="relative flex flex-col items-center gap-3 p-5 rounded-2xl border-2
                             transition-all duration-200 hover:border-teal-400"
                      :class="form.gender === 'laki-laki'
                        ? 'border-teal-500 bg-teal-50'
                        : 'border-slate-200 bg-white'">
                <img src="/images/man/001-man.png" alt="Laki-laki"
                     class="w-20 h-20 object-contain">
                <span class="font-semibold text-slate-700">Laki-laki</span>
                <!-- Check icon -->
                <div v-if="form.gender === 'laki-laki'"
                     class="absolute top-3 right-3 w-5 h-5 bg-teal-500 rounded-full
                            flex items-center justify-center">
                  <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
              </button>

              <!-- Perempuan -->
              <button @click="selectGender('perempuan')"
                      class="relative flex flex-col items-center gap-3 p-5 rounded-2xl border-2
                             transition-all duration-200 hover:border-teal-400"
                      :class="form.gender === 'perempuan'
                        ? 'border-teal-500 bg-teal-50'
                        : 'border-slate-200 bg-white'">
                <img src="/images/woman/003-woman.png" alt="Perempuan"
                     class="w-20 h-20 object-contain">
                <span class="font-semibold text-slate-700">Perempuan</span>
                <div v-if="form.gender === 'perempuan'"
                     class="absolute top-3 right-3 w-5 h-5 bg-teal-500 rounded-full
                            flex items-center justify-center">
                  <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
              </button>
            </div>

            <p v-if="!form.gender && showError"
               class="text-red-500 text-xs mt-3 text-center">
              Pilih jenis kelamin terlebih dahulu
            </p>

            <button @click="nextStep"
                    class="w-full mt-6 py-3 bg-teal-600 hover:bg-teal-700 text-white
                           font-semibold rounded-xl transition-colors">
              Lanjutkan →
            </button>
          </div>

          <!-- ━━━ STEP 1: Pilih Avatar ━━━ -->
          <div v-if="currentStep === 1">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Pilih Avatarmu 🎭</h2>
            <p class="text-slate-400 text-sm mb-5">
              Pilih karakter yang mewakilimu
            </p>

            <!-- Grid avatar -->
            <div class="grid grid-cols-5 gap-2.5">
              <button v-for="av in currentAvatars" :key="av"
                      @click="form.avatar = av"
                      class="relative rounded-xl p-1 border-2 transition-all hover:border-teal-300"
                      :class="form.avatar === av
                        ? 'border-teal-500 bg-teal-50'
                        : 'border-transparent'">
                <img :src="`/images/${form.gender === 'laki-laki' ? 'man' : 'woman'}/${av}.png`"
                     :alt="av"
                     class="w-full aspect-square object-contain rounded-lg">
                <div v-if="form.avatar === av"
                     class="absolute -top-1 -right-1 w-4 h-4 bg-teal-500 rounded-full
                            flex items-center justify-center shadow">
                  <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
              </button>
            </div>

            <p v-if="!form.avatar && showError"
               class="text-red-500 text-xs mt-3 text-center">
              Pilih avatar terlebih dahulu
            </p>

            <div class="flex gap-3 mt-6">
              <button @click="prevStep"
                      class="flex-1 py-3 border border-slate-200 text-slate-600
                             font-medium rounded-xl hover:bg-slate-50 transition-colors">
                ← Kembali
              </button>
              <button @click="nextStep"
                      class="flex-1 py-3 bg-teal-600 hover:bg-teal-700 text-white
                             font-semibold rounded-xl transition-colors">
                Lanjutkan →
              </button>
            </div>
          </div>

          <!-- ━━━ STEP 2: Data Akun ━━━ -->
          <div v-if="currentStep === 2">

            <!-- Preview avatar terpilih -->
            <div class="flex items-center gap-4 mb-6 p-4 bg-slate-50 rounded-xl">
              <img :src="`/images/${form.gender === 'laki-laki' ? 'man' : 'woman'}/${form.avatar}.png`"
                   class="w-14 h-14 object-contain rounded-full bg-white shadow-sm">
              <div>
                <p class="font-semibold text-slate-800 text-sm">Avatar terpilih</p>
                <p class="text-slate-400 text-xs mt-0.5 capitalize">{{ form.gender }}</p>
              </div>
              <button @click="currentStep = 1"
                      class="ml-auto text-xs text-teal-600 hover:underline">
                Ganti
              </button>
            </div>

            <h2 class="text-xl font-bold text-slate-800 mb-1">Buat Akunmu ✨</h2>
            <p class="text-slate-400 text-sm mb-5">Isi data untuk menyelesaikan pendaftaran</p>

            <!-- Error global -->
            <div v-if="Object.keys(form.errors).length"
                 class="bg-red-50 border border-red-200 text-red-600 rounded-lg
                        px-4 py-3 text-sm mb-4">
              {{ Object.values(form.errors)[0] }}
            </div>

            <form @submit.prevent="submit" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                  Nama Lengkap
                </label>
                <input v-model="form.name" type="text" required autofocus
                       placeholder="Nama kamu"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                              text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                              focus:border-transparent">
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                  Email
                </label>
                <input v-model="form.email" type="email" required
                       placeholder="email@kamu.com"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                              text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                              focus:border-transparent">
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                  Password
                </label>
                <input v-model="form.password" type="password" required
                       placeholder="Minimal 8 karakter"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                              text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                              focus:border-transparent">
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                  Konfirmasi Password
                </label>
                <input v-model="form.password_confirmation" type="password" required
                       placeholder="Ulangi password"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5
                              text-sm focus:outline-none focus:ring-2 focus:ring-teal-500
                              focus:border-transparent">
              </div>

              <div class="flex gap-3 pt-2">
                <button type="button" @click="prevStep"
                        class="flex-1 py-3 border border-slate-200 text-slate-600
                               font-medium rounded-xl hover:bg-slate-50 transition-colors">
                  ← Kembali
                </button>
                <button type="submit" :disabled="form.processing"
                        class="flex-1 py-3 bg-teal-600 hover:bg-teal-700 disabled:opacity-50
                               text-white font-semibold rounded-xl transition-colors">
                  {{ form.processing ? 'Mendaftar...' : 'Daftar Sekarang 🎉' }}
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>

      <!-- Login link -->
      <p class="text-center text-sm text-slate-500 mt-4">
        Sudah punya akun?
        <Link :href="route('login')" class="text-teal-600 font-medium hover:underline">
          Masuk di sini
        </Link>
      </p>

      <p class="text-center text-xs text-slate-400 mt-2">
        © {{ new Date().getFullYear() }} ebuuk.id
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'

defineProps({ errors: { type: Object, default: () => ({}) } })

const steps = ['Jenis Kelamin', 'Pilih Avatar', 'Data Akun']
const currentStep = ref(0)
const showError = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  gender: '',
  avatar: '',
})

// Daftar avatar per gender
const manAvatars = [
  '001-man', '002-old man', '006-man', '007-man', '011-man',
  '012-man', '013-man', '016-man', '017-old man', '020-man'
]
const womanAvatars = [
  '003-woman', '004-woman', '005-woman', '008-woman', '009-woman',
  '010-woman', '014-woman', '015-woman', '018-woman', '019-woman'
]

const currentAvatars = computed(() => {
  return form.gender === 'laki-laki' ? manAvatars : womanAvatars
})

const selectGender = (gender) => {
  form.gender = gender
  form.avatar = '' // reset avatar saat gender berubah
  showError.value = false
}

const nextStep = () => {
  showError.value = false
  if (currentStep.value === 0 && !form.gender) {
    showError.value = true
    return
  }
  if (currentStep.value === 1 && !form.avatar) {
    showError.value = true
    return
  }
  currentStep.value++
}

const prevStep = () => {
  showError.value = false
  currentStep.value--
}

const submit = () => {
  form.post(route('register'))
}
</script>
