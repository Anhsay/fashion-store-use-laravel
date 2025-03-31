<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
</head>
<body>
    <h1>Thêm sản phẩm mới</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/products') }}" method="POST">
        @csrf
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" required><br><br>

        <label for="price">Giá:</label>
        <input type="number" name="price" required><br><br>

        <label for="image_url">Link ảnh:</label>
        <input type="text" name="image_url" required><br><br>

        <label for="description">Mô tả:</label>
        <textarea name="description"></textarea><br><br>

        <button type="submit">Thêm sản phẩm</button>
    </form>
s
    <br>
    <a href="{{ url('/products') }}">Quay lại danh sách sản phẩm</a>
</body>
</html>
