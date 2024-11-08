@extends('template.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ ucwords(Auth::user()->role) }} /</span> Riwayat
            Pemilihan
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userTable" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kandidat</th>
                                        <th>No Urut</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th>Diinput Pada</th>
                                        <th>Riwayat Tanggal input</th>
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
                                                            <img src="{{ asset('assets/data/kandidat/' . $kandidat->kandidat->foto) }}"
                                                                alt="{{ $kandidat->kandidat->foto }}">
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $kandidat->kandidat->nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $kandidat->kandidat->no_urut }}</td>
                                            <td>
                                                <p>{{ \Illuminate\Support\Str::words($kandidat->kandidat->visi, 30, '...') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p>{{ \Illuminate\Support\Str::words($kandidat->kandidat->misi, 30, '...') }}
                                                </p>
                                            </td>
                                            <td>
                                                {{ $kandidat->created_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($kandidat->created_at)->format('d M Y H:i') }}
                                            </td>
                                        </tr>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
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
@endpush
