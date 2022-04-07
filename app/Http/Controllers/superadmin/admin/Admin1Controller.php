<?php

namespace App\Http\Controllers\superadmin\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Models\User;
use App\Models\admin;


class Admin1Controller extends Controller
{

    public function index()
    {
        //
        if (request()->ajax()) {
            return datatables()->of(User::select('*')->where('role', 'admin')->get())
                ->addColumn('action', 'superuser.admin.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('superuser.admin.index');
    }



    public function store(Request $request)
    {
        //
        $adminId = $request->id;

        $admin = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
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
        $data  = User::where($where)->with('admin')->first();
        return Response()->json($data);
    }


    public function update(Request $request)
    {
        $adminId = $request->id;
        $user = User::find($adminId);
        $admin = admin::where('user_id', $adminId)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $ans = $user->save();

        $filename = sprintf('thumbnail_%s.jpg', random_int(1, 10000));
        if ($ans) {
            if ($request->hasFile('adminpic')) {
                $filename = $request->file('adminpic')->storeAs('admin/pic', $filename, 'public');
            } else {
                $filename = $admin->pic;
            }

            $admin->location = $request->location;
            $admin->address = $request->address;
            $admin->cnic = $request->cnic;
            $admin->cnicexpiry = $request->cnicexp;
            $admin->pic = $filename;
            $admin->status = $request->status;
            $admin->save();
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