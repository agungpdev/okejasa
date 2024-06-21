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
            Daftar Jasa
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
            <a href="#" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-jasa">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah Jasa
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table id="table-kategori" class="table is-striped is-hoverable">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Gambar</th>
                                  <th>Nama Jasa</th>
                                  <th>Kategori</th>
                                  <th>Harga Diskon</th>
                                  <th>Deskripsi</th>
                                  <th>Rate</th>
                                  <th>Harga Awal</th>
                                  <th>Tanggal</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($jasa as $key => $val)
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td class="text-muted">
                                    <img src="{{asset('storage/thumbnail'.'/'.$val->gambar)}}" alt="{{$val->gambar}}" width="40">
                                  </td>
                                  <td class="text-muted">
                                    {{$val->namajasa}}
                                  </td>
                                  <td class="text-muted">
                                    {{$val->kategori}}
                                  </td>
                                  <td class="text-muted">
                                    {{$val->hargasetelah}}
                                  </td>
                                  <td class="text-muted">
                                    {{$val->deskripsi}}
                                  </td>
                                  <td class="text-muted">
                                    {{$val->rating}}
                                  </td>
                                  <td class="text-muted">
                                    {{$val->hargasebelum}}
                                  </td>
                                  <td class="text-muted">{{$val->created_at}}</td>
                                  <td><a href="" class="btnedit" data-bs-toggle="modal" data-bs-target="#modal-edit" data-jasa="{{encrypt($val->id)}}">Edit</a> | <a href="" class="text-danger btndelete" data-jasa="{{encrypt($val->id)}}">Delete</a></td>
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

    $('#table-kategori').DataTable();
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });

    $(document).ready(function(){

        $(document).on('submit','#tambah-jasa',function(e){
            e.preventDefault();
            const data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardtokojasa.store')}}',
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
                            location.href="{{url('/dashboard/toko/jasa')}}";
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

        $(document).on('click','.btnedit',function(e){
            e.preventDefault();
            var ID = $(this).data('kategori');
            $.ajax({
                url:'{{route('dashboardtokokategori.edit')}}',
                type: 'get',
                dataType: 'json',
                data: {
                id: ID
                },
                success:function(res){
                    const data = res.result;
                    $("#update-kategori input[name='id']").val(ID);
                    $("#update-kategori input[name='kategori']").val(data.namakategori);
                }
            })

        })

        $(document).on('submit','#update-kategori',function(e){
            e.preventDefault();
            let data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardtokokategori.update')}}',
                data: data,
                contentType:'application/json',
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function() {
                $('.btn-update').prop('disabled', true);
                $('.btn-update').html('Menyimpan Data...');
                },
                complete: function() {
                $('.btn-update').prop('disabled', false);
                $('.btn-update').html('Update');
                },
                success:function(data){
                    var error = data.error
                    if(error==true){
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "Peringatan!",
                            text:data.message,
                            showConfirmButton: true,
                        })
                    }else{
                        Toast.fire({
                            icon: "success",
                            title: data.message
                        }).then((result)=>{
                            location.href="{{url('/dashboard/toko/kategori')}}";
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

        })

        $(document).on('click','.btndelete',function(e){
            e.preventDefault();
            if(confirm('Apakah anda yakin menghapus data ini?')){
                var ID = $(this).data('kategori');
                $.ajax({
                    url:'{{route('dashboardtokokategori.delete')}}',
                    type:'post',
                    data:{
                        _method: 'delete',
                        _token: '{{csrf_token()}}',
                        id: ID
                    },
                    success:function(res){
                        if(res.error == true){
                            Swal.fire({
                                position: "center",
                                icon: "warning",
                                title: "Warning!",
                                text: res.message,
                                showConfirmButton: true,
                            })
                        }else{
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            }).then((result)=>{
                                location.href="{{url('/dashboard/toko/kategori')}}";
                            });
                        }
                    },
                    error:function(jqXHR,textStatus){
                        Swal.fire({
                            position: "center",
                            icon: textStatus,
                            title: jqXHR.statusText,
                            text: "Silahkan hubungi administrator",
                            showConfirmButton: true,
                            confirmButtonColor:"#d63939",
                        });
                    }
                })
            };

        })
    })
</script>
@endpush

@section('modal')
    @include('dashboard.modals._jasamodal')
    @include('dashboard.modals._editkategori')
@endsection
