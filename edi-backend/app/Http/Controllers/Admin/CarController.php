<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Cars::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.car.index', [
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'license_plate' => 'required',
            'driver_name_1' => 'required',
        ];

        $this->validate($request, $validations);

        $checkLicenseExist = Cars::where('license_plate', $request->license_plate)->first();
        if (!empty($checkLicenseExist)) {
            return redirect()->back()->with('error_message', 'Plat nomor sudah terdaftar');
        }

        try {
            $car = new Cars();
            $car->license_plate = $request->license_plate;
            $car->driver_name_1 = $request->driver_name_1;
            $car->driver_name_2 = $request->driver_name_2;
            $car->capacity = 7000;
            $car->is_fulfilled = 0;
            $car->is_departed = 0;
            $car->save();

            // Create car temporary user for android login
            $courierUser = new User();
            $courierUser->name = $car->license_plate;
            $courierUser->username = $car->license_plate;
            $courierUser->password = Hash::make('password');
            $courierUser->type = 'Temporary';
            $courierUser->role = 'Kurir';
            $courierUser->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->route('admin.edi.car.index')->with('success_message', 'Berhasil tambah data mobil');
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Cars::find($id);
        if (empty($car)) {
            return redirect()->back()->with('error_message', 'Mobil tidak ditemukan');
        }

        return view('admin.car.edit', [
            'car' => $car
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validations = [
            'license_plate' => 'required',
            'driver_name_1' => 'required',
        ];

        $this->validate($request, $validations);

        $car = Cars::find($id);
        if (empty($car)) {
            return redirect()->back()->with('error_message', 'Mobil tidak ditemukan');
        }

        try {
            $car->license_plate = $request->license_plate;
            $car->driver_name_1 = $request->driver_name_1;
            $car->driver_name_2 = $request->driver_name_2;
            $car->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->route('admin.edi.car.index')->with('success_message', 'Berhasil edit data mobil');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Cars::find($id);
        if (empty($car)) {
            return redirect()->back()->with('error_message', 'Mobil tidak ditemukan');
        }

        try {
            $car->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }

        return redirect()->route('admin.edi.car.index')->with('success_message', 'Berhasil hapus data mobil');
    }
}
