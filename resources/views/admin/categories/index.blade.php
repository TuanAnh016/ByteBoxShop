@extends('admin.layouts.app')

@section('header', 'Quản lý danh mục')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-lg font-medium">Danh sách danh mục</h3>
    <a href="{{ route('admin.categories.create') }}" class="bg-bb-primary text-bb-surface font-bold py-2 px-6 rounded-lg hover:bg-bb-primary-container transition-colors shadow-[0_0_15px_rgba(242,202,80,0.3)]">
        + Thêm mới
    </a>
</div>

<div class="glass-panel rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-bb-surface-highest border-b border-bb-outline-variant text-bb-on-surface-variant text-sm uppercase tracking-wider">
                <th class="p-4 font-medium">ID</th>
                <th class="p-4 font-medium">Ảnh</th>
                <th class="p-4 font-medium">Tên danh mục</th>
                <th class="p-4 font-medium">Slug</th>
                <th class="p-4 font-medium text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-bb-outline-variant">
            @forelse($categories as $category)
            <tr class="hover:bg-bb-surface-low transition-colors group">
                <td class="p-4 text-bb-on-surface-variant">{{ $category->id }}</td>
                <td class="p-4">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 rounded object-cover border border-bb-outline-variant">
                    @else
                        <div class="w-12 h-12 rounded bg-bb-surface-highest flex items-center justify-center border border-bb-outline-variant text-bb-on-surface-variant">
                            <i class="ph ph-image text-xl"></i>
                        </div>
                    @endif
                </td>
                <td class="p-4 font-medium">{{ $category->name }}</td>
                <td class="p-4 text-bb-on-surface-variant">{{ $category->slug }}</td>
                <td class="p-4 text-right space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-bb-surface-highest text-bb-primary hover:bg-bb-primary hover:text-bb-surface transition-colors" title="Sửa">
                        <i class="ph ph-pencil-simple text-lg"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
                <td colspan="5" class="p-8 text-center text-bb-on-surface-variant">
                    Chưa có danh mục nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($categories->hasPages())
    <div class="p-4 border-t border-bb-outline-variant">
        {{ $categories->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
