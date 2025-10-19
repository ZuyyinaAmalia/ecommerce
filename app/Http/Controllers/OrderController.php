<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan semua pesanan
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|in:pending,processing,completed'
        ]);

        try {
            $order = Order::findOrFail($id);
            
            // Simpan status lama untuk logging (opsional)
            $oldStatus = $order->status;
            
            // Update status
            $order->update(['status' => $request->status]);

            return redirect()->route('orders.index')
                ->with('success', "Status pesanan berhasil diubah dari {$oldStatus} menjadi {$request->status}!");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pesanan
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Cek apakah pesanan sudah completed
            if ($order->status === 'completed') {
                return redirect()->back()
                    ->with('error', 'Pesanan yang sudah selesai tidak bisa dihapus!');
            }
            
            // Hapus order items dulu (jika belum cascade delete)
            $order->items()->delete();
            
            // Hapus order
            $order->delete();

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Detail index dengan filter
     */
    public function detailsIndex(Request $request)
    {
        $query = Order::with(['items.product', 'user']);

        // Filter search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('items.product', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%")
                ->orWhereHas('user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')
                        ->paginate(5)
                        ->withQueryString();

        return view('admin.details.index', compact('orders'));
    }

    /**
     * Detail show
     */
    public function detailsShow($id)
    {
        $details = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.details.show', compact('details'));
    }

    public function success(Request $request)
    {
        return view('order.success', [
            'session_id' => $request->get('session_id')
        ]);
    }

    public function cancel()
    {
        return view('order.cancel');
    }
}
