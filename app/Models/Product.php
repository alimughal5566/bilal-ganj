<?php

namespace App\Models;

//use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class
Product extends Model
{
//    use Searchable;
    use SoftDeletes;
    protected $guarded = [
    'id', '_token'
];

    public function categories()
{
    return $this->belongsToMany(Category::class,'categories_products','product_id','category_id');
}

    public function carts()
{
    return $this->belongsToMany(Cart::class,'carts_products','product_id','cart_id')
        ->withPivot(['id','cart_id','product_id','quantity']);
}

    public function wishList()
{
    return $this->hasMany(Wishlist::class);
}

    public function feedbacks()
{
    return $this->hasMany(Feedback::class);
}
    public function bgShop()
{
    return $this->belongsTo(BgShop::class);
}

    public function media()
{
    return $this->hasMany(Media::class)->withTrashed();
}

    public function updateQuantity(){}

//    public function productView(){
////        $city=Product::where('id',10)->get();
//            $city=Category::all();
//        dd($city);
//
//        $array=[
//            'city'=>$city
//        ];
//        return $array;
//
////        $qry=Product::where('id',1)->get();
////        dd($qry);
////        return $qry;
//    }

    public function addProduct($productTableAttr,$bgShop,$category){

    $product = Product::create(array_merge($productTableAttr, ['bgshop_id' => $bgShop]));
    $product->categories()->attach($category);
    return $product;
}

    public function fetchUser($userTableAttr){
    $user = BgShop::where('user_id',$userTableAttr)->first();
    return $user;
}
    public function fetchCategory($categoryTableAttr){
    $category = Category::where('id',$categoryTableAttr['release'])->first();
    return $category;
}

    public function editProduct($id)
{
    $product = Product::find($id);
    return $product;
}

    public function editProductSave($formdata)
{
    $product = Product::find($formdata['product_id'])->update([
        'name'=>$formdata['name'],
        'description'=>$formdata['description'],
        'quantity'=>$formdata['quantity'],
        'ucp'=>$formdata['ucp'],
        'discount'=>$formdata['discount'],
    ]);
    return $product;
}

    public function deleteProduct($id){
    $product = Product::find($id);
    $media = $product->media()->delete();
    $product->delete();
    return $product;
}

    public function fetchPaginateProducts(){
    $qry = Product::where('is_visible',1)->paginate(9);
    return $qry;
}

    public function fetchRelatedProducts($product){
    $name = $product->name;
    $id = $product->id;
    $category = $product->categories()->first();
    $qry = Product::with('categories')->orWhereHas('categories',function ($query) use ($category){
        $query->where('parent_id',$category->parent_id);
    })->where('id','!=',$id)->where('is_visible',1)->take(5)->get();
    return $qry;
}
    public  function changeProductVisibility($id , $user_id)
{
    $qry = Product::where('bgshop_id' , $id)->update(['is_visible'=> 0]);
    if ($qry) {
        Notification::create([
            'user_id' => $user_id,
            'message' => "You need to recharg your credit inorder to continue your sale on our portal",
        ]);
    }
    return $qry;
}

    public function fetchProducts(){
    $qry = Product::where('is_visible',1)->get();
    return $qry;
}

    public function fetchProduct($productId)
{
    $qry = Product::where('id', $productId)->first();
    return $qry;
}
    public function fetchSpecificProducts($obj){
    $qry = $obj->products()->where('is_visible',1)->paginate(9);
    return $qry;
}

    public function fetchSingleProduct($id){
    $qry = Product::find($id);
    return $qry;
}

    public function fetchPreviousProduct($id){
    $qry = Product::where('id', '<', $id)->where('is_visible',1)->max('id');
    return $qry;
}

    public function fetchNextProduct($id){
    $qry = Product::where('id', '>', $id)->where('is_visible',1)->min('id');
    return $qry;
}
    public function getFeedback($product){
    $feeback = Feedback::where('product_id',$product)->get();
    return $feeback;
}


    public function sorting($value)
{
    switch ($value) {
        case 'ascen':
            $products = Product::where('is_visible',1)->orderBy('name')->paginate(9);
            return $products;
            break;
        case 'descen':
            $products = Product::where('is_visible',1)->orderBy('name','desc')->paginate(9);
            return $products;
            break;
        case 'newness':
            $products = Product::where('is_visible',1)->orderBy('created_at','desc')->paginate(9);
            return $products;
            break;
        case 'discount':
            $products = Product::where('is_visible',1)->orderBy('discount','desc')->paginate(9);
            return $products;
            break;
        case 'low_to_high':
            $products = Product::where('is_visible',1)->orderBy('ucp')->paginate(9);
            return $products;
            break;
        case 'higt_to_low':
            $products = Product::where('is_visible',1)->orderBy('ucp','desc')->paginate(9);
            return $products;
            break;
    }
}

    public function vendorProducts($id)
{
    $sry = Product::where('bgshop_id', $id)->where('is_visible',1)->get();
    return $sry;
}


    public function fetchProductSlider($start,$end){
    $qry = Product::where('ucp','>=',$start)->where('ucp','<=',$end)->paginate(9);
    return $qry;
}
    public function fetchProductCheckbox($category)
{
    $products = [];
    foreach ($category as $cat){
        foreach ($cat->products()->get() as $product){
            array_push($products,$product);
        }
    }
    return $products;
}
    public function fetchProductCheckboxVendor($vendors)
{
    foreach ($vendors as $vendor){
        $products[] = Product::where('bgshop_id', $vendor)->get();
    }
    return $products;
}

    public function fetchRecommendedProducts($name){
    $qry = Product::where('name','like','%'.$name.'%')->where('is_visible',1)
        ->orWhereHas('categories', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->paginate(9);
    return $qry;
}
}
