<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display the specified invoice.
     */
    public function show(Order $order)
    {
        $this->authorizeAccess($order);

        if (!$order->invoice) {
            abort(404, 'Invoice belum tersedia.');
        }

        $order->load(['items.product', 'user', 'pembayaran', 'pengiriman', 'invoice']);

        return view('invoice.show', compact('order'));
    }

    /**
     * Download the specified invoice as PDF.
     */
    public function download(Order $order)
    {
        $this->authorizeAccess($order);

        if (!$order->invoice) {
            abort(404, 'Invoice belum tersedia.');
        }

        $order->load(['items.product', 'user', 'pembayaran', 'pengiriman', 'invoice']);

        $pdf = Pdf::loadView('invoice.pdf', compact('order'))->setPaper('a4', 'portrait');
        
        return $pdf->download($order->invoice->invoice_number . '.pdf');
    }

    /**
     * Authorize access to the invoice.
     * Customers can only see their own orders.
     * Admins can see all orders.
     */
    private function authorizeAccess(Order $order)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $user = Auth::user();

        if ($user->role !== 'admin' && $order->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengakses invoice ini.');
        }
    }
}
