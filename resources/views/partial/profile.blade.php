<div class="modal-content">
    <form action="{{ $url }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <!-- Kolom untuk Nama Kandidat -->
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Kandidat" name="nama"
                            required value="{{ $id->nama }}" required>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Siswa<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nomor Induk Siswa" name="nis"
                            required value="{{ $id->nis }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" class="form-control" required value="{{ $id->role }}" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" required value="{{ $id->email }}"
                    placeholder="Masukan Email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password <span class="text-secondary">*</span></label>
                <input type="password" class="form-control" name="password" placeholder="Masukan Password">
            </div>
            <div class="mb-3">
                <label class="form-label">Repassword <span class="text-secondary">*</span></label>
                <input type="password" class="form-control" name="repassword" placeholder="Masukan Repassword">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Default <span class="text-secondary">*</span></label>
                <br>
                <img src="{{ asset('assets/data/profile/' . $id->foto) }}" alt="{{ $id->foto }}" class="img-fluid"
                    style="max-width: 20%; height: auto;">
                <p class="text-danger mt-2">Format : jpg, jpeg, png, max ukuran 10 MB</p>
                <input type="file" class="form-control" name="foto" accept="image/*" size="10240">
                <span class="text-secondary">*jika tidak diupdate maka lewati saja</span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>
