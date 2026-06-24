<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Darussalam Platform</title>
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

    <main class="flex-grow flex items-center justify-center p-4 sm:p-6 md:p-12 my-2">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100 max-w-4xl w-full flex overflow-hidden min-h-[650px]">
            
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
                        <a href="{{ route('login') }}" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800/50 font-medium text-sm px-4 py-3.5 rounded-xl transition-all group">
                            <i class="fa-solid fa-right-to-bracket text-slate-500 group-hover:text-slate-300"></i>
                            <span>Masuk ke Akun</span>
                        </a>

                        <a href="{{ route('register') }}" class="flex items-center space-x-3 text-white bg-slate-800 border border-slate-700 font-semibold text-sm px-4 py-3.5 rounded-xl transition-all">
                            <i class="fa-solid fa-user-plus text-indigo-400"></i>
                            <span>Daftar Akun Baru</span>
                        </a>
                    </div>
                </div>
                
                <div class="text-[11px] text-slate-500 font-semibold tracking-widest uppercase relative z-10">
                    &copy; 2026 Core System Integrated
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 sm:p-12 flex flex-col justify-center bg-white">
                
                <div class="mb-8">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-2">Buat akun baru</h1>
                    <p class="text-sm text-slate-500">Lengkapi detail informasi Anda untuk mendaftar.</p>
                </div>

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-sm text-red-600 rounded-2xl">
                    <div class="flex items-start space-x-3 mb-1.5">
                        <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0 text-red-500"></i>
                        <span class="font-semibold">Terjadi kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-gray-500 space-y-0.5 pl-2">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="registerForm" action="{{ route('register.post') }}" method="POST" class="space-y-5" novalidate>
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                                <i class="fa-regular fa-user text-sm"></i>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder=" " required
                                class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                            <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Nama Lengkap</label>
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </div>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder=" " required
                                class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                            <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Nomor Telepon</label>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required
                            class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                        <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Alamat Email</label>
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 pt-4 flex items-start pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                            <i class="fa-regular fa-map text-sm"></i>
                        </div>
                        <textarea name="address" id="address" rows="2" placeholder=" " required
                            class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none resize-none relative z-0">{{ old('address') }}</textarea>
                        <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Alamat Domisili</label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password" name="password" id="passField" placeholder=" " required
                                class="input-field w-full pl-11 pr-11 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                            <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Kata Sandi</label>
                            <button type="button" onclick="toggleVisibility('passField', 'passIcon')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors z-10">
                                <i id="passIcon" class="fa-regular fa-eye text-sm"></i>
                            </button>
                            <div class="absolute bottom-[-10px] left-2 w-[calc(100%-16px)] h-1 bg-gray-100 rounded-full overflow-hidden">
                                <div id="strengthBar" class="w-0 h-full bg-red-500 transition-all duration-300"></div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10">
                                <i class="fa-solid fa-shield-stroke text-xs"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="confirmField" placeholder=" " required
                                class="input-field w-full pl-11 pr-11 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 text-sm transition-all text-gray-900 outline-none relative z-0">
                            <label class="floating-label absolute left-11 top-3.5 text-sm text-gray-400 pointer-events-none transition-all duration-200 origin-left">Konfirmasi Sandi</label>
                            <button type="button" onclick="toggleVisibility('confirmField', 'confirmIcon')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors z-10">
                                <i id="confirmIcon" class="fa-regular fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" id="submitBtn"
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3.5 rounded-xl text-sm transition-all duration-200 shadow-md transform active:scale-[0.99] flex items-center justify-center space-x-2">
                            <span id="btnText">Daftar Akun Baru</span>
                            <span id="btnSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        </button>
                    </div>

                    <div class="text-center mt-4 md:hidden border-t border-gray-100 pt-5">
                        <p class="text-sm text-gray-500">
                            Sudah memiliki akun? 
                            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">Masuk sekarang</a>
                        </p>
                    </div>

                </form>
            </div>

        </div>
    </main>

    <script>
        function toggleVisibility(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
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

        const passField = document.getElementById('passField');
        const strengthBar = document.getElementById('strengthBar');
        passField.addEventListener('input', () => {
            const val = passField.value;
            if (val.length === 0) {
                strengthBar.style.width = '0%';
            } else if (val.length < 5) {
                strengthBar.style.width = '35%';
                strengthBar.className = 'h-full bg-red-500 transition-all';
            } else if (val.length < 8) {
                strengthBar.style.width = '65%';
                strengthBar.className = 'h-full bg-yellow-500 transition-all';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.className = 'h-full bg-emerald-500 transition-all';
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const fields = ['name', 'phone', 'email', 'address', 'passField', 'confirmField'];
            let hasError = false;

            fields.forEach(id => {
                const el = document.getElementById(id);
                if (!el.value.trim()) {
                    el.classList.add('shake-input');
                    setTimeout(() => el.classList.remove('shake-input'), 400);
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
                return;
            }

            document.getElementById('btnText').innerText = 'Mendaftar...';
            document.getElementById('btnSpinner').classList.remove('hidden');
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').classList.add('opacity-80', 'cursor-not-allowed');
        });
    </script>
</body>
</html>