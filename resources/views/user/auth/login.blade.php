<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Darussalam Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .input-field:focus ~ .floating-label,
        .input-field:not(:placeholder-shown) ~ .floating-label {
            transform: translateY(-24px) scale(0.85);
            color: #4f46e5;
            background-color: #ffffff;
            padding: 0 6px;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .shake-input { animation: shake 0.4s ease-in-out; border-color: #ef4444 !important; }
    </style>
</head>
<body class="bg-[#fafafa] min-h-screen flex flex-col justify-between antialiased selection:bg-indigo-600/10 selection:text-indigo-600">

    <main class="flex-grow flex items-center justify-center p-4 sm:p-6 md:p-12">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100 max-w-4xl w-full flex overflow-hidden min-h-[600px]">
            
            <div id="leftPanel" class="w-full md:w-5/12 p-10 bg-slate-900 border-r border-gray-100 hidden md:flex flex-col justify-between relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:16px_16px] opacity-20"></div>
                <div id="glowCircle" class="absolute w-64 h-64 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none transition-all duration-75 ease-out -left-32 -top-32"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-16 transform hover:scale-[1.02] transition-transform cursor-pointer duration-300">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                            <i class="fa-solid fa-house-laptop text-white text-base"></i>
                        </div>
                        <span class="text-white font-bold text-lg tracking-tight">Darussalam <span class="text-indigo-400 font-medium">Platform</span></span>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}" class="flex items-center space-x-3 text-white bg-slate-800 border border-slate-700 font-semibold text-sm px-4 py-3.5 rounded-xl transition-all">
                            <i class="fa-solid fa-right-to-bracket text-indigo-400"></i>
                            <span>Masuk ke Akun</span>
                        </a>

                        <a href="{{ route('register') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 font-medium text-sm px-4 py-3.5 rounded-xl transition-all group">
                            <i class="fa-solid fa-user-plus text-slate-500 group-hover:text-slate-300"></i>
                            <span>Daftar Akun Baru</span>
                        </a>
                    </div>
                </div>
                
                <div class="text-[11px] text-slate-500 font-semibold tracking-widest uppercase relative z-10">
                    &copy; 2026 Core System Integrated
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white">
                
                <div class="mb-10">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-2">Selamat datang</h1>
                    <p class="text-sm text-slate-500">Akses akun Darussalam Platform Anda di bawah ini.</p>
                </div>

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-sm text-red-600 rounded-2xl flex items-start space-x-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0 text-red-500"></i>
                    <span class="font-medium">{{ $errors->first() }}</span>
                </div>
                @endif

                <form id="loginForm" action="{{ route('login.post') }}" method="POST" class="space-y-7" novalidate>
                    @csrf

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required
                            class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                        <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Alamat Email</label>
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" name="password" id="passwordField" placeholder=" " required
                            class="input-field w-full pl-11 pr-12 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                        <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Kata Sandi</label>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors z-10">
                            <i id="passwordIcon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                        
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center select-none cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-0 focus:ring-offset-0 transition cursor-pointer accent-indigo-600">
                            <span class="ml-2.5 text-sm text-gray-400 group-hover:text-gray-900 transition-colors">Ingat sesi perangkat ini</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="submitBtn"
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3.5 rounded-xl text-sm transition-all duration-200 shadow-md transform active:scale-[0.99] flex items-center justify-center space-x-2">
                            <span id="btnText">Masuk ke Platform</span>
                            <span id="btnSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        </button>
                    </div>

                    <div class="text-center mt-6 md:hidden border-t border-gray-100 pt-5">
                        <p class="text-sm text-gray-500">
                            Belum terdaftar di platform? 
                            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">Daftar sekarang</a>
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
                icon.className = 'fa-solid fa-eye-slash text-sm';
            } else {
                field.type = 'password';
                icon.className = 'fa-regular fa-eye text-sm';
            }
        }

        const leftPanel = document.getElementById('leftPanel');
        const glowCircle = document.getElementById('glowCircle');
        leftPanel.addEventListener('mousemove', (e) => {
            const rect = leftPanel.getBoundingClientRect();
            const x = e.clientX - rect.left - 128;
            const y = e.clientY - rect.top - 128;
            glowCircle.style.left = `${x}px`;
            glowCircle.style.top = `${y}px`;
        });

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('passwordField');
            let hasError = false;

            if (!email.value.trim()) {
                email.classList.add('shake-input');
                setTimeout(() => email.classList.remove('shake-input'), 400);
                hasError = true;
            }
            if (!password.value.trim()) {
                password.classList.add('shake-input');
                setTimeout(() => password.classList.remove('shake-input'), 400);
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                return;
            }

            document.getElementById('btnText').innerText = 'Memproses...';
            document.getElementById('btnSpinner').classList.remove('hidden');
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').classList.add('opacity-80', 'cursor-not-allowed');
        });
    </script>
</body>
</html>