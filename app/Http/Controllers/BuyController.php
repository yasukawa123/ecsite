<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// まずstore()アクションの引数でIlluminate\Http\Requestクラスを$requestという変数として受け取る。
// これで$requestによりフォームからの入力を受け取る。
use Illuminate\Support\Facades\Auth; //追加

class BuyController extends Controller
{
    public function index()
    {
        $cartitems = CartItem::select('cart_items.*', 'items.name', 'items.amount')
            ->where('user_id', Auth::id())
            ->join('items', 'items.id','=','cart_items.item_id')
            ->get();
        // カート内の商品合計を計算
        $subtotal = 0;
        foreach($cartitems as $cartitem){
            $subtotal += $cartitem->amount * $cartitem->quantity;
        }
        return view('buy/index', ['cartitems' => $cartitems, 'subtotal' => $subtotal]);
    }

    public function store(Request $request)
    {
        // 入力した郵送先の情報を処理する
        // if( !$request->has('post') ){...}でフォームからのリクエストパラメータにpostという値が含まれているかどうかを判定
        // postが含まれている場合は注文を確定する処理を実行します。
        // postが含まれていなければもう一度購入画面を表示して、ビュー側で入力確認用の表示に切り替える事にします。
        if( $request->has('post') ){
            CartItem::where('user_id', Auth::id())->delete();
            return view('buy/complete');
        }
        $request->flash();
        return $this->index();
    }


}
