<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;

class MarkPaidController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        return $this->service->markAsPaid($id);
    }
}
