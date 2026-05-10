@extends('layouts.app')

@section('content')
<section class="py-12 md:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Breadcrumb -->
        <div class="font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-12 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-bb-primary transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-bb-primary transition-colors">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-bb-on-surface line-clamp-1">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            <!-- Product Image -->
            <div class="relative bg-bb-surface-low rounded-2xl aspect-square flex items-center justify-center p-8 ambient-shadow" data-aos="fade-right">
                <img src="{{ $product->getFirstMediaUrl('images') ?: ($product->image ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=1000&auto=format&fit=crop') }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain mix-blend-lighten">
                
                @if($product->sale_price)
                <div class="absolute top-8 left-8 bg-bb-primary text-bb-surface text-sm font-bold font-body px-4 py-2 rounded-sm uppercase tracking-wider">Sale</div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-center" data-aos="fade-left">
                <h1 class="font-display font-bold text-4xl md:text-5xl text-bb-on-surface mb-6 leading-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center space-x-6 mb-8">
                    @if($product->sale_price)
                        <div class="font-body text-3xl text-bb-primary font-bold">${{ number_format($product->sale_price, 2) }}</div>
                        <div class="text-xl text-bb-on-surface-variant line-through">${{ number_format($product->price, 2) }}</div>
                    @else
                        <div class="font-body text-3xl text-bb-on-surface font-bold">${{ number_format($product->price, 2) }}</div>
                    @endif
                </div>

                <p class="font-body text-bb-on-surface-variant leading-relaxed mb-10">{{ $product->description }}</p>

                <form action="{{ route('cart.add') }}" method="POST" class="mb-12">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="flex items-center space-x-6 mb-8">
                        <div class="font-body text-sm text-bb-on-surface-variant uppercase tracking-widest">Số lượng</div>
                        <div class="flex items-center border ghost-border rounded-md">
                            <button type="button" onclick="const input=document.getElementById('qty'); input.value=Math.max(1, parseInt(input.value)-1);" class="px-4 py-2 text-bb-on-surface-variant hover:text-bb-primary transition-colors">-</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" class="w-12 text-center bg-transparent text-bb-on-surface font-body outline-none pointer-events-none">
                            <button type="button" onclick="const input=document.getElementById('qty'); input.value=parseInt(input.value)+1;" class="px-4 py-2 text-bb-on-surface-variant hover:text-bb-primary transition-colors">+</button>
                        </div>
                    </div>

                    <button type="submit" class="w-full md:w-auto gold-lustre px-12 py-5 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-[1.02] transition-transform flex items-center justify-center space-x-3">
                        <i class="ph ph-shopping-cart text-lg"></i>
                        <span>Thêm vào giỏ hàng</span>
                    </button>
                </form>

                <div class="border-t ghost-border-bottom pt-8 grid grid-cols-2 gap-6">
                    <div class="flex items-center space-x-3 text-bb-on-surface-variant font-body text-sm">
                        <i class="ph ph-shield-check text-2xl text-bb-primary"></i>
                        <span>Bảo hành chính hãng 12 tháng</span>
                    </div>
                    <div class="flex items-center space-x-3 text-bb-on-surface-variant font-body text-sm">
                        <i class="ph ph-truck text-2xl text-bb-primary"></i>
                        <span>Giao hàng miễn phí toàn quốc</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detail Tabs (Minimalist) -->
        <div class="mt-32" data-aos="fade-up">
            <div class="border-b ghost-border-bottom flex space-x-12 mb-12">
                <button class="font-body text-sm uppercase tracking-widest text-bb-primary font-bold pb-4 border-b-2 border-bb-primary">Chi tiết sản phẩm</button>
            </div>
            <div class="font-body text-bb-on-surface-variant leading-loose max-w-4xl">
                {!! $product->detail ?: 'Thông tin chi tiết đang được cập nhật...' !!}
            </div>
        </div>
    </div>
</section>
@endsection
