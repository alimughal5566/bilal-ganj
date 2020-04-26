<?php


namespace App\Http\Controllers;


use App\Models\BgShop;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function addProductView($id = null)
    {

        if ($id) {
            $obj = new BgShop();
            $vendor = $obj->fetchSpecificVendor($id);
            $category = new Category();
            $categories = $category->categoryfetch();
            return view('vendor.add-product', compact('vendor', 'categories'));
        }
        $category = new Category();
        $categories = $category->categoryfetch();
        return view('vendor.add-product', compact('categories'));
    }

    public function fetchDependent(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('categories')
            ->where($select, $value)
            ->get();
        $output = '<option value=""></option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->$dependent . '</option>';
        }
        echo $output;
    }

    public function addProduct(Request $request)
    {
        $formdata = $request->all();

        $this->validate($request, [
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

        $array = $request->allFiles('image');
        $allFiles = $array['image'];

        $categoryTableAttr = $request->only('release');


        $category = new Product();
        $category = $category->fetchCategory($categoryTableAttr);


        $userTableAttr = $request->only('user_id');

        $user = new Product();
        $bgShop = $user->fetchUser($userTableAttr);

        $productTableAttr = $request->except('image','deal', 'user_id', 'release', 'brand', 'parent_id');
        $product = new Product();

        $product = $product->addProduct($productTableAttr, $bgShop->id, $category);

        foreach ($allFiles as $file) {
            $image = $file;
            $extension = rand() . '.' . $file->extension();
            $location = public_path('/assets/images');
            $newImage = Image::make($image->getPathName())->resize(600, 600);
            $newImage->save($location.'/'.$extension);
            $media = new Media();
            $array = [
                'image' => $extension,
                'product_id' => $product['id']
            ];
            $image = $media->saveimage($array);
        }


        if ($product && $image) {
            Session::flash('addProduct', 'Product add Successfully');
            return redirect()->back();
        }
    }

    public function editProduct($id, $user_id)
    {

        $product = new Product();
        $product = $product->editProduct($id);
        $obj = new BgShop();
        $vendor = $obj->fetchSpecificVendor($user_id);
        $edit = '';
        return view('vendor.add-product', compact('product', 'edit', 'vendor'));
    }

    public function editProductSave(Request $request)
    {
        $formdata = $request->all();
        $product = new Product();
        $product = $product->editProductSave($formdata);
        if ($product) {
            Session::flash('editProduct', 'Product Edit Successfully');
            return redirect()->back();
        }
    }

    public function deleteProduct($id)
    {
        $product = new Product();
        $product = $product->deleteProduct($id);
        if ($product) {
            Session::flash('success','Product Deleted Successfully');
            return redirect()->back();
        }
    }

    public function categorySelect()
    {
        $category = new Category();
        $categories = $category->categoryfetch();
        dd($categories);
        return view('home.home', compact('categories'));
    }

    public function fetchProduct($id)
    {
        $qry = Product::where('id',$id)->first();
        return $qry;
    }

    public function fetchProductSlider(Request $request)
    {
        $product = $request->all();
        $obj = new Product();
        $start = $product['start_price'];
        $end = $product['end_price'];
        $products = $obj->fetchProductSlider($start, $end);
        $allProducts = $products;
        return view('home.include.single-product', compact('products', 'allProducts'));

    }

    public function fetchProductCheckbox(Request $request)
    {
        $category = $request->data;
        $objCategory = new Category();
        $obj = new Product();
        $product = [];
            $array = $objCategory->fetchCategory($category);
        foreach ($array as $key => $val){
            array_push($product, $obj->fetchProductCheckbox($val));
        }
        $products = [];
        foreach ($product as $val){
            foreach ($val as $val2){
                $products[] = $val2;
            }
        }
        $allProducts = $products;
        $flag = 'test';
        return view('home.include.single-product', compact('products', 'allProducts', 'flag'));
    }

    public function fetchProductCheckboxVendor(Request $request)
    {
        $vendors = $request->data;
        $product = new Product();

        $array= $product->fetchProductCheckboxVendor($vendors);
        $product = [];
        foreach ($array as $key => $val){
            array_push($product, $val);
        }
        $products = [];
        foreach ($product as $val){
            foreach ($val as $val2){
                $products[] = $val2;
            }
        }
        $flag = 'test';
        $allProducts = $products;
        return view('home.include.single-product', compact('products', 'allProducts','flag'));

    }

    public function undoProduct($id){
        $product = Product::withTrashed()->where('id',$id)->first();
        $product->restore();
        $product->media()->restore();
        if($product){
            Session::flash('success','Product Restored Successfully');
            return redirect()->route('productList');
        }
        return $product;
    }

    public function sortProducts(Request $request)
    {
        $value = $request->value;
        $obj = new Product();
        switch ($value) {
            case 'ascen':
                $products = $obj->sorting($value);
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
            case 'descen':
                $products = $obj->sorting($value);
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
            case 'newness':
                $products = $obj->sorting($value);
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
            case 'discount':
                $products = $obj->sorting($value);
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
            case 'low_to_high':
                $products = $obj->sorting($value);
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
            case 'higt_to_low':
                $products = $obj->sorting($value);
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
            default:
                $products = $obj->fetchPaginateProducts();
                $allProducts = $products;
                return view('home.include.single-product', compact('products', 'allProducts'));
                break;
        }
    }
}
