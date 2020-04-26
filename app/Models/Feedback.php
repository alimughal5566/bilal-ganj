<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $guarded=[
        'id','_token'
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function addFeedback($userId,$productId,$message){
        $feeback = Feedback::create([
            'user_id'=>$userId,
            'product_id'=>$productId,
            'message'=>$message,
        ]);
        return $feeback;
    }
    public function updateFeedback($comment_id,$message){
        $feedback = Feedback::find($comment_id)->update([
            'message' => $message
        ]);
        return $feedback;
    }
    public function removeFeedback($comment_id){
        $feedback = Feedback::find($comment_id)->delete();
        return $feedback;
    }

}
