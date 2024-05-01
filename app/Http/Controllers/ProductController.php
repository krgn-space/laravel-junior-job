<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([Product::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'name' => 'required|min:10',
            'article' => 'required|unique:products|regex:/^[a-zA-Z0-9]+$/',
            'status' => 'in:' . ProductStatus::cases(),
        ]);

        if($validator->fails()) {
            return response()->json(["Validation error.", $validator->errors()->toArray()], 422);
        }

        $product = Product::create($data);

        if($product->save()) {
            return response()->json(["Product created successfully.", $data], 201);
        }
        
        return response()->json(["Something went wrong.", $data], 500);
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::find($id);

        if($product) {
            return response()->json($product, 200);
        }
        
        return response()->json(["Product not found.", $id], 404);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function edit(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        $data = $request->all();

        if($product) {
            $validator = Validator::make($data, [
                'name' => 'min:10',
                'article' => 'unique:products|regex:/^[a-zA-Z0-9]+$/',
                'status' => 'in:' . ProductStatus::cases(),
            ]);

            if($validator->fails()) {
                return response()->json(["Validation error.", $validator->errors()->toArray()], 422);
            }

            $product->update($data);

            if($product->save()) {
                return response()->json(["Product updated successfully.", $data], 201);
            }

            return response()->json(["Something went wrong.", $data], 500);
        }
        
        return response()->json(["Product not found.", $id], 404);
    }

    /**
     * Delete the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $product = Product::find($id);

        if($product) {
            $product->delete();

            return response()->json(["Product deleted successfully.", $id], 200);
        }

        return response()->json(["Product not found.", $id], 404);
    }
}
