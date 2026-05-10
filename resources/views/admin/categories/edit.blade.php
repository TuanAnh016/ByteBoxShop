@extends('admin.layouts.app')

@section('header', 'Sửa Danh Mục')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categories.index') }}" class="text-bb-on-surface-variant hover:text-bb-primary flex items-center space-x-2 w-max transition-colors">
        <i class="ph ph-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>
</div>

<div class="glass-panel rounded-2xl p-8 max-w-2xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Tên danh mục <span class="text-red-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Mô tả</label>
            <textarea name="description" id="description" rows="4"
                class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Hình ảnh</label>
            
            @if($category->image)
            <div class="mb-4">
                <p class="text-xs text-bb-on-surface-variant mb-2">Ảnh hiện tại:</p>
                <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" class="h-32 rounded border border-bb-outline-variant object-cover">
            </div>
            @endif

            <input type="file" name="image" id="image" accept="image/*"
                class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-bb-surface-highest file:text-bb-primary hover:file:bg-bb-primary hover:file:text-bb-surface transition-all cursor-pointer">
            <p class="text-xs text-bb-on-surface-variant mt-2">Để trống nếu không muốn thay đổi ảnh.</p>
            @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4 border-t border-bb-outline-variant flex justify-end">
            <button type="submit" class="bg-bb-primary text-bb-surface font-bold py-3 px-8 rounded-lg hover:bg-bb-primary-container transition-colors shadow-[0_0_15px_rgba(242,202,80,0.3)]">
                Lưu cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
