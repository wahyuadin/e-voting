@php
    $kandidat = \App\Models\admin\KandidatModel::find($id);
@endphp
<div class="modal-content">
    <form method="POST" action="{{ $url }}" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <input type="text" name="id" id="id" value="{{ $kandidat->id }}" hidden>
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <!-- Kolom untuk Nama Kandidat -->
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama Kandidat <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="exampleFormControlInput1"
                            placeholder="Masukan Nama Kandidat" name="nama" value="{{ $kandidat->nama }}">
                        <div id="exampleFormControlInput1Feedback" class="invalid-feedback">
                            {{ $errors->has('nama') ? $errors->first('nama') : 'Masukan Nama Kandidat.' }}
                        </div>
                    </div>
                </div>

                <!-- Kolom untuk No Urut dengan tombol +/- -->
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput2" class="form-label">No Urut <span
                                class="text-danger">*</span></label>
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-2">
                            <!-- Tombol Kurang -->
                            <button class="btn btn-danger btn-rounded w-100 w-sm-auto" type="button"
                                id="decrementButtonEdit">
                                <i class="bx bx-minus"></i>
                            </button>

                            <!-- Input Nomor -->
                            <input type="number" name="no_urut" class="form-control text-center w-100 w-sm-auto"
                                id="noUrutEdit" value="{{ $kandidat->no_urut }}" placeholder="Masukan No Urut" required
                                readonly>

                            <!-- Tombol Tambah -->
                            <button class="btn btn-primary btn-rounded w-100 w-sm-auto" type="button"
                                id="incrementButtonEdit">
                                <i class="bx bx-plus"></i>
                            </button>
                        </div>
                        <div id="exampleFormControlInput2Feedback" class="invalid-feedback">
                            Masukan No Urut.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="visi" class="form-label">Visi <span class="text-danger">*</span></label>
                <textarea class="form-control" name="visi" rows="5" required>{{ $kandidat->visi }}</textarea>
                <div id="visi" class="invalid-feedback">
                    Masukan Visi.
                </div>
            </div>
            <div class="mb-3">
                <label for="misi" class="form-label">Misi <span class="text-danger">*</span></label>
                <textarea class="form-control" name="misi" rows="5" required>{{ $kandidat->misi }}</textarea>
                <div id="misi" class="invalid-feedback">
                    Masukan Misi.
                </div>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Formal <span class="text-danger">*</span></label>
                <br>
                <img src="{{ asset('assets/data/kandidat/' . $kandidat->foto) }}" alt="foto-formal" class="img-fluid"
                    style="max-width: 20%; height: auto;">
                <p class="text-danger mt-2">*Lewati jika foto tidak diupdate!</p>
                <input type="file" class="form-control" name="foto" id="foto" value="{{ old('foto') }}"
                    accept="image/*" size="10240">
                <p><span class="text-success">Format : jpg, jpeg, png, max ukuran 10 MB</span></p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>
