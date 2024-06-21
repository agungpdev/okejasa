<div class="modal modal-blur fade" id="modal-submenu" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="tambah-submenu" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sub Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-end">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama Submenu</label>
                                <input type="text" class="form-control" name="submenu" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label required">Parent Menu</label>
                                <select type="text" class="form-select select-rsub" name="menu">
                                <option value="">--Pilih Menu--</option>
                                @foreach ($menu as $k => $r)
                                    <option value="{{encrypt($r->id)}}">{{$r->menu}}</option>
                                @endforeach
                                </select>
                              </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label required">Route</label>
                                <select type="text" class="form-select select-rsub" name="route">
                                <option value="">--Pilih Route Menu--</option>
                                @foreach ($route as $k => $r)
                                    <option value="{{$k.'%'.$r}}">{{$k}}</option>
                                @endforeach
                                </select>
                              </div>
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
