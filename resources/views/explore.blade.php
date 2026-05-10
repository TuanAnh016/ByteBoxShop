@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-10">
    <div class="mb-16" data-aos="fade-up">
        <h1 class="font-display font-bold text-4xl mb-4 text-bb-primary">Khám Phá</h1>
        <p class="font-body text-bb-on-surface-variant">Khám phá các bộ sưu tập mới nhất và ưu đãi đặc quyền từ ByteBox Atelier.</p>
    </div>

    <!-- Ad Slider -->
    <div class="mb-20 rounded-2xl overflow-hidden ambient-shadow" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper explore-swiper w-full h-[400px]">
            <div class="swiper-wrapper">
                @foreach($featuredProducts as $product)
                <div class="swiper-slide relative">
                    <img src="{{ $product->getFirstMediaUrl('images') ?: $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 bg-gradient-to-t from-bb-surface via-transparent to-transparent"></div>
                    <div class="absolute bottom-10 left-10 max-w-lg">
                        <span class="px-3 py-1 bg-bb-primary text-bb-surface text-xs font-bold uppercase tracking-widest mb-4 inline-block">Nổi bật</span>
                        <h2 class="text-4xl font-display font-bold text-white mb-2">{{ $product->name }}</h2>
                        <p class="text-bb-on-surface-variant mb-6 line-clamp-2">{{ $product->description }}</p>
                        <a href="{{ route('product.show', $product->slug) }}" class="inline-block px-6 py-3 border border-bb-primary text-bb-primary font-body uppercase tracking-widest text-sm hover:bg-bb-primary hover:text-bb-surface transition-colors">
                            Khám phá ngay
                        </a>
                    </div>
                </div>
                @endforeach
                <!-- Custom Banner Slide -->
                <div class="swiper-slide relative">
                    <img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-bb-surface via-transparent to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                        <h2 class="text-5xl font-display font-bold text-bb-primary mb-4">Mùa Lễ Hội. Giảm Giá Bất Tận.</h2>
                        <p class="text-xl text-bb-on-surface-variant mb-8 max-w-2xl">Trang bị cho mình những kiệt tác công nghệ với mức giá không tưởng. Nhập mã HOLIDAY26 giảm thêm 15%.</p>
                    </div>
                </div>
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev !text-bb-primary"></div>
            <div class="swiper-button-next !text-bb-primary"></div>
        </div>
    </div>

    <!-- Sale Products -->
    <div class="mb-20">
        <div class="flex justify-between items-end mb-10 border-b border-bb-outline-variant pb-4" data-aos="fade-up">
            <h2 class="font-display font-bold text-3xl text-bb-on-surface">Khuyến Mãi Đặc Quyền</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($saleProducts as $index => $product)
                <a href="{{ route('product.show', $product->slug) }}" class="group block" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="relative aspect-square overflow-hidden bg-bb-surface-high mb-4">
                        <img src="{{ $product->getFirstMediaUrl('images') ?: $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#e74c3c] text-white text-xs font-bold uppercase tracking-widest px-2 py-1">Sale</span>
                        </div>
                    </div>
                    <h3 class="font-display font-bold text-lg text-bb-on-surface group-hover:text-bb-primary transition-colors mb-2 line-clamp-1">{{ $product->name }}</h3>
                    <div class="flex items-center space-x-3 font-body">
                        <span class="text-bb-primary font-bold">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-bb-on-surface-variant line-through text-sm">${{ number_format($product->price, 2) }}</span>
                    </div>
                </a>
            @empty
                <p class="text-bb-on-surface-variant">Đang cập nhật siêu phẩm khuyến mãi...</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.explore-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    });
</script>
@endpush
