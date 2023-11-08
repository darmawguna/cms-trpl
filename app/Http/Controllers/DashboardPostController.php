<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\kategori;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
// use Image, File;
use Intervention\Image\Facades\Image;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10; // Jumlah item per halaman
        $currentPage = request()->query('page', 1); // Mengambil nomor halaman dari URL

        // Hitung offset (item yang akan dilewati)
        $offset = ($currentPage - 1) * $perPage;
        $beritas = Berita::latest()
            ->filter(request(['search']))
            ->skip($offset) // Melewati item yang tidak dibutuhkan
            ->take($perPage) // Mengambil item sebanyak yang diperlukan untuk halaman saat ini
            ->paginate($perPage); // Menghitung paginasi dengan jumlah item per halaman

        return view('berita.index', ['beritas' => $beritas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('berita.createPost', [
            'categories' => kategori::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:berita',
            'description' => 'required',
            'kategori_id' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2000', // Validasi gambar
            'related_images' => 'array',
            'related_images.*' => 'image|mimes:jpg,jpeg,png|max:2000', // Validasi gambar (multiple)
        ]);


        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $originalName = $file->getClientOriginalName();
            $photoPath = $file->storeAs('uploads', $originalName, 'public');
            $validatedData['photo'] = $photoPath;
        }
        $related_image = [];
        if ($request->hasFile('related_images')) {

            foreach ($request->file('related_images') as $photo) {
                $name = $photo->getClientOriginalName();
                $photoPath = $photo->store('uploads', 'public'); // Simpan gambar dan dapatkan path
                $related_image[] = [
                    'name' => $name,
                    'path' => $photoPath,
                ];
            }
            $validatedData['related_images'] = json_encode($related_image);
        }

        Berita::create($validatedData);
        return redirect('/dashboard/berita')->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        return view('berita.show', [

            'berita' => $berita
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        return view('berita.edit', [
            'berita' => $berita,
            'categories' => kategori::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $slug)
    {
        
        $berita = Berita::where('slug', $slug)->first();

        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'kategori_id' => 'required',
            'related_images' => 'array',
            'related_images.*' => 'image|mimes:jpg,jpeg,png|max:2000',
        ];

        
        if ($request->slug != $berita->slug) {
            $rules['slug'] = 'required|unique:berita';
        }

        
        if ($request->hasFile('photo')) {
            $rules['photo'] = 'image|mimes:jpg,jpeg,png|max:2000';
        }

        $validatedData = $request->validate($rules);

       
        if ($request->hasFile('photo')) {
            if ($berita->photo) {
                $oldPhotoPath = storage_path('app/public/' . $berita->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }

                
                $file = $request->file('photo');
                $originalName = $file->getClientOriginalName();
                $photoPath = $file->storeAs('uploads', $originalName, 'public');
                $validatedData['photo'] = $photoPath;
            }
        }

        // Periksa apakah ada gambar terkait yang perlu dihapus dan ganti yang baru
        if ($request->hasFile('related_images')) {
            // Hapus gambar terkait lama (jika ada)
            $oldRelatedImages = json_decode($berita->related_images, true);

            foreach ($oldRelatedImages as $relatedImage) {
                $oldImagePath = storage_path('app/public/' . $relatedImage['path']);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $related_image = [];
            foreach ($request->file('related_images') as $photo) {
                $name = $photo->getClientOriginalName();
                $photoPath = $photo->store('uploads', 'public');
                $related_image[] = [
                    'name' => $name,
                    'path' => $photoPath,
                ];
            }

            $validatedData['related_images'] = json_encode($related_image);
        }

        // Perbarui data berita
        $berita->update($validatedData);

        return redirect('/dashboard/berita')->with('success', 'Berita berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        Berita::destroy($berita->berita_id);
        return redirect('/dashboard/berita')->with('success', 'Berita berhasil dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Berita::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
