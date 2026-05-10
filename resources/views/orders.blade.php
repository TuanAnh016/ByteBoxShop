@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-10">
    <div class="mb-12" data-aos="fade-up">
        <h1 class="font-display font-bold text-4xl mb-4 text-bb-on-surface">Đơn Hàng Của Tôi</h1>
        <p class="font-body text-bb-on-surface-variant">Theo dõi hành trình và trạng thái các kiệt tác công nghệ bạn đã sở hữu.</p>
    </div>

    <div class="space-y-8">
        @forelse($orders as $index => $order)
            <div class="bg-bb-surface-high border border-bb-outline-variant p-6 rounded-lg ambient-shadow" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 pb-4 border-b border-bb-outline-variant">
                    <div>
                        <p class="text-xs text-bb-on-surface-variant uppercase tracking-widest mb-1">Mã đơn hàng</p>
                        <p class="font-display font-bold text-lg text-bb-primary">#ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-left md:text-right">
                        <p class="text-xs text-bb-on-surface-variant uppercase tracking-widest mb-1">Ngày đặt</p>
                        <p class="font-body text-bb-on-surface">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-left md:text-right">
                        <p class="text-xs text-bb-on-surface-variant uppercase tracking-widest mb-1">Trạng thái</p>
                        <span class="inline-block px-3 py-1 bg-bb-surface-highest text-bb-primary text-xs font-bold uppercase tracking-widest rounded-sm border border-bb-outline-variant">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($order->details as $detail)
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-bb-surface overflow-hidden rounded-sm mr-4 flex-shrink-0">
                                @if($detail->product)
                                    <img src="{{ $detail->product->getFirstMediaUrl('images') ?: $detail->product->image }}" alt="{{ $detail->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-bb-surface-highest flex items-center justify-center">
                                        <i class="ph ph-image text-bb-on-surface-variant"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-display font-bold text-bb-on-surface">{{ $detail->product ? $detail->product->name : 'Sản phẩm không còn tồn tại' }}</h4>
                                <p class="text-sm font-body text-bb-on-surface-variant">Số lượng: {{ $detail->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-body font-bold text-bb-primary">${{ number_format($detail->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-bb-outline-variant flex justify-between items-center">
                    <span class="font-body uppercase tracking-widest text-xs text-bb-on-surface-variant">Tổng cộng</span>
                    <span class="font-display font-bold text-2xl text-bb-primary">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-bb-surface-high border border-bb-outline-variant rounded-lg" data-aos="fade-up">
                <i class="ph ph-package text-6xl text-bb-on-surface-variant mb-4"></i>
                <h3 class="font-display font-bold text-2xl mb-2 text-bb-on-surface">Chưa có đơn hàng nào</h3>
                <p class="text-bb-on-surface-variant mb-6 font-body">Bạn chưa sở hữu bất kỳ siêu phẩm nào từ ByteBox.</p>
                <a href="{{ route('explore') }}" class="inline-block px-8 py-4 bg-bb-primary text-bb-surface font-bold uppercase tracking-widest text-sm hover:bg-bb-primary-container transition-colors">
                    Khám phá ngay
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
