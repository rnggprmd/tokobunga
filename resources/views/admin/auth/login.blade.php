<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal — Mbah Bibit</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'],
                        headline: ['Newsreader', 'serif']
                    },
                    colors: {
                        "background": "#FAFAE3",
                        "admin-accent": "#8F9E83", /* Sage Green from Dashboard */
                        "admin-rose": "#D9B2A9",
                        "admin-border": "#e4e4ce",
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(251, 251, 228, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(143, 158, 131, 0.2);
        }
    </style>
</head>
<body class="bg-background font-sans antialiased text-slate-800 min-h-screen flex items-center justify-center p-6 relative">
    {{-- Background Decoration --}}
    <div class="absolute inset-0 opacity-40 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-admin-accent/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-admin-rose/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-admin-accent shadow-lg shadow-admin-accent/20 mb-4 transform -rotate-3">
                <span class="material-symbols-outlined text-white text-3xl">shield_person</span>
            </div>
            <h1 class="text-2xl font-headline font-black text-admin-accent uppercase tracking-widest leading-none">Mbah Bibit</h1>
            <p class="text-[10px] font-black text-slate-400 mt-2 uppercase tracking-[0.3em]">Staff Management Access</p>
        </div>

        <div class="glass-card rounded-[2.5rem] p-10 shadow-2xl shadow-admin-accent/5">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="p-4 bg-red-50 text-red-500 rounded-2xl text-[10px] font-bold border border-red-100 flex items-start gap-3 uppercase tracking-wider">
                        <span class="material-symbols-outlined text-base">error_outline</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="space-y-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Email Kredensial</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xl group-focus-within:text-admin-accent transition-colors">admin_panel_settings</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full bg-white/50 border border-admin-border rounded-2xl pl-12 pr-5 py-4 text-sm focus:border-admin-accent focus:ring-1 focus:ring-admin-accent outline-none transition-all placeholder:text-slate-300 font-medium"
                               placeholder="admin@mbahbibit.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Kunci Keamanan</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xl group-focus-within:text-admin-accent transition-colors">key</span>
                        <input type="password" name="password" required
                               class="w-full bg-white/50 border border-admin-border rounded-2xl pl-12 pr-5 py-4 text-sm focus:border-admin-accent focus:ring-1 focus:ring-admin-accent outline-none transition-all placeholder:text-slate-300 font-medium"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pl-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-admin-border text-admin-accent focus:ring-admin-accent">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ingat Sesi</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-admin-accent text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-slate-800 transition-all shadow-xl shadow-admin-accent/20 flex items-center justify-center gap-3 group">
                        Masuk Dashboard
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] hover:text-admin-accent transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-base">west</span>
                Kembali ke Archiv Utama
            </a>
        </div>
    </div>
</body>
</html>
