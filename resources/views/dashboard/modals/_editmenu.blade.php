<div class="modal modal-blur fade" id="modal-editmenu" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="update-menu" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="id" id="id-emenu">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-end">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label required">Nama Menu</label>
                                <input type="text" class="form-control" name="menu" id="emenu" autocomplete="off">
                            </div>
                        </div>
                        <div class="col" id="route-emenu">
                            <div class="mb-3">
                                <label class="form-label required">Route</label>
                                <select type="text" class="form-select" id="select-emenu" name="route">
                                <option value="">--Pilih Route Menu--</option>

                                </select>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-green btn-update">Update</button>
                </div>
            </form>
        </div>
    </div>
  </div>
