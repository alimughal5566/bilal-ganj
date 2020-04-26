<?php
/**
 * Created by PhpStorm.
 * User: soft
 * Date: 7/3/2019
 * Time: 1:51 PM
 */

namespace App\Http\Controllers;

use App\Models\Product;
use Composer\Config;
use DTS\eBaySDK\Trading\Enums\SeverityCodeType;
use DTS\eBaySDK\Trading\Enums\ShippingTypeCodeType;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\ShippingDetailsType;
use Illuminate\Http\Request;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\AddFixedPriceItemRequestType;


class EbayController extends Controller
{
    private $products ,  $config , $service;

    public  function view()
    {
        return view('vendor.ebay');
    }
    public function _construct(Product $products)
    {
        $this->products = $products;
        $this->config = Config::get('ebay');
        $this->service = new TradingService(array(
            'apiVersion' => $this->config['tradingApiVersion'],
            'devId' => $this->config['sandbox']['devId'],
            'appId' => $this->config['sandbox']['appId'],
            'certId' => $this->config['sandbox']['cerId'],
            'siteId' => env('EBAY-MY','207'),
            'sandbox' => true,
        ));
    }
    public function productDetail($id)
    {
//        dd($id);
        $obj = new Product();
        $product = $obj->fetchProduct($id);
        dd($product);
        return view('vendor.ebay',compact('product'));
    }
    public function addToStore(Request $requests)
    {
        $request = new AddFixedPriceItemRequestType();
        $request->RequesterCredentials = new CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $this->config['sandbox']['userToken'];
        $item = $this->itemType($requests);
        $this->pictureDetail($item);
        $item->ShippingDetails = new ShippingDetailsType();
        $item->ShippingDetails->ShappingType = ShippingTypeCodeType::C_FLAT;
        $shippingService = $this->shippingService($item);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
        $this->returnPolicy($item);
        $request->Item = $item;
        $response = $this->service->addFixedPriceItem($request);
        if (isset($response->Errors))
        {
            foreach ($response->Errors as $error)
            {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->shortMessage,
                    $error->LongMessage
                );
            }
        }
        if($response->Ack !== 'Failure')
        {
            return redirect()->to(route('products.index'))->with('message','The item was listed to the ebay sandbox with item number'. $response->ItemId);
        }
    }

}