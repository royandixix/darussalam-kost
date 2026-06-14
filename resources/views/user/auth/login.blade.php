<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Darussalam Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f4f7fa] font-sans min-h-screen flex flex-col justify-between antialiased selection:bg-blue-600/10 selection:text-blue-600">

    <main class="flex-grow flex items-center justify-center p-4 sm:p-6 md:p-12">
        <div class="bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border border-gray-100 max-w-4xl w-full flex overflow-hidden min-h-[580px]">
            
            <div class="w-full md:w-5/12 p-10 bg-gradient-to-b from-[#f8fafc] to-[#f1f5f9] border-r border-gray-100 hidden md:flex flex-col justify-between">
                <div>
                    <div class="flex items-center space-x-2.5 mb-12">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-[0_4px_12px_rgba(37,99,235,0.2)]">
                            <i class="fa-solid fa-house-laptop text-white text-sm"></i>
                        </div>
                        <span class="text-gray-900 font-bold text-base tracking-tight">Darussalam <span class="text-blue-600 font-medium">Platform</span></span>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}" class="flex items-center space-x-3 text-blue-600 bg-blue-50 border border-blue-100/50 font-semibold text-sm px-4 py-3 rounded-xl transition-all">
                            <i class="fa-solid fa-right-to-bracket text-blue-600"></i>
                            <span>Masuk ke Akun</span>
                        </a>

                        <a href="{{ route('register') }}" class="flex items-center space-x-3 text-gray-500 hover:text-gray-900 hover:bg-gray-50 font-medium text-sm px-4 py-3 rounded-xl transition-all group">
                            <i class="fa-solid fa-user-plus text-gray-400 group-hover:text-gray-600"></i>
                            <span>Daftar Akun Baru</span>
                        </a>
                    </div>
                </div>
                
                <div class="text-[11px] text-gray-400 font-semibold tracking-wide uppercase">
                    &copy; 2026 Core System Integrated
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white">
                
                <div class="mb-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 mb-2">Selamat Datang di Kos Ini!</h1>
                    <p class="text-sm text-gray-500 leading-relaxed">Silakan login terlebih dahulu untuk masuk ke sistem.</p>
                </div>

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-sm text-red-600 rounded-xl flex items-start space-x-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0 text-red-500"></i>
                    <span class="font-medium">{{ $errors->first() }}</span>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-bold tracking-widest uppercase text-gray-500 mb-2">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#f8fafc] border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-sm transition-all placeholder-gray-400 text-gray-900 outline-none"
                                placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-widest uppercase text-gray-500 mb-2">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password" name="password" id="passwordField"
                                class="w-full pl-10 pr-12 py-3 rounded-xl bg-[#f8fafc] border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-sm transition-all placeholder-gray-400 text-gray-900 outline-none"
                                placeholder="••••••••" required>
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <i id="passwordIcon" class="fa-regular fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center select-none cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 text-blue-600 border-gray-200 rounded focus:ring-blue-500/20 focus:ring-offset-0 transition cursor-pointer">
                            <span class="ml-2.5 text-sm text-gray-500 group-hover:text-gray-900 transition-colors">Ingat sesi perangkat ini</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-sm transition-all duration-200 shadow-[0_4px_12px_rgba(37,99,235,0.15)] hover:shadow-[0_4px_20px_rgba(37,99,235,0.3)] transform active:scale-[0.99]">
                            Masuk
                        </button>
                    </div>

                    <div class="text-center mt-6 md:hidden border-t border-gray-100 pt-4">
                        <p class="text-sm text-gray-500">
                            Belum terdaftar di platform? 
                            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">Daftar sekarang</a>
                        </p>
                    </div>

                </form>
            </div>

        </div>
    </main>

    <script>
        function togglePassword() {
            const field = document.getElementById('passwordField');
            const icon = document.getElementById('passwordIcon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fa-solid fa-eye-slash text-xs';
            } else {
                field.type = 'password';
                icon.className = 'fa-regular fa-eye text-xs';
            }
        }
    </script>
</body>
</html>