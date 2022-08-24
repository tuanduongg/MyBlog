<header role="banner">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-9 social">
                    <a href="#"><span class="fa fa-twitter"></span></a>
                    <a href="https://www.facebook.com/toilatuann/"><span class="fa fa-facebook"></span></a>
                    <a href="https://www.instagram.com/toilatuannnnnn/"><span class="fa fa-instagram"></span></a>
                    <a href="#"><span class="fa fa-youtube-play"></span></a>
                </div>


                <div class="col-3 search-top">
                    <form action="/" class="search-top-form">
                        <span class="icon fa fa-search"></span>
                        <input type="search" 
                        @if (session()->has('q'))
                            value = "{{ session()->get('q') }}"
                        @endif id="s"
                         name="q" placeholder="Tìm Kiếm..."
                            autocomplete="off">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container logo-wrap">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button"
                    aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
                <h1 class="site-logo"><a href="/">Dev-Ơi</a></h1>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-md  navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto" id="ul-navbar">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Trang Chủ</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link" href="/danh-muc/lap-trinh">Lập Trình</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link" href="/danh-muc/tool-software">Tool & SoftWare</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link" href="/danh-muc/ban-da-biet">Bạn Đã Biết ?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/lien-he">Liên Hệ</a>
                    </li>
                    
                </ul>

            </div>
        </div>
    </nav>
</header>
