<div class="modal modal-blur fade" id="modal-menu" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="tambah-menu" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Nama Menu</label>
                                <input type="text" class="form-control" name="menu" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6" id="route-box">
                            <div class="mb-3">
                                <label class="form-label required">Route</label>
                                <select type="text" class="form-select select-rmenu" id="select-route" name="route">
                                <option value="">--Pilih Route Menu--</option>
                                @foreach ($route as $k => $r)
                                    <option value="{{$k.'%'.$r}}">{{$k}}</option>
                                @endforeach
                                </select>
                              </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Select Icons</label>
                                <select type="text" class="select-icons" name="icons">
                                    <option value="">--Pilih Icon--</option>
                                    @foreach ($icons as $key => $val)
                                        <option value="{{$val->icon}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub menu (optional)</label>
                            <label class="row">
                                <span class="col">Menu memiliki sub menu?</span>
                                <span class="col-auto">
                                  <label class="form-check form-check-single form-switch">
                                    <input class="form-check-input" type="checkbox" name="sub">
                                  </label>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="box-submenu">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Sub Menu</label>
                                <input type="text" class="form-control" id="submenu" name="submenus[0][submenu]" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Route</label>
                                <select type="text" class="form-select" id="select-route" name="submenus[0][route]">
                                    <option value="">--Pilih Route Menu--</option>
                                    @foreach ($route as $k => $r)
                                    <option value="{{$k.'%'.$r}}">{{$k}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">Opsi</label>
                                <a href="#" id="add" class="btn btn-outline-indigo">Tambah</a>
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
