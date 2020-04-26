<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdsMedia;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public $successStatus = 200;
    public $errorsStatus = 401;

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:30',
            'release' => 'required',
            'size' => 'required',
            'parent_id' => 'required',
            'brand' => 'required',
            'description' => 'required|min:20',
            'image.*' => 'required|mimes:jpeg,jpg,png',
            'quantity' => 'required|numeric',
            'ucp' => 'required|numeric|min:1',
            'discount' => 'required|numeric|digits_between:1,3|min:0|max:100',
            'model' => 'required',
            'condition' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors()],
                $this->errorsStatus);
        } else {
            dd($request->all());
            $msg = 'Registration Successful! Please Verify Email Address...';
            $array = $request->allFiles('image');
            $allFiles = $array['image'];

            $categoryTableAttr = $request->only('release');


            $category = new Product();
            $category = $category->fetchCategory($categoryTableAttr);


            $userTableAttr = $request->only('user_id');

            $user = new Product();
            $bgShop = $user->fetchUser($userTableAttr);

            $productTableAttr = $request->except('image', 'deal', 'user_id', 'release', 'brand', 'parent_id');
            $product = new Product();

            $product = $product->addProduct($productTableAttr, $bgShop->id, $category);

            foreach ($allFiles as $file) {
                $image = $file;
                $extension = rand() . '.' . $file->extension();
                $location = public_path('/assets/images');
                $newImage = Image::make($image->getPathName())->resize(600, 600);
                $newImage->save($location . '/' . $extension);
                $media = new Media();
                $array = [
                    'image' => $extension,
                    'product_id' => $product['id']
                ];
                $image = $media->saveimage($array);
            }


            if ($product && $image) {

                $success['token'] = $user->createToken('bilalganj')->accessToken;
                return response()->json(['success' => $msg], $this->successStatus);
            }
        }

    }

    public function fetchProduct()
    {
//        $this->checkVendorsCredit();
        $obj = new Product();
        $allProducts = $obj->fetchProducts();
        return response()->json(['products' => $allProducts], $this->successStatus);
    }

    public function productDetail($id)
    {
        $obj = new Product();
        $product = $obj->fetchSingleProduct($id);

        $media = new Media();
        $media = $media->fetchImage();

        return response()->json(['status' => 'success', 'product' => $product, 'image' => $media], $this->successStatus);

//        $media = Media::where('product_id',$product->id)->get();
//        return response()->json(['status' => 'success','product' => $product,'images' => $media], $this->successStatus);

    }

}
