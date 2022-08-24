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
            <a href="{{ route('admin.posts.create') }}" target="_blank" class="btn btn-primary">Thêm Mới</a>
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
        <div class="col-4 ">
            <div class="alert alert-success alert-dismissible fade show float-right" style="display: none;" role="alert">
                <strong></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>

    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="col-11">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Tiêu Đề</th>
                        <th>Tác Giả</th>
                        <th>Danh Mục</th>
                        <th>Tags</th>
                        <th>Created At</th>
                        <th colspan="2" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody-posts">
                    @forelse ($posts as $post)
                        <tr>
                            <td class="text-center">{{ $post->id }}</td>
                            <td>{{ $post->format_tittle }}</td>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->ct_name }}</td>
                            <td>{{ $post->tags }}</td>
                            <td>{{ $post->format_full_house_created_at }}</td>
                            <td class="td-actions text-right">
                                <form action="{{ route('admin.posts.edit',$post->id) }}" method="get">
                                  
                                    <button type="submit" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                        <i class="tim-icons icon-pencil"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <button type="button" data-id="{{ $post->id }}" rel="tooltip"
                                    class="btn btn-danger btn-sm btn-icon" id="btn-delete-post"
                                    data-id="{{ $post->id }}">
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
        <div class="col-6">
            <nav aria-label="Page navigation">
                {{ $posts->onEachSide(0)->links() }}
            </nav>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.tbody-posts > tr', function() {
                //active current tr
                $(".tbody-posts > tr").removeClass('active-tr');
                $(this).addClass("active-tr");
            });
            $(document).on('click', '#btn-delete-post', function() {
                let isConf = confirm('Bạn chắc chắn muốn xoá?');
                if (isConf == true) {
                    let id = $(this).data('id');
                    let url = "{{ route('admin.posts.destroy') }}";
                    let ele = $(this);
                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            'id': id
                        },
                        dataType: "json",
                        success: function(response) {
                            // console.log(response);
                            $('.alert-success > strong').text(response[1]);
                            $('.alert-success').show();
                            ele.closest("tr").remove();
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });




        }); //ready
    </script>
@endpush
