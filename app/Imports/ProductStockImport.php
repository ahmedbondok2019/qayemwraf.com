<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductStockImport implements ToCollection, WithHeadingRow
{
    public $successful = 0;
    public $failed = 0;
    public $total = 0;
    public $details = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->total++;
            $sku = $row['sku'] ?? null;
            $quantity = $row['quantity'] ?? null;

            if (!$sku || !is_numeric($quantity)) {
                $this->failed++;
                $this->details[] = [
                    'sku' => $sku,
                    'quantity' => $quantity,
                    'status' => 'failed',
                    'reason' => 'Invalid SKU or quantity'
                ];
                continue;
            }

            $product = Product::where('sku', $sku)->first();

            if ($product) {
                $old_qty = $product->quantity;
                $product->quantity += (int)$quantity;
                $product->save();

                $this->successful++;
                $this->details[] = [
                    'sku' => $sku,
                    'added' => $quantity,
                    'old_qty' => $old_qty,
                    'new_qty' => $product->quantity,
                    'status' => 'success'
                ];
            } else {
                $this->failed++;
                $this->details[] = [
                    'sku' => $sku,
                    'quantity' => $quantity,
                    'status' => 'failed',
                    'reason' => 'Product not found'
                ];
            }
        }
    }
}
