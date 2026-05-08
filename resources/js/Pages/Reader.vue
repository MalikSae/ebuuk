<template>
  <div class="h-screen flex flex-col bg-slate-900 overflow-hidden"
       style="font-family: 'Inter', sans-serif;">

    <!-- NAVBAR READER -->
    <div class="flex items-center justify-between px-3 md:px-4 py-2.5
                bg-slate-800 border-b border-slate-700 flex-shrink-0">

      <!-- Kiri: Back + Judul -->
      <div class="flex items-center gap-2 md:gap-3 min-w-0 flex-1">
        <Link :href="route('buku.show', buku.slug)"
              class="flex items-center gap-1 text-slate-400 hover:text-white
                     transition-colors text-sm flex-shrink-0">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span class="hidden sm:inline">Kembali</span>
        </Link>
        <div class="w-px h-4 bg-slate-600 hidden sm:block flex-shrink-0"></div>
        <div class="min-w-0 flex-1">
          <p class="text-white text-xs md:text-sm font-medium truncate">{{ buku.judul }}</p>
          <p class="text-slate-400 text-xs truncate hidden sm:block">
            {{ buku.penulis || 'Penulis tidak diketahui' }}
          </p>
        </div>
      </div>

      <!-- Tengah: Navigasi halaman (Desktop only) -->
      <div v-if="!isMobile" class="flex items-center gap-2 flex-shrink-0">
        <button @click="prevPage" :disabled="currentPage <= 1"
                class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700
                       rounded-lg transition-colors disabled:opacity-30 disabled:cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>
        <div class="flex items-center gap-1.5">
          <input v-model.number="inputPage"
                 @keyup.enter="goToPage(inputPage)"
                 type="number" :min="1" :max="totalPages"
                 class="w-12 text-center bg-slate-700 border border-slate-600
                        text-white text-sm rounded-lg px-2 py-1
                        focus:outline-none focus:border-teal-500">
          <span class="text-slate-400 text-sm">/ {{ totalPages }}</span>
        </div>
        <button @click="nextPage" :disabled="currentPage >= totalPages"
                class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700
                       rounded-lg transition-colors disabled:opacity-30 disabled:cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>

      <!-- Mobile: info halaman saat ini -->
      <div v-else class="text-slate-400 text-xs flex-shrink-0">
        {{ currentPage }} / {{ totalPages }}
      </div>

      <!-- Kanan: Zoom (Desktop) -->
      <div class="flex items-center gap-1 md:gap-2 flex-shrink-0">
        <template v-if="!isMobile">
          <button @click="zoomOut"
                  class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700
                         rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/>
            </svg>
          </button>
          <span class="text-slate-400 text-xs w-10 text-center">
            {{ Math.round(scale * 100) }}%
          </span>
          <button @click="zoomIn"
                  class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700
                         rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
            </svg>
          </button>
        </template>
      </div>
    </div>

    <!-- PDF VIEWER -->
    <div class="flex-1 overflow-auto bg-slate-800" ref="viewerContainer">

      <!-- LOADING -->
      <div v-if="loading"
           class="flex flex-col items-center justify-center h-full text-slate-400 gap-3">
        <svg class="w-8 h-8 animate-spin" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10"
                  stroke="currentColor" stroke-width="4"/>
          <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        <p class="text-sm">Memuat dokumen...</p>
        <p v-if="isMobile" class="text-xs text-slate-500">
          Harap tunggu, memuat semua halaman...
        </p>
      </div>

      <!-- ERROR -->
      <div v-else-if="error"
           class="flex flex-col items-center justify-center h-full text-slate-400 gap-3">
        <svg class="w-12 h-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
        <p class="text-sm text-red-400">Gagal memuat dokumen</p>
        <button @click="loadPDF"
                class="text-xs text-teal-400 hover:underline">Coba lagi</button>
      </div>

      <!-- DESKTOP: Single page canvas -->
      <div v-show="!loading && !error && !isMobile"
           class="flex justify-center py-4 md:py-6">
        <canvas ref="pdfCanvas"
                class="shadow-2xl max-w-full"
                :style="{ transform: `scale(${scale})`, transformOrigin: 'top center' }">
        </canvas>
      </div>

      <!-- MOBILE: All pages scroll vertikal -->
      <div v-show="!loading && !error && isMobile"
           class="flex flex-col items-center gap-2 py-3 px-2"
           ref="mobileContainer">
        <canvas v-for="n in totalPages" :key="n"
                :ref="el => { if (el) mobileCanvases[n-1] = el }"
                class="w-full max-w-full shadow-lg rounded-sm bg-white"
                :data-page="n">
        </canvas>
      </div>

    </div>

    <!-- PROGRESS BAR -->
    <div class="h-1 bg-slate-700 flex-shrink-0">
      <div class="h-full bg-teal-500 transition-all duration-300"
           :style="{ width: totalPages > 0 ? (currentPage / totalPages * 100) + '%' : '0%' }">
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  buku: Object,
  halamanTerakhir: Number,
  streamUrl: String,
})

// State
const loading = ref(true)
const error = ref(false)
const currentPage = ref(props.halamanTerakhir || 1)
const totalPages = ref(0)
const scale = ref(1.0)
const inputPage = ref(currentPage.value)
const pdfCanvas = ref(null)
const viewerContainer = ref(null)
const mobileContainer = ref(null)
const mobileCanvases = ref([])
const isMobile = ref(false)

let pdfDoc = null
let renderTask = null

// Deteksi mobile
const checkMobile = () => {
  isMobile.value = window.innerWidth < 768
}

// Load PDF.js dari CDN
const loadPdfJs = () => {
  return new Promise((resolve, reject) => {
    if (window.pdfjsLib) return resolve(window.pdfjsLib)
    const script = document.createElement('script')
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js'
    script.onload = () => {
      window.pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js'
      resolve(window.pdfjsLib)
    }
    script.onerror = reject
    document.head.appendChild(script)
  })
}

const loadPDF = async () => {
  loading.value = true
  error.value = false
  mobileCanvases.value = []
  try {
    const pdfjsLib = await loadPdfJs()
    const loadingTask = pdfjsLib.getDocument({
      url: props.streamUrl,
      withCredentials: true,
    })
    pdfDoc = await loadingTask.promise
    totalPages.value = pdfDoc.numPages
    loading.value = false

    await nextTick()

    if (isMobile.value) {
      await renderAllPages()
      // Scroll ke halaman terakhir jika ada riwayat
      scrollToPage(props.halamanTerakhir || 1)
    } else {
      await renderPage(currentPage.value)
    }
  } catch (err) {
    console.error('PDF load error:', err)
    loading.value = false
    error.value = true
  }
}

// Desktop: render satu halaman
const renderPage = async (pageNum) => {
  if (!pdfDoc || !pdfCanvas.value) return
  if (renderTask) {
    renderTask.cancel()
    renderTask = null
  }
  try {
    const page = await pdfDoc.getPage(pageNum)
    const containerWidth = viewerContainer.value?.clientWidth || 800
    const viewport = page.getViewport({ scale: Math.min(1.5, containerWidth / page.getViewport({ scale: 1 }).width * 0.9) })
    const canvas = pdfCanvas.value
    const context = canvas.getContext('2d')
    canvas.height = viewport.height
    canvas.width = viewport.width
    renderTask = page.render({ canvasContext: context, viewport })
    await renderTask.promise
    renderTask = null
  } catch (err) {
    if (err?.name !== 'RenderingCancelledException') console.error(err)
  }
}

// Mobile: render semua halaman
const renderAllPages = async () => {
  if (!pdfDoc) return
  const containerWidth = (mobileContainer.value?.clientWidth || 390) - 16
  for (let i = 1; i <= totalPages.value; i++) {
    try {
      const page = await pdfDoc.getPage(i)
      const baseViewport = page.getViewport({ scale: 1 })
      const scaleRatio = containerWidth / baseViewport.width
      const viewport = page.getViewport({ scale: scaleRatio })
      const canvas = mobileCanvases.value[i - 1]
      if (!canvas) continue
      canvas.height = viewport.height
      canvas.width = viewport.width
      const context = canvas.getContext('2d')
      await page.render({ canvasContext: context, viewport }).promise
    } catch (err) {
      console.error('Render page error:', i, err)
    }
  }
}

// Scroll ke halaman tertentu di mobile
const scrollToPage = (pageNum) => {
  if (!mobileContainer.value) return
  const canvas = mobileCanvases.value[pageNum - 2]
  if (canvas) canvas.scrollIntoView({ behavior: 'smooth' })
}

// Track halaman saat ini saat scroll di mobile
const handleMobileScroll = () => {
  if (!isMobile.value || !mobileContainer.value) return
  const container = viewerContainer.value
  const scrollTop = container.scrollTop
  const containerHeight = container.clientHeight

  let closestPage = 1
  let closestDistance = Infinity

  mobileCanvases.value.forEach((canvas, index) => {
    if (!canvas) return
    const rect = canvas.getBoundingClientRect()
    const containerRect = container.getBoundingClientRect()
    const distance = Math.abs(rect.top - containerRect.top)
    if (distance < closestDistance) {
      closestDistance = distance
      closestPage = index + 1
    }
  })

  if (closestPage !== currentPage.value) {
    currentPage.value = closestPage
    saveProgress()
  }
}

// Desktop navigasi
const prevPage = async () => {
  if (currentPage.value <= 1) return
  currentPage.value--
  inputPage.value = currentPage.value
  await renderPage(currentPage.value)
  saveProgress()
}

const nextPage = async () => {
  if (currentPage.value >= totalPages.value) return
  currentPage.value++
  inputPage.value = currentPage.value
  await renderPage(currentPage.value)
  saveProgress()
}

const goToPage = async (page) => {
  const p = Math.max(1, Math.min(page, totalPages.value))
  currentPage.value = p
  inputPage.value = p
  if (isMobile.value) {
    scrollToPage(p)
  } else {
    await renderPage(p)
  }
  saveProgress()
}

const zoomIn = () => {
  scale.value = Math.min(scale.value + 0.2, 3.0)
  renderPage(currentPage.value)
}
const zoomOut = () => {
  scale.value = Math.max(scale.value - 0.2, 0.5)
  renderPage(currentPage.value)
}

// Save progress
let progressTimer = null
const saveProgress = () => {
  if (progressTimer) clearTimeout(progressTimer)
  progressTimer = setTimeout(() => {
    router.post(
      route('reader.progress', props.buku.slug),
      { halaman: currentPage.value },
      { preserveState: true, preserveScroll: true }
    )
  }, 2000)
}

// Keyboard navigation (desktop only)
const handleKeydown = (e) => {
  if (isMobile.value) return
  if (e.key === 'ArrowRight' || e.key === 'ArrowDown') nextPage()
  if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') prevPage()
}

// Handle resize
const handleResize = () => {
  const wasMobile = isMobile.value
  checkMobile()
  if (wasMobile !== isMobile.value) {
    loadPDF()
  }
}

onMounted(() => {
  checkMobile()
  loadPDF()
  window.addEventListener('keydown', handleKeydown)
  window.addEventListener('resize', handleResize)

  // Scroll listener untuk mobile tracking
  nextTick(() => {
    if (viewerContainer.value) {
      viewerContainer.value.addEventListener('scroll', handleMobileScroll)
    }
  })
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)
  window.removeEventListener('resize', handleResize)
  if (viewerContainer.value) {
    viewerContainer.value.removeEventListener('scroll', handleMobileScroll)
  }
  if (progressTimer) clearTimeout(progressTimer)
})
</script>
