@extends('layouts.client')

@section('content')
    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding">
            <div class="container">
                <div class="section-bg-color">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('cart.update') }}" method="post">
                                @csrf
                                <!-- Cart Table Area -->
                                <div class="cart-table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="pro-thumbnail">Thumbnail</th>
                                                <th class="pro-title">Product</th>
                                                <th class="pro-price">Price</th>
                                                <th class="pro-quantity">Quantity</th>
                                                <th class="pro-subtotal">Total</th>
                                                <th class="pro-remove">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $key => $item)
                                                <tr>
                                                    <td class="pro-thumbnail">
                                                        <a href="#">
                                                            <img class="img-fluid"
                                                                src="{{ Storage::url($item['hinh_anh']) }}"
                                                                alt="Product" /></a>
                                                        <input type="hidden" name="cart[{{ $key }}][hinh_anh]"
                                                            value="{{ $item['hinh_anh'] }}">
                                                    </td>
                                                    <td class="pro-title">
                                                        <a href="{{ route('product-detail', $key) }}"
                                                            class="tm-cart-productname">{{ $item['ten_san_pham'] }}</a>
                                                        <input type="hidden" name="cart[{{ $key }}][ten_san_pham]"
                                                            value="{{ $item['ten_san_pham'] }}">
                                                    </td>
                                                    <td class="pro-price">{{ number_format($item['gia'], 0, '', '.') }}đ
                                                    </td>
                                                    <input type="hidden" name="cart[{{ $key }}][gia]"
                                                        value="{{ $item['gia'] }}">

                                                    <td class="pro-quantity">
                                                        <div class="pro-qty">
                                                            <input type="text" value="{{ $item['so_luong'] }}"
                                                                data-price="{{ $item['gia'] }}" class="quantityInput" 
                                                                name="cart[{{ $key }}][so_luong]"/>
                                                        </div>
                                                    </td>
                                                    <td class="pro-subtotal">
                                                        <span
                                                            class="subtotal">{{ number_format($item['gia'] * $item['so_luong'], 0, '', '.') }}đ</span>
                                                    </td>
                                                    <td class="pro-remove"><a href="#"><i
                                                                class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Cart Update Option -->
                                <div class="cart-update-option d-block d-md-flex justify-content-between">
                                    <div class="apply-coupon-wrapper">
                                    </div>
                                    <div class="cart-update">
                                        <button type="submit" class="btn btn-sqr">Update Cart</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 ml-auto">
                            <!-- Cart Calculation Area -->
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h6>Cart Totals</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="sub-total" id="cartSubtotal">
                                                    {{ number_format($subTotal, 0, '', '.') }}đ</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping</td>
                                                <td class="shipping">{{ number_format($shipping, 0, '', '.') }}đ</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Total</td>
                                                <td class="total-amount">{{ number_format($total, 0, '', '.') }}đ</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <a href="{{ route('donhangs.create') }}" class="btn btn-sqr d-block">Proceed Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->
@endsection

@push('js')
  <script>
    $(document).ready(function() {
        // Add the increment and decrement buttons only once
        $('.pro-qty').each(function() {
            var $this = $(this);
            if ($this.find('.qtybtn').length === 0) {
                $this.prepend('<span class="dec qtybtn">-</span>');
                $this.append('<span class="inc qtybtn">+</span>');
            }
        });

        function updateTotals() {
            var subTotal = 0;
            $('.quantityInput').each(function() {
                var input = $(this);
                var price = parseFloat(input.data('price'));
                var quantity = parseFloat(input.val());
                subTotal += price * quantity;
            });

            // Get shipping cost 
            var shipping = parseFloat($('.shipping').text().replace(/\./g, '').replace(' đ', ''));
            var total = subTotal + shipping;

            // Update values
            $('.sub-total').text(subTotal.toLocaleString('vi-VN') + ' đ');
            $('.total-amount').text(total.toLocaleString('vi-VN') + ' đ');
        }

        $(document).on('click', '.qtybtn', function() {
            var $button = $(this);
            var $input = $button.siblings('input');
            var oldValue = parseFloat($input.val());
            var newVal;

            if ($button.hasClass('inc')) {
                newVal = oldValue + 1;
            } else {
                if (oldValue > 1) {
                    newVal = oldValue - 1;
                } else {
                    newVal = 1;
                }
            }

            $input.val(newVal);
            var price = parseFloat($input.data('price'));
            var subtotalElement = $input.closest('tr').find('.subtotal');
            var newSubtotal = newVal * price;

            subtotalElement.text(newSubtotal.toLocaleString('vi-VN') + ' đ');
            updateTotals();
        });

        $('.quantityInput').on('change', function() {
            var value = parseInt($(this).val(), 10);

            if (isNaN(value) || value < 1) {
                alert('Số lượng phải lớn hơn 1.');
                $(this).val(1);
            }
            updateTotals();
        });

        $('.pro-remove').on('click', function(event) {
            event.preventDefault();
            var $row = $(this).closest('tr');
            $row.remove(); // Remove row
            updateTotals(); // Update totals
        });

        updateTotals();
    });
</script>

@endpush
