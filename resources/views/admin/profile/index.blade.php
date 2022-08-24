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

        <div class="col-6">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                    </p>
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        <a href="javascript:void(0)">
                            <img class="avatar" src="{{ asset('admin/assets/img/'. $user->avatar .'') }}" alt="avatar">
                            <h5 class="title">{{ $user->name }}</h5>
                        </a>
                        <p class="description">
                            @if ($user->role == 0)
                            Employer
                            @else
                            Ceo/Founder
                            @endif
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="button-container">
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form id="form-profile" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Họ Tên</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Nhập họ và tên">
                        </div>
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email"  value="{{ $user->email }}" class="form-control" placeholder="Nhập Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Mật Khẩu</label>
                            <input type="text" name="password" value="" class="form-control" placeholder="Nhập mật khẩu">
                        </div>
                        <div class="form-group">
                            <label for="select">Quyền</label>
                            <select id="select-role-form" style="color: #e14eca;" name="role" class="form-control">
                                <option @if ($user->role == 0)
                                    selected
                                @endif value="0">Admin</option>
                                <option @if ($user->role == 1)
                                    selected
                                @endif value="1">Super Admin</option>
                            </select>
                        </div>
                        <div class="custom-file form-group">
                            <input type="file" class="custom-file-input" name="avatar" id="input-avatar">
                            <label class="custom-file-label" for="customFile">Avatar</label>
                        </div>
                        <div class="row">
                            <div class="ml-3">
                                <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
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
        $('#form-profile').on('submit', function(event) {
            event.preventDefault();
            $('.card-header > p').remove();
            $('.alert-primary > span').empty();
            $.ajax({
                url: "{{ route('api.users.update') }}",
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
                    $(".card-footer > .button-container > p").empty();
                    $(".card-footer > .button-container > p").text(user.email);

                    $(".author > .description").empty();
                    $(".author > .description").text(nameRole);

                    $(".title").empty();
                    $(".title").text(user.name);
                    let link = `{{ asset('/admin/assets/img/${user.avatar}') }}`;
                    // $(".avatar").wrap($('<a>', {
                    //     href: link
                    // }));
                    $('.avatar').prop('src',link);
                    $('.card-header').append(
                            `<p >
                                    <i style="color: green;" class="fa fa-check" aria-hidden="true"></i> Sửa Thành Công!
                                </p>`);
                
                    // $('.tbody-users').append(html);
                    // $('.alert-primary').show();
                    // $('.alert-primary > span').append(response.message);
                    setTimeout(() => {
                        $('.card-header').empty();
                    }, 2000);
                },
                error: function(response) {
                    let objError = response.responseJSON.errors;
                    console.log(response);
                    $.each(objError, function(index, value) {
                        $('.card-header').append(
                            `<p >
                                    <i style="color: red;" class="fa fa-ban" aria-hidden="true"></i> ${value}
                                </p>`)
                    });
                }
            })
        });
    </script>
@endpush
