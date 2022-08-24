@extends('admin.layout.master')

@push('css')
    <style>
        .table>tbody>tr:hover {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-4">
            <form class="form-inline">
                <div class="form-group">
                    <input type="text" name="search" id="input-search" class="form-control" placeholder="Search">
                </div>
                <button type="button" class="btn btn-link btn-icon btn-round">
                    <i class="tim-icons icon-zoom-split"></i>
                </button>
            </form>

        </div>
        <div class="col-2">
            <div class="form-group">
                <select id="filter-role" name="role" style="color: #e14eca;" class="form-control">
                    <option value="-1">Tất Cả</option>
                    <option value="0">Admin</option>
                    <option value="1">Super Admin</option>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="alert alert-primary alert-dismissible fade show float-right"
                style="display: none; position: absolute; z-index: 999;" role="alert">
                <span></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">

            <table class="table table-user">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody-users">
                    @forelse ($users as $user)
                        <tr>
                            <td id="td-id" class="text-center">{{ $user->id }}</td>
                            <td id="td-name">{{ $user->name }}</td>
                            <td id="td-email">{{ $user->email }}</td>
                            <td id="td-role">
                                @if ($user->role == 0)
                                    Admin
                                @else
                                    Super Admin
                                @endif
                            </td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                    <i class="fa fa-comments" aria-hidden="true"></i>
                                </button>
                                <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon"
                                    id="btn-delete-user" data-id="{{ $user->id }}">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <p>Không Có Dữ Liệu</p>
                    @endforelse

                </tbody>
            </table>
        </div>
        <div class="col-5">

            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <form id="form-users" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Họ Tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập họ và tên">
                        </div>
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Nhập Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Mật Khẩu</label>
                            <input type="text" name="password" class="form-control" placeholder="Nhập mật khẩu">
                        </div>
                        <div class="form-group">
                            <label for="select">Quyền</label>
                            <select id="select-role-form" style="color: #e14eca;" name="role" class="form-control">
                                <option value="0">Admin</option>
                                <option value="1">Super Admin</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <button type="submit" id="btn-add-user" class="btn btn-primary">Thêm Mới</button>
                            </div>
                            <div class="col-4">
                                <button type="button" id="btn-update-user" class="btn btn-info">Sửa</button>
                            </div>
                            <div class="col-4">
                                <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            //live search
            $('#input-search').keyup(function() {
                // Search Text
                var search = $(this).val();

                // Hide all table tbody rows
                $('.table-user tbody tr').hide();

                // Count total search result
                var len = $('.table-user tbody tr:not(.notfound) td:contains("' + search + '")').length;

                if (len > 0) {
                    // Searching text in columns and show match row
                    $('.table-user tbody tr:not(.notfound) td:contains("' + search + '")').each(function() {
                        $(this).closest('tr').show();
                    });
                } else {
                    $('.notfound').show();
                }

            });


            //click to each row
            $(document).on('click', '.tbody-users > tr', function() {
                //active current tr
                $(".tbody-users > tr").removeClass('active-tr');
                $(this).addClass("active-tr");
                //add value to form
                let name = $(this).children('#td-name').text();
                let id = $(this).children('#td-id').text();
                let email = $(this).children('#td-email').text();
                // let password = $(this).children('#td-password').text();
                let role = $(this).children('#td-role').text();
                $('input[name=name]').val(name);
                $('input[name=email]').val(email);
                // $('input[name=password]').val(password);
                $('input[name=id]').val(id);
                if (role.trim() == 'Admin') {
                    $('#select-role-form').val(0);
                } else {
                    $('#select-role-form').val(1);
                }
            });
            
            //btn-reset
            $(document).on('click', '#btn-reset', function() {
                $('input[name=name]').val('');
                $('input[name=email]').val('');
                $('input[name=password]').val('');
                $('input[name=id]').val('');
                $('#select-role-form').val(0);
            });


            //filter role
            $(document).on('change', '#filter-role', function() {
                let value = $(this).val();
                let url = "{{ route('api.users.seach') }}";
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        'role': value
                    },
                    dataType: "json",
                    success: function(response) {
                        $('.tbody-users > tr').remove();
                        response.map((item) => {
                            let nameRole = '';
                            if (item.role == '0') {
                                nameRole = 'Admin';
                            } else {
                                nameRole = 'Super Admin';
                            }
                            let html = `<tr>
                            <td id="td-id" class="text-center">${ item.id }</td>
                            <td id="td-name">${ item.name }</td>
                            <td id="td-email">${ item.email }</td>
                            <td id="td-role">${nameRole} </td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                        <i class="tim-icons icon-single-02"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </td>
                            </tr>`;
                            $('.tbody-users').append(html);
                        });
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });

            //add user
            $('#form-users').on('submit', function(event) {
                event.preventDefault();
                $('.card-header > p').remove();
                $('.alert-primary > span').empty();
                $.ajax({
                    url: "{{ route('api.users.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        let user = response.user;
                        let nameRole = '';
                        if (user.role == 0) {
                            nameRole = 'Admin';
                        } else {
                            nameRole = 'Super Admin';
                        }
                        let html = `<tr>
                        <td id="td-id" class="text-center">${ user.id }</td>
                        <td id="td-name">${ user.name }</td>
                        <td id="td-email">${ user.email }</td>
                        <td id="td-role">${nameRole} </td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                    <i class="tim-icons icon-single-02"></i>
                                </button>
                                <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </td>
                        </tr>`;
                        $('.tbody-users').append(html);
                        $('.alert-primary').show();
                        $('.alert-primary > span').append(response.message);
                        setTimeout(() => {
                            $('.alert-primary').hide();
                        }, 2000);
                    },
                    error: function(response) {
                        let objError = response.responseJSON.errors;
                        console.log(response);
                        $.each(objError, function(index, value) {
                            $('.card-header').append(
                                `<p style="color: red;">${value}</p>`)
                        });
                    }
                })
            });

            
            //update user
            $(document).on('click', '#btn-update-user', function(event) {
                event.preventDefault();
                $('.card-header > p').remove();
                $('.alert-primary > span').empty();
                $.ajax({
                    type: "post",
                    url: "{{ route('api.users.update') }}",
                    data: $('#form-users').serialize(),
                    dataType: "json",
                    success: function(response) {
                        let user = response.user;
                        console.log(user);
                        let nameRole = '';
                        if (parseInt(user.role) == 0) {
                            nameRole = 'Admin';
                        } else {
                            nameRole = 'Super Admin';
                        }
                        $('.tbody-users > tr').each(function(index, tr) {
                            let id = $(this).children('#td-id').text();
                            if (id == user.id) {
                                $(this).children('#td-name').text(user.name);
                                $(this).children('#td-email').text(user.email);
                                $(this).children('#td-role').text(nameRole);
                            }
                        });
                        $('.alert-primary').show();
                        $('.alert-primary > span').append(response.message);
                        setTimeout(() => {
                            $('.alert-primary').hide();
                        }, 2000);
                    },
                    error: function(response) {
                        let objError = response.responseJSON.errors;
                        console.log(response);
                        $.each(objError, function(index, value) {
                            $('.card-header').append(
                                `<p style="color: red;">${value}</p>`)
                        });

                    }
                });
            });

            //delete user
            $(document).on('click', '#btn-delete-user', function(event) {
                event.preventDefault();
                let isConfirm = confirm(
                    'Xoá danh mục là xoá tất cả bài viết thuộc danh mục đó! Bạn chắc chắn muốn xoá ?');
                if (isConfirm == true) {
                    $('.card-header > p').remove();
                    $('.alert-primary > span').empty();
                    let id = $(this).data('id');
                    let ele = $(this);
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.users.delete') }}",
                        data: {
                            'id': id
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.alert-primary').show();
                            $('.alert-primary > span').append(response.message);
                            ele.closest("tr").remove();
                            setTimeout(() => {
                                $('.alert-primary').hide();
                            }, 2000);
                        },
                        error: function(response) {
                            console.error(response);
                        }
                    });
                }
            });


            


        }); //ready
    </script>
@endpush
