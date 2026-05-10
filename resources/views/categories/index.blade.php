@extends('layouts.app')

@section('content')
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="font-display font-bold text-5xl md:text-6xl text-bb-on-surface mb-8" data-aos="fade-up">Tất cả danh mục</h1>
        <div class="h-1 w-24 bg-bb-primary mb-16" data-aos="fade-right" data-aos-delay="200"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($categories as $index => $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="group block relative overflow-hidden rounded-2xl aspect-square bg-bb-surface-low" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <img src="{{ $category->getFirstMediaUrl('images') ?: 'https://images.unsplash.com/photo-1546435770-a3e426fa99f5?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-30 group-hover:scale-105 transition-all duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-bb-surface via-bb-surface/50 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="absolute inset-0 p-10 flex flex-col justify-end">
                    <div class="transform group-hover:-translate-y-4 transition-transform duration-500">
                        <h2 class="font-display text-3xl font-bold text-bb-on-surface mb-4">{{ $category->name }}</h2>
                        <div class="font-body text-sm text-bb-primary uppercase tracking-widest">{{ $category->products_count }} Sản phẩm</div>
                    </div>
                    <div class="absolute bottom-10 right-10 opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-500 text-bb-primary">
                        <i class="ph ph-arrow-right text-3xl"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
