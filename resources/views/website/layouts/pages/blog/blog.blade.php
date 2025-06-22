    @include('website.layouts.inc.bradecramp')
    <div class="blog-section py-120">
        <div class="container">
            <div class="row flex-wrap-reverse gy-5">
                <div class="col-lg-4">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar" data-aos="fade-up">
                            <form action="#" autocomplete="off">
                                <div class="search-box w-100">
                                    <input type="text" class="form--control style-two" placeholder="Email Address" />
                                    <button type="submit" class="search-box__button">
                                        <i class="las la-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
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
                                        <a href="{{ route('blog_single.page', $recentblog->post_slug) }}">
                                            <img src="{{ asset($recentblog->image) }}" alt="" /></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title">
                                            <a href="{{ route('blog_single.page', $recentblog->post_slug) }}">
                                                {{ $recentblog->post_title }}
                                            </a>
                                        </h6>
                                        <span class="latest-blog__date">{{ $recentblog->created_at->format('F d, Y') }}</span>
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

                    @foreach ($blogs as $blog)
                        <div class="blog-card-wrapper" data-aos="fade-up">
                            <a href="{{ route('blog_single.page', $blog->post_slug) }}" class="blog-card-wrapper__thumb">
                                <img src="{{ asset($blog->image) }}" alt="" />
                            </a>
                            <div class="blog-card-wrapper__content">
                                <h4 class="blog-card-wrapper__title">
                                    <a href="{{ route('blog_single.page', $blog->post_slug) }}" class="blog-card-wrapper__title-link">
                                        {{ $blog->post_title }}
                                    </a>
                                </h4>
                                <p class="blog-card-wrapper__date">
                                    By: {{ $blog->user_name }} / {{ $blog->created_at->format('j F, Y') }}
                                </p>
                                <p class="blog-card-wrapper__desc">
                                    {!! Str::limit($blog->post_content, 250, '...') !!}
                                </p>
                                @php
                                    $shareUrl = urlencode(route('blog_single.page', $blog->post_slug));
                                    $shareTitle = urlencode($blog->post_title);
                                @endphp
                                <div class="blog-card-wrapper__icon">
                                    <ul class="social-list style-three">
                                        <li class="social-list__item">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                            class="social-list__link" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>

                                        <li class="social-list__item">
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}"
                                            class="social-list__link" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('blog_single.page', $blog->post_slug) }}" class="blog-card-wrapper__button">
                                        Continue Reading
                                        <span class="blog-card-wrapper__button-icon"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <!-- pagination html -->
                    @if ($blogs->lastPage() > 1)
                        <nav aria-label="Page navigation example" data-aos="fade-up">
                            <ul class="pagination">
                                {{-- Page Numbers --}}
                                @for ($i = 1; $i <= $blogs->lastPage(); $i++)
                                    <li class="page-item {{ $blogs->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $blogs->url($i) }}">
                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </li>
                                @endfor

                                {{-- Next Page --}}
                                @if ($blogs->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $blogs->nextPageUrl() }}">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif

                    <!-- pagination html end -->
                </div>
            </div>
        </div>
    </div>
