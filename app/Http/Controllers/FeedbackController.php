<?php

namespace App\Http\Controllers;

use App\Models\BgShop;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    //
    public function addFeedback(Request $request)
    {
        $userId = $request->user_id;
        $productId = $request->product_id;
        $message = $request->message;
        $userName = $request->user_name;
        $request->validate([
            'message' => 'required',
        ]);

        $feedback = new Feedback();
        $comment = $feedback->addFeedback($userId, $productId, $message);
        $product = new Product();
        $product = $product->fetchProduct($productId);
        $bgShop = BgShop::where('id',$product->bgshop_id)->first();
        $user = User::where('id', $bgShop->user_id)->first();
        if ($comment->user_id != $user->id) {
            Notification::create([
                'user_id' => $user->id,
                'message' => $userName . " is commented on your post " . $product->name,
                'type' => "feedback",
                'target_id'=>$product->id,
            ]);
        }
        if ($comment) {
            return response()->json([
                'comment' => $comment,
                'userName' => $userName,
            ]);
        }
    }

    public function updateFeedback(Request $request)
    {
        $comment_id = $request->comment_id;
        $comment_message = $request->message;
        $feeback = new Feedback();
        $feedback = $feeback->updateFeedback($comment_id, $comment_message);
        return redirect()->back();
    }

    public function removeFeedback($comment_id)
    {
        $feeback = new Feedback();
        $feedback = $feeback->removeFeedback($comment_id);
        if ($feedback) {
            return redirect()->back();
        }
    }

    public function deleteComment($comment_id)
    {
        $feeback = new Feedback();
        $feedback = $feeback->removeFeedback($comment_id);
        if ($feedback) {
            Session::flash('success','Comment deleted Successfully');
            return redirect()->back();
        }
    }

    public function commentList(){
        $comments = Feedback::all();
        $time = Feedback::latest('updated_at')->first();
        return view('admin.comment-table',compact('comments','time'));
    }

    public function commentOnProduct(Request $request){
        $product = Product::find($request->product_id);
        $comments = $product->feedbacks()->get();
        $time = Feedback::latest('updated_at')->first();
        return view('admin.comment-on-product',compact('comments','time'));

    }
}
