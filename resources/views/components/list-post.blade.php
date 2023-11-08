<tr class="hover:bg-gray-50">
    <td class="px-6 py-4 text-center">{{ $iteration }}</td>
    <td class="px-6 py-4 text-left">
        <a href="{{ route('berita.show', $berita->slug) }}">
            {{ $berita->title }}
        </a>
    </td>
    <td class="px-6 py-4 text-center">{{ $berita->created_at->format('Y-m-d') }}</td>
    <td class="px-6 py-4 flex gap-4 justify-center items-center">
       
        <a class=" p-2 rounded-3xl  hover:bg-yellow-400"
            href="{{ route('berita.edit', $berita->slug) }}"><x-edit-logo></x-edit-logo></a>
        <form action="{{ route('berita.destroy', $berita->slug) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class=" p-2 rounded-3xl hover:stroke-white hover:bg-red-400"
                onclick="return confirm('konfirmasi hapus')"><x-trash-icon></x-trash-icon></button>
        </form>
    </td>
</tr>
