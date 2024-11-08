<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h5>Total Pemilih : {{ $data->pemilih->count() }} Orang</h5>
        <div class="table-responsive">
            <table class="table" id="detailUser">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Nomor Induk</th>
                        <th scope="col">Riwayat Tanggal input</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data->pemilih as $result)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $result->user->nama }}</td>
                            <td>{{ $result->user->nis }}</td>
                            <td>{{ \Carbon\Carbon::parse($result->created_at)->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
