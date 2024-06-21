<div class="modal modal-blur fade" id="modal-password" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="change-pass" method="post">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title">Set New Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-end">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label required">Current Password</label>
                            <input type="password" class="form-control" name="current_password" autocomplete="off">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">New Password</label>
                            <input type="password" class="form-control" name="password" autocomplete="off">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>
