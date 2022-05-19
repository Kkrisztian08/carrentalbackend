<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars=Car::all();
        return response()->json(["data"=>$cars]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request)
    {
        $car= new Car();
        $car->fill($request->all());
        $car->save();
        return response()->json($car,201);
    }

    public function rent(Request $request, Car $car)
    {
        $vehicle=Car::find($car->id);
        if (is_null($vehicle)) {
            return response()->json(["message"=>"Nincs ilyen azonosítóju autó"],404);
        }

        $count=Rental::where('car_id', $car->id)
        ->where('start_date', '<=', Carbon::now())
        ->where('end_date', '>=', Carbon::now())
        ->count();
        if ($count>0) {
            return response()->json(["message"=>"Az auto már foglalt"],409);
        }
        $rental= new Rental();
        $rental->car_id=$car->id;
        $rental->start_date=Carbon::now();
        $rental->end_date=Carbon::now()->addDays(7);
        $rental->save();
        return response()->json($rental,201);
    }


    
}
