<html>
<head>
    <style>
        html {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .page {
            width: 19cm;
            height: 27cm;
            padding: 1cm;
            box-sizing: border-box;
        }

        img {
            width: 60%;
            height: auto;
        }

        table.orderTable {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            width: 100%;
        }

        table.orderTable tr {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        table.orderTable td, table.orderTable th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        table.orderTable th {
            background-color: #ccc;
        }

        hr {
            color: #DBBC25;
            background-color: #DBBC25;
            height: 5px;
            margin: 15px 0;
            border: 0 #DBBC25;
        }

        .address {
            margin-left: 2cm;
        }
    </style>
</head>
<body>
<?php

use App\Models\Shop\ShopOrder;
use App\Support\Helpers;
use Money\Money;

/** @var ShopOrder $order */
?>
@foreach($orders as $order)
    <div class="page">
        <div style="width:100%;text-align:center">
            <img src="{{ asset('/images/dispatch_logo.png') }}"/>
        </div>

        <hr/>

        <table style="width:100%">
            <tr>
                <td style="width:60%;vertical-align:top;">
                    <div class="address">
                        {{ $order->address->name }}<br/>
                        {{ $order->address->line_1 }}<br/>
                        @if($order->address->line_2)
                            {{ $order->address->line_2 }}<br/>
                        @endif
                        @if($order->address->line_3)
                            {{ $order->address->line_3 }}<br/>
                        @endif
                        {{ $order->address->town }}<br/>
                        {{ $order->address->county }}<br/>
                        {{ $order->address->postcode }}<br/>
                        {{ $order->address->country }}
                    </div>
                </td>
                <td>
                    <strong>Return Address</strong><br/>
                    Coeliac Sanctuary<br/>
                    PO Box 643<br/>
                    Crewe<br/>
                    CW1 9LJ<br/>
                    England<br/>
                    contact@coeliacsanctuary.co.uk<br/><br/>
                    <strong>{{ $order->payment->created_at->format('jS F Y') }}</strong><br/>
                    <strong>Order ID: </strong>{{ $order->order_key }}<br/>
                </td>
            </tr>
        </table>
        <hr/>
        <p>Thank you for ordering from Coeliac Sanctuary. Please find details of your order below.</p>
        <table class="orderTable">
            <thead>
            <tr>
                <th style="width:70%;">Item</th>
                <th style="width:15%;">Quantity</th>
                <th style="width:15%;">Cost</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ Helpers::formatMoney(Money::GBP($item->product_price * $item->quantity)) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Subtotal</strong></td>
                <td><strong>{{ Helpers::formatMoney(Money::GBP($order->payment->subtotal)) }}</strong></td>
            </tr>
            @if($order->payment->discount > 0)
                <tr>
                    <td colspan="2"><strong>{{ $order->discountCode->name }}</strong></td>
                    <td><strong>-{{ Helpers::formatMoney(Money::GBP($order->payment->discount)) }}</strong></td>
                </tr>
            @endif
            <tr>
                <td colspan="2"><strong>Postage</strong></td>
                <td><strong>{{ Helpers::formatMoney(Money::GBP($order->payment->postage)) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2"><strong>TOTAL COST</strong></td>
                <td><strong>{{ Helpers::formatMoney(Money::GBP($order->payment->total)) }}</strong></td>
            </tr>
            </tbody>
        </table>
        <hr/>
        <p>Problem with your order? Please contact us via email and quote your order number if you wish to return your
            item within 14 days of delivery.</p>
        <p>For full Terms and Conditions please see www.coeliacsanctuary.co.uk/terms-of-use#shop</p>
    </div>
@endforeach
</body>
</html>
