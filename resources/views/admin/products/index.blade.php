@extends('admin.layouts.app')

@section('header', 'Quản lý vật phẩm')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-lg font-medium">Danh sách vật phẩm</h3>
    <a href="{{ route('admin.products.create') }}" class="bg-bb-primary text-bb-surface font-bold py-2 px-6 rounded-lg hover:bg-bb-primary-container transition-colors shadow-[0_0_15px_rgba(242,202,80,0.3)]">
        + Thêm mới
    </a>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-bb-surface-highest border-b border-bb-outline-variant text-bb-on-surface-variant text-sm uppercase tracking-wider">
                    <th class="p-4 font-medium">ID</th>
                    <th class="p-4 font-medium">Ảnh</th>
                    <th class="p-4 font-medium">Tên vật phẩm</th>
                    <th class="p-4 font-medium">Danh mục</th>
                    <th class="p-4 font-medium">Giá</th>
                    <th class="p-4 font-medium">Kho</th>
                    <th class="p-4 font-medium text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-bb-outline-variant">
                @forelse($products as $product)
                <tr class="hover:bg-bb-surface-low transition-colors group">
                    <td class="p-4 text-bb-on-surface-variant">{{ $product->id }}</td>
                    <td class="p-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover border border-bb-outline-variant">
                        @else
                            <div class="w-12 h-12 rounded bg-bb-surface-highest flex items-center justify-center border border-bb-outline-variant text-bb-on-surface-variant">
                                <i class="ph ph-image text-xl"></i>
                            </div>
                        @endif
                    </td>
                    <td class="p-4 font-medium max-w-[200px] truncate" title="{{ $product->name }}">{{ $product->name }}</td>
                    <td class="p-4 text-bb-on-surface-variant">{{ $product->category->name ?? 'N/A' }}</td>
                    <td class="p-4">
                        <div class="text-bb-primary font-bold">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                        @if($product->sale_price)
                            <div class="text-xs text-bb-on-surface-variant line-through">{{ number_format($product->sale_price, 0, ',', '.') }}đ</div>
                        @endif
                    </td>
                    <td class="p-4 text-bb-on-surface-variant">{{ $product->quantity }}</td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-bb-surface-highest text-bb-primary hover:bg-bb-primary hover:text-bb-surface transition-colors" title="Sửa">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vật phẩm này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-bb-surface-highest text-red-400 hover:bg-red-500 hover:text-white transition-colors" title="Xóa">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-bb-on-surface-variant">
                        Chưa có vật phẩm nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="p-4 border-t border-bb-outline-variant">
        {{ $products->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
