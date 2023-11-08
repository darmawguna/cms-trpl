<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('berita.update', $berita->slug) }}" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="mb-6">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul
                        Berita</label>
                    <input type="text" id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="masukan judul berita.." name="title" required
                        value="{{ old('title', $berita->title) }}">
                </div>



                <div class="mb-6">
                    <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">slug
                        Berita</label>
                    <input type="text" id="slug"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="masukan slug berita.." name="slug" required
                        value="{{ old('slug', $berita->slug) }}">
                </div>

                <div class="mb-6">
                    <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                        Kategori</label>
                    <select name="kategori_id" id="kategori"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->kategori_id }}">{{ $category->kategori }}</option>
                        @endforeach
                    </select>

                </div>
                @if ($berita->photo)
                    <div class="mb-6">
                        <label for="existing_photo">Foto Saat Ini:</label>
                        <img class="w-20 h-20" src="{{ asset($berita->photo) }}" alt="Foto saat ini">
                    </div>
                @endif
                <div class="mb-6">
                    <label for="photo">Masukan Foto</label>
                    <input type="file" name="photo" id="photo">
                </div>
                <label for="description">description</label>
                <input id="description" type="hidden" name="description"
                    value="{{ old('description', $berita->description) }}">
                <trix-editor input="description"></trix-editor>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 mt-3 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>
    </div>

    <script>
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');
        title.addEventListener('change', function() {
            fetch('/dashboard/berita/checkSlug?title=' + title.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })
    </script>

</x-app-layout>
