<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Models\User;
use App\Models\vendor;

class RequestController extends Controller
{
    //
    public function index()
    {
        if (request()->ajax()) {
            $data = vendor::select('*')->where('status', '0')->with('user')->get();
            return datatables()->of($data)
                ->addColumn('name', function (vendor $ven) {
                    return $ven->user->name;
                })
                ->addColumn('email', function (vendor $ven) {
                    return $ven->user->email;
                })
                ->addColumn('action', 'admin.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.request');
    }

    public function showVendor()
    {
        if (request()->ajax()) {

            $data = vendor::select('*')->with('user')->get();
            return datatables()->of($data)
                ->addColumn('name', function (vendor $ven) {
                    return $ven->user->name;
                })
                ->addColumn('email', function (vendor $ven) {
                    return $ven->user->email;
                })
                ->addColumn('action', 'admin.vaction')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.vcrud');
    }


    public function store(Request $request)
    {
        //
        $adminId = $request->id;

        $admin = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => bcrypt($request->password),
        ]);
        $filename = sprintf('thumbnail_%s.jpg', random_int(1, 10000));
        if ($admin) {
            if ($request->hasFile('adminpic')) {
                $filename = $request->file('adminpic')->storeAs('admin/pic', $filename, 'public');
            } else {
                $filename = 'dummy.jpg';
            }
            admin::create([
                'user_id' => $admin->id,
                'location' => $request->location,
                'address' => $request->address,
                'cnic' => $request->cnic,
                'cnicexpiry' => $request->cnicexp,
                'pic' => $filename,
                'status' => $request->status,
            ]);
        }



        return Response()->json($admin);
    }




    public function edit(Request $request, $id)
    {
        //
        $where = array('id' => $request->id);
        $data  = vendor::where($where)->with('user')->first();
        // $img = 
        // $imgdata = 'storage/' . User::where('user', $data)->get('pic');
        return Response()->json($data);
    }

    public function update(Request $request)
    {
        $vendorId = $request->id;

        $vendor = vendor::find($vendorId);
        $user = User::where('id', $vendor->user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = bcrypt($request->password);
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
        //ven
        $ven = vendor::find($request->id);
        $data = User::where('id', $ven->user_id)->delete();

        return Response()->json($data);
    }
}