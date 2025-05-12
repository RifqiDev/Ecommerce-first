<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class CartControler extends Controller
{
    public function index( ){


    return view('cart');

    }
    public function addToCart(Request $request, $productId)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil informasi produk
        $product = Product::find($productId);

        // Jika produk tidak ditemukan, kembalikan respons dengan pesan error
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

                    // Simpan barang ke keranjang pengguna
                    $cart = new Cart();
            $cart->user_id = Auth::id();
            $cart->product_id = $product->id;
            $cart->kode_produk = $product->kode;// Simpan kode produk
            $cart->quantity = $request->input('quantity', 1); // Jika tidak ada jumlah yang ditentukan, defaultnya adalah 1
            $cart->save();

        return view('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');

    }

    public function removeFromCart($cartId)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah barang ada di keranjang pengguna
        $cart = Cart::find($cartId);
        if (!$cart) {
            return back()->with('error', 'Barang tidak ditemukan di keranjang.');
        }

        // Pastikan barang yang akan dihapus adalah milik pengguna yang sedang login
        if ($cart->user_id != Auth::id()) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        // Hapus barang dari keranjang
        $cart->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function updateCart($cartId)
{
    $quantity = request('quantity');
    $cart = Cart::find($cartId);

    if (!$cart) {
        return response()->json(['error' => 'Barang tidak ditemukan di keranjang.'], 404);
    }

    // Pastikan barang yang akan diubah adalah milik pengguna yang sedang login
    if ($cart->user_id != Auth::id()) {
        return response()->json(['error' => 'Aksi tidak diizinkan.'], 403);
    }

    // Update kuantitas dan simpan perubahan
    $cart->quantity = $quantity;
    $cart->save();

    return response()->json(['success' => 'Kuantitas berhasil diperbarui.'], 200);
}
}
