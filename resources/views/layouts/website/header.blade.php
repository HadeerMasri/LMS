 <section class="header-menu-area header-menu-area4 header-menu-area5">
    <div class="header-menu-fluid">
        <div class="container">
            <div class="row align-items-center menu-content">
                <div class="col-lg-2">
                    <div class="logo-box">
                        <a href="home-55.html" class="logo" title="WebCom"><img src="logo/webcom-logo2.png" class="img-fluid" alt="WebCom"></a>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-9">
                    <div class="menu-wrapper">
                        <nav class="main-menu">
                            <ul>
                                @foreach ($websiteNavbar as $key => $value)
                                @if($value->parent_id == '0' )
                                @if(count($value->children) == '0')
                                <li>
                                    <a class=" {{ ( URL(\Request::getPathInfo()) == URL(\Lang::getLocale(),$value->url) ) ? 'active' : '' }}" href="{{ URL(\Lang::getLocale(),$value->url) }}">  {{ \App::getLocale() == 'en' ? $value->title_en : $value->title }}  </a>
                                </li>
                                @else
                                <li ><a class="{{ ( URL(\Request::getPathInfo()) == URL(\Lang::getLocale(),$value->url) ) ? 'active' : '' }}"
                                  href="{{ URL(\Lang::getLocale(),$value->url) }}">
                                  {{ \App::getLocale() == 'en' ? $value->title_en : $value->title }}  </a>
                                  <ul class="dropdown-menu-item">
                                    @foreach($value->children as $ky => $val)
                                    <li>
                                      <a class="{{ ( URL(\Request::getPathInfo()) == URL(\Lang::getLocale(),$val->url) ) ? 'active' : '' }}" href="{{ route($val->url,\Lang::getLocale()) }}">  {{ \App::getLocale() == 'en' ? $val->title_en : $val->title }}  </a>
                                    </li>
                                      @endforeach

                                  </ul>

                                </li>
                                @endif
                                @endif
                                @endforeach
                            </ul><!-- end ul -->

                        </nav><!-- end main-menu -->
                        <div class="logo-right-button">
                            <div class="side-menu-open">
                                <span class="menu__bar"></span>
                                <span class="menu__bar"></span>
                                <span class="menu__bar"></span>
                            </div>
                        </div><!-- end logo-right-button -->
                        <div class="side-nav-container">
                            <div class="humburger-menu">
                                <div class="humburger-menu-lines side-menu-close"></div><!-- end humburger-menu-lines -->
                            </div><!-- end humburger-menu -->
                            <div class="side-menu-wrap">
                                <ul class="side-menu-ul">
                                    <li class="sidenav__item">
                                        <a href="index.html">home</a>
                                        <span class="menu-plus-icon"></span>
                                        <ul class="side-sub-menu">
                                            <li><a href="index.html">home - main</a></li>
                                            <li><a href="home-2.html">home - agency</a></li>
                                            <li><a href="home-3.html">home - SEO</a></li>
                                            <li><a href="home-4.html">home  - IT Service</a></li>
                                            <li><a href="home-5.html">home - Medical</a></li>
                                        </ul>
                                    </li>
                                    <li class="sidenav__item">
                                        <a href="#">pages</a>
                                        <span class="menu-plus-icon"></span>
                                        <ul class="side-sub-menu">
                                            <li><a href="about-us.html">about us</a></li>
                                            <li><a href="services.html">services</a></li>
                                            <li><a href="service-single.html">service single</a></li>
                                            <li><a href="team.html">our team</a></li>
                                            <li><a href="team-single.html">team single</a></li>
                                            <li><a href="contact-us.html">contact us</a></li>
                                            <li><a href="page-404.html">404 page</a></li>
                                            <li><a href="page-faq.html">FAQ</a></li>
                                            <li><a href="login.html">log in
                                                    <span class="new-page-badge">NEW</span></a>
                                            </li>
                                            <li><a href="sign-up.html">sign up
                                                    <span class="new-page-badge">NEW</span></a>
                                            </li>
                                            <li><a href="recover.html">recover
                                                    <span class="new-page-badge">NEW</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidenav__item">
                                        <a href="#">portfolio</a>
                                        <span class="menu-plus-icon"></span>
                                        <ul class="side-sub-menu">
                                            <li><a href="portfolio-2.html">2 columns</a></li>
                                            <li><a href="portfolio-3.html">3 columns</a></li>
                                            <li><a href="portfolio-4.html">4 columns</a></li>
                                            <li><a href="portfolio-masonry.html">portfolio masonry</a></li>
                                            <li><a href="portfolio-full-width.html">wide version</a></li>
                                            <li><a href="portfolio-single.html">single portfolio</a></li>
                                        </ul>
                                    </li>
                                    <li class="sidenav__item">
                                        <a href="#">blog</a>
                                        <span class="menu-plus-icon"></span>
                                        <ul class="side-sub-menu">
                                            <li><a href="blog-2.html">2 columns</a></li>
                                            <li><a href="blog-3.html">3 columns</a></li>
                                            <li><a href="blog-4.html">4 columns</a></li>
                                            <li><a href="blog-masonry.html">blog masonry</a></li>
                                            <li><a href="blog-full-width.html">wide version</a></li>
                                            <li><a href="blog-single.html">single blog</a></li>
                                        </ul>
                                    </li>
                                    <li class="sidenav__item">
                                        <a href="#">shop</a>
                                        <span class="menu-plus-icon"></span>
                                        <ul class="side-sub-menu">
                                            <li><a href="shop-home.html">shop home</a></li>
                                            <li><a href="shop-grid.html">shop grid</a></li>
                                            <li><a href="shop-single.html">shop single</a></li>
                                            <li><a href="shopping-cart.html">Shopping Cart</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li class="sidenav__item">
                                        <a href="#">elements</a>
                                        <span class="menu-plus-icon"></span>
                                        <ul class="side-sub-menu">
                                            <li><a href="team-members.html"><span class="la la-users"></span>team members</a></li>
                                            <li><a href="pricing-tables.html"><span class="la la-money"></span>pricing tables</a></li>
                                            <li><a href="buttons.html"><span class="la la-mouse-pointer"></span>buttons</a></li>
                                            <li><a href="icon-hover-effects.html"><span class="la la-leaf"></span>icon hover effects</a></li>
                                            <li><a href="content-boxes.html"><span class="la la-question-circle"></span>content boxes</a></li>
                                            <li><a href="flip-boxes.html"><span class="la la-file"></span>flip boxes</a></li>
                                            <li><a href="alert-boxes.html"><span class="la la-warning"></span>alert boxes</a></li>
                                            <li><a href="countdown.html"><span class="la la-clock-o"></span>countdown</a></li>
                                            <li><a href="social-icons.html"><span class="la la-facebook"></span>social icons</a></li>
                                            <li><a href="google-maps.html"><span class="la la-map"></span>google maps</a></li>
                                            <li><a href="charts.html"><span class="la la-line-chart"></span>charts</a></li>
                                            <li><a href="content-carousels.html"><span class="la la-sliders"></span>content carousels</a></li>
                                            <li><a href="bullet-list.html"><span class="la la-list"></span>bullet list</a></li>
                                            <li><a href="accordions.html"><span class="la la-plus"></span>accordions</a></li>
                                            <li><a href="tabs.html"><span class="la la-list-alt"></span>tabs</a></li>
                                            <li><a href="image-galleries.html"><span class="la la-image"></span>image galleries</a></li>
                                            <li><a href="testimonials.html"><span class="la la-star"></span>testimonials</a></li>
                                            <li><a href="faqs.html"><span class="la la-question"></span>faqs</a></li>
                                            <li><a href="timeline.html"><span class="la la-hourglass"></span>timeline</a></li>
                                            <li><a href="tooltip.html"><span class="la la-bolt"></span>tooltip</a></li>
                                            <li><a href="modal.html"><span class="la la-columns"></span>modal</a></li>
                                            <li><a href="heading.html"><span class="la la-h-square"></span>heading</a></li>
                                            <li><a href="highlight-box.html"><span class="la la-bolt"></span>highlight box</a></li>
                                            <li><a href="dual-button.html"><span class="la la-toggle-on"></span>dual button</a></li>
                                            <li><a href="cards.html"><span class="la la-file-text"></span>cards</a></li>
                                            <li><a href="info-box.html"><span class="la la-file-o"></span>info box</a></li>
                                            <li><a href="icon-box.html"><span class="la la-tree"></span>icon box</a></li>
                                            <li><a href="progress-bar.html"><span class="la la-tasks"></span>progress bar</a></li>
                                            <li><a href="instagram-Widgets.html"><span class="la la-instagram"></span>Instagram Widgets</a></li>
                                            <li><a href="video-galleries.html"><span class="la la-video-camera"></span>video galleries</a></li>
                                            <li><a href="blockquotes.html"><span class="la la-quote-left"></span>blockquotes</a></li>
                                            <li><a href="counters.html"><span class="la la-clock-o"></span>counters</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="side-btn-box">
                                    <a href="#" class="theme-btn">get started <span class="la la-caret-right"></span></a>
                                </div>
                            </div><!-- end side-menu-wrap -->
                        </div><!-- end side-nav-container -->
                    </div><!-- end menu-wrapper -->
                </div><!-- end col-lg-9 -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </div><!-- end header-menu-fluid -->
</section><!-- end header-menu-area -->
