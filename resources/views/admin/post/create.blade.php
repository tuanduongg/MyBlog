@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="card col-10">
            <div class="card-header">
                <h4>Thêm Bài Đăng Mới</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                    </div>
                @endif
                <form action="{{ route('admin.posts.store') }}" id="form" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Tiêu Đề</label>
                                <input onkeyup="ChangeToSlug();" id="input-tittle" value="{{ old('tittle') }}"
                                    type="text" name="tittle" class="form-control" placeholder="Nhập tiêu đề">
                            </div>
                        </div>
                    </div>
                    {{-- <input type="hidden" name="author_id" value="{{ auth()->user()->id }}"> --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Slug</label>
                                <input type="text" name="slug" value="{{ old('slug') }}" id="input-slug"
                                    class="form-control" placeholder="Slug">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="email">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tags</label>
                                <input type="text" name="tags" value="{{ old('tags') }}" id="input-tags"
                                    class="form-control" placeholder="Nhập Tags">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="select">Danh Mục</label>
                                <select id="select-role-form" style="color: #e14eca;" name="category_id"
                                    class="form-control">
                                    @forelse ($categories as $category)
                                        <option @if (old('category_id') == $category->id) selected @endif
                                            value="{{ $category->id }}">{{ $category->ct_name }}</option>
                                    @empty
                                        <option value="-1">Chưa Có Danh Mục Nào</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <div class="form-group">
                                <label for="name">Nội Dung</label>
                                <textarea name="content" id="ckeditor-content" cols="70" rows="10">{{ old('content') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <a href="{{ route('admin.posts') }}" class="btn btn-default">Trở Lại</a>
                        </div>
                        <div class="col-4">
                            <button type="button" id="btn-add-post" class="btn btn-primary">Thêm Bài Đăng Mới</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function ChangeToSlug() {
            var title, slug;

            //Lấy text từ thẻ input title 
            title = document.getElementById("input-tittle").value;

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
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
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

        function SuggestTaginput(link, selector) {

            var tagsname = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: (link + '?q=%QUERY%'),
                    wildcard: '%QUERY%',
                    filter: function(list) {
                        return $.map(list, function(tagname) {
                            return {
                                name: tagname
                            };
                        });
                    }
                },
            });
            tagsname.initialize();

            $(selector).tagsinput({
                trimValue: true,
                onTagExists: function(item, $tag) {
                    $tag.hide().fadeIn();
                },
                typeaheadjs: [{
                        hint: false,
                        highlight: true
                    },
                    {
                        name: 'citynames',
                        displayKey: 'name',
                        valueKey: 'name',
                        source: tagsname.ttAdapter(),
                        templates: {
                            empty: [],
                            header: [
                                '<ul class="list-group">'
                            ],
                            suggestion: function(data) {
                                return '<li class="list-group-item">' + data.name + '</li>'
                            }
                        }
                    }
                ]
            });
        }
        SuggestTaginput('tags/search', '#input-tags');
        $('.bootstrap-tagsinput').css('width', '100%');

        CKEDITOR.replace('ckeditor-content', {
            filebrowserImageUploadUrl: "{!! route('UpLoadPhotoCkEditor') . '?_token=' . csrf_token() !!}",
            filebrowserBrowseUrl: "{!! route('file-browser') . '?_token=' . csrf_token() !!}",
            filebrowserUploadMethod: "form",
        });

        $(document).on('click', '#btn-add-post', function() {
            $('#form').submit();
        })
    </script>
@endpush
