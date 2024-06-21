<div class="modal modal-blur fade" id="modal-kategori" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="tambah-kategori" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
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
                    <button type="submit" class="btn btn-indigo btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>
