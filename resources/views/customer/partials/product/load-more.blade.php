@foreach ($products as $product)
    <div class="trending-prods_cards">
        <div class="card-image">
            @if ($product->images->isNotEmpty())
                @php
                    $firstImage = $product->images->first();
                @endphp
                <img src="{{ asset('storage/' . $firstImage->image_path) }}" alt="{{ $product->name }}">
            @else
                <img src="N/A" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="cards_contain">
            <a class="cards_name-prod">{{ $product->name }}</a>
            <div class="cards_desc-prod">
                {{ $product->description }}
            </div>
            <div class="cards_price-prod">{{ $product->price }} VND</div>
        </div>
    </div>
@endforeach