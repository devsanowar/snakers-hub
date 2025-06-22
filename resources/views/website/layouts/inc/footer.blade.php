	@php
        use App\Models\WebsiteSetting;
        use App\Models\WebsiteSocialIcon;
        $website_setting = WebsiteSetting::first();
        $website_social = WebsiteSocialIcon::first();
    @endphp


    <!-- bottom navigation -->
    <!-- Mobile Sticky Bottom Menu Start-->
    <section id="mobile-sticky-bottom-menu">
        <ul class="mobile-bottom-ul">
            <li>
                <a href="{{ route('home') }}" class="active"><i class="fas fa-home"></i><span>Home</span></a>
            </li>
            <li>
                <a href="#"><i class="fa-solid fa-table"></i><span>Categories</span></a>
            </li>
            <li>
            <a href="javascript:void(0);" id="searchToggle">
                <i class="fas fa-search"></i><span>Search</span>
            </a>
        </li>

            <li>
                <a href="/cart.html"><i class="fas fa-shopping-cart"></i><span>Cart</span></a>
            </li>
            <li>
                <a href="/login.html"><i class="fas fa-user"></i><span>Account</span></a>
            </li>
        </ul>
    </section>
    <!-- Mobile Sticky Bottom Menu Start-->
    <!-- ========footer===== -->

    <!-- ==================== Footer Start Here ==================== -->
    <footer class="footer-area section-bg-light bg-img">
        <div class="pb-60" style="padding-top:70px">
            <div class="container">
                <div class="row justify-content-center gy-5">
                    <div class="col-xl-3 col-sm-6">
                        <div class="footer-item">
                            <div class="footer-item__logo">
                                <a href="index.html">
                                    <img src="{{ asset($website_setting->website_footer_logo) }}" alt="" /></a>
                            </div>
                            <p class="footer-item__desc">
                                {!! $website_setting->footer_content !!}
                            </p>
                            <ul class="social-list">
                                <li class="social-list__item">
                                    <a href="{{ $website_social->facebook_url }}" class="social-list__link" target="_blank"><i
                                            class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="social-list__item">
                                    <a href="{{ $website_social->twitter_url }}" class="social-list__link" target="_blank">
                                        <i class="fab fa-twitter"></i></a>
                                </li>
                                <li class="social-list__item">
                                    <a href="{{ $website_social->linkedin_url }}" class="social-list__link" target="_blank">
                                        <i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li class="social-list__item">
                                    <a href="{{ $website_social->pinterest_url }}" class="social-list__link" target="_blank">
                                        <i class="fab fa-pinterest-p"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-1 d-xl-block d-none"></div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="footer-item">
                            <h5 class="footer-item__title">Pages</h5>
                            <ul class="footer-menu">
                                <li class="footer-menu__item">
                                    <a href="{{ route('about.page') }}" class="footer-menu__link"> About Us</a>
                                </li>
                                <li class="footer-menu__item">
                                    <a href="{{ route('shop_page') }}" class="footer-menu__link"> Shop</a>
                                </li>
                                <li class="footer-menu__item">
                                    <a href="{{ route('faq.page') }}" class="footer-menu__link"> Faq</a>
                                </li>
                                <li class="footer-menu__item">
                                    <a href="{{ route('cart.page') }}" class="footer-menu__link">Shopping Cart
                                    </a>
                                </li>
                                <li class="footer-menu__item">
                                    <a href="{{ route('blog.page') }}" class="footer-menu__link"> Blog</a>
                                </li>

                                <li class="footer-menu__item">
                                    <a href="{{ route('contact.page') }}" class="footer-menu__link"> Contact</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="footer-item">
                            <h5 class="footer-item__title">Useful link</h5>
                            <ul class="footer-menu">
                                <li class="footer-menu__item">
                                    <a href="{{route('privacy_policy.page')}}" class="footer-menu__link">
                                        Privacy Policy
                                    </a>
                                </li>
                                <li class="footer-menu__item">
                                    <a href="{{route('terms_and_condition.page')}}" class="footer-menu__link">Terms & Condition
                                    </a>
                                </li>
                                <li class="footer-menu__item">
                                    <a href="{{route('return_refund.page')}}" class="footer-menu__link">Return & Refund </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-1 d-xl-block d-none"></div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="footer-item">
                            <h5 class="footer-item__title">Subscribe now</h5>
                            <div class="subscriber-form mb-3">
                                <form id="newsletterForm">
                                    @csrf
                                    <input type="text" name="phone" class="form--control style-two" placeholder="Phone Number"
                                    aria-label="Recipient's username" />
                                    <button class="btn btn--base subscribe-button" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                            <p>
                                Subscribe to our newsletter and get 10% off your first
                                purchase..
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Top End-->

        <!-- bottom Footer -->
        <div class="bottom-footer section-bg py-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="bottom-footer__text">
                            {{ $website_setting->copyright_text }}.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bottom-footer__text_dev">
                            <span>Devbeloped by <a href="https://www.freelanceit.com.bd/" target="_blank" rel="noopener noreferrer">Freelance It</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ==================== Footer End Here ==================== -->

    @include('website.layouts.inc.script')

<script>
    $(document).ready(function() {
        $(document).on('click', '.subscribe-button', function(e) {
            e.preventDefault();

            var formData = $('#newsletterForm').serialize(); // ✅ ফর্মের ডাটা সংগ্রহ করো

            $.ajax({
                url: '/subscribe-newsletter',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('বার্তাটি সফলভাবে পাঠানো হয়েছে');
                    $('#newsletterForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('ত্রুটি হয়েছে, আবার চেষ্টা করুন');
                    }
                }
            });
        });
    });
</script>

</body>

</html>
