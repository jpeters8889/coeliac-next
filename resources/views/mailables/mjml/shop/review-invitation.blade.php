@php
    use App\Models\Shop\ShopOrder;
    /** @var ShopOrder $order */
@endphp

@extends('mailables.mjml.layout')

@push('head')
    <mj-style>
        @media only screen and (min-width: 480px) { *[class~=prod-image] { padding-right: 10px !important;} }
    </mj-style>
@endpush

@section('header')
    <h2 style="padding: 5px 0">Review your order!</h2>
@endsection

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner">Hey {{ $order->address->name }}</mj-text>
            <mj-text mj-class="inner">
                Thanks again for your recent order, I hope it arrived with you quickly!
            </mj-text>
            <mj-text mj-class="inner">
                If you have a couple of minutes, I'd love to read your feedback about my products, and to share your feedback on our website to help other potential buyers.
            </mj-text>
            <mj-text mj-class="inner">
                This email was automatically sent {{ $delayText }} after your order was dropped in the postbox, if you haven't received your order yet, please let me know and I'll try my best to sort it out for you, hopefully its not got lost in the post somewhere!
            </mj-text>
            <mj-text mj-class="inner">
                To leave a review, click the button below!
            </mj-text>
            <mj-button href="{{ $reviewLink }}">
                Leave A Review!
            </mj-button>
            <mj-text mj-class="inner">
                If you cant see the button above copy the link below into your browser
            </mj-text>
            <mj-text mj-class="inner">
                {{ $reviewLink }}
            </mj-text>
            <mj-text mj-class="inner" padding-top="10px">
                Thanks again, Alison - Coeliac Sanctuary
            </mj-text>
        </mj-column>
    </mj-section>
@endsection
