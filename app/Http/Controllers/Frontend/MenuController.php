<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DataRekomendasi;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Category;
use App\Models\table;
use App\Services\TripayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Get recommended items based on item similarity.
     *
     * @param array $cartSkus
     * @return array
     */
    public function index(Request $request)
{
    $categories = Category::with('menus')->get();  
    $tables = Table::all();
    $menus = Menu::all();
    

     // Ambil menu dengan rating tertinggi dari tiap kategori
    $highestRatedMenus = $this->getHighestRatedMenuPerCategory();

    // Filter berdasarkan kategori yang dipilih
    $selectedCategories = $request->input('category', []);

     // Ambil item yang ada di keranjang
    $cart = session()->get('cart', []);
    Log::info('Cart data:', $cart);
    $cartSkus = array_keys($cart);

     // Dapatkan menu rekomendasi berdasarkan item similarity
    $recommendedItems = $this->getRecommendedItems($request->cookie('cust_uid'));
    // Mendapatkan keyword pencarian dari input
    $searchKeyword = $request->input('search'); 

    $query = Menu::query();

    // Filter berdasarkan kategori yang dipilih
    if (!empty($selectedCategories)) {
        $query->whereIn('category_id', $selectedCategories);  // Menggunakan category_id untuk filter menu
    }

    // Filter berdasarkan keyword pencarian
    if ($searchKeyword) {
        $query->where(function($q) use ($searchKeyword) {
            $q->where('name', 'like', '%' . $searchKeyword . '%')
              ->orWhere('description', 'like', '%' . $searchKeyword . '%');
        });
    }

    $menus = $query->get();  // Mendapatkan menu berdasarkan filter

    // Mengirimkan data ke view
    return view('menus.index', compact(
        'categories',
        'tables',
        'menus',
        'selectedCategories',
        'recommendedItems',
        'highestRatedMenus'
    ));
}

        

  public function addToCart(Request $request, $menuId)
{
    // Cek apakah menu ditemukan
    $menu = Menu::findOrFail($menuId);

    // if (!$menu) {
    //     // Jika menu tidak ada, buat menu pajak dengan ID default atau tambahkan menu pajak ke database
    //     $menuId = 0; // ID menu default atau buat entri pajak di menus
    //     $menu = new Menu();
    //     $menu->name = "Pajak 10%";
    //     $menu->price = 2100;
    //     $menu->save(); // Menyimpan item pajak ke menus jika diperlukan
    // }

    // Pastikan menu pajak tidak ditambahkan ke keranjang
    if ($menu->name === 'Pajak 10%') {
        return redirect()->route('menus.index')->with('error', 'Menu pajak tidak dapat ditambahkan ke keranjang.');
    }

    // Melanjutkan penambahan ke keranjang
    $cart = session()->get('cart', []);
    if (isset($cart[$menuId])) {
        $cart[$menuId]['quantity']++;
    } else {
        $cart[$menuId] = [
            'name' => $menu->name,
            'price' => $menu->price,
            'quantity' => 1,
            'image' => $menu->image ?? 'default.jpg',
            'rating' => $menu->rating ?? 0,
        ];
    }
    session()->put('cart', $cart);
    return redirect()->route('menus.index');
}




    public function updateQuantity(Request $request, $menuId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil menu dari keranjang
        $cart = session()->get('cart', []);

        // Update jumlah item yang dipesan
        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] = $request->quantity;
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);
        return redirect()->route('menus.checkout');
    }

    public function checkout(Request $request)
    {
       
        $cart = session()->get('cart');
        if (empty($cart)) {
            return redirect()->route('menus.index')->with('error', 'Keranjang anda kosong!');
        }
        if (auth()->check()) {
            $user = auth()->user();
            Log::info('User is authenticated', ['user_id' => $user->id, 'email' => $user->email]);
        } else {
            Log::info('User is not authenticated');
        }

        // Hitung total harga tanpa pajak
            $total = 0;
            foreach ($cart as $item) {
                if ($item['name'] !== 'Pajak 10%') {  // Abaikan menu pajak
                    $total += $item['price'] * $item['quantity'];
                }
            }

             // Menghitung pajak 10% berdasarkan subtotal
            $tax = $total * 0.10;  // 10% pajak
            $totalWithTax = $total + $tax;  // Total dengan pajak

             Log::info('Checkout initiated', [
            'cart' => $cart,
            'total' => $total,
            'tax' => $tax,
            'totalWithTax' => $totalWithTax,
        ]);
        $tables = Table::all(); // Mengambil semua meja dari database
        
        // Ambil daftar channel pembayaran dari TripayService
        $channelsPayment = app(TripayService::class)->getPaymentChannels();
        Log::info('Checkout initiated', [
            'cart' => $cart,
            'tables' => $tables->toArray(),
            'channelsPayment' => $channelsPayment,
        ]);

        
        return view('menus.checkout', compact('cart', 'tables', 'channelsPayment', 'total', 'tax', 'totalWithTax'));
    }


    public function removeFromCart($menuId)
    {
        // Ambil keranjang dari session
        $cart = session()->get('cart', []);

        // Jika item ada di keranjang, hapus item tersebut
        if (isset($cart[$menuId])) {
            unset($cart[$menuId]);
        }

        // Simpan keranjang yang diperbarui ke session
        session()->put('cart', $cart);

        // Arahkan kembali ke halaman menu dengan pesan sukses
        return redirect()->route('menus.index')->with('success', 'Item removed from cart!');
    }





    // Menampilkan daftar order milik user (atau berdasarkan session/email)
    public function orders(Request $request)
    {
        // Jika user login, bisa pakai Auth::user()->email, jika tidak pakai session/email dari order
        $email = $request->session()->get('customer_email');
        $orders = Order::where('email', $email)->orderByDesc('created_at')->get();
        return view('menus.orders', compact('orders'));
    }


    private function calculateTotalPrice($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $tax = $total * 0.10; // Pajak 10%
        return $total + $tax;
    }

    public function summary($orderId)
    {
        $order = Order::with(['orderItems', 'menus', 'table'])->findOrFail($orderId);
        $payment = DB::table('payment_transactions')->where('order_id', $order->id)->latest()->first();
        $fee_customer = $payment->fee_customer ?? 0;
        $merchantCode = config('services.tripay.merchant_code');
        // Hapus session cart setelah order sukses
        session()->forget('cart');
        return view('menus.summary', compact('order', 'payment', 'merchantCode', 'fee_customer'));
    }

    // Fungsi untuk mengurangi quantity menu di cart
    public function decreaseQuantity($menuId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$menuId])) {
            if ($cart[$menuId]['quantity'] > 1) {
                $cart[$menuId]['quantity']--;
            } else {
                unset($cart[$menuId]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('menus.index')->with('success', 'Item quantity updated!');
    }
    /**
     * Get recommended items based on the menu ID.
     *
     * @param int $menuId
     * @return \Illuminate\Http\JsonResponse
     */    
public function getRecommendedItems($cust_uid)
{
    // // Jika tidak ada item di keranjang, kembalikan koleksi kosong
    // if (empty($cartSkus)) {
    //     return collect();
    // }

    // // Jika hanya ada satu item di keranjang, rekomendasikan berdasarkan popularitas
    // if (count($cartSkus) == 1) {
    //     return $this->getPopularItems();  // Fungsi untuk mengambil menu populer
    // }

    // // Tentukan jumlah pesanan minimum (3 kali lebih banyak dari pesanan item di keranjang)
    // $minOrders = 3;

    // // Ambil pasangan item yang mirip, mengecualikan 'TAX10'
    // $similarPairs = DB::table('item_similarities')
    //     ->whereIn('menu_id_1', $cartSkus)
    //     ->orWhereIn('menu_id_2', $cartSkus)
    //     ->whereNotIn('menu_id_1', ['TAX10'])
    //     ->whereNotIn('menu_id_2', ['TAX10'])
    //     ->orderBy('similarity_score', 'desc')
    //     ->limit(10)
    //     ->get();

    // $similarSkus = [];
    // foreach ($similarPairs as $pair) {
    //     if (in_array($pair->menu_id_1, $cartSkus)) {
    //         $similarSkus[] = $pair->menu_id_2;
    //     }
    //     if (in_array($pair->menu_id_2, $cartSkus)) {
    //         $similarSkus[] = $pair->menu_id_1;
    //     }
    // }

    // // Mengambil rekomendasi unik yang tidak ada di keranjang
    // $uniqueRecommendedSkus = array_diff(array_unique($similarSkus), $cartSkus);

    // // Jika ada rekomendasi yang valid
    // if (!empty($uniqueRecommendedSkus)) {
    //     $recommendedItems = Menu::whereIn('sku', $uniqueRecommendedSkus)
    //         ->inRandomOrder()
    //         ->limit(3)
    //         ->get();

    //     // Jika rekomendasi kurang dari 3, tambahkan menu lainnya secara acak
    //     if ($recommendedItems->count() < 3) {
    //         $additionalItems = Menu::whereNotIn('sku', $uniqueRecommendedSkus)
    //             ->inRandomOrder()
    //             ->limit(3 - $recommendedItems->count())
    //             ->get();

    //         $recommendedItems = $recommendedItems->merge($additionalItems);
    //     }

    //     return $recommendedItems;
    // }

    // // Jika tidak ada rekomendasi, kembalikan koleksi kosong
    // return collect();
    $rekomendasi = collect();
    $db = DataRekomendasi::where('cust_uid',$cust_uid)->first();
    if($db == null){
        return $rekomendasi;
    }
    foreach(explode(",",$db["menu_id"]) as $a){
        $hasil = Menu::where('id',$a)->first();
        $rekomendasi->push($hasil);
    }
    return $rekomendasi;
}

// Fungsi untuk mendapatkan menu populer
private function getPopularItems()
{
    // Mendapatkan menu yang paling sering dipesan
    return DB::table('order_items')
        ->select('menu_id', DB::raw('COUNT(*) as order_count'))
        ->groupBy('menu_id')
        ->orderBy('order_count', 'desc')  // Urutkan berdasarkan jumlah pesanan
        ->limit(3)
        ->pluck('menu_id')
        ->map(function ($menuId) {
            return Menu::find($menuId);
        });
}

public function getHighestRatedMenuPerCategory()
{
    // Ambil kategori yang ada
    $categories = Category::all();

    $highestRatedMenus = [];

    foreach ($categories as $category) {
        // Ambil menu dengan rating tertinggi di setiap kategori
        $highestRatedMenu = Menu::where('category_id', $category->id)
            ->orderBy('rating', 'desc')  // Urutkan berdasarkan rating tertinggi
            ->first();  // Ambil hanya menu pertama (rating tertinggi)

        if ($highestRatedMenu) {
            $highestRatedMenus[$category->id] = $highestRatedMenu;
        }
    }

    return $highestRatedMenus;
}

public function updateMenuRating($menuId)
{
    // Ambil semua rating dari tabel user_menu_rekomendasis (atau tabel lain yang menyimpan rating)
    $ratings = DB::table('user_menu_rekomendasis')
        ->where('menu_id', $menuId)
        ->pluck('rating');  // Ambil semua rating untuk menu ini

    if ($ratings->isNotEmpty()) {
        // Hitung rata-rata rating
        $averageRating = $ratings->avg();  // Fungsi avg() menghitung rata-rata

        // Update rating pada tabel menus
        Menu::where('id', $menuId)
            ->update(['rating' => $averageRating]);  // Update rating dengan rata-rata
    }
}

public function storeFeedback(Request $request, $menuId)
{
    // Validasi rating yang diterima dari pengguna
    $request->validate([
        'rating' => 'required|numeric|min:1|max:5',  // Rating harus antara 1 dan 5
    ]);

    // Simpan rating baru di tabel user_menu_rekomendasis
    DB::table('user_menu_rekomendasis')->insert([
        'user_id' => auth()->id(),  // ID pengguna
        'menu_id' => $menuId,  // ID menu yang diberi rating
        'rating' => $request->rating,  // Rating yang diberikan
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Update rating menu berdasarkan rata-rata rating
    $this->updateMenuRating($menuId);

    // Redirect atau beri feedback kepada pengguna
    return redirect()->back()->with('success', 'Rating berhasil diberikan');
}



}
