<div class="modal-content">
    <form action="{{ $url }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Upload File <span class="text-danger">*</span></label>
                <input type="file" name="excel" class="form-control" required accept=".xls,.xlsx" size="3072">
                <p>Note : <span class="text-danger">Format file harus .xls maksimal 3MB</span></p>
                <p>Download <a href="{{ asset('assets/data/excel/template.xlsx') }}">template</a></p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>
