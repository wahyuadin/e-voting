@extends('template.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-center row" style="height: 100%;">
                        <div class="col-sm-7 d-flex justify-content-center flex-column">
                            <div class="card-body text-left">
                                <h2 class="card-title text-primary">Tentukan Pilihanmu, {{ Auth::user()->nama }}!</h2>
                                <p class="mb-4" style="text-align: justify">
                                    Pastikan pilihanmu benar-benar sesuai, karena keputusanmu akan digunakan untuk
                                    kepentingan sekolah. Mekanisme ini hanya dapat diakses oleh siswa SMKN 1 Rengasdengklok
                                    - Karawang dan hanya dapat digunakan satu kali. <br>
                                    <span class="fw-bold">Selamat Berpartisipasi 🎉</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left d-flex justify-content-center">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/demokrasi.png') }}" class="img-fluid max-w-100"
                                    style="max-height: 200px; object-fit: contain;" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- rekapitulasi -->
            <div class="col-md-6 col-lg-12 col-xl-12 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">
                            <h2 class="m-0 me-2 d-flex flex-column" style="text-align: center; line-height: 1.5;">
                                <span>CALON KETUA OSIS SMKN 1 RENGASDENGKLOK - KARAWANG </span>
                            </h2>
                            <p class="text-muted mt-3" style="text-align: center;">
                                Update tanggal {{ \Carbon\Carbon::now()->isoFormat('DD/MM/YYYY - HH:mm') }} WIB
                            </p>
                        </div>
                    </div>

                    <div class="card-body mt-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <!-- Grid Card -->
                                        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
                                            @foreach ($data as $dataItem)
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <div
                                                            style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                            <img class="card-img-top"
                                                                src="{{ asset('assets/data/kandidat/' . $dataItem->foto) }}"
                                                                alt="{{ $dataItem->foto }}"
                                                                style="width: 400px; height: 400px; object-fit: contain;" />
                                                        </div>
                                                        <div class="card-body">
                                                            <h3 class="card-title text-center">
                                                                <b>{{ $dataItem->nama }}</b>
                                                            </h3>
                                                            <h5 class="text-center">No Urut. {{ $dataItem->no_urut }}
                                                            </h5>

                                                            <!-- Membungkus tabel dengan .table-responsive -->
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <td class="w-25">Visi</td>
                                                                        <td class="w-5">:</td>
                                                                        <td style="text-align: justify">
                                                                            {{ $dataItem->visi }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-25">Misi</td>
                                                                        <td class="w-5">:</td>
                                                                        <td style="text-align: justify">
                                                                            {{ $dataItem->misi }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <button type="button" class="btn btn-secondary w-100 mt-3"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#paslon{{ $dataItem->id }}"
                                                                @if (\App\Models\Admin\DataPemilihModel::where('user_id', auth()->user()->id)->exists()) disabled @endif>
                                                                <i class="bi bi-pin-fill"></i> Pilih Kandidat
                                                            </button>

                                                            @component('components.modal', [
                                                                'modal_id' => 'paslon' . $dataItem->id,
                                                                'url' => route('siswa.voting.edit', ['id' => $dataItem->id]),
                                                                'title' => 'Voting Kandidat | Pilih Kandidat',
                                                                'body' => 'siswa.partial.paslon',
                                                            ])
                                                            @endcomponent
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Order Statistics -->
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
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
