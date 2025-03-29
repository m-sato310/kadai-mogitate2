<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録ページ</title>
    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <main class="main-contents">
        <h1>商品登録</h1>
        <form action="/products/upload" method="post" enctype="multipart/form-data">
            @csrf
            <label class="label" for="product_name">商品名<span class="require">必須</span></label>
            <input class="text" type="text" placeholder="商品名を入力" name="product_name" id="product_name">
            @error('product_name')
            <span class="input-error">
                <p class=input_error_message>{{ $message }}</p>
            </span>
            @enderror
            <label class="label" for="product_price">値段<span class="require">必須</span></label>
            <input class="text" type="text" placeholder="値段を入力" name="product_price" id="product_price">
            @error('product_price')
            <span class="input_error">
                <p class="input_error_message">{{ $message }}</p>
            </span>
            @enderror
            <label for="product_image">商品画像<span class="require">必須</span></label>
            <output class="image_output" id="list"></output>
            <input type="file" name="product_image" id="product_image">
            @error('product_image')
            <span class="input_error">
                <p class="input_error_message">{{ $message }}</p>
            </span>
            @enderror
            <label class="label">季節<span class="require">必須</span><span class="note">複数選択可</span></label>
            @foreach ($seasons as $season)
            <input type="checkbox" id="season_{{ $season->id }}" value="{{ $season->id }}" name="product_season[]">
            <label for="season">{{ $season->name }}</label>
            @endforeach
            @error('product_season')
            <span class="input_error">
                <p class="input_error_message">{{ $message }}</p>
            </span>
            @enderror
            <label class="label" for="product_description">商品説明<span class="require">必須</span></label>
            <textarea class="textarea" name="product_description" id="product_description" placeholder="商品の説明を入力" cols="30" rows="5"></textarea>
            @error('product_description')
            <span class="input_error">
                <p class="input_error_message">{{ $message }}</p>
            </span>
            @enderror
            <div class="button-content">
                <a class="back" href="/products">戻る</a>
                <button class="button-register" type="submit">登録</button>
            </div>
        </form>
    </main>
    <script>
        document.getElementById('product_image').onchange = function(event) {

            initializeFiles();

            var files = event.target.files;

            for (var i = 0, f; f = files[i]; i++) {
                var reader = new FileReader;
                reader.readAsDataURL(f);

                reader.onload = (function(theFile) {
                    return function (e) {
                        var div = document.createElement('div');
                        div.className = 'reader_file';
                        div.innerHTML += '<img class="reader_image" src="' + e.target.result + '" />';
                        document.getElementById('list').insertBefore(div,
                     null);
                    }
                })(f);
            }
        };

        function initializeFiles() {
            document.getElementById('list'),innerHTML = '';
        }
        
    </script>
</body>

</html>