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
        <div class="col-2">
            {{-- <a href="" data-toggle="modal" data-target="#modalEdit" rel="tooltip" target="_blank" class="btn btn-primary">Thêm Mới</a> --}}
            <button data-toggle="modal" data-target="#modalEdit" rel="tooltip" id="btn-add-category"
                class="btn btn-primary">Thêm Mới</button>
        </div>
        <div class="col-4">
            <form class="form-inline">
                <div class="form-group">
                    <input type="search" value="{{ session()->get('q') }}" name="q" id="input-search"
                        class="form-control" placeholder="Search">
                </div>
                <button type="button" class="btn btn-link btn-icon btn-round">
                    <i class="tim-icons icon-zoom-split"></i>
                </button>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-6 ">
            <div class="alert alert-success alert-dismissible fade show float-left" style="display: none;" role="alert">
                <strong></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        <h5 class="modal-title" id="modalEditTittle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                    </div> --}}
                    {{-- <div class="modal-body"> --}}
                    <div class="card col-12 mb-0">
                        <div class="card-header">
                            <h4>Danh Mục</h1>
                        </div>
                        <div class="card-content">

                            <form id="form-category" method="">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên Danh Mục</label>
                                    <input id="input-name" onkeyup="ChangeToSlug();" autocomplete="off" required type="text" name="ct_name"
                                        class="form-control" placeholder="Nhập tên danh mục">
                                </div>
                                @csrf
                                <div class="form-group">
                                    <label for="email">Slug</label>
                                    <input id="input-slug" type="text" autocomplete="off" required placeholder="Nhập slug" name="slug"
                                        class="form-control">
                                </div>
                            </form>
                            <div class="card-footer">
                                <button type="button" id="btn-store" class="btn btn-primary">Thêm Mới</button>
                                <button type="button" id="btn-save" class="btn btn-primary">Lưu Thay Đổi</button>
                                <button type="button" class="btn btn-secondary float-right"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-11">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Tên Danh Mục</th>
                        <th>Slug</th>
                        <th>Thời Gian Tạo</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody-categories">
                    @forelse ($categories as $category)
                        <tr>
                            <td id="td-id" class="text-center">{{ $category->id }}</td>
                            <td id="td-ct_name">{{ $category->ct_name }}</td>
                            <td id="td-slug">{{ $category->slug }}</td>
                            <td id="td-createdat">{{ $category->format_full_house_created_at }}</td>
                            <td class="td-actions text-right">
                                {{-- <form action="{{ route('admin.categorys.edit',$post->id) }}" method="get"> --}}
                                <button type="button" data-id="{{ $category->id }}" id="btn-edit-category"
                                    data-toggle="modal" data-target="#modalEdit" rel="tooltip"
                                    class="btn btn-info btn-sm btn-icon">
                                    <i class="tim-icons icon-pencil"></i>
                                </button>
                                {{-- </form> --}}
                            </td>
                            <td>
                                <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon"
                                    id="btn-delete-category" data-id="{{ $category->id }}">
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
    </div>
@endsection
@push('scripts')
    <script>
    function ChangeToSlug() {
            var title, slug;

            //Lấy text từ thẻ input title 
            title = document.getElementById("input-name").value;

            //Đổi chữ hoa thành chữ thường
            slug = title.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(
                /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('input-slug').value = slug;
    }

    //format datetime
    function getFormattedDate(date) {
        const D = new Date(date); // {object Date}
        return D.getHours() + ":" + D.getMinutes() + " " + D.getDate() + "/" + (D.getMonth() + 1) + "/" + D
            .getFullYear();
    }


    $(document).ready(function() {
        $(document).on('click', '.tbody-categories > tr', function() {
            //active current tr
            $(".tbody-categories > tr").removeClass('active-tr');
            $(this).addClass("active-tr");
        });

        //update category

        $(document).on('click', '#btn-edit-category', function() {
            $('#btn-save').show();
            $('#btn-store').hide();
            $('.alert-success').hide();
            $('.card-header > h4').text('Sửa Danh Mục');
            let id = $(this).data('id');
            let url = "{{ route('api.categories.show', ':id') }}";
            url = url.replace(':id', id);
            let ele = $(this);
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    $('input[name=ct_name]').val(response.category.ct_name);
                    $('input[name=slug]').val(response.category.slug);
                    $('#btn-save').data('id', response.category.id)
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });

        $(document).on('click', '#btn-save', function() {
            let id = $(this).data('id');
            let url = "{{ route('api.categories.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: "post",
                url: url,
                data: $('#form-category').serialize(),
                dataType: "json",
                success: function(response) {
                    $('.tbody-categories > tr').each(function(index, tr) {
                        let cateid = $(this).children('#td-id').text();
                        if (cateid == id) {
                            $(this).children('#td-ct_name').text(response.category.ct_name);
                            $(this).children('#td-slug').text(response.category.slug);
                            //$(this).children('#td-createdat').text(getFormattedDate(response.category.created_at));
                        }
                    });
                    $('.alert-success > strong').text(response.message);
                    $('.alert-success').show();
                    // ele.closest("tr").remove();
                },
                error: function(response) {
                    let objError = response.responseJSON.errors;
                        $.each(objError, function(index, value) {
                            $('.card-header').append(
                                `<p style="color: red;">${value}</p>`);
                        });
                }
            });
        });


        //delete category

        $(document).on('click', '#btn-delete-category', function() {
            let isConf = confirm(
                'Xoá danh mục là xoá tất cả bài viết thuộc danh mục đó! Bạn chắc chắn muốn xoá ?');
            if (isConf == true) {
                let id = $(this).data('id');
                let url = "{{ route('api.categories.delete', ':id') }}";
                url = url.replace(':id', id);
                let ele = $(this);
                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        $('.alert-success > strong').text(response.message);
                        $('.alert-success').show();
                        ele.closest("tr").remove();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }
        });

        //add category

        $(document).on('click', '#btn-add-category', function() {
            $('#btn-save').hide();
            $('#btn-store').show();
            $('input[name=ct_name]').val('');
            $('input[name=slug]').val('');
            $('.card-header > h4').text('Tạo Mới Danh Mục');

        });

        $(document).on('click', '#btn-store', function() {
            $('.card-header').empty();
            
            let url = "{{ route('api.categories.store') }}";
            // let ele = $(this);
            $.ajax({
                type: "post",
                url: url,
                data: $('#form-category').serialize(),
                dataType: "json",
                success: function(response) {
                    let item = response.category;
                    item.created_at = getFormattedDate(item.created_at);
                    let html = `<tr>
                                                <td class="text-center">${ item.id }</td>
                                                <td>${item.ct_name }</td>
                                                <td>${ item.slug }</td>
                                                <td>${ item.created_at}</td>
                                                <td class="td-actions text-right">
                                                    {{-- <form action="{{ route('admin.categorys.edit',${ item.id }) }}" method="post"> --}}
                                                    <button type="button" data-id="${ item.id }" id="btn-edit-category"
                                                        data-toggle="modal" data-target="#modalEdit" rel="tooltip"
                                                        class="btn btn-info btn-sm btn-icon">
                                                        <i class="tim-icons icon-pencil"></i>
                                                    </button>
                                                    {{-- </form> --}}
                                                </td>
                                                <td>
                                                    <button type="button" data-id="${ item.id }" rel="tooltip"
                                                        class="btn btn-danger btn-sm btn-icon" id="btn-delete-category">
                                                        <i class="tim-icons icon-simple-remove"></i>
                                                    </button>

                                                </td>
                                            </tr>`;
                    $('.tbody-categories').append(html);
                    $('.alert-success > strong').text(response.message);
                    $('.alert-success').show();
                    // ele.closest("tr").remove();
                },
                error: function(response) {
                        let objError = response.responseJSON.errors;
                        $.each(objError, function(index, value) {
                            $('.card-header').append(
                                `<p style="color: red;">${value}</p>`);
                        });
                    }
                });
            });


        }); //ready
    </script>
@endpush
