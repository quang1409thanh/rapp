<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <a href="#">
                        <img width="160" src="/images/hi.gif" alt="#"/>
                    </a>
                    <li class="nav-item active" style="padding-top: 3%">
                        <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown" style="padding-top: 3%">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="true"> <span class="nav-label">Pages <span
                                    class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="about.html">About</a></li>
                            <li><a href="testimonial.html">Testimonial</a></li>
                        </ul>
                    </li>
                    <li class="nav-item" style="padding-top: 3%">
                        <a class="nav-link" href="{{url('products')}}">Products</a>
                    </li>
                    <li class="nav-item" style="padding-top: 3%">
                        <a class="nav-link" href="blog_list.html">Blog</a>
                    </li>
                    <li class="nav-item" style="padding-top: 3%">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item" style="padding-top: 3%">
                        <a class="nav-link" href="{{ url('show_cart') }}">Cart
                            @if(isset($total_carts) && $total_carts != null)
                                <span id="cart-count"></span>
                                <script>
                                    var total_cart = 0;
                                    @if($total_carts > 0)
                                        total_cart = {{ $total_carts }};
                                    @endif
                                    document.getElementById('cart-count').textContent = total_cart;
                                </script>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item" style="padding-top: 3%">
                        <a class="nav-link" href="{{ url('show_order') }}">Order
                            @if(isset($total_orders) && $total_orders != null)
                                <span id="order-count"></span>
                                <script>
                                    var total_order = 0;
                                    @if($total_orders > 0)
                                        total_order = {{ $total_orders }};
                                    @endif
                                    document.getElementById('order-count').textContent = total_order;
                                </script>
                            @endif
                        </a>
                    </li>
                    <style>
                        #cart-count {
                            background-color: #ff0000;
                            color: #ffffff;
                            border-radius: 50%;
                            padding: 2px 5px;
                            font-size: 0.8em;
                            vertical-align: top;
                        }

                        #order-count {
                            background-color: #ff0000;
                            color: #ffffff;
                            border-radius: 50%;
                            padding: 2px 5px;
                            font-size: 0.8em;
                            vertical-align: top;
                        }
                    </style>
                    @if (Route::has('login'))
                        @auth
                            <li style="padding-top: 3%">
                                <x-app-layout>
                                </x-app-layout>
                            </li>
                        @else
                            <li class="nav-item" style="padding-top: 3%">
                                <a class="btn btn-primary" id="logincss" href="{{route('login')}}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item" style="padding-top: 3%">
                                    <a class="btn btn-success" id="logincss" href="{{route('register')}}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
