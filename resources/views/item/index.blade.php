@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        {{-- @foreach ($items as $item)～@endforeachの部分でコントローラから受け取ったitemsから商品情報を一つずつ取り出して表示する --}}
        @foreach ($items as $item)
        <div class="col-md-4 mb-2">
            <div class="card">
                <!-- 下記で商品名を取得 -->
                <div class="card-header">{{ $item->name }}</div>
                <div clas="card-body">
                    <!-- 下記で商品の価格を取得 -->
                    {{ $item->amount }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
