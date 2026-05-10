@extends('layouts.app')

@section('content')
<section class="py-20 bg-bb-surface-low border-b ghost-border-bottom relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <h1 class="font-display font-bold text-4xl md:text-6xl text-bb-on-surface mb-8" data-aos="fade-up">Khám phá</h1>
        
        <form action="{{ route('search') }}" method="GET" class="relative max-w-2xl" data-aos="fade-up" data-aos-delay="100">
            <div class="relative">
                <input type="text" name="q" value="{{ $query }}" placeholder="Tìm kiếm kiệt tác công nghệ..." class="w-full bg-bb-surface-highest border-b ghost-border-bottom text-bb-on-surface font-body text-lg px-0 py-4 pl-12 focus:outline-none focus:border-bb-primary transition-colors bg-transparent placeholder-bb-on-surface-variant">
                <i class="ph ph-magnifying-glass absolute left-0 top-1/2 -translate-y-1/2 text-2xl text-bb-on-surface-variant"></i>
            </div>
            <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 font-body text-sm font-bold uppercase tracking-widest text-bb-primary hover:text-bb-primary-container transition-colors">Tìm</button>
        </form>
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">
        @if($query)
            <div class="font-body text-bb-on-surface-variant mb-12">
                Tìm thấy <span class="text-bb-primary">{{ $products->total() }}</span> kết quả cho "<span class="text-bb-on-surface">{{ $query }}</span>"
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                <!-- Same product card as category.show -->
                <div class="group bg-bb-surface rounded-xl p-6 ghost-border h-full flex flex-col transition-all hover:bg-bb-surface-high hover:-translate-y-2">
                    <a href="{{ route('product.show', $product->slug) }}" class="block relative aspect-square mb-6 overflow-hidden rounded-lg bg-bb-surface-lowest">
                        <img src="{{ $product->getFirstMediaUrl('images') ?: ($product->image ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop') }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-lighten group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="flex-grow flex flex-col justify-between">
                        <div>
                            <a href="{{ route('product.show', $product->slug) }}" class="font-display font-bold text-lg text-bb-on-surface mb-4 block group-hover:text-bb-primary transition-colors line-clamp-3 min-h-[4.5rem]">{{ $product->name }}</a>
                        </div>
                        <div class="flex items-end justify-between mt-6 pt-6 ghost-border-bottom border-t">
                            <div class="font-body text-base text-bb-primary font-bold">${{ number_format($product->getCurrentPrice(), 2) }}</div>
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
                    <i class="ph ph-magnifying-glass text-6xl text-bb-on-surface-variant mb-4"></i>
                    <p class="font-body text-bb-on-surface-variant">Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-16 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-32">
                <p class="font-body text-bb-on-surface-variant text-lg">Nhập từ khóa để bắt đầu khám phá.</p>
            </div>
        @endif
    </div>
</section>
@endsection
