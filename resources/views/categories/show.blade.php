@extends('layouts.app')

@section('content')
<section class="py-20 bg-bb-surface-low border-b ghost-border-bottom">
    <div class="max-w-7xl mx-auto px-6">
        <div class="font-body text-xs uppercase tracking-widest text-bb-on-surface-variant mb-4" data-aos="fade-up">Danh mục</div>
        <h1 class="font-display font-bold text-4xl md:text-6xl text-bb-on-surface mb-6" data-aos="fade-up" data-aos-delay="100">{{ $category->name }}</h1>
        @if($category->description)
            <p class="font-body text-bb-on-surface-variant max-w-2xl" data-aos="fade-up" data-aos-delay="200">{{ $category->description }}</p>
        @endif
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div class="font-body text-sm text-bb-on-surface-variant mb-4 md:mb-0">{{ $products->total() }} sản phẩm</div>
            
            <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="flex items-center space-x-4">
                <label for="sort" class="font-body text-sm text-bb-on-surface-variant">Sắp xếp:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="bg-bb-surface border ghost-border text-bb-on-surface font-body text-sm rounded-md px-4 py-2 focus:outline-none focus:border-bb-primary focus:ring-1 focus:ring-bb-primary">
                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                    <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
            <div class="group bg-bb-surface rounded-xl p-6 ghost-border h-full flex flex-col transition-all hover:bg-bb-surface-high hover:-translate-y-2">
                <a href="{{ route('product.show', $product->slug) }}" class="block relative aspect-square mb-6 overflow-hidden rounded-lg bg-bb-surface-lowest">
                    <img src="{{ $product->getFirstMediaUrl('images') ?: ($product->image ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop') }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-lighten group-hover:scale-105 transition-transform duration-500">
                    @if($product->sale_price)
                        <div class="absolute top-4 left-4 bg-bb-primary text-bb-surface text-xs font-bold font-body px-3 py-1 rounded-sm uppercase tracking-wider">Sale</div>
                    @endif
                </a>
                <div class="flex-grow flex flex-col justify-between">
                    <div>
                        <a href="{{ route('product.show', $product->slug) }}" class="font-display font-bold text-lg text-bb-on-surface mb-4 block group-hover:text-bb-primary transition-colors line-clamp-2">{{ $product->name }}</a>
                    </div>
                    <div class="flex items-end justify-between mt-6 pt-6 ghost-border-bottom border-t">
                        <div>
                            @if($product->sale_price)
                                <div class="text-xs text-bb-on-surface-variant line-through mb-1">${{ number_format($product->price, 2) }}</div>
                                <div class="font-body text-base text-bb-primary font-bold">${{ number_format($product->sale_price, 2) }}</div>
                            @else
                                <div class="font-body text-base text-bb-on-surface font-bold">${{ number_format($product->price, 2) }}</div>
                            @endif
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-10 h-10 rounded-full border border-bb-outline-variant flex items-center justify-center text-bb-on-surface hover:bg-bb-primary hover:text-bb-surface hover:border-bb-primary transition-all group-hover:scale-110">
                                <i class="ph ph-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <i class="ph ph-empty text-6xl text-bb-on-surface-variant mb-4"></i>
                <p class="font-body text-bb-on-surface-variant">Không có sản phẩm nào trong danh mục này.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-16 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection
