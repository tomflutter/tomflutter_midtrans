<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

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
		$params = [
			/**
			 * 'order_id' => id order unik yang akan digunakan sebagai "primary key" oleh Midtrans untuk
			 * 				 membedakan order satu dengan order lain. Key ini harus unik (tidak boleh ada duplikat).
			 * 'gross_amount' => merupakan total harga yang harus dibayar customer.
			 */
			'transaction_details' => [
				'order_id' => $this->order->number,
				'gross_amount' => $this->order->total_price,
			],
			/**
			 * 'item_details' bisa diisi dengan detail item dalam order.
			 * Umumnya, data ini diambil dari tabel `order_items`.
			 */
			'item_details' => [
				[
					'id' => 1, // primary key produk
					'price' => '150000', // harga satuan produk
					'quantity' => 1, // kuantitas pembelian
					'name' => 'Gorengan', // nama produk
				],
				[
					'id' => 2,
					'price' => '60000',
					'quantity' => 2,
					'name' => 'Tahu isi',
				],
			],
			'customer_details' => [
				// Key `customer_details` dapat diisi dengan data customer yang melakukan order.
				'first_name' => 'My Love flutter',
				'email' => 'tomflutter@asia.com',
				'phone' => '081122334455',
			]
		];

		$snapToken = Snap::getSnapToken($params);

		return $snapToken;
	}
}
