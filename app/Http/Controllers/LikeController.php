<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\LikeInterface;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;

    public function __construct(
        LikeInterface $like_interface
    ) {
        $this->like = $like_interface;
    }

    /**
     * いいね登録
     *
     * @param int $id
     */
    public function like(int $id, Request $request)
    {
        $this->like->like($id, 1);
 

        return ["user_id" => $id];
    }

    /**
     * いいね解除
     *
     * @param int $id
     */
    public function unLike(int $id, Request $request)
    {
        $this->like->unlike($id, $request->user_id);


        return ["user_id" => $id];
    }
}
