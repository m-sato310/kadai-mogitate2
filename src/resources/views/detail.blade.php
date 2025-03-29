<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細ページ</title>
    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>
    <div class="all-contents">
        <form action="/products/{{ $product->id }}/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="top-contents">

                <div class="left-content">
                    <p><span class="span-item">商品一覧></span>{{ $product->name }}</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="店内画像" class="img-content">
                </div>

                <div class="right-content">
                    <label class="name-label" for="product_name">商品名</label>
                    <input class="text" type="text" value="{{ $product->name }}" name="product_name" id="product_name">
                    @error('product_name')
                    <span class="input-error">
                        <p class=input-error-message>{{ $message }}</p>
                    </span>
                    @enderror
                    <label class="price-label" for="product_price">値段</label>
                    <input class="text" type="text" value="{{ $product->price }}" name="product_price" id="product_price">
                    @error('product_price')
                    <span class="input-error">
                        <p class="input-error-message">{{ $message }}</p>
                    </span>
                    @enderror
                    <label class="season-label" for="product_season">季節</label>
                    @foreach ($seasons as $season)
                    <label for="season_{{ $season->id }}">{{ $season->name }}</label>
                    <input type="checkbox" name="product_season[]" value="{{ $season->id }}" id="season_{{ $season->id }}"
                        @if ($product->seasons->contains($season->id)) checked @endif>
                    @endforeach
                    @error('product_season')
                    <span class="input-error">
                        <p class="input-error-message">{{ $message }}</p>
                    </span>
                    @enderror
                </div>

            </div>

            <div class="under-content">
                <input class="image" type="file" name="product_image" id="product_image">
                <label class="description-label" for="product_description">商品説明</label>
                <textarea class="product-description" name="product_description" id="product_description" cols="30" rows="5">{{ $product->description }}</textarea>
                @error('product_description')
                    <span class="input-error">
                        <p class="input-error-message">{{ $message }}</p>
                    </span>
                @enderror

                <div class="button-content">
                    <a class="back" href="/products">戻る</a>
                    <button class="button-change" type="submit">変更を保存</button>

                    <div class="trash-can-content">
                        <a href="/products/{{ $product->id }}/delete" onclick="return confirm('本当に削除しますか?')">
                            <img src="{{ asset('/images/trash-can.png') }}" alt="ゴミ箱の画像" class="img-trash-can">
                        </a>
                    </div>

                </div>

            </div>

        </form>

    </div>
</body>

</html>