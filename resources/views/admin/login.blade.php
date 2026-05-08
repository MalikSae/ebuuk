<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — ebuuk.id</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-teal-50 min-h-screen flex items-center justify-center p-4 antialiased">

  <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-[400px]">
    
    <!-- Logo -->
    <img src="{{ asset('images/logo_ebuuk_light.png') }}" alt="ebuuk.id" class="h-10 w-auto mx-auto mb-2">
    <p class="text-center text-slate-500 text-sm mb-8">
      Panel Admin — Masuk untuk melanjutkan
    </p>

    <!-- Flash Message -->
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg px-4 py-3 text-sm mb-4">
      {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      
      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@ebuuk.id" required autofocus
               class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
        @error('email')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div class="mt-4">
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
        <input type="password" name="password" placeholder="••••••••" required
               class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
        @error('password')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Submit -->
      <div class="mt-6">
        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
          Masuk &rarr;
        </button>
      </div>
    </form>

    <!-- Copyright -->
    <p class="text-center text-xs text-slate-400 mt-6">
      &copy; {{ date('Y') }} ebuuk.id — Baca. Belajar. Bertumbuh.
    </p>
  </div>

</body>
</html>
