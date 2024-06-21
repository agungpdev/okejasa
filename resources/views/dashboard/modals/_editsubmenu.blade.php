<div class="modal modal-blur fade" id="modal-editsubmenu" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="update-submenu" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="id" id="id-esubmenu">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Submenu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-end">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama Submenu</label>
                                <input type="text" class="form-control" id="esubmenu" name="submenu" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label required">Parent Menu</label>
                                <select type="text" class="form-select" id="select-eparent" name="menu">

                                </select>
                              </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label required">Route</label>
                                <select type="text" class="form-select" id="select-esubroute" name="route">

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
