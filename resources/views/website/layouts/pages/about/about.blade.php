@include('website.layouts.inc.bradecramp')

<!--========================== About Section Start ==========================-->
<div class="about-section py-120">
    <div class="container">
        <div class="row gy-5 flex-wrap-reverse align-items-center">
            <div class="col-lg-6" data-aos="zoom-in">
                <div class="about-thumb">
                    <img src="{{ asset($about->image) }}" alt="image" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="section-heading style-two" data-aos="fade-up">
                        <h4 class="section-heading__subtitle">About Us</h4>
                        <div class="col-md-6">
                            <h3 class="section-heading__title style-two">
                                {{ $about->about_title }}
                                <span class="section-heading__bars style-two"></span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="about-us">
                    <p class="about-us__desc">
                        {!! $about->description !!}
                    </p>
                    {{-- <div class="d-flex justify-content-betwwen flex-wrap mb-4">
                            <ul class="text-menu style">
                                <li class="text-menu__item">
                                    <span class="text-menu__icon"><i class="fas fa-check"></i></span>
                                    Deals & Promotions
                                </li>
                                <li class="text-menu__item">
                                    <span class="text-menu__icon"><i class="fas fa-check"></i></span>
                                    Service agreement
                                </li>
                            </ul>
                            <ul class="text-menu">
                                <li class="text-menu__item">
                                    <span class="text-menu__icon"><i class="fas fa-check"></i></span>
                                    Nsectetur cing elit
                                </li>
                                <li class="text-menu__item">
                                    <span class="text-menu__icon"><i class="fas fa-check"></i></span>
                                    Printing and typesetting
                                </li>
                            </ul>
                        </div> --}}
                    {{-- <div class="about-us-author">
                            <div class="about-us-author__info d-flex align-items-center">
                                <div class="about-us-author__thumb">
                                    <img src="{{ asset('frontend') }}/assets/images/thumbs/about/about03.png" alt="" />
                                </div>
                                <div class="about-us-author__title">
                                    <h6 class="about-us-author__name">Dianne Russell</h6>
                                    <span class="about-us-author__customer"> Customer </span>
                                </div>
                            </div>
                            <h5 class="about-us-author__text">
                                Over
                                <span class="about-us-author__text-style"> 150,000+</span>
                                client all over the world.
                            </h5>
                        </div> --}}
                    <div class="about-us-footer">
                        <span class="about-us-footer__text">If you need any help? Call us
                            <a href="tel:$about->help_number" class="about-us-footer__link">
                                {{ $about->help_number }}
                            </a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--========================== About Section End ==========================-->

<!-- =======================Mission and vission section start here =================-->
<div id="custom-mission-vision">
    <div class="container">
        <div class="row gy-4 justify-content-center" data-aos="zoom-in">
            <div class="col-lg-6 col-sm-6 col-xsm-6">
                <div class="choose-item">

                    <div class="choose-item__content">
                        <h2 class="">Our Mission</h2>
                        <p class="">
                            {!! $missionVission->mission_content !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xsm-6">
                <div class="choose-item">

                    <div class="choose-item__content">
                        <h2 class="choose-item__title">Our Vision</h2>
                        <p class="choose-item__desc">
                            {!! $missionVission->vision_content !!}
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- ====================why choose section end here =====================-->


<!-- =======================why choose section start here =================-->
<div class="why-choose pt-120">
    <div class="why-choose__bg">
        <img src="{{ asset('frontend') }}/assets/images/home/bg-banner.jpg" alt="" />
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h4 class="section-heading__subtitle text-white">Choose Us</h4>
                    <h3 class="section-heading__title style-two text-white style-three">
                        Why Choose Us
                        <span class="section-heading__bars style-three"></span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center" data-aos="zoom-in">
            @foreach ($whychoseuses as $whychoseus)
                <div class="col-lg-4 col-sm-6 col-xsm-6">
                    <div class="choose-item">
                        <div class="choose-item__thumb">
                            <img src="{{ asset($whychoseus->image) }}" alt="" />
                        </div>
                        <div class="choose-item__content">
                            <h4 class="choose-item__title">{{ $whychoseus->title }}</h4>
                            <p class="choose-item__desc">
                                {!! $whychoseus->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
<!-- ====================why choose section end here =====================-->


<!-- ==========================testimonial section start here=======================-->
<div class="testimonial-section pb-60">
    <div class="container">
        <div class="row align-items-center flex-wrap" data-aos="zoom-in">
            <div class="col-lg-6">
                <div class="testimonials-thumb-slider">
                    @foreach ($reviews as $review)
                        <div class="testimonial-thumb">
                            <img src="{{ asset($review->image) }}" alt="" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testimonial-slick-slider">

                    @foreach ($reviews as $review)
                        <div class="testimonial-slider">
                            <div class="testimonial-slider__icon">
                                <img src="{{ asset('frontend') }}/assets/images/icons/testimonial-icon.png"
                                    alt="" />
                            </div>
                            <p class="testimonial-slider__desc">
                                {!! $review->review !!}
                            </p>
                            <div class="testimonial-slider__details">
                                <h4 class="testimonial-slider__name">{{ $review->name }}</h4>
                                <span class="testimonial-slider__designation">{{ $review->profession }} </span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================testimonial section end here ==========================-->
<!--========================== Coverage Section Start ==========================-->
{{-- <div class="client pb-120 pt-60">
        <div class="container">
            <div class="client-logos client-slider" data-aos="zoom-in">
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-01.png" alt="" />
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-04.png" alt="" />
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-03.png" alt="" />
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-04.png" alt="" />
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-01.png" alt="" />
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-04.png" alt="" />
                <img src="{{ asset('frontend') }}/assets/images/2__brands/client-03.png" alt="" />
            </div>
        </div>
    </div> --}}
<!--========================== Coverage Section End ==========================-->
<!-- ======================galler section start here=================== -->

{{-- <div class="gallery-section">
        <div class="container-fluid px-0">
            <div class="row gx-0">
                <div class="col-lg-3 col-sm-6 col-xxsm-6">
                    <div class="gallery-item">
                        <div class="gallery-item__thumb">
                            <img src="{{ asset('frontend') }}/assets/images/thumbs/about/about09.png" alt="" />
                            <div class="hover-overlay">
                                <a href="https://www.instagram.com/" class="hover-overlay__icon"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xxsm-6">
                    <div class="gallery-item">
                        <div class="gallery-item__thumb">
                            <img src="{{ asset('frontend') }}/assets/images/thumbs/about/about10.png" alt="" />
                            <div class="hover-overlay">
                                <a href="https://www.instagram.com/" class="hover-overlay__icon"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xxsm-6">
                    <div class="gallery-item">
                        <div class="gallery-item__thumb">
                            <img src="{{ asset('frontend') }}/assets/images/thumbs/about/about12.png" alt="" />
                            <div class="hover-overlay">
                                <a href="https://www.instagram.com/" class="hover-overlay__icon"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xxsm-6">
                    <div class="gallery-item">
                        <div class="gallery-item__thumb">
                            <img src="{{ asset('frontend') }}/assets/images/thumbs/about/about11.png" alt="" />
                            <div class="hover-overlay">
                                <a href="https://www.instagram.com/" class="hover-overlay__icon"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

<!-- ======================galler section end here=================== -->

<!--============================feature section start here =======================-->
<div class="feature-section bg-img py-60"
    style="
        background-image: url({{ asset('frontend') }}/assets/images/home/bg-banner.jpg);
      ">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f04.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">FREE SHIPPING</h5>
                        <span class="feature-item__payment">
                            For All Order Over $99
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f03.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">FRIENDLY SUPPORT</h5>
                        <span class="feature-item__payment">
                            24/7 Customer Support
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f02.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">SECURE PAYMENT</h5>
                        <span class="feature-item__payment">100% Secure Payment</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f01.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">SHIPPING & RETURN</h5>
                        <span class="feature-item__payment">
                            within 30days For Refund
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
