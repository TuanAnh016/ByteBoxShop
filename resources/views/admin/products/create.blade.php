@extends('admin.layouts.app')

@section('header', 'Thêm Vật Phẩm')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-bb-on-surface-variant hover:text-bb-primary flex items-center space-x-2 w-max transition-colors">
        <i class="ph ph-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Cột trái (Thông tin chính) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-panel rounded-2xl p-8">
                <h4 class="text-lg font-medium mb-6 border-b border-bb-outline-variant pb-2">Thông tin cơ bản</h4>
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Tên vật phẩm <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Giá bán <span class="text-red-400">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="1"
                                class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">
                            @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Giá khuyến mãi (tùy chọn)</label>
                            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" min="0" step="1"
                                class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">
                            @error('sale_price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Mô tả ngắn</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="detail" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Chi tiết sản phẩm (HTML hỗ trợ)</label>
                        <textarea name="detail" id="detail" rows="6"
                            class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">{{ old('detail') }}</textarea>
                        @error('detail') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột phải (Phân loại, ảnh, v.v) -->
        <div class="space-y-6">
            <div class="glass-panel rounded-2xl p-8">
                <h4 class="text-lg font-medium mb-6 border-b border-bb-outline-variant pb-2">Phân loại & Kho</h4>
                
                <div class="space-y-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Danh mục <span class="text-red-400">*</span></label>
                        <select name="category_id" id="category_id" required
                            class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-bb-on-surface-variant mb-2">Số lượng kho <span class="text-red-400">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" required min="0"
                            class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface focus:border-bb-primary focus:outline-none transition-colors">
                        @error('quantity') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-3 pt-2">
                        <input type="hidden" name="featured" value="0">
                        <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                            class="w-5 h-5 text-bb-primary bg-bb-surface-low border-bb-outline-variant rounded focus:ring-bb-primary focus:ring-2">
                        <label for="featured" class="text-sm font-medium text-bb-on-surface">Vật phẩm nổi bật</label>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-2xl p-8">
                <h4 class="text-lg font-medium mb-6 border-b border-bb-outline-variant pb-2">Hình ảnh</h4>
                
                <div>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full bg-bb-surface-low border border-bb-outline-variant rounded-lg px-4 py-3 text-bb-on-surface file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-bb-surface-highest file:text-bb-primary hover:file:bg-bb-primary hover:file:text-bb-surface transition-all cursor-pointer">
                    <p class="text-xs text-bb-on-surface-variant mt-2">Định dạng hỗ trợ: jpg, png, jpeg, gif.</p>
                    @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="glass-panel rounded-2xl p-6 flex justify-center">
                <button type="submit" class="w-full bg-bb-primary text-bb-surface font-bold py-4 px-8 rounded-lg hover:bg-bb-primary-container transition-colors shadow-[0_0_15px_rgba(242,202,80,0.3)]">
                    LƯU VẬT PHẨM
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
