@extends('frontend::layouts.default')

@section('title', '新闻')

@section('style')
    @include('frontend::news._css')
@stop

@section('script')
    @include('frontend::news._js')
@stop

@section('content')

    <!-- Home -->

    <div class="home d-flex flex-column align-items-start justify-content-end">
        <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/blog.jpg" data-speed="0.8"></div>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="home_text">The <span>News</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog -->

    <div class="blog">
        <div class="container">
            <div class="row">

                <!-- Blog Posts -->
                <div class="col-lg-9">
                    <div class="blog_posts">

                        <!-- Blog Post -->
                        <div class="blog_post">
                            <div class="blog_post_image">
                                <img src="images/blog_1.jpg" alt="https://unsplash.com/@johntorcasio">
                                <div class="blog_post_date">
                                    <a href="#">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div>10</div>
                                            <div>sept</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="blog_post_content">
                                <div class="tags">
                                    <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
                                        <li><a href="blog.html">News</a></li>
                                    </ul>
                                </div>
                                <div class="blog_post_title"><a href="blog.html">T-shirt release date - Announcement</a></div>
                                <div class="blog_post_text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Post -->
                        <div class="blog_post">
                            <div class="blog_post_image">
                                <img src="images/blog_2.jpg" alt="">
                                <div class="blog_post_date">
                                    <a href="#">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div>10</div>
                                            <div>sept</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="blog_post_content">
                                <div class="tags">
                                    <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
                                        <li><a href="blog.html">News</a></li>
                                    </ul>
                                </div>
                                <div class="blog_post_title"><a href="blog.html">3 new transfers for this summer</a></div>
                                <div class="blog_post_text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Post -->
                        <div class="blog_post">
                            <div class="blog_post_image">
                                <img src="images/blog_3.jpg" alt="https://unsplash.com/@aloragriffiths">
                                <div class="blog_post_date">
                                    <a href="#">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div>10</div>
                                            <div>sept</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="blog_post_content">
                                <div class="tags">
                                    <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
                                        <li><a href="blog.html">News</a></li>
                                    </ul>
                                </div>
                                <div class="blog_post_title"><a href="blog.html">Woman’s league is comming strong</a></div>
                                <div class="blog_post_text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan dolor id enim lacinia, sed feugiat ex suscipit.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3 sidebar_col">
                    <div class="sidebar">
                        <div class="latest_games">
                            <div class="sidebar_title_container">
                                <div class="sidebar_title"><h3>latest games</h3></div>
                                <div class="sidebar_subtitle">Results</div>
                            </div>

                            <!-- Latest Games -->
                            <div class="latest_games_container text-center">
                                <ul>
                                    <li>
                                        <div class="latest_games_score">8 : 3</div>
                                        <div class="latest_games_teams d-flex flex-row align-items-start justify-content-start">
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-start align-items-center justify-content-start">
                                                <div class="team_logo"><a href="team.html"><img src="images/logo_1.png" alt=""></a></div>
                                                <div class="team_name text-left"><a href="team.html">New Alligators</a></div>
                                            </div>
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-end align-items-center justify-content-end">
                                                <div class="team_name text-right order-xl-1 order-lg-2 order-1"><a href="team.html">The Tigers</a></div>
                                                <div class="team_logo order-xl-2 order-lg-1 order-2"><a href="team.html"><img src="images/logo_2.png" alt=""></a></div>
                                            </div>
                                        </div>
                                        <div class="latest_games_date"><a href="#">August 25, 2018 / 17 UTC</a></div>
                                    </li>
                                    <li>
                                        <div class="latest_games_score">7 : 5</div>
                                        <div class="latest_games_teams d-flex flex-row align-items-start justify-content-start">
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-start align-items-center justify-content-start">
                                                <div class="team_logo"><a href="team.html"><img src="images/logo_2.png" alt=""></a></div>
                                                <div class="team_name text-left"><a href="team.html">The Tigers</a></div>
                                            </div>
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-end align-items-center justify-content-end">
                                                <div class="team_name text-right order-xl-1 order-lg-2 order-1"><a href="team.html">The Eagles</a></div>
                                                <div class="team_logo order-xl-2 order-lg-1 order-2"><a href="team.html"><img src="images/logo_4.png" alt=""></a></div>
                                            </div>
                                        </div>
                                        <div class="latest_games_date"><a href="#">August 25, 2018 / 17 UTC</a></div>
                                    </li>
                                    <li>
                                        <div class="latest_games_score">3 : 9</div>
                                        <div class="latest_games_teams d-flex flex-row align-items-start justify-content-start">
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-start align-items-center justify-content-start">
                                                <div class="team_logo"><a href="team.html"><img src="images/logo_3.png" alt=""></a></div>
                                                <div class="team_name text-left"><a href="team.html">Denver Pumas</a></div>
                                            </div>
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-end align-items-center justify-content-end">
                                                <div class="team_name text-right order-xl-1 order-lg-2 order-1"><a href="team.html">The Tigers</a></div>
                                                <div class="team_logo order-xl-2 order-lg-1 order-2"><a href="team.html"><img src="images/logo_2.png" alt=""></a></div>
                                            </div>
                                        </div>
                                        <div class="latest_games_date"><a href="#">August 25, 2018 / 17 UTC</a></div>
                                    </li>
                                    <li>
                                        <div class="latest_games_score">7 : 5</div>
                                        <div class="latest_games_teams d-flex flex-row align-items-start justify-content-start">
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-start align-items-center justify-content-start">
                                                <div class="team_logo"><a href="team.html"><img src="images/logo_2.png" alt=""></a></div>
                                                <div class="team_name text-left"><a href="team.html">New Tigers</a></div>
                                            </div>
                                            <div class="d-flex flex-xl-row flex-lg-column flex-row align-items-xl-center align-items-lg-end align-items-center justify-content-end">
                                                <div class="team_name text-right order-xl-1 order-lg-2 order-1"><a href="team.html">The Eagles</a></div>
                                                <div class="team_logo order-xl-2 order-lg-1 order-2"><a href="team.html"><img src="images/logo_5.png" alt=""></a></div>
                                            </div>
                                        </div>
                                        <div class="latest_games_date"><a href="#">August 25, 2018 / 17 UTC</a></div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Cagegories -->
                            <div class="categories">
                                <div class="sidebar_title_container">
                                    <div class="sidebar_title"><h3>categories</h3></div>
                                    <div class="sidebar_subtitle">Results</div>
                                </div>
                                <div class="categories_list">
                                    <ul>
                                        <li><a href="#">Games</a></li>
                                        <li><a href="#">About the team</a></li>
                                        <li><a href="#">Press Release</a></li>
                                        <li><a href="#">Football</a></li>
                                        <li><a href="#">Uncategorized</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Latest Posts -->
                            <div class="latest_posts">
                                <div class="sidebar_title_container">
                                    <div class="sidebar_title"><h3>latest posts</h3></div>
                                    <div class="sidebar_subtitle">Results</div>
                                </div>
                                <div class="latest_posts_container">

                                    <!-- Latest_post -->
                                    <div class="latest_post d-flex flex-row align-items-start justify-content-start">
                                        <div class="latest_post_image"><a href="#"><img src="images/latest_1.jpg" alt=""></a></div>
                                        <div class="latest_post_content">
                                            <div class="latest_post_date"><a href="#">Sept 10</a></div>
                                            <div class="latest_post_title"><a href="#">3 New transfers for this summer</a></div>
                                        </div>
                                    </div>

                                    <!-- Latest_post -->
                                    <div class="latest_post d-flex flex-row align-items-start justify-content-start">
                                        <div class="latest_post_image"><a href="#"><img src="images/latest_2.jpg" alt=""></a></div>
                                        <div class="latest_post_content">
                                            <div class="latest_post_date"><a href="#">Sept 10</a></div>
                                            <div class="latest_post_title"><a href="#">T-shirt release press conference</a></div>
                                        </div>
                                    </div>

                                    <!-- Latest_post -->
                                    <div class="latest_post d-flex flex-row align-items-start justify-content-start">
                                        <div class="latest_post_image"><a href="#"><img src="images/latest_3.jpg" alt=""></a></div>
                                        <div class="latest_post_content">
                                            <div class="latest_post_date"><a href="#">Sept 10</a></div>
                                            <div class="latest_post_title"><a href="#">3 New transfers for this summer</a></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Tickets -->
                            <div class="tickets">
                                <div class="background_image" style="background-image:url(images/tickets.jpg)"></div>
                                <div class="tickets_content text-center">
                                    <div class="tickets_title">Buy Tickets</div>
                                    <div class="tickets_subtitle">See The Tigers Play</div>
                                    <div class="tickets_logo"><img src="images/logo.png" alt=""></div>
                                    <div class="button tickets_button"><a href="#">Get tickets now</a></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row page_nav_row">
                <div class="col">
                    <div class="page_nav">
                        <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
                            <li class="active"><a href="#">01.</a></li>
                            <li><a href="#">02.</a></li>
                            <li><a href="#">03.</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop