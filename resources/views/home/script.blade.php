<!--script-->
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        var keyword = "product_search";
        var scrollpos = localStorage.getItem('scrollpos');
        var savedUrl = localStorage.getItem('savedUrl');
        if (scrollpos && (savedUrl === window.location.href || window.location.href.includes("search"))) {
            window.scrollTo(0, scrollpos);
        }
    });

    window.onbeforeunload = function (e) {
        localStorage.setItem('scrollpos', window.scrollY);
        localStorage.setItem('savedUrl', window.location.href);
    };
</script>
<!-- jQery -->
<script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
<!-- popper js -->
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('home/js/bootstrap.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('home/js/custom.js') }}"></script>
