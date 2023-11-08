<x-app-layout>
    <div class="p-4 sm:ml-64">
        <section class="w-full md:w-full flex flex-col items-center px-3">
        </section>
        <main class="mt-10">
            <article class="flex flex-col shadow my-4 mx-14">
                <!-- Article Image -->
                <div class="w-full max-w-screen-lg mx-auto">
                    @if ($berita->photo)
                        <div class="mb-6">
                            <img class="w-28 h-28" src="{{ asset($berita->photo) }}" alt="Foto saat ini">
                        </div>
                    @endif
                </div>
                <div class="bg-white flex flex-col justify-start p-6">
                    <div class="mb-4">
                        <a class="p-2 mb-4 bg-blue-400 rounded-lg " href="/dashboard/berita"> Back to Berita</a>
                    </div>
                    {{-- link untuk kategori --}}
                    <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4"></a>
                    {{-- link untuk judul --}}

                    <a href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $berita->title }}</a>

                    <p class="pb-3">
                        {!! $berita->description !!}
                    </p>

                    <td class="flex gap-4 px-6 py-4">
                        @if (!empty($berita->related_images))
                            <ul>
                                @foreach (json_decode($berita->related_images) as $image)
                                    <li>
                                        <img src="{{ asset($image->path) }}" alt="{{ $image->name }}">
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </div>
            </article>
        </main>
    </div>
</x-app-layout>
