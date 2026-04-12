<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Mbah Bibit</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'brand-bg': '#f3f4f6',
                        'accent-emerald': '#34d399',
                        'accent-emerald-dark': '#059669',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased bg-brand-bg text-gray-800 min-h-screen flex flex-col justify-center relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-accent-emerald/20 rounded-full blur-3xl mix-blend-multiply"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-emerald-200/30 rounded-full blur-3xl mix-blend-multiply"></div>

    <div class="relative w-full max-w-md mx-auto px-6">
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-accent-emerald to-accent-emerald-dark rounded-2xl flex items-center justify-center shadow-lg shadow-accent-emerald/30 mb-4 transform -rotate-3 hover:rotate-0 transition-transform">
                <span class="material-symbols-outlined text-white text-3xl">local_florist</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Mbah Bibit</h1>
            <p class="text-gray-500 mt-2 text-sm">Masuk untuk mengelola pesanan & stok toko Anda.</p>
        </div>

        <div class="glass-panel rounded-2xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Session Status / Errors -->
                @if ($errors->any())
                    <div class="p-3 bg-red-50 text-red-600 rounded-lg text-sm border border-red-100 flex items-start gap-2">
                        <span class="material-symbols-outlined text-base">error</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400 text-lg">mail</span>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent-emerald focus:border-accent-emerald bg-gray-50 hover:bg-white transition-colors text-sm"
                            placeholder="admin@tokobunga.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400 text-lg">lock</span>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent-emerald focus:border-accent-emerald bg-gray-50 hover:bg-white transition-colors text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-accent-emerald border-gray-300 rounded focus:ring-accent-emerald cursor-pointer">
                        <span class="text-sm text-gray-600 select-none">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all active:scale-[0.98]">
                    <span>Masuk ke Sistem</span>
                    <span class="material-symbols-outlined text-base">login</span>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            &copy; {{ date('Y') }} Mbah Bibit Nursery. Semua Hak Cipta Dilindungi.
        </p>
    </div>
</body>
</html>
