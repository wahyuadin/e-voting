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
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar flex-shrink-0 me-3">
                                                        <span class="avatar-initial rounded bg-label-primary">
                                                            <img src="{{ asset('assets/data/kandidat/' . $kandidat->foto) }}"
                                                                alt="{{ $kandidat->foto }}">
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $kandidat->nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $kandidat->no_urut }}</td>
                                            <td>
                                                <p>{{ \Illuminate\Support\Str::words($kandidat->visi, 30, '...') }}</p>
                                            </td>
                                            <td>
                                                <p>{{ \Illuminate\Support\Str::words($kandidat->misi, 30, '...') }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-wrap gap-1">
                                                    <button class="btn btn-icon btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#edit{{ $kandidat->id }}">
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
                                            'modal_id' => 'edit' . $kandidat->id,
                                            'id' => $kandidat->id,
                                            'url' => url('/admin/kandidat/' . $kandidat->id),
                                            'title' => 'Edit Data | Kandidat',
                                            'body' => 'admin.partial.kandidat.edit',
                                        ])
                                        @endcomponent
                                        @component('components.modal', [
                                            'modal_id' => 'hapus' . $kandidat->id,
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
        'modal_id' => 'tambahKandidat',
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

        // Validasi Form dengan Bootstrap
        (function() {
            'use strict';

            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Fungsi Increment dan Decrement Nomor Urut
        const setupIncrementDecrement = (incrementId, decrementId, inputId) => {
            const incrementButton = document.getElementById(incrementId);
            const decrementButton = document.getElementById(decrementId);
            const inputField = document.getElementById(inputId);

            if (incrementButton && decrementButton && inputField) {
                incrementButton.addEventListener('click', () => {
                    inputField.value = parseInt(inputField.value) + 1;
                });

                decrementButton.addEventListener('click', () => {
                    if (parseInt(inputField.value) > 1) {
                        inputField.value = parseInt(inputField.value) - 1;
                    }
                });
            }
        };

        setupIncrementDecrement('incrementButton', 'decrementButton', 'noUrut');
        setupIncrementDecrement('incrementButtonEdit', 'decrementButtonEdit', 'noUrutEdit');

        // Fungsi untuk menampilkan toast
        function showToast(message, type = 'danger') {
            const toastHTML = `
            <div class="bs-toast toast fade show bg-${type}" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class='bx bx-bell me-2'></i>
                    <div class="me-auto fw-medium">Pemberitahuan</div>
                    <small>Beberapa detik lalu</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;

            const toastContainer = document.createElement('div');
            toastContainer.classList.add('position-fixed', 'top-0', 'end-0', 'p-3', 'mt-3');
            toastContainer.style.zIndex = 9999;
            toastContainer.innerHTML = toastHTML;

            document.body.appendChild(toastContainer);

            setTimeout(() => {
                toastContainer.remove();
            }, 5000);
        }

        // Form Submit dengan Fetch API
        document.getElementById('kandidatPost').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const fotoInput = document.querySelector('input[name="foto"]');
            if (fotoInput && fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            fetch(`{{ url('admin/kandidat') }}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Toastify({
                            text: 'Data Kandidat Berhasil Ditambah!',
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            style: {
                                background: "#28a745",
                                borderRadius: "12px",
                                color: "#FFFFFF",
                                fontSize: ".85rem",
                                padding: "1rem",
                                boxShadow: "0px 4px 6px rgba(0, 0, 0, 0.1)",
                                display: "flex",
                                alignItems: "center",
                                gap: "0.5rem"
                            },
                            avatar: "https://img.icons8.com/emoji/48/000000/check-mark-emoji.png"
                        }).showToast();
                        setTimeout(() => window.location.href = `{{ url('/admin/kandidat') }}`, 1000);
                    } else {
                        showToast(`Harap lengkapi semua kolom, ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data!');
                });
        });

        @if (session('success'))
            Toastify({
                text: `{{ session('success') }}`,
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "#28a745",
                    borderRadius: "12px",
                    color: "#FFFFFF",
                    fontSize: ".85rem",
                    padding: "1rem",
                    boxShadow: "0px 4px 6px rgba(0, 0, 0, 0.1)",
                    display: "flex",
                    alignItems: "center",
                    gap: "0.5rem"
                },
                avatar: "https://img.icons8.com/emoji/48/000000/check-mark-emoji.png"
            }).showToast();
        @endif

        @if (session('error'))
            Toastify({
                text: `{{ session('error') }}`,
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "#dc3545",
                    borderRadius: "12px",
                    color: "#FFFFFF",
                    fontSize: ".85rem",
                    padding: "1rem",
                    boxShadow: "0px 4px 6px rgba(0, 0, 0, 0.1)",
                    display: "flex",
                    alignItems: "center",
                    gap: "0.5rem"
                },
                avatar: "https://img.icons8.com/emoji/48/FFFFFF/exclamation-mark-emoji.png"
            }).showToast();
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast('{{ $error }}');
            @endforeach
        @endif
    </script>
@endpush()
