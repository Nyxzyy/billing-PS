<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Billing Manage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left side with background image - modified for mobile view -->
        <div class="relative flex items-center justify-center w-full md:w-1/2 lg:w-3/5 bg-cover bg-center h-40 md:h-auto"
            style="background-image: url('{{ asset('assets/images/Background (1).png') }}');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <h1 class="relative text-white text-3xl md:text-4xl font-semibold italic underline text-center px-4" 
                style="font-family: Roboto, sans-serif">
                "INILOGONYA"
            </h1>
        </div>

        <!-- Right side with login form -->
        <div
            class="w-full md:w-1/2 lg:w-2/5 bg-white px-6 sm:px-8 md:px-12 lg:px-16 py-8 flex flex-col justify-center shadow-lg">
            <!-- Welcome message container with stylish top border -->
            <div class="border-t-4 border-[#004a6a] pt-4 mb-6 md:border-t-0 md:pt-0">
                <h2 class="text-2xl sm:text-3xl font-semibold text-center md:text-left">Selamat Datang!</h2>
                <p class="text-[#606060] mt-1 text-sm text-center md:text-left">
                    Silakan masuk untuk mengelola transaksi dan pelanggan dengan mudah.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mb-2"
                    role="alert">
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 mb-2"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div id="alert-message" class="hidden text-center text-red-600 font-semibold mb-4"></div>

            <!-- Card container for the form on mobile -->
            <div class="bg-white rounded-lg shadow-md p-5 sm:p-6 border border-gray-100 max-w-md md:max-w-lg mx-auto w-full">
                <form id="loginForm" action="{{ route('login') }}" method="POST" class="w-full max-w mt-2">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#BDBDBD]">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input
                                class="text-sm w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="email" type="email" name="email" placeholder="Masukkan email anda" required
                                value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#BDBDBD]">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input
                                class="text-sm w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="password" type="password" name="password" placeholder="Masukkan password anda"
                                required>
                        </div>
                    </div>

                    {{-- <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember_me" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                        </div>
                        <a href="#" class="text-sm font-medium text-[#004a6a] hover:text-[#003a55]">Lupa
                            password?</a>
                    </div> --}}

                    <button type="submit"
                        class="w-full text-white font-semibold py-3 px-4 rounded-lg italic bg-[#004a6ae3] hover:bg-[#004a6a] hover:text-white hover:cursor-pointer hover:font-semibold hover:drop-shadow-2xl transition duration-300">
                        Masuk
                    </button>
                </form>
            </div>

            {{-- <!-- Footer information on mobile -->
            <div class="mt-6 text-center text-sm text-gray-600 md:hidden">
                <p>© 2025 Billing Manage. Semua hak dilindungi.</p>
                <div class="mt-2 flex justify-center space-x-4">
                    <a href="#" class="text-[#004a6a] hover:underline">Bantuan</a>
                    <a href="#" class="text-[#004a6a] hover:underline">Ketentuan</a>
                    <a href="#" class="text-[#004a6a] hover:underline">Privasi</a>
                </div>
            </div> --}}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                let email = $('#email').val();
                let password = $('#password').val();
                let _token = $('input[name="_token"]').val();
                let loginButton = $('button[type="submit"]');
                let originalText = loginButton.html();

                loginButton.prop('disabled', true).html('Memproses...');

                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: {
                        email: email,
                        password: password,
                        _token: _token
                    },
                    success: function(response) {
                        if (response.success) {
                            loginButton.html('Berhasil!');
                            setTimeout(function() {
                                window.location.href = response
                                    .redirect;
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        let response = xhr.responseJSON;
                        if (response && response.errors) {
                            $('#alert-message').removeClass('hidden').text(response.errors
                                .email || "Email atau password salah.");
                        }
                        loginButton.prop('disabled', false).html(originalText);
                    }
                });
            });
        });
    </script>
</body>

</html>
