@php
    use App\Models\WebsiteSetting;
    $website_setting = WebsiteSetting::select(['image'])->first();
@endphp

<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb py-120 bg-img" style="background-image: url({{ asset($website_setting->image) }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcumb__wrapper">
                    <h1 class="breadcumb__title">{{ $singleBlogPage->post_title }}</h1>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item">
                            <a href="{{ route('home') }}" class="breadcumb__link">
                                <i class="las la-home"></i> Home</a>
                        </li>
                        <li class="breadcumb__item">/</li>
                        <li class="breadcumb__item">
                            <span class="breadcumb__item-text"> Blog Single Page </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->

<div class="blog-section py-120">
    <div class="container">
        <div class="row flex-wrap-reverse gy-5">
            <div class="col-lg-4">
                <div class="blog-sidebar-wrapper">

                    <div class="blog-sidebar" data-aos="fade-up">
                        <h5 class="blog-sidebar__title">Category</h5>
                        <ul class="text-list style-category">
                            @forelse ($postCategories as $postCategory)
                                <li class="text-list__item">
                                    <a href="blog.html" class="text-list__link"><span class="text-list__icon"><i
                                                class="fas fa-angle-right"></i></span>
                                        {{ $postCategory->category_name }} ({{ $postCategory->posts->count() }})
                                    </a>
                                </li>
                            @empty
                                <li class="text-list__item">
                                    Category not found
                                </li>
                            @endforelse


                        </ul>
                    </div>
                    <div class="blog-sidebar" data-aos="fade-up">
                        <h5 class="blog-sidebar__title">Recent Post</h5>

                        @forelse ($recentBlogs as $recentblog)
                            <div class="latest-blog">
                                <div class="latest-blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="{{ asset($recentblog->image) }}" alt="" /></a>
                                </div>
                                <div class="latest-blog__content">
                                    <h6 class="latest-blog__title">
                                        <a href="blog-details.html">
                                            {{ $recentblog->post_title }}
                                        </a>
                                    </h6>
                                    <span
                                        class="latest-blog__date">{{ $recentblog->created_at->format('F d, Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="latest-blog">
                                <h4>Post Not Found</h4>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>


            <div class="col-lg-8">


                <div class="blog-card-wrapper" data-aos="fade-up">
                    <a href="#" class="blog-card-wrapper__thumb">
                        <img src="{{ asset($singleBlogPage->image) }}" alt="" />
                    </a>
                    <div class="blog-card-wrapper__content">
                        <h4 class="blog-card-wrapper__title">
                            <a href="#" class="blog-card-wrapper__title-link">
                                {{ $singleBlogPage->post_title }}
                            </a>
                        </h4>
                        <p class="blog-card-wrapper__date">
                            By: {{ $singleBlogPage->user_name }} / {{ $singleBlogPage->created_at->format('j F, Y') }}
                        </p>
                        @php
                            $shareUrl = urlencode(route('blog_single.page', $singleBlogPage->post_slug));
                            $shareTitle = urlencode($singleBlogPage->post_title);
                        @endphp

                        <p class="blog-card-wrapper__desc">
                            {!! $singleBlogPage->post_content !!}
                        </p>

                        <div class="blog-card-wrapper__icon">
                            <ul class="social-list style-three">
                                <li class="social-list__item">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                        class="social-list__link" target="_blank" rel="noopener noreferrer"
                                        title="Share on Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>

                                <li class="social-list__item">
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}"
                                        class="social-list__link" target="_blank" rel="noopener noreferrer"
                                        title="Share on LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
