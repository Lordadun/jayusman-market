<div><label class="block mb-1 font-medium">Nama Kategori</label><input name="name" class="w-full border rounded-xl p-3" value="{{ old('name', $category->name ?? '') }}" required></div>
<div><label class="block mb-1 font-medium">Deskripsi</label><textarea name="description" class="w-full border rounded-xl p-3">{{ old('description', $category->description ?? '') }}</textarea></div>
<div class="flex gap-2"><button class="bg-blue-600 text-white px-4 py-2 rounded-xl">Simpan</button><a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl">Kembali</a></div>
