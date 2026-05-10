@extends('layouts.app')

@section('content')
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="font-display font-bold text-4xl md:text-5xl text-bb-on-surface mb-16" data-aos="fade-up">Giỏ hàng</h1>

        @if(empty($cart))
            <div class="text-center py-20 bg-bb-surface-low rounded-2xl ghost-border" data-aos="fade-up" data-aos-delay="100">
                <i class="ph ph-shopping-cart-simple text-6xl text-bb-on-surface-variant mb-6 block"></i>
                <h2 class="font-display text-2xl font-bold text-bb-on-surface mb-4">Giỏ hàng của bạn đang trống</h2>
                <p class="font-body text-bb-on-surface-variant mb-8">Hãy khám phá các kiệt tác công nghệ của chúng tôi.</p>
                <a href="{{ route('categories.index') }}" class="inline-block gold-lustre px-8 py-4 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-105 transition-transform">
                    Bắt đầu mua sắm
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-12" data-aos="fade-up" data-aos-delay="100">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-bb-surface-low rounded-2xl ghost-border overflow-hidden">
                        <!-- Header -->
                        <div class="hidden md:grid grid-cols-12 gap-4 p-6 border-b ghost-border-bottom font-body text-xs uppercase tracking-widest text-bb-on-surface-variant">
                            <div class="col-span-6">Sản phẩm</div>
                            <div class="col-span-2 text-center">Giá</div>
                            <div class="col-span-2 text-center">Số lượng</div>
                            <div class="col-span-2 text-right">Tổng</div>
                        </div>

                        <!-- Items -->
                        <div class="divide-y ghost-border-bottom">
                            @foreach($cart as $id => $item)
                            <div class="p-6 flex flex-col md:grid md:grid-cols-12 gap-4 items-center" id="cart-item-{{ $id }}">
                                <!-- Product Info -->
                                <div class="col-span-6 flex items-center space-x-6 w-full">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="event.preventDefault(); removeCartItem(this, {{ $id }});">
                                        @csrf
                                        <button type="submit" class="text-bb-on-surface-variant hover:text-bb-error transition-colors">
                                            <i class="ph ph-x text-lg"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('product.show', $item['slug']) }}" class="w-20 h-20 bg-bb-surface-highest rounded-md flex-shrink-0 flex items-center justify-center p-2">
                                        <img src="{{ $item['image'] ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=200&auto=format&fit=crop' }}" alt="{{ $item['name'] }}" class="max-w-full max-h-full object-contain mix-blend-lighten">
                                    </a>
                                    <a href="{{ route('product.show', $item['slug']) }}" class="font-display font-bold text-bb-on-surface hover:text-bb-primary transition-colors line-clamp-2">
                                        {{ $item['name'] }}
                                    </a>
                                </div>

                                <!-- Price -->
                                <div class="col-span-2 text-center w-full md:w-auto flex justify-between md:block mt-4 md:mt-0">
                                    <span class="md:hidden font-body text-xs uppercase tracking-widest text-bb-on-surface-variant">Giá</span>
                                    <span class="font-body text-bb-on-surface-variant">${{ number_format($item['price'], 2) }}</span>
                                </div>

                                <!-- Quantity -->
                                <div class="col-span-2 flex justify-center w-full md:w-auto mt-4 md:mt-0">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border ghost-border rounded-md">
                                        @csrf
                                        <button type="button" onclick="updateCart(this.closest('form'), {{ $id }}, Math.max(1, parseInt(this.nextElementSibling.value)-1))" class="px-3 py-1 text-bb-on-surface-variant hover:text-bb-primary transition-colors">-</button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-10 text-center bg-transparent text-bb-on-surface font-body text-sm outline-none pointer-events-none">
                                        <button type="button" onclick="updateCart(this.closest('form'), {{ $id }}, parseInt(this.previousElementSibling.value)+1)" class="px-3 py-1 text-bb-on-surface-variant hover:text-bb-primary transition-colors">+</button>
                                    </form>
                                </div>

                                <!-- Total -->
                                <div class="col-span-2 text-right w-full md:w-auto flex justify-between md:block mt-4 md:mt-0">
                                    <span class="md:hidden font-body text-xs uppercase tracking-widest text-bb-on-surface-variant">Tổng</span>
                                    <span class="font-body font-bold text-bb-primary" id="item-total-{{ $id }}">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between items-center">
                        <a href="{{ route('categories.index') }}" class="font-body text-sm text-bb-on-surface-variant hover:text-bb-primary transition-colors flex items-center space-x-2">
                            <i class="ph ph-arrow-left"></i>
                            <span>Tiếp tục mua sắm</span>
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="event.preventDefault(); clearCart(this);">
                            @csrf
                            <button type="submit" class="font-body text-sm text-bb-on-surface-variant hover:text-bb-error transition-colors uppercase tracking-widest">
                                Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-bb-surface-low rounded-2xl p-8 ghost-border sticky top-32">
                        <h2 class="font-display text-2xl font-bold text-bb-on-surface mb-8">Tổng quan</h2>
                        
                        <div class="space-y-4 mb-8 font-body">
                            <div class="flex justify-between text-bb-on-surface-variant">
                                <span>Tạm tính</span>
                                <span class="cart-total-value">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-bb-on-surface-variant">
                                <span>Giao hàng</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="border-t ghost-border-bottom pt-4 flex justify-between text-lg font-bold">
                                <span class="text-bb-on-surface">Tổng cộng</span>
                                <span class="text-bb-primary cart-total-value">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block text-center gold-lustre w-full px-8 py-4 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-[1.02] transition-transform">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    function formatCurrency(value) {
        return '$' + new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(value);
    }

    function updateCart(form, id, newQty) {
        if (newQty < 1) return;
        form.querySelector('input[name=quantity]').value = newQty;
        
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById('item-total-' + id).innerText = formatCurrency(data.itemTotal);
                document.querySelectorAll('.cart-total-value').forEach(el => {
                    el.innerText = formatCurrency(data.cartTotal);
                });
            }
        });
    }

    function removeCartItem(form, id) {
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                if(data.isEmpty) {
                    location.reload();
                } else {
                    document.getElementById('cart-item-' + id).remove();
                    document.querySelectorAll('.cart-total-value').forEach(el => {
                        el.innerText = formatCurrency(data.cartTotal);
                    });
                }
            }
        });
    }
    
    function clearCart(form) {
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
</script>
@endpush
