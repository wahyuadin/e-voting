<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name') }} | Login Page</title>
    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- end vite --}}
    <meta name="description" content="{{ config('app.name') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    @php
        $rememberDeviceDecoded = isset($rememberDevice) ? json_decode($rememberDevice) : null;
    @endphp
    @include('sweetalert::alert')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="d-flex justify-content-center">
                            <img src="https://yt3.googleusercontent.com/MtwQrazWIGSDbi74o-dYkpjTP6HJZUY7I_s8xrAypIezzW31cHyWAZJB488dq45gw_fszrtV=s900-c-k-c0x00ffffff-no-rj"
                                alt="logo-smk" width="200" class="mb-3">
                        </div>
                        <!-- /Logo -->
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h4 class="mb-2">Aplikasi Voting Sekolah!👋</h4>
                                <p class="mb-4">Silahkan Login untuk melanjutkan</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ url('/') }}" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="nis" class="form-label">NOMOR INDUK SISWA</label>
                                <input type="number" class="form-control" id="nis" name="nis"
                                    value="{{ $rememberDeviceDecoded ? $rememberDeviceDecoded->nis : '' }}"
                                    placeholder="Masukan NIS" required autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        value="{{ $rememberDeviceDecoded ? $rememberDeviceDecoded->password : '' }}"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        name="remember_device" {{ $rememberDevice ? 'checked' : '' }} />
                                    <label class="form-check-label" for="remember-me"> Simpan data </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary d-grid w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- toastify --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- custome --}}
    <script>
        document.getElementById("formAuthentication").addEventListener("submit", function(event) {
            event.preventDefault();

            // Ambil data dari form
            const nis = document.getElementById("nis").value;
            const password = document.getElementById("password").value;

            // Kirim data ke API Laravel
            fetch(`{{ url('/') }}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nis,
                        password
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    if (data.status === "success") {
                        Toastify({
                            text: "Login berhasil!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4CAF50",
                            close: true
                        }).showToast();

                    } else {
                        Toastify({
                            text: data.message || "Login gagal, periksa kembali NIS dan password Anda.",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#FF0000",
                            close: true
                        }).showToast();
                    }
                })
                .catch(error => {
                    Toastify({
                        text: "Terjadi kesalahan pada server.",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#FF0000",
                        close: true
                    }).showToast();
                    console.error("Error:", error);
                });
        });
    </script>


</body>

</html>
