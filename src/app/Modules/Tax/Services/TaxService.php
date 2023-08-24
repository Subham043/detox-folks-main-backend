<?php

namespace App\Modules\Tax\Services;

use App\Modules\Tax\Models\Tax;

class TaxService
{

    public function getById(Int $id): Tax|null
    {
        return Tax::where('id', $id)->first();
    }

    public function getBySlug(): Tax|null
    {
        return Tax::where('tax_slug', 'tax')->first();
    }

    public function createOrUpdate(array $data): Tax
    {
        $tax = Tax::updateOrCreate(
            ['tax_slug' => 'tax'],
            [...$data]
        );

        $tax->user_id = auth()->user()->id;
        $tax->save();

        return $tax;
    }

}
