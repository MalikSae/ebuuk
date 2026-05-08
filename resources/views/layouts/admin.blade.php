<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden max-w-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') — ebuuk.id</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  @stack('styles')
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#F8FAFC] text-[#64748B] min-h-screen antialiased overflow-x-hidden max-w-full">

  <!-- Overlay -->
  <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden transition-opacity duration-300 opacity-0"></div>

  <!-- SIDEBAR -->
  <aside id="sidebar" class="fixed top-0 left-0 h-screen w-[240px] bg-white border-r border-[#E2E8F0] flex flex-col z-50 transition-transform duration-300 -translate-x-full md:translate-x-0">
    <!-- Logo area -->
    <div class="px-6 py-5 border-b border-[#E2E8F0]">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
        <img src="{{ asset('images/logo_ebuuk_light.png') }}" alt="ebuuk.id" class="h-10 w-auto">
      </a>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden pt-4 pb-4">
      <div class="px-6 pb-2">
        <p class="text-[#94A3B8] text-[11px] font-semibold tracking-widest uppercase">Menu Utama</p>
      </div>
      
      <nav class="px-3 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-teal-100 text-teal-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
          Dashboard
        </a>

        <!-- Buku -->
        <a href="{{ route('admin.buku.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.buku.*') ? 'bg-teal-100 text-teal-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
          Buku
        </a>

        <!-- Kategori -->
        <a href="{{ route('admin.kategori.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.kategori.*') ? 'bg-teal-100 text-teal-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
          Kategori
        </a>

        <!-- User -->
        <a href="{{ route('admin.user.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.user.*') ? 'bg-teal-100 text-teal-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
          User
        </a>
      </nav>

      <div class="px-6 pb-2 pt-6">
        <p class="text-[#94A3B8] text-[11px] font-semibold tracking-widest uppercase">Pengaturan</p>
      </div>

      <nav class="px-3 space-y-1">
        <!-- Pengaturan -->
        <a href="{{ route('admin.pengaturan.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.pengaturan.*') ? 'bg-teal-100 text-teal-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Pengaturan
        </a>
      </nav>
    </div>

    <!-- User Info & Logout -->
    <div class="mt-auto border-t border-[#E2E8F0] p-4 bg-white w-full absolute bottom-0">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0">
          <span class="text-teal-700 font-semibold text-xs">
            {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
          </span>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-slate-700 truncate">{{ session('admin_name') }}</p>
          <p class="text-xs text-slate-400">Administrator</p>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" title="Keluar" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
            </svg>
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- MAIN AREA -->
  <div class="min-h-screen flex flex-col transition-all duration-300 md:pl-[240px]">
    
    <!-- TOPBAR -->
    <header class="h-16 bg-white border-b border-[#E2E8F0] sticky top-0 z-40 px-4 sm:px-8 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <button id="mobile-menu-btn" class="md:hidden p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div>
          <h1 class="text-base sm:text-lg font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h1>
          <p class="text-xs text-slate-400 hidden sm:block">@yield('page-subtitle', '')</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
          <p class="text-sm font-medium text-slate-700">{{ session('admin_name') }}</p>
          <p class="text-xs text-slate-400">Administrator</p>
        </div>
        <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center">
          <span class="text-teal-700 font-semibold text-xs">
            {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
          </span>
        </div>
      </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-6 md:p-8">
      @yield('content')
    </main>
  </div>

  @stack('scripts')
  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    let isSidebarOpen = false;

    function toggleSidebar() {
      isSidebarOpen = !isSidebarOpen;
      if (isSidebarOpen) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.remove('opacity-0'), 10);
      } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 300);
      }
    }

    if (mobileMenuBtn) {
      mobileMenuBtn.addEventListener('click', toggleSidebar);
    }
    if (overlay) {
      overlay.addEventListener('click', toggleSidebar);
    }
  </script>
</body>
</html>
