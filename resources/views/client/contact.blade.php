@extends('client.layout.master')
@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Liên Hệ Cho Tôi</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">

                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Tên</label>
                                <input type="text" id="name" class="form-control ">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control ">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="message">Nội Dung</label>
                                <textarea name="message" id="message" class="form-control " cols="30" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="button" value="Gửi" class="btn btn-primary">
                            </div>
                        </div>
                    </form>


                </div>

                <!-- END main-content -->

                <div class="col-md-12 col-lg-4 sidebar mt-4">
                    <!-- END sidebar-box -->
                    <div class="sidebar-box">
                        <div class="bio text-center">
                            <img src="https://media.discordapp.net/attachments/980671209094144032/980671668060045332/meomeo2.jpg?width=445&height=430"
                                alt="Image Placeholder" class="img-fluid">
                            <div class="bio-body">
                                <h2>ToiLaTuan</h2>
                                <p>Biết nói gì với cái web này giờ.</p>
                                <p><a href="#" class="btn btn-primary btn-sm">Read my bio</a></p>
                                <p class="social">
                                    <a class="p-2" href="#"><span class="fa fa-linkedin"></span></a>
                                    <a class="p-2" href="https://www.facebook.com/toilatuann/"><span
                                            class="fa fa-facebook"></span></a>
                                    <a class="p-2" href="https://www.instagram.com/toilatuannnnnn/"><span
                                            class="fa fa-instagram"></span></a>
                                    <a class="p-2" href="https://github.com/tuanduongg"><span class="fa fa-github"></span></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END sidebar -->

            </div>
        </div>
    </section>
@endsection
