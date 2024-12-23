<div>
    <div class="form-group mb-3">
        <label for="country" class="fw-bold">Country</label>
        <select wire:model.live="country" id="country" class="form-control" required>
            <option value="">Select Country</option>
            @foreach($countries as $countryOption)
            <option value="{{ $countryOption['code'] }}">{{ $countryOption['name'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="city" class="fw-bold">City</label>

        <select wire:model.live="city" id="city" class="form-control" required>
            <option value="">Select City</option>
            @foreach($cities as $cityOption)
            <option value="{{ $cityOption['name'] }}">{{ $cityOption['name'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="checkout-total mt-4">
        <h4 class="fw-bold">Total Amount</h4>
        <div class="form-group d-flex justify-content-between">
            <label>Shipping Fee:</label>
            <span>{{ $shippingFee ? '$'.number_format($shippingFee, 2) : 'Not calculated' }}</span>
        </div>

        @if($error)
        <div class="alert alert-danger mt-2">{{ $error }}</div>
        @endif

        @if($selectedZone)
        <div class="alert alert-info mt-2">
            Shipping Zone: {{ $selectedZone }}
        </div>
        @endif

        <div class="d-flex justify-content-between mt-2">
            <strong>Total with shipping:</strong>
            <strong>${{ number_format($totalWithShipping, 2) }}</strong>
        </div>
    </div>
</div>