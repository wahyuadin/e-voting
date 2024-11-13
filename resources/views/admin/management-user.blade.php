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
                                </tbody>
                            </table>
                        </div>
                        <div id="modalContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            $('#dataUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user.data') }}",
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false
                    }, // Column for numbering
                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data, type, row) {
                            return `
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <img src="{{ asset('assets/data/profile/') }}/${row.foto}" alt="${row.nama}">
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">${row.nama}</h6>
                                <small class="text-muted">${row.role}</small>
                            </div>
                        </div>
                    `;
                        }
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button type="button" class="btn btn-primary" onclick="showEditModal(${row.id})">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button type="button" class="btn btn-danger" onclick="showDeleteModal(${row.id})">
                                    <i class='bx bx-trash'></i>
                                </button>
                            `;
                        }
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td:eq(0)', row).html(dataIndex + 1 + this.api().page.info().start);
                }
            });
        });

        // function showEditModal(userId) {
        //     $.ajax({
        //         url: `{{ url('admin/user/partial/edit/`+userId+`') }}`,
        //         method: 'GET',
        //         success: function(data) {
        //             const modalHtml = `
    //                 <div class="modal fade" id="editModal${userId}" tabindex="-1" aria-labelledby="editModalLabel${userId}" aria-hidden="true">
    //                     <div class="modal-dialog modal-xl">
    //                         <div class="modal-content">
    //                             <div class="modal-header">
    //                                 <h5 class="modal-title" id="editModalLabel${userId}">Edit User</h5>
    //                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    //                             </div>
    //                             <div class="modal-body">
    //                                 ${data} <!-- Konten dari form edit -->
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>
    //             `;
        //             $('#modalContainer').html(modalHtml);
        //             $('#editModal' + userId).modal('show');
        //         }
        //     });
        // }

        // function showDeleteModal(userId) {
        //     $.ajax({
        //         url: `{{ url('admin/user/partial/delete/`+userId+`') }}`,
        //         method: 'GET',
        //         success: function(data) {
        //             const modalHtml = `
    //                 <div class="modal fade" id="deleteModal${userId}" tabindex="-1" aria-labelledby="deleteModalLabel${userId}" aria-hidden="true">
    //                     <div class="modal-dialog modal-xl">
    //                         <div class="modal-content">
    //                             <div class="modal-header">
    //                                 <h5 class="modal-title" id="deleteModalLabel${userId}">Hapus User</h5>
    //                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    //                             </div>
    //                             <div class="modal-body">
    //                                 ${data} <!-- Konten konfirmasi hapus -->
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>
    //             `;
        //             $('#modalContainer').html(modalHtml);
        //             $('#deleteModal' + userId).modal('show');
        //         }
        //     });
        // }

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
