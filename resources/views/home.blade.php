@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
    <!-- Asymmetric background elements -->
    <div class="absolute top-0 right-0 w-[40vw] h-[80vh] bg-bb-surface-low rounded-bl-[120px] -z-10 rellax" data-rellax-speed="-1"></div>
    <div class="absolute bottom-20 left-10 w-64 h-64 bg-bb-primary-container rounded-full blur-[100px] opacity-20"></div>

    <div class="max-w-7xl mx-auto px-6 w-full flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="w-full md:w-1/2 z-10" data-aos="fade-up">
            <div class="font-body uppercase tracking-[0.2em] text-bb-primary text-sm mb-6 flex items-center">
                <span class="w-8 h-[1px] bg-bb-primary mr-4"></span> Kỷ nguyên mới
            </div>
            <h1 class="font-display font-bold text-5xl md:text-7xl leading-[1.1] mb-8 text-bb-on-surface">
                Nghệ thuật<br>
                <span class="text-bb-on-surface-variant italic font-light">Công nghệ.</span>
            </h1>
            <p class="font-body text-bb-on-surface-variant text-lg max-w-md mb-10 leading-relaxed">
                Khám phá bộ sưu tập các tuyệt tác công nghệ được tuyển chọn tỉ mỉ, kết hợp giữa hiệu năng đỉnh cao và thiết kế nghệ thuật.
            </p>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center space-x-4 gold-lustre px-8 py-4 rounded-md font-body font-bold text-sm tracking-widest uppercase hover:scale-105 transition-transform group">
                <span>Khám phá ngay</span>
                <i class="ph ph-arrow-right group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
        
        <div class="w-full md:w-1/2 relative z-10" data-aos="fade-left" data-aos-delay="200">
            <!-- GSAP Animated elements in script below -->
            <div class="relative w-full aspect-square hero-image-container">
                <img src="https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?q=80&w=1000&auto=format&fit=crop" alt="Premium Tech" class="w-full h-full object-cover rounded-2xl ambient-shadow hero-img">
                
                <!-- Floating Spec Card -->
                <div class="absolute -bottom-8 -left-8 bg-bb-surface-highest/80 backdrop-blur-md p-6 rounded-xl ghost-border hero-card">
                    <div class="font-display text-2xl font-bold text-bb-on-surface mb-1">Aura Master</div>
                    <div class="font-body text-xs tracking-widest uppercase text-bb-primary">Limited Edition</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-32 relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20" data-aos="fade-up">
            <div>
                <h2 class="font-display font-bold text-4xl md:text-5xl text-bb-on-surface">Bộ sưu tập</h2>
                <div class="h-1 w-20 bg-bb-primary mt-6"></div>
            </div>
            <a href="{{ route('categories.index') }}" class="group flex items-center space-x-2 font-body text-sm tracking-widest text-bb-on-surface-variant hover:text-bb-primary transition-colors mt-8 md:mt-0 uppercase">
                <span>Xem tất cả</span>
                <i class="ph ph-arrow-right group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($categories->take(3) as $index => $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="group block relative overflow-hidden rounded-xl aspect-[4/5] bg-bb-surface-low" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <img src="{{ $category->getFirstMediaUrl('images') ?: 'https://images.unsplash.com/photo-1546435770-a3e426fa99f5?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 group-hover:scale-110 transition-all duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-bb-surface via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8 w-full">
                    <h3 class="font-display text-2xl font-bold text-bb-on-surface mb-2 group-hover:-translate-y-2 transition-transform duration-500">{{ $category->name }}</h3>
                    <p class="font-body text-sm text-bb-primary opacity-0 group-hover:opacity-100 group-hover:-translate-y-2 transition-all duration-500 delay-100">{{ $category->products_count }} Sản phẩm</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Slider -->
<section class="py-32 bg-bb-surface-low relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <h2 class="font-display font-bold text-4xl md:text-5xl text-bb-on-surface mb-16 text-center" data-aos="fade-up">Kiệt tác nổi bật</h2>
        
        <div class="swiper featuredSwiper !pb-16" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                @foreach($featured as $product)
                <div class="swiper-slide">
                    <div class="group bg-bb-surface rounded-xl p-6 ghost-border h-full flex flex-col transition-all hover:bg-bb-surface-high hover:-translate-y-2">
                        <a href="{{ route('product.show', $product->slug) }}" class="block relative aspect-square mb-6 overflow-hidden rounded-lg bg-bb-surface-lowest">
                            <img src="{{ $product->getFirstMediaUrl('images') ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $product->name }}" class="w-full h-full object-cover mix-blend-lighten group-hover:scale-105 transition-transform duration-500">
                            @if($product->sale_price)
                                <div class="absolute top-4 left-4 bg-bb-primary text-bb-surface text-xs font-bold font-body px-3 py-1 rounded-sm uppercase tracking-wider">Sale</div>
                            @endif
                        </a>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <a href="{{ route('categories.show', $product->category->slug) }}" class="text-xs font-body text-bb-on-surface-variant uppercase tracking-widest mb-2 block hover:text-bb-primary">{{ $product->category->name }}</a>
                                <a href="{{ route('product.show', $product->slug) }}" class="font-display font-bold text-xl text-bb-on-surface mb-4 block group-hover:text-bb-primary transition-colors line-clamp-3 min-h-[5rem]">{{ $product->name }}</a>
                            </div>
                            <div class="flex items-end justify-between mt-6 pt-6 ghost-border-bottom border-t">
                                <div>
                                    @if($product->sale_price)
                                        <div class="text-sm text-bb-on-surface-variant line-through mb-1">${{ number_format($product->price, 2) }}</div>
                                        <div class="font-body text-lg text-bb-primary font-bold">${{ number_format($product->sale_price, 2) }}</div>
                                    @else
                                        <div class="font-body text-lg text-bb-on-surface font-bold">${{ number_format($product->price, 2) }}</div>
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
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Anime.js text reveal for hero
    anime.timeline({loop: false})
        .add({
            targets: '.hero-card',
            translateY: [50, 0],
            opacity: [0, 1],
            easing: "easeOutExpo",
            duration: 1500,
            delay: 1000
        });

    // GSAP parallax for hero image
    gsap.to(".hero-img", {
        yPercent: 15,
        ease: "none",
        scrollTrigger: {
            trigger: ".hero-image-container",
            start: "top bottom", 
            end: "bottom top",
            scrub: true
        } 
    });

    // Swiper initialization
    new Swiper(".featuredSwiper", {
        slidesPerView: 1,
        spaceBetween: 24,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 4 },
        },
    });
</script>
<style>
    /* Custom Swiper Pagination for Dark Atelier */
    .swiper-pagination-bullet {
        background: var(--on-surface-variant);
        opacity: 0.5;
        transition: all 0.3s;
    }
    .swiper-pagination-bullet-active {
        background: var(--primary);
        opacity: 1;
        width: 24px;
        border-radius: 4px;
    }
</style>
@endpush
