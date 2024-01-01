<?php

declare(strict_types=1);

return [
    'cache' => [
        'blogs' => [
            'home' => 'blogs.home',
        ],
        'recipes' => [
            'home' => 'recipes.home',
        ],
    ],

    'images_url' => env('IMAGES_URL'),

    'shop' => [
        'product_postage_description' => <<<'TEXT'
            <ul>
                <li>Orders are only processed on normal UK working days.</li>
                <li>
                    <strong>UK</strong>
                    <ul>
                        <li>All orders are sent by Royal Mail First Class Post</li>
                        <li>All orders usually dispatched within 2 working days.</li>
                        <li>You will receive an email when your order has been dispatched.</li>
                        <li>Royal Mail state that 90% of orders will be delivered next working day.</li>
                    </ul>
                </li>
                <li>
                    <strong>Rest of the world</strong>
                    <ul>
                        <li>All orders are sent by Royal Mail International Standard Post</li>
                        <li>All orders usually dispatched within 2 working days.</li>
                        <li>You will receive an email when your order has been dispatched.</li>
                    </ul>
                </li>
            </ul>
            TEXT,
    ],
];
