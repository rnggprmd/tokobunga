<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Mbah Bibit</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "background": "#FAFAE3",
                        "primary": "#D9B2A9",
                        "secondary": "#A5A68F",
                        "on-background": "#1b1d0f",
                    },
                    fontFamily: {
                        "headline": ["Newsreader", "serif"],
                        "body": ["Manrope", "sans-serif"],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .serif-italic { font-family: 'Newsreader', serif; font-style: italic; }
        .glass-panel {
            background: rgba(250, 250, 227, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(165, 166, 143, 0.2);
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    {{-- Background Decoration --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[1000px] grid md:grid-cols-2 bg-white/50 rounded-[2.5rem] overflow-hidden shadow-2xl shadow-secondary/10 relative z-10 border border-secondary/10">
        {{-- Left: Visual --}}
        <div class="hidden md:block relative overflow-hidden bg-[#efefd9]">
            <img src="https://images.unsplash.com/photo-1526047932273-341f2a7631f9?auto=format&fit=crop&q=80&w=800" 
                 class="w-full h-full object-cover opacity-80 grayscale hover:grayscale-0 transition-all duration-1000" alt="Botanical">
            <div class="absolute inset-0 bg-gradient-to-t from-secondary/60 to-transparent"></div>
            <div class="absolute bottom-12 left-12 right-12 text-white">
                <p class="font-headline text-4xl leading-tight">Membawa <span class="serif-italic">Jiwa Alam</span> ke Dalam Rumah Anda.</p>
                <p class="text-sm font-light mt-4 opacity-80 tracking-widest uppercase">Mbah Bibit Botanical Archiv</p>
            </div>
        </div>

        {{-- Right: Form --}}
        <div class="p-8 md:p-16 flex flex-col justify-center">
            <div class="mb-12">
                <a href="{{ route('home') }}" class="text-2xl font-headline text-secondary uppercase tracking-[0.2em] mb-2 block">Mbah Bibit</a>
                <h1 class="font-headline text-4xl text-on-background">Selamat Datang <span class="serif-italic">Kembali</span></h1>
                <p class="text-secondary/60 text-sm mt-3">Silakan masuk ke akun Anda untuk melanjutkan koleksi spesimen botani.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="p-4 bg-red-50 text-red-500 rounded-2xl text-xs border border-red-100 flex items-start gap-3">
                        <span class="material-symbols-outlined text-base">error</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-secondary/60">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-background/50 border border-secondary/20 rounded-2xl px-5 py-4 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                           placeholder="nama@email.com">
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-[10px] font-black uppercase tracking-widest text-secondary/60">Kata Sandi</label>
                        <a href="#" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline">Lupa?</a>
                    </div>
                    <input type="password" name="password" required
                           class="w-full bg-background/50 border border-secondary/20 rounded-2xl px-5 py-4 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-secondary/20 text-primary focus:ring-primary">
                    <label for="remember" class="text-xs text-secondary/60">Ingat perangkat ini</label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-secondary text-background py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-on-background transition-all shadow-lg shadow-secondary/20 active:scale-[0.98]">
                        Masuk Sekarang —
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-8 border-t border-secondary/10 text-center">
                <p class="text-xs text-secondary/60">Belum memiliki akun? <a href="#" class="text-primary font-bold hover:underline">Daftar Koleksi</a></p>
                <a href="{{ route('admin.login') }}" class="mt-8 inline-block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 hover:text-secondary transition-colors italic">Portal Staf Admin</a>
            </div>
        </div>
    </div>
</body>
</html>
