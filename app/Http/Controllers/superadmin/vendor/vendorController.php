<?php

namespace App\Http\Controllers\superadmin\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Models\User;
use App\Models\vendor;

class vendorController extends Controller
{
    //
    public function index()
    {
        //
        if (request()->ajax()) {
            $data = User::select('*')->where('role', 'vendor')->with('vendor')->get();
            return datatables()->of($data)
                ->addColumn('status', function (User $user) {
                    return $user->vendor->status ? "Active" : "Inactive";
                })
                ->addColumn('action', 'superuser.vendor.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('superuser.vendor.index');
    }



    public function store(Request $request)
    {

        $vendorId = $request->id;

        $vendor = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'vendor',
            'password' => bcrypt($request->password),
        ]);
        $filename = sprintf('thumbnail_%s.jpg', random_int(1, 10000));
        if ($vendor) {
            if ($request->hasFile('vendorpic')) {
                $filename = $request->file('vendorpic')->storeAs('vendor/pic', $filename, 'public');
            } else {
                $filename = 'dummy.jpg';
            }
            vendor::create([
                'user_id' => $vendor->id,
                'location' => $request->location,
                'address' => $request->address,
                'cnic' => $request->cnic,
                'cnicexpiry' => $request->cnicexp,
                'pic' => $filename,
                'status' => $request->status,
            ]);
        }



        return Response()->json($vendor);
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        //
        $where = array('id' => $request->id);
        $data  = User::where($where)->with('vendor')->first();
        // $img = 
        // $imgdata = 'storage/' . User::where('user', $data)->get('pic');
        return Response()->json($data);
    }

    public function update(Request $request)
    {
        $vendorId = $request->id;

        $user = User::find($vendorId);
        $vendor = vendor::where('user_id', $vendorId)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $ans = $user->save();

        $filename = sprintf('thumbnail_%s.jpg', random_int(1, 10000));
        if ($ans) {
            if ($request->hasFile('vendorpic')) {
                $filename = $request->file('vendorpic')->storeAs('vendor/pic', $filename, 'public');
            } else {
                $filename = $vendor->pic;
            }

            $vendor->location = $request->location;
            $vendor->address = $request->address;
            $vendor->cnic = $request->cnic;
            $vendor->cnicexpiry = $request->cnicexp;
            $vendor->pic = $filename;
            $vendor->status = $request->status;
            $vendor->save();
        }
        return Response()->json("successfully updated");
    }


    public function destroy(Request $request)
    {
        //
        $data = User::where('id', $request->id)->delete();

        return Response()->json($data);
    }
}