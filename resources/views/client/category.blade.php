@extends('client.layout.master')
@section('content')
    <section class="site-section pt-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="mb-4">Danh Mục: {{ $categoryName }}</h2>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="row mb-5 mt-5">

                        <div class="col-md-12">
                            @forelse ($posts as $post)
                                
                            <div class="post-entry-horzontal" >
                                <a href="{{ route('ShowPost',$post->slug) }}" style="width: 100%">
                                    <div class="image element-animate" data-animate-effect="fadeIn"
                                        style="background-image: url( {{ asset('public/uploads/posts/'. $post->thumbnail .'') }} );"></div>
                                    <span class="text">
                                        <div class="post-meta">
                                            <span class="author mr-2">
                                                <img src="{{ asset('admin/assets/img/'. $post->avatar .'') }}" alt="img">
                                                {{ $post->name }}
                                            </span>&bullet;
                                            <span class="mr-2">{{ $post->format_created_at }}</span> &bullet;
                                            <span class="mr-2">{{ $categoryName }}</span>
                                        </div>
                                        <h2>{{ $post->tittle }}</h2>
                                    </span>
                                </a>
                            </div>
                        
                            @empty
                                <p>
                                    Chưa có bài viết nào danh mục <strong> {{ $categoryName }} </strong>
                                </p>
                                <p>
                                    <a href="/">Xem các bài viết khác</a>
                                </p>
                            @endforelse
                            <!-- END post -->

                            
                            <!-- END post -->

                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12 text-center">
                            {{ $posts->onEachSide(2)->links() }}
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
