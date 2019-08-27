@extends('frontend::layouts.default')

@section('title', '关于我们')

@section('style')
    @include('frontend::about._css')
@stop

@section('script')
    @include('frontend::about._js')
@stop

@section('content')

    <div class="home d-flex flex-column align-items-start justify-content-end">
        <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="home_text">About <span>the team</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- About -->

    <div class="about">
        <div class="container">
            <div class="row">

                <!-- About Image -->
                <div class="col-xl-6 order-xl-1 order-2">
                    <div class="about_image">
                        <div class="background_image" style="background-image:url(images/about_1.jpg)"></div>
                        <img src="images/about_1.jpg" alt="">
                    </div>
                </div>

                <!-- About content -->
                <div class="col-xl-6 order-xl-2 order-1">
                    <div class="about_content">
                        <div class="about_content_container">
                            <div class="section_title_container">
                                <div class="section_title"><h1>about the tigers</h1></div>
                            </div>
                            <div class="about_title">mission&vision</div>
                            <div class="about_subtitle">Resoect for the game</div>
                            <div class="about_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Nunc molestie malesuada pellentesque. Quisque mattis ante ut nisl tristique ornare. Aenean interdum dictum augue, quis egestas erat lacinia in. Proin dictum commodo nulla ut mattis. Pellentesque vel commodo nisi. Donec eget purus eget ex efficitur tristique. Nulla ut mollis justo.</p>
                                <p>Nam turpis nulla, ullamcorper volutpat faucibus ut, facilisis in elit. Nam blandit diam vel felis porta, vitae congue nulla feugiat. Vestibulum rhoncus odio elit, at aliquet sem posuere vel.</p>
                            </div>
                            <div class="button about_button"><a href="#">See More Info</a></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Team -->

    <div class="team">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section_title_container text-center">
                        <div class="section_title"><h1>meet the tigers</h1></div>
                        <div class="section_subtitle">2018-2019 season</div>
                    </div>
                </div>
            </div>
            <div class="row team_large_row">

                <!-- Team Item -->
                <div class="col-lg-4">
                    <div class="team_large">
                        <div class="team_large_image"><img src="images/team_large_1.jpg" alt=""></div>
                        <div class="team_large_content text-center">
                            <div class="team_large_name"><a href="#">Michael Smith</a></div>
                            <div class="team_large_title">head coach</div>
                            <div class="team_large_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit.</p>
                            </div>
                            <div class="team_large_history"><span>Past teams: </span><a href="#">Panthers</a>, <a href="#">The Cougars</a></div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-lg-4">
                    <div class="team_large">
                        <div class="team_large_image"><img src="images/team_large_2.jpg" alt=""></div>
                        <div class="team_large_content text-center">
                            <div class="team_large_name"><a href="#">Chris Parker</a></div>
                            <div class="team_large_title">assistant coach</div>
                            <div class="team_large_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit.</p>
                            </div>
                            <div class="team_large_history"><span>Past teams: </span><a href="#">The Jaguars</a></div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-lg-4">
                    <div class="team_large">
                        <div class="team_large_image"><img src="images/team_large_3.jpg" alt=""></div>
                        <div class="team_large_content text-center">
                            <div class="team_large_name"><a href="#">George Williams</a></div>
                            <div class="team_large_title">advance scout</div>
                            <div class="team_large_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit.</p>
                            </div>
                            <div class="team_large_history"><span>Past teams: </span><a href="#">The Stars</a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row team_small_row">

                <!-- Team Item -->
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="team_small d-flex flex-sm-column flex-row align-items-center justify-content-sm-center justify-content-start">
                        <div class="team_small_image"><a href="#"><img src="images/team_small_1.jpg" alt=""></a><div>83</div></div>
                        <div class="team_small_content text-sm-center">
                            <div class="team_small_name"><a href="#">Paul Kay</a></div>
                            <div class="team_small_title">team leader</div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="team_small d-flex flex-sm-column flex-row align-items-center justify-content-sm-center justify-content-start">
                        <div class="team_small_image"><a href="#"><img src="images/team_small_2.jpg" alt=""></a><div>12</div></div>
                        <div class="team_small_content text-sm-center">
                            <div class="team_small_name"><a href="#">Sam Dean</a></div>
                            <div class="team_small_title">quarterback</div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="team_small d-flex flex-sm-column flex-row align-items-center justify-content-sm-center justify-content-start">
                        <div class="team_small_image"><a href="#"><img src="images/team_small_3.jpg" alt=""></a><div>25</div></div>
                        <div class="team_small_content text-sm-center">
                            <div class="team_small_name"><a href="#">Michael Doe</a></div>
                            <div class="team_small_title">player</div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="team_small d-flex flex-sm-column flex-row align-items-center justify-content-sm-center justify-content-start">
                        <div class="team_small_image"><a href="#"><img src="images/team_small_4.jpg" alt=""></a><div>33</div></div>
                        <div class="team_small_content text-sm-center">
                            <div class="team_small_name"><a href="#">Paul Kay</a></div>
                            <div class="team_small_title">player</div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="team_small d-flex flex-sm-column flex-row align-items-center justify-content-sm-center justify-content-start">
                        <div class="team_small_image"><a href="#"><img src="images/team_small_5.jpg" alt=""></a><div>61</div></div>
                        <div class="team_small_content text-sm-center">
                            <div class="team_small_name"><a href="#">Dan Joe</a></div>
                            <div class="team_small_title">player</div>
                        </div>
                    </div>
                </div>

                <!-- Team Item -->
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="team_small d-flex flex-sm-column flex-row align-items-center justify-content-sm-center justify-content-start">
                        <div class="team_small_image"><a href="#"><img src="images/team_small_6.jpg" alt=""></a><div>09</div></div>
                        <div class="team_small_content text-sm-center">
                            <div class="team_small_name"><a href="#">Patrick Kay</a></div>
                            <div class="team_small_title">player</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col text-center">
                    <div class="button team_button"><a href="#">See the team</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->

    <div class="testimonials">
        <div class="parallax_background" data-image-src="images/testimonials.jpg"></div>
        <div class="test_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section_title_container text-center">
                        <div class="section_title"><h1>testimonials</h1></div>
                        <div class="section_subtitle">The Fans</div>
                    </div>
                    <div class="testimonials_slider_container">
                        <div class="owl-carousel owl-theme test_slider">

                            <!-- Slide -->
                            <div>
                                <div class="test_item text-center">
                                    <div class="test_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Nunc molestie malesuada pellentesque. Quisque mattis ante ut nisl tristique ornare. Aenean interdum dictum augue, quis egestas erat lacinia in. Proin dictum commodo nulla ut mattis. Pellentesque vel commodo nisi. Donec eget purus eget ex efficitur tristique. Nulla ut mollis justo.</p>
                                    </div>
                                    <div class="test_image"><img src="images/test_1.jpg" alt=""></div>
                                    <div class="test_name"><a href="#">Michael</a><span>, Superfan</span></div>
                                </div>
                            </div>

                            <!-- Slide -->
                            <div>
                                <div class="test_item text-center">
                                    <div class="test_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Nunc molestie malesuada pellentesque. Quisque mattis ante ut nisl tristique ornare. Aenean interdum dictum augue, quis egestas erat lacinia in. Proin dictum commodo nulla ut mattis. Pellentesque vel commodo nisi. Donec eget purus eget ex efficitur tristique. Nulla ut mollis justo.</p>
                                    </div>
                                    <div class="test_image"><img src="images/test_1.jpg" alt=""></div>
                                    <div class="test_name"><a href="#">Michael</a><span>, Superfan</span></div>
                                </div>
                            </div>

                            <!-- Slide -->
                            <div>
                                <div class="test_item text-center">
                                    <div class="test_text">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Nunc molestie malesuada pellentesque. Quisque mattis ante ut nisl tristique ornare. Aenean interdum dictum augue, quis egestas erat lacinia in. Proin dictum commodo nulla ut mattis. Pellentesque vel commodo nisi. Donec eget purus eget ex efficitur tristique. Nulla ut mollis justo.</p>
                                    </div>
                                    <div class="test_image"><img src="images/test_1.jpg" alt=""></div>
                                    <div class="test_name"><a href="#">Michael</a><span>, Superfan</span></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->

    <div class="cta">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="cta_content d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-start">
                        <div class="cta_text">Would you like to join our <span>football club?</span></div>
                        <div class="cta_button button ml-md-auto"><a href="#">See More Info</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop