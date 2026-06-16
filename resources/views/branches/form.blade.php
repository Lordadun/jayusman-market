<div><label class="block mb-1 font-medium">Nama Cabang</label><input name="name" class="w-full border rounded-xl p-3" value="{{ old('name', $branch->name ?? '') }}" required></div>
<div><label class="block mb-1 font-medium">Kota</label><input name="city" class="w-full border rounded-xl p-3" value="{{ old('city', $branch->city ?? '') }}" required></div>
<div><label class="block mb-1 font-medium">Alamat</label><textarea name="address" class="w-full border rounded-xl p-3">{{ old('address', $branch->address ?? '') }}</textarea></div>
<div><label class="block mb-1 font-medium">Telepon</label><input name="phone" class="w-full border rounded-xl p-3" value="{{ old('phone', $branch->phone ?? '') }}"></div>
<div class="flex gap-2"><button class="bg-blue-600 text-white px-4 py-2 rounded-xl">Simpan</button><a href="{{ route('branches.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl">Kembali</a></div>
