<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::with('rooms')->orderByDesc('id')->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderByDesc('id')->get();
        $cities = Country::orderByDesc('id')->get();
        return view('admin.hotels.create', compact('countries', 'cities')); //menampilkan view create.blade.php dengan data countries dan cities
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if($request->hasFile('thumbnail')){
                $thumbnailPath = //variabel untuk menyimpan path file thumbnail
                $request->file('thumbnail')->store('thumbnails', 'public'); //menyimpan file thumbnail di storage/app/public/thumbnails/tanggal
                $validated['thumbnail'] = $thumbnailPath; //menyimpan path file thumbnail di kolom thumbnail
            }else{
                $validated['thumbnail'] = null; //jika tidak ada file thumbnail, maka kolom thumbnail diisi null
            }

            $validated['slug'] = Str::slug($validated['name']);

            $hotel = Hotel::create($validated);

            //digunakan untuk menyimpan multiple file photo pada hotel
            if($request->hasFile('photos')){
                foreach($request->file('photos') as $photo){ //looping setiap file photo yang diupload
                    if ( $photo && $photo->isValid() ){ //cek apakah file photo valid
                        $photoPath = $photo->store('hotel_photos', 'public'); //menyimpan file photo di storage/app/public/hotel_photos/tanggal
                        $hotel->photos()->create([ //membuat relasi ke tabel hotel_photos dan membuat record baru
                            'photo' => $photoPath,
                        ]);
                    }
                }
            }else{
                //jika tidak ada file photo, maka kolom photo diisi null
                $hotel->photos()->create([
                    'photo' => null
                ]);
            }
        });

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $latestPhotos = $hotel->photos()->orderByDesc('id')->take(2)->get(); //mengambil 2 foto terbaru dari relasi photos
        return view('admin.hotels.show', compact('hotel', 'latestPhotos')); //menampilkan view show.blade.php dengan data hotel dan latestPhotos
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        $countries = Country::orderByDesc('id')->get();
        $cities = Country::orderByDesc('id')->get();
        $star_rating = [1,2,3,4,5];
        $latestPhotos = $hotel->photos()->orderByDesc('id')->take(3)->get(); //mengambil 3 foto terbaru dari relasi photos
        return view('admin.hotels.edit', compact('hotel', 'countries', 'cities', 'latestPhotos')); //menampilkan view edit.blade.php dengan data hotel, countries, cities, dan latestPhotos
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        DB::transaction(function () use ($request, $hotel) {
            $validated = $request->validated();

            if($request->hasFile('thumbnail')){
                $thumbnailPath = //variabel untuk menyimpan path file thumbnail
                $request->file('thumbnail')->store('thumbnails', 'public'); //menyimpan file thumbnail di storage/app/public/thumbnails/tanggal
                $validated['thumbnail'] = $thumbnailPath; //menyimpan path file thumbnail di kolom thumbnail
            }

            $validated['slug'] = Str::slug($validated['name']);

            $hotel->update($validated);

            //digunakan untuk menyimpan multiple file photo pada hotel
            if($request->hasFile('photos')){
                foreach($request->file('photos') as $photo){ //looping setiap file photo yang diupload
                    if ( $photo && $photo->isValid() ){ //cek apakah file photo valid
                        $photoPath = $photo->store('hotel_photos', 'public'); //menyimpan file photo di storage/app/public/hotel_photos/tanggal
                        $hotel->photos()->create([ //membuat relasi ke tabel hotel_photos dan membuat record baru
                            'photo' => $photoPath,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete(); 
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
