@php
    use App\Models\WebsiteSetting;
    $website_setting = WebsiteSetting::first();
@endphp
@include('website.layouts.inc.bradecramp')
<!-- ==================== Breadcumb End Here ==================== -->

<!-- ==================== Contact Start Here ==================== -->
<section class="contact-top" style="background: #F8F9FA">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="contact-item">
                    <div class="contact-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/home/telephone.png" alt="" />
                    </div>
                    <div class="contact-item__content">
                        <h5 class="contact-item__title">{{ $website_setting->phone }}</h5>
                        {{-- <p class="contact-item__desc">
                             Accompanied By English versions
                         </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="contact-item">
                    <div class="contact-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/home/location.png" alt="" />
                    </div>
                    <div class="contact-item__content">
                        <h5 class="contact-item__title">{{ $website_setting->address }}</h5>
                        {{-- <p class="contact-item__desc">
                             including versions of Lorem Ipsum
                         </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="contact-item">
                    <div class="contact-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/home/mail.png" alt="" />
                    </div>
                    <div class="contact-item__content">
                        <h5 class="contact-item__title">{{ $website_setting->email }}</h5>
                        {{-- <p class="contact-item__desc">
                             including versions of Lorem Ipsum
                         </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 d-lg-none d-block">
                <div class="contact-item">
                    <div class="contact-item__thumb">
                        <img src="assets/images/icons/contact01.png" alt="" />
                    </div>
                    <div class="contact-item__content">
                        <h5 class="contact-item__title">000 - 8888 - 9999</h5>
                        <p class="contact-item__desc">
                            Accompanied By English versions
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Contact End Here ==================== -->
<!-- ==================== Contact Form & Map Start Here ==================== -->
<div class="contact-bottom py-120" style="background: #F8F9FA">
    <div class="container">
        <div class="bg-img" style="background-image: url({{ asset('frontend') }}/assets/images/home/bg-banner.jpg)">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-bottom__inner">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-9 col-md-10 col-sm-10">
                                <div class="contactus-form">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="section-heading">
                                                <h4 class="section-heading__title style-four">
                                                    Send Your Message
                                                    <span class="section-heading__bars"></span>
                                                </h4>
                                            </div>
                                        </div>
                                        <form id="contact-form" class="row">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="name" class="mb-2">Your Name<span
                                                                class="required">*</span></label>
                                                        <input type="text" name="name" class="form--control"
                                                            id="name" value="{{ old('name') }}" />
                                                        @error('name')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="emailaddress" class="mb-2">Email Address<span
                                                                class="required">*</span></label>
                                                        <input type="email" name="email" class="form--control"
                                                            id="emailaddress" value="{{ old('email') }}" />
                                                    </div>
                                                    @error('email')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="message" class="mb-2">Your Message
                                                        </label>
                                                        <textarea class="form--control" id="message" name="message">{!! old('message') !!}</textarea>
                                                        @error('message')
                                                            <p class="text-danger">{{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit"
                                                        class="btn-snekers btn-snekers-primary submit_btn">
                                                        SEMD YOUR MESSAGE
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--==================== contact map start here =================-->
<div class="contact-section" style="background: #F8F9FA">
    <div class="contact-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3610.1786539292675!2d55.272182351322364!3d25.197196983817076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f43348a67e24b%3A0xff45e502e1ceb7e2!2sBurj%20Khalifa!5e0!3m2!1sen!2sbd!4v1664880876062!5m2!1sen!2sbd"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
<!-- ====================contact map end here==================== -->

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.submit_btn', function(e) {
                e.preventDefault();

                var formData = $('#contact-form').serialize(); // ✅ ফর্মের ডাটা সংগ্রহ করো

                $.ajax({
                    url: '/contact/submit',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success('বার্তাটি সফলভাবে পাঠানো হয়েছে');
                        $('#contact-form')[0].reset();
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
@endpush
