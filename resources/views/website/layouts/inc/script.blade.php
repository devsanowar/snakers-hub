<!-- Jquery js -->
<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery-3.6.1.min.js"></script>
<!-- Popper js -->
<script src="{{ asset('frontend') }}/assets/js/popper.min.js"></script>
<!-- Bootstrap Js -->
<script src="{{ asset('frontend') }}/assets/js/bootstrap.min.js"></script>
<!-- Slick js -->
<script src="{{ asset('frontend') }}/assets/js/slick.min.js"></script>
<!-- mixitup js -->
<script src="{{ asset('frontend') }}/assets/js/mixitup.min.js"></script>
<!-- countdown js -->
<script src="{{ asset('frontend') }}/assets/js/jquery.knob.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery.throttle.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery.classycountdown.min.js"></script>
<!-- range js -->
<script src="{{ asset('frontend') }}/assets/js/jquery-ui.js"></script>
<!-- magnific popup js -->
<script src="{{ asset('frontend') }}/assets/js/jquery.magnific-popup.min.js"></script>
<!-- swiper -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000
        });
    </script>
<!-- main js -->
<script src="{{ asset('frontend') }}/assets/js/main.js"></script>

{{-- <script src="{{ asset('frontend') }}/assets/js/mixitup.min.js"></script> --}}
<script>
    // mixitup initialization
    var mixer = mixitup(".mix-container");

    // AOS animation initialization
    AOS.init({
        duration: 800,
    });

    // Active class handler for mobile menu (optional)
    const links = document.querySelectorAll(".mobile-bottom-ul a");
    links.forEach((link) => {
        link.addEventListener("click", () => {
            links.forEach((l) => l.classList.remove("active"));
            link.classList.add("active");
        });
    });
</script>


<script>

    // Seacrch Text Animated
    const placeholderText = "Search by Product  Name ...";
    const inputField = document.getElementById("searchInput");

    let index = 0;

    function typePlaceholder() {
        if (index < placeholderText.length) {
            inputField.setAttribute(
                "placeholder",
                inputField.getAttribute("placeholder") + placeholderText[index]
            );
            index++;
            setTimeout(typePlaceholder, 100); // Adjust speed here (lower is faster)
        } else {
            // Restart typing after a delay (optional)
            setTimeout(() => {
                index = 0;
                inputField.setAttribute("placeholder", "");
                typePlaceholder();
            }, 2000); // Wait for 3 seconds before restarting
        }
    }

    window.onload = typePlaceholder;
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{!! Toastr::message() !!}



@stack('scripts')
