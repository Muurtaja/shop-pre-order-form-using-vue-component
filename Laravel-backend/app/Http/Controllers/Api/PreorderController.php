<?php

namespace App\Http\Controllers\Api;

use App\Events\PreorderSubmitted;
use App\Http\Controllers\Controller;
use App\Models\Preorder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PreorderController extends Controller
{
    public function products()
    {
        return response()->json([
            "products" => Product::orderBy("id", "desc")->select("id", "name")->get(),
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'product' => 'required|exists:products,id',
        ]);

        $validator->sometimes('phone', 'required|string|max:15', function ($input) {
            return str_ends_with($input->email, '@xyz.com');
        });


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $preorderExists = Preorder::where('email', $request->email)->where('product_id', $request->product)->exists();
        if ($preorderExists) {
            return response()->json(['errors' => ["YOu have submitted another preorder for this product"]], 422);
        }

        if (recaptchaStatus() === true) {
            $recaptcha = verifyRecaptcha($request);
            if ($recaptcha["success"] == false) {
                return response()->json(['errors' => $recaptcha["errors"]], 422);
            }
        }


        $data = $validator->validated();

        $preorder = Preorder::create([
            'product_id' => $data['product'],
            'name'       => htmlspecialchars($data['name']),
            'email'      => htmlspecialchars($data['email']),
            'phone'      => str_ends_with($data['email'], '@xyz.com') ? htmlspecialchars($data['phone'])  : null,
        ]);

        event(new PreorderSubmitted($preorder));

        return response()->json([
            'message' => 'Pre-order successfully placed.',
            'preorder' => $preorder,
        ], 201);
    }
}
