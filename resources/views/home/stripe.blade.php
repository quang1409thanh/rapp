<!DOCTYPE html>
<html>
<head>
    @include('home.head')
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/payment.css')}}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
@include('home.navbar')
<!-- header section strats -->
<header
    style="text-align: center;padding-top: 20PX; padding-bottom: 20PX; font-size: 40px; background-color: rgba(253,23,103,0.24) ">
    Trang Thanh Toán Bằng Thẻ
</header>
<div class="snippet-body">
    <div class="container" style="width: 50%;">
        <div class="row">
            <div class="col-lg-4 mb-lg-0 mb-3">
                <div class="card p-3">
                    <div class="img-box">
                        <img src="https://www.freepnglogos.com/uploads/visa-logo-download-png-21.png" alt=""/>
                    </div>
                    <div class="number">
                        <label class="fw-bold" for="">**** **** **** 1060</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small><span class="fw-bold">Expiry date:</span><span>10/16</span></small>
                        <small><span class="fw-bold">Name:</span><span>Kumar</span></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-lg-0 mb-3">
                <div class="card p-3">
                    <div class="img-box">
                        <img
                            src="https://www.freepnglogos.com/uploads/mastercard-png/file-mastercard-logo-svg-wikimedia-commons-4.png"
                            alt=""/>
                    </div>
                    <div class="number">
                        <label class="fw-bold">**** **** **** 1060</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small><span class="fw-bold">Expiry date:</span><span>10/16</span></small>
                        <small><span class="fw-bold">Name:</span><span>Kumar</span></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-lg-0 mb-3">
                <div class="card p-3">
                    <div class="img-box">
                        <img
                            src="https://www.freepnglogos.com/uploads/discover-png-logo/credit-cards-discover-png-logo-4.png"
                            alt=""/>
                    </div>
                    <div class="number">
                        <label class="fw-bold">**** **** **** 1060</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small><span class="fw-bold">Expiry date:</span><span>10/16</span></small>
                        <small><span class="fw-bold">Name:</span><span>Kumar</span></small>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="card p-3">
                    <p class="mb-0 fw-bold h4">Payment Methods</p>
                </div>
            </div>

            <div class="col-12">
                <div class="card p-3">
                    <div class="card-body border p-0">
                        <p>
                            <a class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-between "
                               data-bs-toggle="collapse"
                               href="#collapseExample"
                               role="button"
                               aria-expanded="false"
                               aria-controls="collapseExample">
                                <span class="fw-bold">PayPal</span>
                            </a>
                        </p>
                        <div class="collapse p-3 pt-0" id="collapseExample">
                            <div class="row">
                                <div class="col-8">
                                    <p class="h4 mb-0">Summary</p>
                                    <p class="mb-0">
                                        <span class="fw-bold">Product:</span>
                                        <span class="c-green">: Name of product</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="fw-bold">Price:</span>
                                        <span class="c-green">:${{$totalprice}}</span>
                                    </p>
                                    <p class="mb-0">
                                        Cảm ơn rất nhiều. Và không có gì và không ai bị đẩy lùi, tôi sẽ ra lệnh?
                                        Người ta nói tâm có tham, dễ được người cho, chính người này ở đây, không ai cả!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border p-0">
                        <p><a class="btn btn-primary p-2 w-100 h-100 d-flex align-items-center justify-content-between"
                              data-bs-toggle="collapse"
                              href="#collapseExample"
                              role="button"
                              aria-expanded="true"
                              aria-controls="collapseExample">
                                <span class="fw-bold">Credit Card</span>
                            </a>
                        </p>
                        <div class="collapse show p-3 pt-0" id="collapseExample">
                            <div class="row">
                                <div class="col-lg-5 mb-lg-0 mb-3">
                                    <p class="h4 mb-0">Summary</p>
                                    <p class="mb-0"><span class="fw-bold">Product:</span>
                                        <span class="c-green">: Name of product</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="fw-bold">Price:</span>
                                        <span class="c-green">:${{$totalprice}}</span>
                                    </p>
                                    <p class="mb-0">
                                        Cảm ơn rất nhiều. Và không có gì và không ai bị đẩy lùi, tôi sẽ ra lệnh?
                                        Người ta nói tâm có tham, dễ được người cho, chính người này ở đây, không ai cả!
                                    </p>
                                </div>
                                <div class="col-lg-7">
                                    <form
                                        role="form"
                                        action="{{ route('stripe.post', $totalprice)}}"
                                        method="post"
                                        class="require-validation"
                                        data-cc-on-file="false"
                                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                        id="payment-form">
                                        @csrf
                                        <div class="row" style="padding-top: 20px">
                                            <div class="col-12">
                                                @if (Session::has('success'))
                                                    <div class="alert alert-success text-center"
                                                         style="padding-left: 20px; padding-right: 20px">
                                                        <a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">×</a>
                                                        <p>{{ Session::get('success') }}</p>
                                                    </div>
                                                @endif
                                                @if(session('error'))
                                                    <div class="alert alert-danger text-center"
                                                         style="padding-left: 20px; padding-right: 20px">
                                                        <a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">×</a>
                                                        <p>{{ Session::get('error') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <div class="form__div required">
                                                    <input type="text" class="form-control card-number card-number"
                                                           placeholder=" "/>
                                                    <label for="" class="form__label">Card Number</label>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form__div required">
                                                    <input type="text" class="form-control card-expiry-month"
                                                           placeholder=" "/>
                                                    <label for="" class="form__label">MM</label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form__div required">
                                                    <input type="text" class="form-control card-expiry-year"
                                                           placeholder=" "/>
                                                    <label for="" class="form__label">YY</label>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form__div required">
                                                    <input type="password" class="form-control card-cvc"
                                                           placeholder=" "/>
                                                    <label for="" class="form__label">cvv </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form__div">
                                                    <input type="text" class="form-control required" placeholder=" "/>
                                                    <label for="" class="form__label">name on the card</label>
                                                </div>
                                            </div>
                                            <div class='col-12'>
                                                <div class='error hide'>

                                                    <div class='alert-danger alert'>Please correct the errors and try
                                                        again.
                                                    </div>
                                                </div>
                                            </div>
                                            <style>
                                                .hide {
                                                    display: none;
                                                }
                                            </style>
                                            <div class="col-12">
                                                <input type="submit" name="" value="Pay Now">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="btn btn-primary payment">Make Payment</div>
            </div>
        </div>
    </div>
    <script
        type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js">
    </script>
</div>
@include('home.footer')
@include('home.copyright')
</body>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@include('home.script')
<script type="text/javascript">
    $(function () {
        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function (e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
    // more
    var myLink = document.querySelector('a[href="#"]');
    myLink.addEventListener("click", function (e) {
        e.preventDefault();
    });
</script>
</html>
