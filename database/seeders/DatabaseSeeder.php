<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@fashionmarket.com'],
            [
                'name' => 'Admin FashionMarket',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08111222333',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'status' => 'active',
            ]
        );

        $seller1 = User::firstOrCreate(
            ['email' => 'batiqueen@fashionmarket.com'],
            [
                'name' => 'Batik Queen Studio',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'phone' => '081234567890',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
                'status' => 'active',
            ]
        );

        $seller2 = User::firstOrCreate(
            ['email' => 'urbanstyle@fashionmarket.com'],
            [
                'name' => 'Urban District Wear',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'phone' => '081298765432',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'status' => 'active',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'buyer@fashionmarket.com'],
            [
                'name' => 'Rian Pratama',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '081345678901',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'status' => 'active',
            ]
        );

        // 2. Categories
        $categoriesData = [
            ['name' => 'Pria', 'slug' => 'pria', 'icon' => 'fa-solid fa-shirt'],
            ['name' => 'Wanita', 'slug' => 'wanita', 'icon' => 'fa-solid fa-person-dress'],
            ['name' => 'Hijab & Muslim', 'slug' => 'hijab-muslim', 'icon' => 'fa-solid fa-star-and-crescent'],
            ['name' => 'Streetwear', 'slug' => 'streetwear', 'icon' => 'fa-solid fa-fire'],
            ['name' => 'Sepatu & Sneakers', 'slug' => 'sepatu-sneakers', 'icon' => 'fa-solid fa-shoe-prints'],
            ['name' => 'Aksesoris & Tas', 'slug' => 'aksesoris-tas', 'icon' => 'fa-solid fa-bag-shopping'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Products
        $productsData = [
            [
                'seller' => $seller1,
                'category' => $categories['wanita'],
                'name' => 'Batik Silk Modern Peplum Blouse',
                'slug' => 'batik-silk-modern-peplum-blouse',
                'description' => 'Blouse batik sutra premium dengan potongan peplum kontemporer. Motif parang geometris elegan yang cocok untuk acara formal, pesta, maupun kantor. Bahan adem, jatuh anggun, dan tidak mudah kusut.',
                'price' => 389000,
                'images' => [
                    'https://images.unsplash.com/photo-1551803091-e20673f15770?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'S', 'color' => 'Navy Gold', 'stock' => 15],
                    ['size' => 'M', 'color' => 'Navy Gold', 'stock' => 20],
                    ['size' => 'L', 'color' => 'Navy Gold', 'stock' => 12],
                    ['size' => 'M', 'color' => 'Maroon Ruby', 'stock' => 18],
                    ['size' => 'L', 'color' => 'Maroon Ruby', 'stock' => 10],
                ],
            ],
            [
                'seller' => $seller1,
                'category' => $categories['pria'],
                'name' => 'Kemeja Batik Tulis Prabuseno Lengan Panjang',
                'slug' => 'kemeja-batik-tulis-prabuseno-lengan-panjang',
                'description' => 'Kemeja batik pria eksklusif katun primissima lapis furing Hero. Jahitan tailor rapi, pola presisi bersambung di bagian kancing. Memberikan aura wibawa dan karismatik.',
                'price' => 450000,
                'images' => [
                    'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'M', 'color' => 'Hitam Tembaga', 'stock' => 25],
                    ['size' => 'L', 'color' => 'Hitam Tembaga', 'stock' => 30],
                    ['size' => 'XL', 'color' => 'Hitam Tembaga', 'stock' => 15],
                    ['size' => 'M', 'color' => 'Cokelat Klasik', 'stock' => 14],
                    ['size' => 'L', 'color' => 'Cokelat Klasik', 'stock' => 16],
                ],
            ],
            [
                'seller' => $seller2,
                'category' => $categories['streetwear'],
                'name' => 'Oversized Heavyweight Vintage Hoodie 400 GSM',
                'slug' => 'oversized-heavyweight-vintage-hoodie-400-gsm',
                'description' => 'Hoodie streetwear premium dengan gramasi 400 GSM French Terry 100% Cotton. Potongan boxy drop shoulder kekinian dengan efek acid wash vintage yang unik dan tebal.',
                'price' => 345000,
                'images' => [
                    'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1509967419530-da38b4704bc6?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'M', 'color' => 'Washed Charcoal', 'stock' => 20],
                    ['size' => 'L', 'color' => 'Washed Charcoal', 'stock' => 25],
                    ['size' => 'XL', 'color' => 'Washed Charcoal', 'stock' => 15],
                    ['size' => 'M', 'color' => 'Bone White', 'stock' => 18],
                    ['size' => 'L', 'color' => 'Bone White', 'stock' => 22],
                ],
            ],
            [
                'seller' => $seller2,
                'category' => $categories['streetwear'],
                'name' => 'Tactical Cargo Pants Multi-Pocket Relaxed Fit',
                'slug' => 'tactical-cargo-pants-multi-pocket-relaxed-fit',
                'description' => 'Celana cargo gaya urban techwear dengan bahan twill stretch ripstop tahan lama. Dilengkapi 6 kantong fungsional dengan resleting YKK dan tali serut di bagian pergelangan kaki.',
                'price' => 299000,
                'images' => [
                    'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1517445312882-bc9910d016b7?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'M', 'color' => 'Army Green', 'stock' => 15],
                    ['size' => 'L', 'color' => 'Army Green', 'stock' => 20],
                    ['size' => 'M', 'color' => 'Midnight Black', 'stock' => 30],
                    ['size' => 'L', 'color' => 'Midnight Black', 'stock' => 25],
                ],
            ],
            [
                'seller' => $seller1,
                'category' => $categories['hijab-muslim'],
                'name' => 'Abaya Silk Dubai Minimalist Embroidery',
                'slug' => 'abaya-silk-dubai-minimalist-embroidery',
                'description' => 'Gamis Abaya bergaya Dubai dengan bahan silky nida impor yang sangat sejuk dan mewah. Dilengkapi bordir minimalis benang emas di manset tangan dan tepian kerah. Busui dan wudhu friendly.',
                'price' => 495000,
                'images' => [
                    'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'All Size', 'color' => 'Jet Black', 'stock' => 40],
                    ['size' => 'All Size', 'color' => 'Dusty Rose', 'stock' => 25],
                    ['size' => 'All Size', 'color' => 'Sage Olive', 'stock' => 20],
                ],
            ],
            [
                'seller' => $seller2,
                'category' => $categories['sepatu-sneakers'],
                'name' => 'Retro Heritage Leather Sneakers Cream Gum',
                'slug' => 'retro-heritage-leather-sneakers-cream-gum',
                'description' => 'Sneakers kulit sapi asli bergaya court retro 90-an dengan outsole karet gum grip tinggi. Insole memory foam empuk nyaman untuk jalan kaki seharian tanpa pegal.',
                'price' => 589000,
                'images' => [
                    'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => '40', 'color' => 'Off White Cream', 'stock' => 12],
                    ['size' => '41', 'color' => 'Off White Cream', 'stock' => 15],
                    ['size' => '42', 'color' => 'Off White Cream', 'stock' => 18],
                    ['size' => '43', 'color' => 'Off White Cream', 'stock' => 10],
                    ['size' => '41', 'color' => 'Panda Black White', 'stock' => 14],
                    ['size' => '42', 'color' => 'Panda Black White', 'stock' => 16],
                ],
            ],
            [
                'seller' => $seller1,
                'category' => $categories['aksesoris-tas'],
                'name' => 'Genuine Leather Hobo Shoulder Bag with Gold Buckle',
                'slug' => 'genuine-leather-hobo-shoulder-bag-gold-buckle',
                'description' => 'Tas bahu wanita terbuat dari 100% genuine calfskin leather. Desain bulan sabit yang timeless dengan hardware kuningan anti karat dan kompartemen luas yang muat tablet dan makeup pouch.',
                'price' => 670000,
                'images' => [
                    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'Regular', 'color' => 'Caramel Brown', 'stock' => 15],
                    ['size' => 'Regular', 'color' => 'Noir Black', 'stock' => 20],
                    ['size' => 'Regular', 'color' => 'Burgundy Wine', 'stock' => 10],
                ],
            ],
            [
                'seller' => $seller2,
                'category' => $categories['pria'],
                'name' => 'Italian Linen Cuban Collar Resort Shirt',
                'slug' => 'italian-linen-cuban-collar-resort-shirt',
                'description' => 'Kemeja pria kerah camp cuban bahan 100% linen alami bernapas tinggi. Sangat cocok untuk liburan ke pantai, brunch santai akhir pekan, atau smart casual hangout.',
                'price' => 275000,
                'images' => [
                    'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1603252109303-2751441dd157?auto=format&fit=crop&w=800&q=80',
                ],
                'variants' => [
                    ['size' => 'M', 'color' => 'Natural Beige', 'stock' => 20],
                    ['size' => 'L', 'color' => 'Natural Beige', 'stock' => 25],
                    ['size' => 'M', 'color' => 'Sky Blue', 'stock' => 18],
                    ['size' => 'L', 'color' => 'Sky Blue', 'stock' => 20],
                ],
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $pData) {
            $product = Product::firstOrCreate(
                ['slug' => $pData['slug']],
                [
                    'user_id' => $pData['seller']->id,
                    'category_id' => $pData['category']->id,
                    'name' => $pData['name'],
                    'description' => $pData['description'],
                    'price' => $pData['price'],
                    'is_active' => true,
                ]
            );

            // Images
            foreach ($pData['images'] as $idx => $imgUrl) {
                ProductImage::firstOrCreate(
                    ['product_id' => $product->id, 'image_path' => $imgUrl],
                    ['is_primary' => ($idx === 0)]
                );
            }

            // Variants
            foreach ($pData['variants'] as $v) {
                ProductVariant::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'size' => $v['size'],
                        'color' => $v['color'],
                    ],
                    [
                        'stock' => $v['stock'],
                    ]
                );
            }

            $createdProducts[] = $product;
        }

        // 4. Sample Order & Review for Customer
        $firstProduct = $createdProducts[0];
        $firstVariant = $firstProduct->variants()->first();

        $order = Order::firstOrCreate(
            ['order_number' => 'FM-20261008-001'],
            [
                'user_id' => $customer->id,
                'total_amount' => $firstProduct->price,
                'shipping_cost' => 18000,
                'shipping_service' => 'JNE Reguler (2-3 hari)',
                'recipient_name' => 'Rian Pratama',
                'recipient_phone' => '081345678901',
                'shipping_address' => 'Jl. Senopati No. 45, Kebayoran Baru',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'postal_code' => '12190',
                'tracking_number' => 'JNE88921004123',
                'status' => 'delivered',
            ]
        );

        $orderItem = OrderItem::firstOrCreate(
            ['order_id' => $order->id, 'seller_id' => $firstProduct->user_id],
            [
                'product_variant_id' => $firstVariant->id,
                'product_name' => $firstProduct->name,
                'size' => $firstVariant->size,
                'color' => $firstVariant->color,
                'price' => $firstProduct->price,
                'quantity' => 1,
                'subtotal' => $firstProduct->price,
            ]
        );

        Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => 'bank_transfer',
                'payment_status' => 'success',
                'amount' => $order->grand_total,
                'paid_at' => now()->subDays(2),
            ]
        );

        Review::firstOrCreate(
            ['order_item_id' => $orderItem->id],
            [
                'product_id' => $firstProduct->id,
                'user_id' => $customer->id,
                'rating' => 5,
                'comment' => 'Kualitas sutranya juara banget! Jahitannya sangat rapi dan pas di badan. Pengiriman juga super cepat. Recommended seller!',
            ]
        );

        // Add 1 more review for sneakers
        $sneakerProduct = $createdProducts[5] ?? null;
        if ($sneakerProduct) {
            $sneakerVariant = $sneakerProduct->variants()->first();
            $order2 = Order::firstOrCreate(
                ['order_number' => 'FM-20261008-002'],
                [
                    'user_id' => $customer->id,
                    'total_amount' => $sneakerProduct->price,
                    'shipping_cost' => 22000,
                    'shipping_service' => 'SiCepat BEST (1 hari)',
                    'recipient_name' => 'Rian Pratama',
                    'recipient_phone' => '081345678901',
                    'shipping_address' => 'Jl. Senopati No. 45, Kebayoran Baru',
                    'city' => 'Jakarta Selatan',
                    'province' => 'DKI Jakarta',
                    'postal_code' => '12190',
                    'tracking_number' => '002938192831',
                    'status' => 'delivered',
                ]
            );

            $orderItem2 = OrderItem::firstOrCreate(
                ['order_id' => $order2->id, 'seller_id' => $sneakerProduct->user_id],
                [
                    'product_variant_id' => $sneakerVariant->id,
                    'product_name' => $sneakerProduct->name,
                    'size' => $sneakerVariant->size,
                    'color' => $sneakerVariant->color,
                    'price' => $sneakerProduct->price,
                    'quantity' => 1,
                    'subtotal' => $sneakerProduct->price,
                ]
            );

            Payment::firstOrCreate(
                ['order_id' => $order2->id],
                [
                    'payment_method' => 'ewallet',
                    'payment_status' => 'success',
                    'amount' => $order2->grand_total,
                    'paid_at' => now()->subDay(),
                ]
            );

            Review::firstOrCreate(
                ['order_item_id' => $orderItem2->id],
                [
                    'product_id' => $sneakerProduct->id,
                    'user_id' => $customer->id,
                    'rating' => 5,
                    'comment' => 'Sneakersnya sangat empuk dan kulit aslinya berasa mewah banget. Tidak kalah dengan brand luar negeri!',
                ]
            );
        }

        // Initialize empty cart and wishlist for customer
        Cart::firstOrCreate(['user_id' => $customer->id]);
        Wishlist::firstOrCreate(['user_id' => $customer->id]);
    }
}
