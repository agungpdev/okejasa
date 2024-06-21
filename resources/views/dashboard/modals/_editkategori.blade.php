<div class="modal modal-blur fade" id="modal-edit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="update-kategori" method="post">
                @csrf
                <input type="hidden" name="id" id="id-ekategori">
                <div class="modal-header">
                    <h5 class="modal-title">Update Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-end">
                    <div class="col">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="kategori" autocomplete="off">
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-update">Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>
