<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Authorize access to an invoice.
     * - Authenticated users may only view their own invoices.
     * - Guest orders (user_id = null) are accessible only if the request
     *   includes the matching customer email (lightweight ownership proof).
     */
    private function authorizeInvoiceAccess(Order $order): void
    {
        // If order has a registered user, only that user (or admin) can access
        if ($order->user_id !== null) {
            if (!Auth::check() || Auth::id() !== $order->user_id) {
                // Allow admins to bypass
                if (!Auth::check() || !Auth::user()->isAdmin()) {
                    abort(403, 'Anda tidak memiliki akses ke invoice ini.');
                }
            }
            return;
        }

        // Guest order: require matching email as proof of ownership
        $email = request()->query('email');
        if (!$email || strtolower($email) !== strtolower($order->customer_email)) {
            abort(403, 'Akses invoice memerlukan verifikasi email pemesan.');
        }
    }

    /**
     * Display the specified invoice.
     */
    public function show(Order $order)
    {
        if (!$order->invoice) {
            abort(404, 'Invoice belum tersedia.');
        }

        $this->authorizeInvoiceAccess($order);

        $order->load(['items.product', 'user', 'pembayaran', 'pengiriman', 'invoice']);

        return view('invoice.show', compact('order'));
    }

    /**
     * Download the specified invoice as PDF.
     */
    public function download(Order $order)
    {
        if (!$order->invoice) {
            abort(404, 'Invoice belum tersedia.');
        }

        $this->authorizeInvoiceAccess($order);

        $order->load(['items.product', 'user', 'pembayaran', 'pengiriman', 'invoice']);

        $pdf = Pdf::loadView('invoice.pdf', compact('order'))->setPaper('a4', 'portrait');
        
        return $pdf->download($order->invoice->invoice_number . '.pdf');
    }
}
