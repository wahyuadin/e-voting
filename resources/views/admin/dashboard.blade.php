@extends('template.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-center row" style="height: 100%;">
                        <div class="col-sm-7 d-flex justify-content-center flex-column">
                            <div class="card-body text-left">
                                <h4 class="card-title text-primary">Selamat Datang, {{ Auth::user()->nama }}! 🎉</h4>
                                <p class="mb-4">
                                    Di aplikasi voting online <span class="fw-bold">SMKN 1 Rengasdengklok - Karawang</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left d-flex justify-content-center">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                                    class="img-fluid max-w-100" style="max-height: 200px; object-fit: contain;"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->role == 'admin')
                <!-- chart js -->
                <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-12">
                                <h5 class="card-header m-0 me-2 pb-3">Presentase Perolehan Suara</h5>
                                <canvas id="chartline" class="px-2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <!-- rekapitulasi -->
            <div class="col-md-6 col-lg-4 col-xl-12 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2 d-flex flex-column" style="text-align: justify; line-height: 1.5;">
                                <span>Rekapitulasi Data Sementara Pemilihan Ketua OSIS - SMKN 1 Rengasdengklok</span>
                                <span>Tahun 2024</span>
                            </h5>
                            <small class="text-muted" style="text-align: justify;">
                                Update tanggal {{ \Carbon\Carbon::now()->isoFormat('DD/MM/YYYY - HH:mm') }} WIB
                            </small>
                        </div>
                    </div>
                    <div class="card-body mt-5">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                            <!-- Teks di bagian kiri -->
                            <div class="d-flex flex-column align-items-left gap-1 mb-3 mb-md-0">
                                <span>Kandidat Pemilihan Terbanyak</span>
                                @php
                                    $maxPemilih = $data->sortByDesc(fn($item) => $item->pemilih->count())->first();
                                    $jumlahMaxPemilih = $maxPemilih ? $maxPemilih->pemilih->count() : 0;
                                @endphp
                                <h2 class="mb-2">
                                    {{ $jumlahMaxPemilih }} Suara
                                </h2>
                                @if ($data->max('pemilih'))
                                    <p>Sdr/i <b>{{ optional($data->max('pemilih')->first())->user->nama ?? '-' }}</b>
                                    @else
                                    <p><b>Tidak ada kandidat</b>
                                @endif
                                </p>
                            </div>
                            <!-- Chart di bagian kanan -->
                            <div style="width: 100%; max-width: 300px; height: auto;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kandidat</th>
                                        @if (Auth::user()->role == 'admin')
                                            <th>Suara</th>
                                        @endif
                                        <th>Presentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $dataItem)
                                        <tr>
                                            <td>
                                                <b>{{ $no++ }}</b>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar flex-shrink-0 me-3">
                                                        <span class="avatar-initial rounded bg-label-primary">
                                                            <img src="{{ asset('assets/data/kandidat/' . $dataItem->foto) }}"
                                                                alt="">
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0"><b>{{ $dataItem->nama }}</b></h6>
                                                        <small class="text-muted">No urut {{ $dataItem->no_urut }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            @if (Auth::user()->role == 'admin')
                                                <td class="align-middle">
                                                    <div>
                                                        <p class="mb-0">{{ $dataItem->pemilih->count() }} Suara</p>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="align-middle">
                                                <div class="user-progress">
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $dataItem->pemilih->count() > 0 ? ($dataItem->pemilih->count() / App\Models\User::count()) * 100 : 0 }}%;"
                                                            aria-valuenow="{{ $dataItem->pemilih->count() > 0 ? ($dataItem->pemilih->count() / App\Models\User::count()) * 100 : 0 }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <small
                                                                class="fw-semibold text-white">{{ $dataItem->pemilih->count() > 0 ? round(($dataItem->pemilih->count() / App\Models\User::count()) * 100, 2) : 0 }}%</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/ Order Statistics -->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @php
        $total_suara = App\Models\User::count(); // Total suara
        $persentase = $data->map(function ($item) use ($total_suara) {
            return $total_suara > 0 ? round(($item->pemilih->count() / $total_suara) * 100, 2) : 0;
        });
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        const chartline = document.getElementById('chartline');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($data->pluck('nama')),
                datasets: [{
                    data: @json($persentase)
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ": " + tooltipItem.raw + " % Suara";
                            }
                        }
                    }
                }
            }
        });

        new Chart(chartline, {
            type: 'bar',
            data: {
                labels: @json($data->pluck('nama')),
                datasets: [{
                    data: @json(
                        $data->pluck('pemilih')->map(function ($item) {
                            return $item->count();
                        })),
                    label: 'Presentase Kandidat',
                    borderColor: '#2196F3',
                    backgroundColor: 'rgba(33, 150, 243, 0.2)',
                    fill: true,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ": " + tooltipItem.raw + " Suara";
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                // Menambahkan background ke area chart
                backgroundColor: 'rgba(240, 240, 240, 0.5)', // Background chart (berwarna abu-abu muda)
            }
        });
    </script>
@endpush
