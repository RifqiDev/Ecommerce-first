<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
           }
    public function processCheckout(Request $request)
    {
        $userId = Auth::id();
        $carts = DB::table('carts')
            ->leftJoin('tbstok', 'tbstok.id', '=', 'carts.product_id')
            ->where('carts.user_id', $userId)
            ->select(
                'carts.*',
                'tbstok.nama as namastok',
                'tbstok.hargajual as jual',
                'tbstok.foto as foto',
                'tbstok.nama as namajenjang'
            )
            ->get();

        // Simpan data ke tabel orders
        $nobukti = 'k' .date('YmdHis'); // Contoh: 202207021605301234


        // Simpan data ke tabel order_items
        foreach ($carts as $cart) {
            DB::table('checkout2')->insert([
                'user_id' => $userId,
                'product_id' => $cart->kode_produk,
                'qty' => $cart->quantity,
                'harga_barang' => $cart->jual,
                'total_harga' => $request->grandTotal,
                'nobukti' => $nobukti

            ]);
        }

        // Hapus semua item dari cart
        DB::table('carts')->where('user_id', $userId)->delete();

        return view('checkout');
    }
    public function sendWhatsAppMessage(Request $request)
    {
        $request->validate([
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Batasan untuk jenis dan ukuran file
        ]);

        $nama_file = [];

        if ($request->hasFile('foto')) {
            $files = $request->file('foto');

            if (is_array($files)) {
                // Jika lebih dari satu file
                foreach ($files as $image) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('path/status'), $filename);
                    $nama_file[] = $filename; // Menambahkan nama file ke dalam array $nama_file
                }
            } else {
                // Jika hanya satu file
                $filename = time() . '_' . $files->getClientOriginalName();
                $files->move(public_path('path/status'), $filename);
                $nama_file[] = $filename; // Menambahkan nama file ke dalam array $nama_file
            }
        }
        $userId = Auth::id();
        $carts = DB::table('checkout2')
            ->leftJoin('tbstok', 'tbstok.id', '=', 'checkout2.product_id')
            ->where('checkout2.user_id', $userId)
            ->select(
                'checkout2.*',
                'tbstok.nama as namastok',
                'tbstok.hargajual as jual',
                'tbstok.foto as foto',
                'tbstok.nama as namajenjang'
            )
            ->get();

            foreach ($carts as $cart) {
                DB::table('status')->insert([
                    'user_id' => $userId,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'harga_barang' => $cart->harga_barang,
                    'total_harga' => $cart->total_harga,
                    'nobukti' => $cart->nobukti,
                    'foto'=> implode(',', $nama_file)

                ]);
            }


            DB::table('checkout2')->where('user_id', $userId)->delete();

            return view('index');
    }
}
