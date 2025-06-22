<div class="slider-area">
    <div class="slider-active">
        @foreach ($sliders as $index => $slider)
            <div class="single-slider slider-height-2 d-flex align-items-center {{ $index == 0 ? 'active' : '' }}"
                style="background-image: url('{{ asset($slider->image) }}'); background-size: cover; background-position: center;">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="slider-content">
                                <h1 data-animation="fadeInUp" data-delay=".6s">{{ $slider->slider_title }}</h1>
                                <p data-animation="fadeInUp" data-delay=".8s">{!! $slider->slider_content !!}</p>
                                <div class="slider-button">
                                    <a data-animation="fadeInRight" data-delay="1s" class="btn active text-uppercase"
                                        href="{{ $slider->button_url }}">Our Products</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
