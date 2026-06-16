<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label class="block mb-1 font-medium">Cabang</label><select name="branch_id" class="w-full border rounded-xl p-3" required>@foreach($branches as $branch)<option value="{{ $branch->id }}" @selected(old('branch_id', $product->branch_id ?? '') == $branch->id)>{{ $branch->name }}</option>@endforeach</select></div>
    <div><label class="block mb-1 font-medium">Kategori</label><select name="category_id" class="w-full border rounded-xl p-3" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
    <div><label class="block mb-1 font-medium">Kode Produk</label><input name="code" class="w-full border rounded-xl p-3" value="{{ old('code', $product->code ?? '') }}" required></div>
    <div><label class="block mb-1 font-medium">Nama Produk</label><input name="name" class="w-full border rounded-xl p-3" value="{{ old('name', $product->name ?? '') }}" required></div>
    <div><label class="block mb-1 font-medium">Stok</label><input type="number" name="stock" class="w-full border rounded-xl p-3" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required></div>
    <div><label class="block mb-1 font-medium">Minimum Stok</label><input type="number" name="min_stock" class="w-full border rounded-xl p-3" value="{{ old('min_stock', $product->min_stock ?? 5) }}" min="0" required></div>
    <div><label class="block mb-1 font-medium">Harga Beli</label><input type="number" name="purchase_price" class="w-full border rounded-xl p-3" value="{{ old('purchase_price', $product->purchase_price ?? 0) }}" min="0" required></div>
    <div><label class="block mb-1 font-medium">Harga Jual</label><input type="number" name="selling_price" class="w-full border rounded-xl p-3" value="{{ old('selling_price', $product->selling_price ?? 0) }}" min="0" required></div>
    <div><label class="block mb-1 font-medium">Satuan</label><input name="unit" class="w-full border rounded-xl p-3" value="{{ old('unit', $product->unit ?? 'pcs') }}" required></div>
</div>
<div class="flex gap-2 mt-6"><button class="bg-blue-600 text-white px-4 py-2 rounded-xl">Simpan</button><a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl">Kembali</a></div>
