@extends('dashboard.layout.template')
@section('dashboard')
<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
            Overview
            </div>
            <h2 class="page-title">
            Role Managamen
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
            <a href="#" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-role">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah Role
            </a>
            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-role" aria-label="Create new report">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
            </a>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-8">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table id="table-role" class="table is-striped is-hoverable">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Role</th>
                                  <th>Option</th>
                                  <th class="w-1"></th>
                                </tr>
                              </thead>
                              <tbody>
                                  @foreach ($data as $key => $val)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-muted">
                                      {{$val->name}}
                                    </td>
                                    <td class="text-muted"><a href="#" id="permission" class="text-reset" data-roles="{{encrypt($val->id)}}" data-bs-toggle="modal" data-bs-target="#modal-permission">Permission</a></td>
                                    <td>
                                      <a href="#" data-roles="{{encrypt($val->id)}}">Edit</a>
                                    </td>
                                  </tr>
                                  @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head.style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
@endpush

@push('foot.script')
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#table-role').DataTable();
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    $(document).ready(function(){

        $(document).on('submit','#tambah-role',function(e){
            e.preventDefault();
            const data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardpengaturanrole.store')}}',
                data:data,
                contentType:'application/json',
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function() {
                $('.btn-save').prop('disabled', true);
                $('.btn-save').html('Menyimpan Data...');
                },
                complete: function() {
                $('.btn-save').prop('disabled', false);
                $('.btn-save').html('Simpan');
                },
                success:function(response){
                    if(response.error == true){
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Warning!",
                            text: response.message,
                            showConfirmButton: true,
                        })
                    }else{
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        })
                        .then((result)=>{
                            location.href="{{url('/dashboard/pengaturan/role-managemen')}}";
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
            });
        });

        $(document).on('click','#permission',function(e){
            e.preventDefault()
            let ID = $(this).data('roles');
            $.ajax({
                url:'{{route('dashboardpengaturanrolepermission.edit')}}',
                type: 'get',
                dataType: 'json',
                data: {
                id: ID
                },
                success:function(res){
                    $('#temp-permission').html('');
                    const data = res.result;
                    const role = res.role;
                    $('#current-role').html(`Role ${role.name}`);
                    $('#hidden-role').val(`${role.name}`);

                    data.map((val,idx)=>{
                        $('#temp-permission').append(`
                            <label class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="${val.name}" value="${val.name}" ${val.check ? 'checked' : ''} ${res.admin ? 'disabled':''}>
                                  <span class="form-check-label">${val.name}</span>
                            </label>
                        `)
                    });
                }
            })
        })

        $(document).on('submit','#tambah-permission',function(e){
            e.preventDefault();
            const data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardpengaturanrolepermission.store')}}',
                data:data,
                contentType:'application/json',
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function() {
                $('.btn-save').prop('disabled', true);
                $('.btn-save').html('Menyimpan Data...');
                },
                complete: function() {
                $('.btn-save').prop('disabled', false);
                $('.btn-save').html('Simpan');
                },
                success:function(response){
                    if(response.error == true){
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Warning!",
                            text: response.message,
                            showConfirmButton: true,
                        })
                    }else{
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        }).then((result)=>{
                            location.href="{{url('/dashboard/pengaturan/role-managemen')}}";
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
            });
        });
    })
</script>
@endpush

@section('modal')
    @include('dashboard.modals._rolemodal')
    @include('dashboard.modals._permission')
@endsection
