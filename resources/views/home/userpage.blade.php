<!doctype html>
<html lang="en">
@include('home.head')
<body>
@include('sweetalert::alert')

<div class="hero_area">
    <!-- header section strats -->
    @include('home.navbar')
    <!-- end header section -->
    <!-- slider section -->
    @include('home.slide')
    <!-- end slider section -->
</div>
<!-- why section -->
@include('home.whysection')
<!-- end why section -->

<!-- arrival section -->
@include('home.arrival')
<!-- end arrival section -->

<!-- product section -->
@include('home.product')
<!-- end product section -->

<!-- subscribe section -->
@include('home.subscribe')
<!-- end subscribe section -->
<!-- client section -->
@include('home.client')
<!-- end client section -->
<!-- footer start -->
@include('home.footer')
<!-- footer end -->
@include('home.copyright')

@include('home.script')
</body>
</html>
