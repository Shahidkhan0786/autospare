<?php

namespace App\Http\Controllers\Api\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\vendor as Vendor;
use App\Models\shop;

class vendorAuthController extends Controller
{
    public function signin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
            // 'fcm_token' => ['required']
        ]);


        if ($validator->fails()) {
            return response([
                'message' => 'Please provide correct cradentials',
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $user  = User::where('phone', $request->phone)
            ->where('role', '=', 'vendor')->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide correct cradentials',
            ], 400);
        }
        $user_req = Vendor::where('user_id', '=', $user->id)
            ->where('status', '=', '1')->first();

        if (!$user_req) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor Status Pending',
            ], 400);
        }
        $shop = shop::where('vendor_id', '=', $user_req->id)->first();
        $token = $user->createToken('authtoken', ['vendor'])->plainTextToken;
        return response([
            'message' => 'Signin Successfully',
            'token' => $token,
            'data' => [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'shopName' => $shop->storeName,
                'shopLogo' => $shop->shopLogo,
            ]
        ], 200);
    }


    public function Register(Request $request)
    {
        // 'email' => 'required|string|email|unique:users,email
        $input = $request->all();
        // dd($input);
        $address = "";
        $attr = Validator::make($input, [
            'providerid' => 'required',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email',
            'cnic' => 'required',
            'cnicexpiry' => 'required|string',
            'shopName' => 'required|string',
            'category_id' => 'required',
            'location' => 'required',
            'address' => 'required',
        ]);
        if ($attr->fails()) {
            return $attr->errors();
        }

        $check = User::where('phone', $input['phone'])->where('role', 'vendor')->exists();
        if ($check) {
            return response([
                'message' => 'Already Register',
                'data' => $check,
            ], 200);
        }
        $address = json_decode($request->address, true);
        $user = User::create([
            'providerid' => $input['providerid'],
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'role' => 'vendor',
        ]);

        // if ($user) {
        //     $address =  address::create([
        //         'user_id' => $user->id,
        //         'title' => $address['title'],
        //         'address' => $address['address'],
        //         'city' => $address['city'],
        //         'longitude' => $address['longitude'],
        //         'latitude' => $address['latitude'],
        //     ]);
        // }
        if ($user) {
            $filename = sprintf('thumbnail_%s.jpg', random_int(1, 1000));
            if ($request->hasFile('cnicpic')) {
                $filename = $request->file('cnicpic')->storeAs('vendor', $filename, 'public');
            } else {
                $filename = "vendor/dummy.jpg";
            }
            $vendor = Vendor::create([
                'user_id' => $user->id,
                'address_id' => $input['address'],
                'cnic' => $input['cnic'],
                'location' => $input['location'],
                'cnicexpiry' => $input['cnicexpiry'],
                'cnicpic' => $filename,
                'status' => '0',
            ]);
            if ($vendor) {
                $shoplogo = sprintf('shop_%s.jpg', random_int(1, 1000));
                $shopCoverPicture = sprintf('shop_%s.jpg', random_int(1, 1000));

                if ($request->hasFile('shopLogo')) {
                    $shoplogo  = $request->file('shopLogo')->storeAs('shop', $shoplogo, 'public');
                } else {
                    $shoplogo  = "shop/dummy.jpg";
                }
                if ($request->hasFile('shopCoverPicture')) {
                    $shopCoverPicture = $request->file('shopCoverPicture')->storeAs('shop', $shopCoverPicture, 'public');
                } else {
                    $shopCoverPicture = "shop/dummy.jpg";
                }
                $store = shop::create([
                    'vendor_id' => $vendor->id,
                    'category_id' => $input['category_id'],
                    'shopName' => $input['shopName'],
                    'shopLogo' => $shoplogo,
                    'shopCoverPicture' => $shopCoverPicture,
                ]);
            }

            $token = $user->createToken('authtoken', ['vendor'])->plainTextToken;
            return response([
                'message' => 'Vendor Successfulyy Register',
                'token' => $token,
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'cnic' => $vendor->cnic,
                'store name' => $store->stoshopName,
                'created_at' => $user->created_at->format('d/m/Y'),
                'updated_at' => $user->updated_at->format('d/m/Y'),
            ], 200);
        } else {
            $error = "Error in creating Vendor";
            return $error;
        }
    }
}
