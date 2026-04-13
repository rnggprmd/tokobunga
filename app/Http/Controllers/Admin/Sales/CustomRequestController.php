<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\CustomRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CustomRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomRequest::with(['user', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $numericSearch = preg_replace('/[^0-9]/', '', $search);

            $query->where(function ($q) use ($search, $numericSearch) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('product_category', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
                
                if (!empty($numericSearch)) {
                    $q->orWhere('id', $numericSearch);
                }
            });
        }

        $customRequests = $query->latest()->paginate(10);
        return view('admin.sales.custom-requests.index', compact('customRequests'));
    }

    public function create()
    {
        $users = User::where('role', 'customer')->get();
        return view('admin.sales.custom-requests.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'product_category' => 'nullable|string|max:255',
            'keterangan' => 'required|string',
            'harga_estimasi' => 'nullable|numeric|min:0',
            'foto_referensi' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto_referensi');
        
        if ($request->hasFile('foto_referensi')) {
            $data['foto_referensi'] = $request->file('foto_referensi')->store('custom_requests', 'public');
        }

        CustomRequest::create($data);

        return redirect()->route('admin.custom-requests.index')->with('success', 'Custom Request berhasil dibuat.');
    }

    public function edit(CustomRequest $customRequest)
    {
        return view('admin.sales.custom-requests.edit', compact('customRequest'));
    }

    public function update(Request $request, CustomRequest $customRequest)
    {
        $customRequest->update($request->all());
        return redirect()->route('admin.custom-requests.index')->with('success', 'Custom Request berhasil diperbarui.');
    }

    public function destroy(CustomRequest $customRequest)
    {
        $customRequest->delete();
        return redirect()->route('admin.custom-requests.index')->with('success', 'Custom Request berhasil dihapus.');
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
