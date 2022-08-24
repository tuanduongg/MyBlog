<!doctype html>
<html lang="en">

<head>
    <title>Dev Ơi</title>
    <!-- <title>TiDev &mdash; Lỗi Khổ Của Dev</title> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!------ SEO ---->
    <link rel="canonical" href="{{url()->current()}}"/>

    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonts/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fonts/flaticon/font/flaticon.css') }}">
    <link rel="icon" type="image/png" href="{{ asset("admin/assets/img/favicon.png")}}">
    

    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">
</head>

<body>


    <div class="wrap">

        @include('client.layout.header')
        <!-- END header -->
        @yield('content')
        @include('client.layout.footer')
        <!-- END footer -->
    </div>
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#f4b214" />
        </svg></div>

    <script src="{{ asset('client/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('client/js/popper.min.js') }}"></script>
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script>
    <script>
        function activeNav() {
            let currentURL = window.location.href;
            document.querySelectorAll("#ul-navbar > li > a").forEach(p => {
                if (currentURL.indexOf(p.getAttribute("href")) !== -1) {
                    $("#ul-navbar > li > a").removeClass('active');
                    p.classList.add("active");
                }
            })
        }
        activeNav();

        function ShowAllCategories() {
            $.ajax({
                type: "get",
                url: "{{ route('api.categories') }}",
                dataType: "json",
                success: function(response) {

                    response.map(item => {
                        $('.categories').append(
                            `<li><a href="/danh-muc/${item.slug}">${item.ct_name} <span>(${item.total_post})</span></a></li>`
                            );
                        $('#footer-categories').append(
                            `<li><a href="/danh-muc/${item.slug}">${item.ct_name} </a></li>`);
                    })
                },
                error: function(response) {
                    alert('error:' + response);
                }
            });
        }
        ShowAllCategories();

        function ShowAllTag() {
            $.ajax({
                type: "get",
                url: "{{ route('api.tags') }}",
                dataType: "json",
                success: function(response) {
                    response.map(item => {
                        $('.tags').append(`<li><a href="/tag/${ item }">${ item }</a></li>`);
                    })
                },
                error: function(response) {
                    alert('error:' + response);
                }
            });
        }
        ShowAllTag();

        function convertTimstempToDate(timestamp) {
            var date = new Date(timestamp);
            return date.getDate() +
                "/" + (date.getMonth() + 1) +
                "/" + date.getFullYear();
        }

        function ShowSuggestPosts() {
            $.ajax({
                type: "get",
                url: "{{ route('api.posts.suggest') }}",
                dataType: "json",
                success: function(response) {
                    response.map(item => {
                        $('.post-entry-sidebar > ul').append(`
                            <li>
                                <a href="">
                                    <img src="{{ asset('public/uploads/posts/${item.thumbnail}') }}" alt="Image placeholder" class="mr-4">
                                    <div class="text">
                                        <h4>${item.tittle}</h4>
                                        <div class="post-meta">
                                            <span class="mr-2">${convertTimstempToDate(item.created_at)} </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        `);
                    })
                },
                error: function(response) {
                    alert('error:' + response);
                }
            });
        }
        ShowSuggestPosts();

        //set tittle page
        let nameNav = $('#ul-navbar .nav-item .active').text();
        document.title = `TiDev | ${nameNav}`;
    </script>
</body>
@stack('scripts')

</html>
