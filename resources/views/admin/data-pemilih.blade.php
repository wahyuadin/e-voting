@extends('template.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ ucwords(Auth::user()->role) }} /</span>
            Result Voting Data
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Grid Card -->
                        <div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
                            @foreach ($data as $dataItem)
                                <div class="col">
                                    <div class="card h-100">
                                        <img class="card-img-top" width="100"
                                            src="{{ asset('assets/data/kandidat/' . $dataItem->foto) }}"
                                            alt="Card image cap" />
                                        <div class="card-body">
                                            <h3 class="card-title text-center"><b>{{ $dataItem->nama }}</b></h3>
                                            <h5 class="text-center">No Urut. {{ $dataItem->no_urut }}</h5>

                                            <!-- Membungkus tabel dengan .table-responsive -->
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="w-25">Visi</td>
                                                        <td class="w-5">:</td>
                                                        <td style="text-align: justify">{{ $dataItem->visi }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-25">Misi</td>
                                                        <td class="w-5">:</td>
                                                        <td style="text-align: justify">{{ $dataItem->misi }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal"
                                                data-bs-target="#detail{{ $dataItem->id }}">
                                                <i class="bx bx-detail"></i> Detail
                                            </button>
                                            @component('components.modal', [
                                                'modal_id' => 'detail' . $dataItem->id,
                                                'data' => $dataItem,
                                                'title' => 'Detail Data | Data Pemilih',
                                                'body' => 'admin.partial.data-pemilih.detail',
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#detailUser').DataTable();
        });
    </script>
@endpush
