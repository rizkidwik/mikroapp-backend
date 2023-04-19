<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;
use App\Models\Product;
use App\Models\User;

class CreateSnapTokenService extends Midtrans
{
	protected $order;

	public function __construct($order)
	{
		parent::__construct();

		$this->order = $order;
	}

	public function getSnapToken()
	{
        $product= Product::find($this->order->product_id);
        $user=User::find($this->order->user_id);
		$params = [
			'transaction_details' => [
				'order_id' => $this->order->order_id,
				'gross_amount' => $product->price,
			],

			'item_details' => [
				[
					'id' => $this->order->product_id, // primary key produk
					'price' => $product->price, // harga satuan produk
					'quantity' => $this->order->quantity, // kuantitas pembelian
					'name' => $product->name, // nama produk
				],
			],
			'customer_details' => [
				// Key `customer_details` dapat diisi dengan data customer yang melakukan order.
				'first_name' => $user->name,
				'email' => $user->email,
				'phone' => $user->phone,
			]
		];

		$snapToken = Snap::getSnapToken($params);

		return $snapToken;
	}
}
