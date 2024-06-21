@extends('dashboard.layout.template')
@section('dashboard')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Account Settings
          </h2>
        </div>
      </div>
      @if (session('status')==='profile-updated')
      <div class="alert alert-success alert-dismissible mt-3" role="alert">
          <div class="d-flex">
          <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
          </div>
          <div>
              Your Account updated!
          </div>
          </div>
          <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
      </div>
      @endif
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="row g-0">
          <div class="col-3 d-none d-md-block border-end">
            <div class="card-body">
              <h4 class="subheader">Profile settings</h4>
              <div class="list-group list-group-transparent">
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
              </div>
            </div>
          </div>
          <div class="col d-flex flex-column">
            <form action="{{route('profile.update')}}" method="post">
                @csrf
                @method('patch')
                <div class="card-body">
                  <h2 class="mb-4">My Account</h2>
                  <h3 class="card-title">Profile Details</h3>
                  <div class="row align-items-center mb-3">
                    <div class="col-auto"><span class="avatar avatar-xl">{{substr($user->name,0,2)}}</span>
                    </div>
                  </div>
                  <div class="row g-3">
                    <div class="col-md">
                      <div class="form-label">Full Name</div>
                      <input type="text" class="form-control" value="{{$user->name}}" name="name">
                    </div>
                    <div class="col-md">
                      <div class="form-label">Role Name</div>
                      <input type="text" class="form-control" value="{{$user->getRoleNames()[0]}}" disabled>
                    </div>
                    <div class="col-md">
                      <div class="form-label">Registered</div>
                      <input type="text" class="form-control"
                 value="{{date_format($user->created_at,'d F, Y')}}" disabled>
                    </div>
                  </div>
                  <h3 class="card-title mt-4">Email</h3>
                  <p class="card-subtitle">This contact is used as a user to log in to the application.</p>
                  <div>
                    <div class="row g-2">
                      <div class="col-auto">
                        <input type="email" class="form-control w-auto" name="email" value="{{$user->email}}" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <h3 class="card-title mt-4">Password</h3>
                  <p class="card-subtitle">You can change your password if you feel your account is not safe.</p>
                  <div>
                    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-password">
                      Set new password
                    </a>
                  </div>
                </div>
                <div class="card-footer bg-transparent mt-auto">
                  <div class="btn-list justify-content-end">
                    <a href="#" class="btn">
                      Cancel
                    </a>
                    <button type="submit" class="btn btn-indigo">
                      Submit
                    </button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('modal')
    @include('dashboard.modals._newpassword')
@endsection
@push('foot.script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    $(document).ready(function(){

        $(document).on('submit','#change-pass',function(e){
            e.preventDefault();
            const data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('password.update')}}',
                data: data,
                contentType:'application/json',
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function() {
                $('.btn-save').prop('disabled', true);
                $('.btn-save').html('Memproses data...');
                },
                complete: function() {
                $('.btn-save').prop('disabled', false);
                $('.btn-save').html('Simpan');
                },
                success:function(response){
                    let error = response.error;
                    if(error==true){
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Peringatan!",
                            text: response.message,
                            showConfirmButton: true,
                        })
                    }else{
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        }).then((result)=>{
                            location.href='{{route('profile.edit')}}';
                        });
                    }
                },
                error:function(jqXHR,textStatus){
                    if(jqXHR.status == 500){
                        Swal.fire({
                            position: "center",
                            icon: textStatus,
                            title: jqXHR.statusText,
                            text: "Silahkan hubungi administrator",
                            showConfirmButton: true,
                            confirmButtonColor:"#d63939",
                        });
                    }
                }
            })
        })
    })
</script>
@endpush
