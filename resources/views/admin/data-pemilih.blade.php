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
