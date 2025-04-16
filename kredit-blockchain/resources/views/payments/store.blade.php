@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payment Store</h1>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="credit_card">Credit Card</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
</div>
@endsection