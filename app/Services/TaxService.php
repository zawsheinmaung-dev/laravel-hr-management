<?php

namespace App\Services;

use App\Models\TaxBracket;

class TaxService
{
    public function index_get()
    {
        return TaxBracket::all();
    }

    public function tax_view($id)
    {
        return TaxBracket::findOrFail($id);
    }

    public function store_tax($data)
    {
        TaxBracket::create($data);
    }

    public function update_tax($id,$data)
    {
        $tax =TaxBracket::findOrFail($id);
        $tax->update($data);
    }

    public function tax_delete($id)
    {
        $tax =TaxBracket::findOrFail($id);
        $tax->delete();
    }
}