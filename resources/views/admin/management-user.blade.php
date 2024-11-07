@extends('template.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ ucwords(Auth::user()->role) }} /</span>
            Management User
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <button type="button" class="btn btn-primary mb-3 mt-3" data-bs-toggle="modal"
                                data-bs-target="#tambahUser"><i class='bx bx-plus'></i></button>
                            <button type="button" class="btn btn-warning mb-3 mt-3" data-bs-toggle="modal"
                                data-bs-target="#excel"><i class="bi bi-file-earmark-spreadsheet"></i></button>
                            <table id="dataUser" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Nomor Induk Siswa</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $dataItem)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <img src="{{ asset('assets/data/profile/' . $dataItem->foto) }}"
                                                    alt="{{ $dataItem->foto }}" width="50" class="rounded">
                                                <span>{{ $dataItem->nama }}</span>
                                            </td>
                                            <td>{{ $dataItem->nis }}</td>
                                            <td>{{ $dataItem->email }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $dataItem->id }}">
                                                    <i class='bx bx-edit'></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#hapus{{ $dataItem->id }}">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @component('components.modal', [
                                            'modal_id' => 'edit' . $dataItem->id,
                                            'id' => $dataItem,
                                            'title' => 'Edit User | Management User',
                                            'url' => route('admin.user.edit', ['id' => $dataItem->id]),
                                            'body' => 'admin.partial.management-user.edit',
                                        ])
                                        @endcomponent
                                        @component('components.modal', [
                                            'modal_id' => 'hapus' . $dataItem->id,
                                            'title' => 'Hapus User | Management User',
                                            'url' => route('admin.user.delete', ['id' => $dataItem->id]),
                                            'body' => 'admin.partial.management-user.delete',
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
        'modal_id' => 'tambahUser',
        'title' => 'Tambah User | Management User',
        'url' => route('admin.user.post'),
        'body' => 'admin.partial.management-user.add',
    ])
    @endcomponent
    @component('components.modal', [
        'modal_id' => 'excel',
        'title' => 'Tambah User By Excel | Management User',
        'url' => route('admin.user.excel'),
        'body' => 'admin.partial.management-user.excel',
    ])
    @endcomponent
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataUser').DataTable();
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
                duration: 4000, // Sedikit lebih lama untuk memperhatikan pesan
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "#dc1000", // Warna merah dari Bootstrap untuk pesan error
                    borderRadius: "0.75rem",
                    color: "#FFFFFF",
                    fontSize: "0.85rem",
                    padding: "0.75rem 1rem",
                    boxShadow: "0px 6px 10px rgba(0, 0, 0, 0.15)", // Bayangan lebih besar untuk efek mengambang
                    display: "flex",
                    alignItems: "center",
                    gap: "0.75rem", // Sedikit jarak antara ikon dan teks
                    transition: "all 0.3s ease-in-out" // Menambahkan transisi untuk efek halus
                },
                avatar: "https://img.icons8.com/emoji/48/FFFFFF/exclamation-mark-emoji.png", // Ikon peringatan
                avatarStyle: {
                    borderRadius: "50%", // Membuat ikon berbentuk bulat
                    border: "2px solid #FFFFFF", // Border putih untuk kontras yang lebih baik
                },
                onClick: function() {
                    // Optional: bisa tambahkan aksi atau close toast ketika diklik
                }
            }).showToast();
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: `{{ $error }}`,
                    duration: 4000, // Sedikit lebih lama untuk memperhatikan pesan
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    style: {
                        background: "#dc1000", // Warna merah dari Bootstrap untuk pesan error
                        borderRadius: "0.75rem",
                        color: "#FFFFFF",
                        fontSize: "0.85rem",
                        padding: "0.75rem 1rem",
                        boxShadow: "0px 6px 10px rgba(0, 0, 0, 0.15)", // Bayangan lebih besar untuk efek mengambang
                        display: "flex",
                        alignItems: "center",
                        gap: "0.75rem", // Sedikit jarak antara ikon dan teks
                        transition: "all 0.3s ease-in-out" // Menambahkan transisi untuk efek halus
                    },
                    avatar: "https://img.icons8.com/emoji/48/FFFFFF/exclamation-mark-emoji.png", // Ikon peringatan
                    avatarStyle: {
                        borderRadius: "50%", // Membuat ikon berbentuk bulat
                        border: "2px solid #FFFFFF", // Border putih untuk kontras yang lebih baik
                    },
                    onClick: function() {
                        // Optional: bisa tambahkan aksi atau close toast ketika diklik
                    }
                }).showToast();
            @endforeach
        @endif
    </script>
@endpush()
