@extends('client.layout.master')
@section('content')
    <section class="site-section py-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4 mt-4">Bài Viết Mới</h2>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-6" style="">
                                <a href="{{ route('ShowPost', $post->slug) }}" class="blog-entry element-animate"
                                    data-animate-effect="fadeIn">
                                    <img src="{{ asset('public/uploads/posts/'. $post->thumbnail .'') }}" alt="Image placeholder">
                                    {{-- <img src="{{ asset('client/images/img_5.jpg') }}" alt="Image placeholder"> --}}
                                    <div class="blog-content-body" style="">
                                        <div class="post-meta">
                                            <span class="author mr-2">
                                                
                                                <img src="{{ asset('admin/assets/img/'. $post->avatar .'') }}" alt="img">
                                                {{ $post->name }}
                                            </span>&bullet;
                                            <span class="mr-2">{{ $post->format_createdat }} </span>
                                        </div>
                                        <h2>{{ $post->tittle }}</h2>
                                    </div>
                                </a>
                            </div>
                        @empty
                        <div class="col-md-12">
                            <h4 style="">Không Tìm Thấy Bài Viết "{{ session()->get('q') }}"</h4>
                            <p>
                                <a href="/">Xem Tất Cả Bài Viết</a>
                            </p>
                        </div>
                        @endforelse
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            <ul class="pagination">
                                {{ $posts->onEachSide(0)->links() }}
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- END main-content -->

                @include('client.layout.sidebar')
                <!-- END sidebar -->

            </div>
        </div>
    </section>
@endsection
