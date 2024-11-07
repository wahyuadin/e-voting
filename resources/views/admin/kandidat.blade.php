@extends('template.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ ucwords(Auth::user()->role) }} /</span> Data
            Kandidat
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <button type="button" class="btn btn-primary mb-3 mt-3" data-bs-toggle="modal"
                                data-bs-target="#tambahKandidat"><i class='bx bx-plus'></i> Tambah Data</button>
                            <table id="userTable" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kandidat</th>
                                        <th>No Urut</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $kandidat)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <img src="{{ asset('assets/data/kandidat/' . $kandidat->foto) }}"
                                                    alt="{{ $kandidat->foto }}" width="50" height="50"
                                                    class="rounded">
                                                <span>{{ $kandidat->nama }}</span>
                                            </td>
                                            <td>{{ $kandidat->no_urut }}</td>
                                            <td>
                                                <p>{{ $kandidat->visi }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $kandidat->misi }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-wrap gap-1">
                                                    <button class="btn btn-icon btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#{{ $kandidat->id }}">
                                                        <i class='bx bxs-edit'></i>
                                                    </button>
                                                    <button class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#hapus{{ $kandidat->id }}">
                                                        <i class='bx bxs-trash'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @component('components.modal', [
                                            'id' => $kandidat->id,
                                            'url' => url('/admin/kandidat/' . $kandidat->id),
                                            'title' => 'Edit Data | Kandidat',
                                            'body' => 'admin.partial.kandidat.edit',
                                        ])
                                        @endcomponent
                                        @component('components.modal', [
                                            'id' => 'hapus' . $kandidat->id,
                                            'url' => url('/admin/kandidat/' . $kandidat->id),
                                            'title' => 'Hapus Data | Kandidat',
                                            'body' => 'admin.partial.kandidat.delete',
                                        ])
                                        @endcomponent
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @component('components.modal', [
        'id' => 'tambahKandidat',
        'title' => 'Tambah Data | Kandidat',
        'body' => 'admin.partial.kandidat.add',
    ])
    @endcomponent
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });

        (function() {
            'use strict';

            // Ambil semua form yang menggunakan kelas .needs-validation
            const forms = document.querySelectorAll('.needs-validation');

            // Loop melalui semua form dan tambahkan event listener untuk mencegah pengiriman jika tidak valid
            Array.from(forms).forEach((form) => {
                form.addEventListener(
                    'submit',
                    (event) => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        // Tambahkan kelas was-validated untuk menampilkan pesan validasi Bootstrap
                        form.classList.add('was-validated');
                    },
                    false
                );
            });
        })();

        const incrementButton = document.getElementById('incrementButton');
        const decrementButton = document.getElementById('decrementButton');
        const inputField = document.getElementById('noUrut');

        // Event untuk tombol tambah
        incrementButton.addEventListener('click', () => {
            inputField.value = parseInt(inputField.value) + 1;
        });

        // Event untuk tombol kurang
        decrementButton.addEventListener('click', () => {
            if (inputField.value > 1) { // Agar nilai tidak kurang dari 1
                inputField.value = parseInt(inputField.value) - 1;
            }
        });

        document.getElementById('kandidatPost').addEventListener('submit', function(event) {
            function showToast(message) {
                // Buat elemen toast
                const toastHTML = `
                    <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <i class='bx bx-bell me-2'></i>
                            <div class="me-auto fw-medium">Pemberitahuan</div>
                            <small>Beberapa detik lalu</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                `;

                // Tempatkan toast di dalam container (biasanya di bagian bawah halaman)
                const toastContainer = document.createElement('div');
                toastContainer.classList.add('position-fixed', 'top-0', 'end-0', 'p-3', 'mt-3');
                toastContainer.style.zIndex = 9999; // Menambahkan z-index untuk memastikan berada di depan modal
                toastContainer.style.transition = 'opacity 2s ease-in-out';
                toastContainer.innerHTML = toastHTML;


                // Tambahkan ke body
                document.body.appendChild(toastContainer);

                // Setelah beberapa detik, hapus toast
                setTimeout(() => {
                    toastContainer.remove();
                }, 5000); // 5000 ms = 5 detik
            }
            event.preventDefault(); // Mencegah form untuk submit secara default

            // Ambil data form
            const formData = new FormData(this); // Ambil data dari form

            // Ambil nilai dari file input dan tambahkan ke formData
            const fotoInput = document.querySelector('input[name="foto"]');
            if (fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            // Gunakan Fetch API untuk mengirim data ke API
            fetch(`{{ url('admin/kandidat') }}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json()) // Mengambil response dalam bentuk JSON
                .then(data => {
                    // Menangani respon dari API (berhasil)
                    if (data.status === 'success') {
                        Toastify({
                            text: 'Data Kandidat Berhasil Ditambah!',
                            duration: 3000,
                            destination: "https://github.com/apvarun/toastify-js",
                            newWindow: true,
                            close: true,
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "#8BC34A",
                                borderRadius: "1rem",
                                textTransform: "uppercase",
                                fontSize: ".75rem"
                            },
                            onClick: function() {} // Callback after click
                        }).showToast();
                        setTimeout(function() {
                            window.location.href = `{{ url('/admin/kandidat') }}`;
                        }, 1000);
                    } else {
                        showToast('Harap lengkapi semua kolom, ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data!');
                });
        });

        @if (session('success'))
            // Jika terdapat pesan sukses, tampilkan Toastify
            Toastify({
                text: `{{ session('success') }}`, // Menambahkan ikon centang di depan teks
                duration: 3000,
                newWindow: false,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#28a745", // Warna hijau success dari Bootstrap
                    borderRadius: "12px",
                    color: "#FFFFFF",
                    fontSize: ".85rem",
                    padding: "1rem",
                    boxShadow: "0px 4px 6px rgba(0, 0, 0, 0.1)", // Menambahkan bayangan agar lebih elegan
                    display: "flex", // Agar ikon dan teks sejajar
                    alignItems: "center",
                    gap: "0.5rem" // Jarak antara ikon dan teks
                },
                avatar: "https://img.icons8.com/emoji/48/000000/check-mark-emoji.png", // URL gambar ikon centang
                avatarStyle: {
                    borderRadius: "50%", // Membuat gambar berbentuk bulat
                    border: "2px solid white", // Opsional: menambahkan border putih di sekitar gambar
                },
                onClick: function() {} // Callback setelah klik
            }).showToast();
        @endif
        @if (session('error'))
            Toastify({
                text: `{{ session('error') }}`, // Menambahkan ikon centang di depan teks
                duration: 3000,
                newWindow: false,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#dc3530", // Warna merah danger dari Bootstrap
                    borderRadius: "12px",
                    color: "#FFFFFF",
                    fontSize: ".85rem",
                    padding: "1rem",
                    boxShadow: "0px 4px 6px rgba(0, 0, 0, 0.1)", // Menambahkan bayangan agar lebih elegan
                    display: "flex", // Agar ikon dan teks sejajar
                    alignItems: "center",
                    gap: "0.5rem" // Jarak antara ikon dan teks
                },
                avatar: "https://img.icons8.com/emoji/48/FFFFFF/exclamation-mark-emoji.png",
                onClick: function() {} // Callback setelah klik
            }).showToast();
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast('{{ $error }}');
            @endforeach
        @endif
    </script>
@endpush()
