<select name="{{ $name ?? 'year' }}" class="flex w-[310px] h-[50px] border border-gray-300 rounded-lg text-[#1167B1] font-semibold focus:ring-0 focus:border-[#1167B1] text-center" required>
    <option value="" disabled selected>Pilih Tahun</option>
    @for ($year = now()->year; $year <= now()->year + 10; $year++)
        <option value="{{ $year }}">{{ $year }}</option>
    @endfor
</select>