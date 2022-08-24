@extends('client.layout.master')
@section('content')
    <section class="site-section py-lg">
        <div class="container">

            <div class="row blog-entries element-animate">

                <div class="col-md-12 col-lg-8 main-content">
                    <h1 class="mb-4">{{ $post->tittle }}</h1>
                    <div class="post-meta">
                        <span class="author mr-2">
                            {{-- <img src="{{ $post->avatar }}" alt="Colorlib" --}}
                            <img src="{{ asset('admin/assets/img/' . $post->avatar . '') }}" alt="img"
                                class="mr-2">{{ $post->name }}</span>&bullet;
                        <span class="mr-2">{{ $post->format_created_at }} </span>
                        </span>
                        <div class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button_count"
                            data-size="small"><a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                class="fb-xfbml-parse-ignore">Share</a></div>
                        </span>
                    </div>
                    <a class="category mb-5" href="/danh-muc/{{ $category_name->slug }}">{{ $category_name->ct_name }}</a>
                    <div class="post-content-body">
                        <p>{!! $post->content !!}</p>
                    </div>
                    <div class="pt-5">
                        <p>Danh Mục: <a href="/danh-muc/{{ $category_name->slug }}">{{ $category_name->ct_name }}</a>
                            Tags:
                            @foreach ($post->format_tags as $tag)
                                <a href="/tag/{{ $tag }}">&#32;#{{ $tag }}</a>
                            @endforeach
                            {{-- <a href="#">#asia</a> --}}
                        </p>
                    </div>
                    <div class="pt-5">
                        <!-- END comment-list -->
                        <div class="comment-form-wrap pt-5">
                            <h3 class="mb-5">Bình Luận</h3>
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-width="300"
                                data-numposts="10">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END main-content -->
                @include('client.layout.sidebar')
                <!-- END sidebar -->
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-3 ">Bài Viết Liên Quan</h2>
                </div>
            </div>

            <div class="row">
                @foreach ($relatedPosts as $item)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('ShowPost', $item->slug) }}"
                            class="a-block sm d-flex align-items-center height-md"
                            style="background-image: url('{{ asset('public/uploads/posts/' . $item->thumbnail . '') }}'); ">
                            <div class="text">
                                <div class="post-meta">
                                    <span class="category">{{ $category_name->ct_name }}</span>
                                    <span class="mr-2">{{ $item->format_created_at }} </span>
                                </div>
                                <h3>{{ $item->tittle }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- END section -->
@endsection
@push('scripts')
    <script>
        document.title = 'TiDev | ' + "{{ $post->tittle ?? '' }}";
    </script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v14.0&appId=749685669685610&autoLogAppEvents=1"
        nonce="5qwZ1DIl"></script>
@endpush
