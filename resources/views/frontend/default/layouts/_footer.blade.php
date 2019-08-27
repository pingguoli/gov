<!-- Footer -->

<footer class="footer">
    <div class="footer_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 order-lg-1 order-3">
                    <div class="footer_image d-flex flex-column align-items-lg-start align-items-center justify-content-end">
                        <div><img src="{{ asset('images/footer.png') }}" alt=""></div>
                    </div>
                </div>
                <div class="col-lg-3 order-lg-2 order-1">
                    <div class="footer_contact_info">
                        <div class="footer_logo"><a href="#"><img src="{{ asset('images/footer_logo.png') }}" alt=""></a></div>
                        <div class="footer_contact_list">
                            <ul>
                                <li class="d-flex flex-row align-items-start justify-content-start">
                                    <div>Address</div>
                                    <div>245 Principe Lane Avila Beach, USA</div>
                                </li>
                                <li class="d-flex flex-row align-items-start justify-content-start">
                                    <div>Phone</div>
                                    <div>+36 345 7953 4994</div>
                                </li>
                                <li class="d-flex flex-row align-items-start justify-content-start">
                                    <div>E-mail</div>
                                    <div>yourmail@gmail.com</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-3 order-2">
                    <div class="newsletter">
                        <div class="newsletter_title">Subscribe to newsletter</div>
                        <div class="newsletter_form_container">
                            <form action="#" class="newsletter_form" id="newsletter_form">
                                <div class="d-flex flex-row align-items-start justify-content-start">
                                    <input type="email" class="newsletter_input" placeholder="Your e-mail address" required="required">
                                    <button class="newsletter_button">Submit</button>
                                </div>
                            </form>
                            <div class="newsletter_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bar">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="footer_bar_content d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-start">
                        <div class="cr order-md-1 order-2"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
                        <nav class="footer_nav ml-md-auto order-md-2 order-1">
                            <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
                                <li><a href="{{ route('home') }}">首页</a></li>
                                <li><a href="{{ route('news') }}">新闻</a></li>
                                <li><a href="{{ route('contact') }}">联系我们</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>