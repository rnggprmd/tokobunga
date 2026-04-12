<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\CustomRequest;
use Illuminate\Http\Request;

class CustomRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomRequest::with(['user', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customRequests = $query->latest()->paginate(10);
        return view('admin.sales.custom-requests.index', compact('customRequests'));
    }

    public function updateStatus(Request $request, CustomRequest $customRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,in_progress,done',
            'harga_estimasi' => 'nullable|numeric|min:0',
        ]);

        $data = ['status' => $request->status];
        if ($request->filled('harga_estimasi')) {
            $data['harga_estimasi'] = $request->harga_estimasi;
        }

        $customRequest->update($data);
        return back()->with('success', 'Status custom request berhasil diperbarui.');
    }
}
