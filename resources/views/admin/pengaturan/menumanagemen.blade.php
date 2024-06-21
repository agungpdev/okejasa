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
            Menu Managamen
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
            <a href="#" class="btn btn-azure d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-submenu">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Sub Menu
            </a>
            <a href="#" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-menu">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Menu
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
                            <table id="table-menu" class="table is-striped is-hoverable">
                              <thead>
                                <tr>
                                  <th class="w-1">no</th>
                                  <th>menu</th>
                                  <th>Sub menu</th>
                                  <th>route</th>
                                  <th></th>
                                  <th class="w-1">Active</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($menu as $k => $m)
                                <tr class="bg-dark-lt">
                                  <td>{{$k+1 .'.0.0'}}</td>
                                  <td>
                                    {{$m->menu}}
                                  </td>
                                  <td class="text-muted"></td>
                                  <td class="text-muted">{{$m->route ? $m->route : '-'}}</td>
                                  <td>
                                    <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-editmenu" data-menu="{{encrypt($m->id)}}">Edit</a>
                                    <a href="#" class="text-danger btn-delete" data-parent="{{encrypt($m->id.'@'.$m->menu)}}">Delete</a>
                                  </td>
                                  <td>
                                    <form method="post" class="isMenu">
                                        <input type="checkbox" class="form-check-input btn-active" name="active" data-route="{{encrypt($m->id)}}" {{$m->menu_active ? 'checked' : ''}}>
                                    </form>
                                    </td>
                                </tr>
                                @foreach ($m->submenu as $s =>$v)
                                <tr>
                                    <td></td>
                                    <td>{{$k+1 .".".$s+1 .'.0'}}</td>
                                    <td class="text-muted">{{$v->submenu}}</td>
                                    <td class="text-muted">{{$v->route}}</td>
                                    <td>
                                      <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-editsubmenu" data-submenu="{{encrypt($v->id)}}">Edit</a>
                                      <a href="#" class="text-danger btn-delete" data-route="{{encrypt($v->id)}}">Delete</a>
                                    </td>
                                    <td>
                                        <form class="isMenu" method="post">
                                            <input type="checkbox" class="form-check-input btn-active" data-route="{{encrypt($v->id)}}" data-parent="{{encrypt($v->menu_id)}}" name="active" {{$v->is_active ? 'checked' : ''}}>
                                        </form>
                                      </td>
                                  </tr>
                                @endforeach

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

@section('modal')
@include('dashboard.modals._menu')
@include('dashboard.modals._submenu')
@include('dashboard.modals._editmenu')
@include('dashboard.modals._editsubmenu')
@endsection

@push('head.style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<link href="{{asset('assets/be/libs/select2/select2.min.css')}}" rel="stylesheet">
@endpush

@push('foot.script')
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="{{asset('assets/be/libs/select2/select2.min.js')}}"></script>
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
        function formatState (state) {
        if (!state.id) {
            return state.text;
        }

        var $state = $(
            `<span><i class="${state.element.value.toLowerCase()}"></i> ${state.text}</span>`
        );
        return $state;
        };

        $('.select-rsub').select2({
            dropdownParent:$('#modal-submenu'),
            width:'100%',
        });
        $('.select-rmenu').select2({
            dropdownParent:$('#modal-menu'),
            width:'100%',
        });
        $('.select-icons').select2({
            templateResult:formatState,
            templateSelection:formatState,
            dropdownParent:$('#modal-menu'),
            width:'100%',
            escapeMarkup: function(m) { return m; }
        });

        $('#box-submenu').hide();
        $('#route-emenu').hide();

        $("[name=sub]").on('change',function(e){
            if($(this).is(':checked')){
                $('#box-submenu').show();
                $('#route-box').hide();
            }else{
                $('#route-box').show();
                $('#box-submenu').hide();
            }
        })

        let ii =0;
        $('#add').click(function(e){
            e.preventDefault();
            ++ii;
            $('#box-submenu').append(`
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label required">Sub Menu</label>
                        <input type="text" class="form-control" id="submenu" name="submenus[`+ii+`][submenu]" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label required">Route</label>
                        <select type="text" class="form-select" id="select-route" name="submenus[`+ii+`][route]">
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
                        <a href="#" id="add" class="btn btn-outline-danger hapus-baris">Hapus</a>
                    </div>
                </div>
            </div>
            `)
        });

        $(document).on('click','.hapus-baris',function(){
            $(this).parents('.row').remove();
        });

        $(document).on('change','.btn-active',function(e){
            e.preventDefault();
            if($(this).is(':checked')){
                let check = true;
                let id = $(this).data('route');
                let parent = $(this).data('parent');
                $.ajax({
                    url:'{{route('dashboardpengaturanmenu.menuactive')}}',
                    type:'post',
                    data:{
                        _token: '{{csrf_token()}}',
                        id: id,
                        parent:parent,
                        check:check
                    },
                    success:function(res){
                        var error = res.error
                        let load = res.reload;
                        if(error==true){
                            Swal.fire({
                                position: "center",
                                icon: "warning",
                                title: "Peringatan!",
                                text: res.message,
                                showConfirmButton: true,
                            })
                        }else{
                            if(load){
                                Toast.fire({
                                    icon: res.icon,
                                    title: res.message
                                }).then((result)=>{
                                    location.href='{{route('dashboardpengaturanmenuindex')}}';
                                });
                            }else{
                                Toast.fire({
                                    icon: res.icon,
                                    title: res.message
                                });
                            }
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

            }else{
                let id = $(this).data('route');
                let parent = $(this).data('parent');

                $.ajax({
                    url:'{{route('dashboardpengaturanmenu.menuactive')}}',
                    type:'post',
                    data:{
                        _token: '{{csrf_token()}}',
                        id: id,
                        parent:parent,
                    },
                    success:function(res){
                        var error = res.error;
                        let load = res.reload;
                        if(error==true){
                            Swal.fire({
                                position: "center",
                                icon: "warning",
                                title: "Peringatan!",
                                text: res.message,
                                showConfirmButton: true,
                            })
                        }else{
                            if(load){
                                Toast.fire({
                                    icon: res.icon,
                                    title: res.message
                                }).then((result)=>{
                                    location.href='{{route('dashboardpengaturanmenuindex')}}';
                                });
                            }else{
                                Toast.fire({
                                    icon: res.icon,
                                    title: res.message
                                });
                            };
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
            }
        });

        $(document).on('submit','#tambah-menu',function(e){
            e.preventDefault();
            let data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardpengaturanmenu.store')}}',
                data: data,
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
                            location.href='{{route('dashboardpengaturanmenuindex')}}';
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

        $(document).on('click','.btn-delete',function(e){
            e.preventDefault();
            if(confirm('Anda yakin menghapus menu ini?')){
                let ID = $(this).data('route');
                let parent = $(this).data('parent');
                $.ajax({
                    url:'{{route('dashboardpengaturanmenu.delete')}}',
                    type:'post',
                    data:{
                        _method: 'delete',
                        _token: '{{csrf_token()}}',
                        id: ID,
                        parent:parent
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
                                location.href='{{route('dashboardpengaturanmenuindex')}}';
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
            }
        })

        $(document).on('submit','#tambah-submenu',function(e){
            e.preventDefault();
            let data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardpengaturanmenu.store-submenu')}}',
                data: data,
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
                            location.href='{{route('dashboardpengaturanmenuindex')}}';
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

        $(document).on('click','.btn-edit',function(e){
            e.preventDefault();
            let menu = $(this).data('menu');
            let submenu = $(this).data('submenu');
            $.ajax({
                url:'{{route('dashboardpengaturanmenu.edit')}}',
                type:'get',
                data:{menu:menu,submenu:submenu},
                success:function(response){
                    const res = response.result;
                    const parent = response.parent;
                    if(parent){
                        $('#route-emenu').hide();
                        $('#id-emenu').val(btoa(res.id));
                        if(res.route){
                            const route = res.route.split('%');
                            $('#select-emenu').html('');
                            $('#route-emenu').show();
                            $('#emenu').val(res.menu);
                            $('#select-emenu').append(`<option value="">--Pilih Route Menu--</option><option value="${res.route}" selected>${route[0]}</option>`);
                            $('#select-emenu').append(`@foreach ($route as $k => $r)
                                    <option value="{{$k.'%'.$r}}">{{$k}}</option>
                                @endforeach`);
                        }else{
                            $('#emenu').val(res.menu);
                        }
                    }else{
                        $('#id-esubmenu').val(btoa(res.id));
                        const route = res.route.split('%');
                        const menu = `<option value='${res.menu_id}' selected>${res.menu}</option>`;
                        $('#esubmenu').val(res.submenu);
                        $('#select-eparent').html('');
                        $('#select-esubroute').html('');
                        $('#select-eparent').append(`<option value="">--Pilih Parent Menu--</option>`);
                        $('#select-eparent').append(menu);
                        $('#select-eparent').append(`@foreach ($menu as $k => $r)
                                    <option value="{{encrypt($r->id)}}">{{$r->menu}}</option>
                                @endforeach`);
                        $('#select-esubroute').append(`<option value="">--Pilih Route Menu--</option><option value="${res.route}" selected>${route[0]}</option>`);
                        $('#select-esubroute').append(`@foreach ($route as $k => $r)
                                    <option value="{{$k.'%'.$r}}">{{$k}}</option>
                                @endforeach`);

                    }
                }
            })
        });

        $(document).on('submit','#update-menu',function(e){
            e.preventDefault();
            let data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardpengaturanmenu.update')}}',
                data: data,
                contentType:'application/json',
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function() {
                $('.btn-update').prop('disabled', true);
                $('.btn-update').html('Memproses data...');
                },
                complete: function() {
                $('.btn-update').prop('disabled', false);
                $('.btn-update').html('Update');
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
                            location.href='{{route('dashboardpengaturanmenuindex')}}';
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

        $(document).on('submit','#update-submenu',function(e){
            e.preventDefault();
            let data = new FormData($(this)[0]);
            $.ajax({
                url:'{{route('dashboardpengaturanmenu.update-submenu')}}',
                data: data,
                contentType:'application/json',
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function() {
                $('.btn-update').prop('disabled', true);
                $('.btn-update').html('Memproses data...');
                },
                complete: function() {
                $('.btn-update').prop('disabled', false);
                $('.btn-update').html('Update');
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
                            location.href='{{route('dashboardpengaturanmenuindex')}}';
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
