@extends('customer.layout-app.layout')
@section('content')
<h1>Đánh giá sản phẩm</h1>
<div>
    <form action="{{ route('orders.submit-review', ['orderId' => $order->id]) }}" method="POST" enctype="multipart/form-data" class="form-review">
        @csrf
        @foreach ($order->orderItems as $orderItem)
        <div class="item-review">
            <div class="image-review">
                <img src="{{ asset($orderItem->product->images[0]->image_path) }}" alt="hình ảnh của $orderItem->product->name" />
            </div>
            <div class="review-item">
                <h2>{{ $orderItem->product->name }}</h2>
                <label for="rating-{{ $orderItem->product->id }}">Bạn hài lòng với sản phẩm như thế nào?</label>
                <select name="reviews[{{ $orderItem->product->id }}][rating]" id="rating-{{ $orderItem->product->id }}">
                    <option value="1">1 sao</option>
                    <option value="2">2 sao</option>
                    <option value="3">3 sao</option>
                    <option value="4">4 sao</option>
                    <option value="5">5 sao</option>
                </select>
                <label for="comment-{{ $orderItem->product->id }}">Bạn có nhận xét gì về sản phẩm không? </label>
                <textarea name="reviews[{{ $orderItem->product->id }}][comment]" id="comment-{{ $orderItem->product->id }}" require></textarea>
                <label for="image-{{ $orderItem->product->id }}">Hình ảnh đánh giá về sản phẩm:</label>
                <input type="file" name="reviews[{{ $orderItem->product->id }}][images][]" id="images-{{ $orderItem->product->id }}" multiple onchange="previewImages(event, '{{ $orderItem->product->id }}')">
                <div id="preview-{{ $orderItem->product->id }}" class="image-preview"></div>
            </div>
        </div>
        @endforeach
        <button type="submit" class="button light-text">Gửi đánh giá</button>
    </form>
</div>
@endsection
<script>
    function previewImages(event, productId) {
        const preview = document.getElementById(`preview-${productId}`);
        preview.innerHTML = '';
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    }
</script>