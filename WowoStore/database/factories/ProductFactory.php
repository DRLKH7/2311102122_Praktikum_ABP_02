<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productData = [
            'Monitor' => [
                'LG Ultragear 24GS60F' => ['desc' => 'Panel IPS, 180Hz refresh rate, 1ms GtG response time, HDR10, sRGB 99%.', 'price' => 2150000],
                'Samsung Odyssey G5' => ['desc' => 'Layar Curved 1000R, resolusi WQHD 144Hz, 1ms MPRT, HDR10, FreeSync Premium.', 'price' => 3850000],
                'ASUS ROG Swift PG27UCDM' => ['desc' => 'Panel QD-OLED, resolusi 4K, 240Hz, 0.03ms response time, heatsink kustom.', 'price' => 18500000],
                'Dell UltraSharp U2424HE' => ['desc' => 'Panel IPS Black, 120Hz, USB-C Hub 90W, akurasi warna profesional sRGB 100%.', 'price' => 5400000],
                'Xiaomi Monitor G24' => ['desc' => 'Fast IPS 180Hz, FHD resolution, 1ms GtG, HDR10, bezel tipis premium.', 'price' => 1450000],
            ],
            'Laptop' => [
                'MacBook Air M3' => ['desc' => 'Chip Apple M3 8-core, 8GB Unified Memory, 256GB SSD, Liquid Retina 13 inci.', 'price' => 16500000],
                'ASUS ROG Zephyrus G14' => ['desc' => 'AMD Ryzen 9, RTX 4060 8GB, 16GB LPDDR5X, Layar ROG Nebula OLED 3K 120Hz.', 'price' => 28500000],
                'Lenovo Legion 5i' => ['desc' => 'Intel Core i7-14650HX, RTX 4060, 16GB RAM, 512GB SSD, 16" WQXGA 165Hz.', 'price' => 21900000],
                'HP Victus 15' => ['desc' => 'Intel Core i5-13420H, RTX 3050 6GB, 16GB RAM, 512GB SSD, FHD 144Hz.', 'price' => 11200000],
                'Dell XPS 15 9530' => ['desc' => 'Intel Core i9-13900H, RTX 4060, 32GB RAM, 1TB SSD, 15.6" OLED Touch 3.5K.', 'price' => 45000000],
            ],
            'SSD/Storage' => [
                'Samsung 980 Pro 1TB' => ['desc' => 'NVMe M.2 Gen 4x4, Read up to 7000MB/s, DRAM Cache, ideal untuk gaming/pro.', 'price' => 1850000],
                'WD Blue SN580 500GB' => ['desc' => 'NVMe Gen 4, Read up to 4150MB/s, nCache 4.0, efisien daya, garansi 5 tahun.', 'price' => 750000],
                'Seagate IronWolf 4TB' => ['desc' => 'Hard Drive internal NAS, 5400 RPM, 256MB Cache, desain 24/7 reliability.', 'price' => 1600000],
                'Crucial P5 Plus 1TB' => ['desc' => 'PCIe Gen 4 NVMe, Read up to 6600MB/s, kompatibel dengan PS5 dengan heatsink.', 'price' => 1450000],
                'Kingston NV2 1TB' => ['desc' => 'PCIe 4.0 NVMe Gen 4x4, Read up to 3500MB/s, solusi budget kencang.', 'price' => 1050000],
            ],
            'Keyboard' => [
                'Keychron K2 V2' => ['desc' => 'Mechanical Wireless 75%, Gateron G Pro Switch, RGB, Aluminum Frame, Mac/Win.', 'price' => 1250000],
                'Logitech G Pro Keyboard' => ['desc' => 'Tenkeyless design, GX Blue Clicky Switches, Lightsync RGB, detachable cable.', 'price' => 1550000],
                'Razer BlackWidow V4' => ['desc' => 'Mechanical Gaming, Green Clicky Switch, Doubleshot ABS, media roller.', 'price' => 2450000],
                'Corsair K70 RGB MK.2' => ['desc' => 'Cherry MX Brown, Anodized Aluminum frame, 8MB Profile storage, per-key RGB.', 'price' => 2200000],
                'Vortex Series VX5' => ['desc' => '60% Mechanical, Hotswappable Outemu Switch, RGB, Type-C, budget friendly.', 'price' => 450000],
            ],
            'GPU' => [
                'NVIDIA RTX 4070' => ['desc' => '12GB GDDR6X, Ada Lovelace architecture, DLSS 3, Ray Tracing Gen-3, 1440p King.', 'price' => 10500000],
                'AMD RX 7800 XT' => ['desc' => '16GB GDDR6, RDNA 3 architecture, FSR 3, performa rasterisasi murni tinggi.', 'price' => 9200000],
                'RTX 3060 Ti 8GB' => ['desc' => 'Ampere architecture, Ray Tracing Gen-2, DLSS 2, sangat mumpuni di 1080p/1440p.', 'price' => 5500000],
                'GTX 1650 Super' => ['desc' => '4GB GDDR6, Turing architecture, hemat daya, cocok untuk entry gaming 1080p.', 'price' => 2100000],
            ],
            'Cables/Accessories' => [
                'Vention HDMI 2.1' => ['desc' => 'Support 8K@60Hz, 48Gbps, Zinc Alloy Case, Braided Nylon, HDR support.', 'price' => 150000],
                'Robot USB-C Hub 7-in-1' => ['desc' => 'Aluminum Case, 4K HDMI, USB 3.0 x3, SD/TF Card Slot, PD Charging 100W.', 'price' => 350000],
                'Ugreen Cat6 RJ45 10m' => ['desc' => 'Gigabit Ethernet Cable, UTP 1000Mbps, murni tembaga, tahan lama.', 'price' => 85000],
            ],
            'Bracket/Mount' => [
                'North Bayou F80' => ['desc' => 'Single Gas Spring Monitor Arm, support 17-30 inch, VESA 75/100, max 9kg.', 'price' => 285000],
                'Oximus Hydra ZL1122' => ['desc' => 'Dual Monitor Arm Desk Mount, Gas Spring, Tilt, Swivel, Rotate, Clamp type.', 'price' => 550000],
            ]
        ];

        $category = fake()->randomElement(array_keys($productData));
        $itemNames = array_keys($productData[$category]);
        $itemName = fake()->randomElement($itemNames);
        
        $details = $productData[$category][$itemName];

        return [
            'name' => $itemName,
            'description' => $details['desc'],
            'price' => $details['price'],
            'stock' => fake()->numberBetween(0, 100),
            'category' => $category,
        ];
    }
}
