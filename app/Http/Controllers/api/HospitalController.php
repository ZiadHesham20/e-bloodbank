<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HospitalController extends Controller
{
    public $hospital;

    public function __construct(Hospital $hospital)
    {
        $this->middleware('auth.basic.once')->except('index', 'show');
        $this->middleware('HospitalAdmin')->only('update');
        $this->hospital = $hospital;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = $this->hospital::paginate(10);
        return $hospitals;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'cover_image' => 'image|required',
        //     'about' => 'required',
        //     'email' => 'required',
        //     'phone' => 'required',
        //     'address' => 'required',
        // ]);

        $hospital = new $this->hospital;

        // $hospital->name = $request->name;
        // // $hospital->cover_image = $this->uploadImage( $request->cover_image );
        // $hospital->about = $request->about;
        // $hospital->email = $request->email;
        // $hospital->phone = $request->phone;
        // $hospital->address = $request->address;
        // $hospital->latitude = $request->latitude;
        // $hospital->longitude = $request->longitude;
        // $hospital->save();

        $hospital = $this->hospital::create($request->all());
        // the user create hospital his role = 1
        // Update the authenticated user
        $user = Auth::user();
        $user->role = 1;
        $user->hospital_id = $hospital->id;
        $user->save();

        return $hospital;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hospital = $this->hospital::find($id);
        return $hospital;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hospital $hospital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hospital = $this->hospital::findOrFail($id);
        // $this->validate($request, [
        //     'name' => 'required',
        //     'cover_image' => 'image|required',
        //     'about' => 'required',
        //     'email' => 'required',
        //     'phone' => 'required',
        //     'address' => 'required',
        // ]);


        // $hospital->name = $request->name;
        // if ($request->has('cover_image')){
        //     Storage::disk('public')->delete($hospital->cover_image);
        //     $hospital->cover_image = $this->uploadImage($request->cover_image);
        // }

        // $hospital->about = $request->about;
        // $hospital->email = $request->email;
        // $hospital->phone = $request->phone;
        // $hospital->address = $request->address;
        // $hospital->latitude = $request->latitude;
        // $hospital->longitude = $request->longitude;
        // $hospital->save();

        $hospital->update($request->all());

        return $hospital;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->hospital::findOrFail($id)->delete();
        return 204;
    }
// search by name
public function searchByName($name){
    $hospital = $this->hospital::where('name','LIKE',$name)->get();
    return response()->json($hospital);
}
    // search by location
    public function searchByaddress($address){
        $hospital = $this->hospital::where('address','LIKE',$address)->get();
        return response()->json($hospital);
    }
    // by default show hospitals in my locaton
    public function getdafaulthospitals(){
        $user = User::find(Auth::user()->id);
        $hospital = $this->hospital::where('address','LIKE',$user->location)->get();
        return response()->json($hospital);

    }

}
