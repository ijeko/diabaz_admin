<?php


namespace App\Http\Sevices\Orders;


use App\Http\Sevices\Service;
use App\Models\OrderComment;

class CommentsService extends OrderService
{

    public function AddCommentToOrder($comment)
    {
        $dataArray = ['comment' => $comment['comment'],
            'order_id' => $comment['order_id']];
        $params = [['required', 'string', 'min:2', 'max:500'],
            ['required']];
        $validatedData = $this
            ->ValidateInput($dataArray, $params)
            ->validated();
        $newComment = new OrderComment();
        return $newComment->fill($validatedData)->save();
    }
}