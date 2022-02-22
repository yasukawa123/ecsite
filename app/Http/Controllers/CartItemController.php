<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
// ユーザーIDを取得するために、追加する。ユーザー情報を扱う機能が追加される
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cartitems = CartItem::select('cart_items.*', 'items.name', 'items.amount')
            ->where('user_id', Auth::id())
            ->join('items', 'items.id','=','cart_items.item_id')
            ->get();
        // 合計金額を出すように設定
        $subtotal = 0;
        foreach($cartitems as $cartitem){
            $subtotal += $cartitem->amount * $cartitem->quantity;
        }
        return view('cartitem/index', ['cartitems' => $cartitems, 'subtotal' => $subtotal]);

        // return view('cartitem/index', ['cartitems' => $cartitems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ウェブアプリの「カートに追加」ボタンが押された時に呼び出される機能を、CartItemコントローラのstore()メソッドとして実装します。
        // store()メソッドが呼ばれると、データベースのcart_itemsテーブルに新しいレコードを（行）が追加される。
        // CartItem::updateOrCreate()は、レコードの登録と更新を兼ねるメソッド
        // 例では`user_idとitem_idが一致するレコードがすでに存在していた場合はquantity(数量)を加算し、レコードが存在していなければ新規登録するようにします。
        CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $request->post('item_id'),
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $request->post('quantity') ),
            ]
        );
        // with()に指定した引数の値をセッションデータに保存したうえでリダイレクトします。
        // このセッションデータは一度リダイレクトしたら消えるので、メッセージを一度だけ表示したい時に便利です。
        // ビューにはフラッシュメッセージを表示する部分を追加します。  

        return redirect('/')->with('flash_message', 'カートに追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        //更新用
        $cartItem->quantity = $request->post('quantity');
        $cartItem->save();
        return redirect('cartitem')->with('flash_message', 'カートを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        // カート内の削除
        $cartItem->delete();
        return redirect('cartitem')->with('flash_message', 'カートから削除しました');
    }
}
