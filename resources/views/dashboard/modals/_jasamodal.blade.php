<div class="modal modal-blur fade" id="modal-jasa" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="tambah-jasa" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jasa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-end gap-2">
                        <div class="col-12">
                            <label class="form-label">Nama Jasa</label>
                            <input type="text" class="form-control" name="jasa" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Kategori</label>
                            <select class="form-select" name="kategori" id="">
                                <option value="">--Pilih Kategori--</option>
                                @foreach ($data as $key=>$val)
                                    <option value="{{$val->id}}">{{$val->namakategori}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Rating</label>
                            <input type="number" class="form-control" name="rating" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga Sebelum Diskon</label>
                            <input type="number" class="form-control" name="harga" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Harga Setelah Diskon</label>
                            <input type="number" class="form-control" name="hargadiskon" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deksripsi</label>
                            <textarea name="deskripsi" class="form-control" id="" cols="30" rows="5"></textarea>
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
