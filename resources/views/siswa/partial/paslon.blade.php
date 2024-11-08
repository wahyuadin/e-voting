<div class="modal-content">
    <form method="POST" action="{{ $url }}" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        @method('POST')
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin memilih kandidat ini? <br> Mohon diperhatikan bahwa setelah memilih, Anda tidak
                akan dapat memilih kandidat lain.</p>
        </div>
        <div class="modal-footer">
            <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Accept</button>
        </div>
    </form>
</div>