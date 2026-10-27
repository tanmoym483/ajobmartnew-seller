<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AjobmartSubcategoriesSeeder extends Seeder
{
    public function run()
    {
        $subcategories = [
            'electronics' => [
                'Mobile Phones',
                'Tablets',
                'Televisions',
                'Refrigerators',
                'Washing Machines',
                'Air Conditioners',
                'Cameras',
                'Smart Home Devices',
            ],

            'fashion' => [
                'Men Clothing',
                'Women Clothing',
                'Men Footwear',
                'Women Footwear',
                'Bags and Wallets',
                'Fashion Accessories',
                'Ethnic Wear',
                'Innerwear',
            ],

            'grocery' => [
                'Rice and Grains',
                'Pulses and Lentils',
                'Cooking Oil and Ghee',
                'Spices and Masalas',
                'Packaged Food',
                'Snacks and Biscuits',
                'Beverages',
                'Dairy Products',
                'Fruits and Vegetables',
                'Household Essentials',
            ],

            'home' => [
                'Kitchenware',
                'Cookware',
                'Home Decor',
                'Bedding and Linen',
                'Bathroom Accessories',
                'Cleaning Supplies',
                'Storage and Organizers',
                'Lighting',
            ],

            'beauty' => [
                'Skin Care',
                'Hair Care',
                'Makeup',
                'Fragrances',
                'Personal Care',
                'Bath and Body',
                'Beauty Tools',
            ],

            'computers' => [
                'Laptops',
                'Desktop Computers',
                'Computer Monitors',
                'Keyboards and Mice',
                'Printers and Scanners',
                'Computer Components',
                'Storage Devices',
                'Networking Devices',
            ],

            'sports' => [
                'Fitness Equipment',
                'Gym Accessories',
                'Outdoor Sports',
                'Indoor Games',
                'Cycling',
                'Yoga Accessories',
                'Sportswear',
                'Camping and Hiking',
            ],

            'furniture' => [
                'Sofas and Couches',
                'Beds and Mattresses',
                'Tables',
                'Chairs',
                'Wardrobes',
                'Office Furniture',
                'Bookshelves',
                'Outdoor Furniture',
            ],

            'automotive' => [
                'Car Accessories',
                'Bike Accessories',
                'Car Care',
                'Helmets and Safety Gear',
                'Tyres and Tubes',
                'Vehicle Electronics',
                'Tools and Equipment',
            ],

            'books' => [
                'Educational Books',
                'Fiction',
                'Non-Fiction',
                'Competitive Exam Books',
                'Children Books',
                'Comics and Graphic Novels',
                'Reference Books',
            ],

            'pets' => [
                'Dog Supplies',
                'Cat Supplies',
                'Pet Food',
                'Bird Supplies',
                'Fish and Aquarium',
                'Pet Grooming',
                'Pet Toys',
            ],

            'toys' => [
                'Educational Toys',
                'Building Blocks',
                'Dolls and Action Figures',
                'Remote Control Toys',
                'Board Games',
                'Outdoor Toys',
                'Baby Toys',
            ],

            'garden' => [
                'Seeds',
                'Plants and Saplings',
                'Pots and Planters',
                'Gardening Tools',
                'Fertilizers and Soil',
                'Watering Equipment',
                'Outdoor Decor',
            ],

            'jewelry' => [
                'Necklaces',
                'Earrings',
                'Rings',
                'Bracelets',
                'Bangles',
                'Pendants',
                'Jewelry Sets',
                'Artificial Jewelry',
            ],

            'watches' => [
                'Men Watches',
                'Women Watches',
                'Kids Watches',
                'Smart Watches',
                'Digital Watches',
                'Watch Accessories',
            ],

            'arts_crafts' => [
                'Painting Supplies',
                'Drawing Supplies',
                'Craft Materials',
                'DIY Kits',
                'Sewing and Knitting',
                'Art Paper',
                'Calligraphy Supplies',
            ],

            'baby_kids' => [
                'Baby Clothing',
                'Baby Diapers',
                'Baby Feeding',
                'Baby Bath and Skin Care',
                'Baby Bedding',
                'Baby Strollers',
                'Kids Accessories',
            ],

            'health' => [
                'Health Care Devices',
                'First Aid',
                'Personal Hygiene',
                'Fitness and Wellness',
                'Mobility Aids',
                'Health Monitoring',
                'Medical Supplies',
            ],

            'audio' => [
                'Headphones',
                'Earphones',
                'Bluetooth Speakers',
                'Home Audio Systems',
                'Soundbars',
                'Microphones',
                'Audio Accessories',
            ],

            'tools' => [
                'Hand Tools',
                'Power Tools',
                'Tool Kits',
                'Measuring Tools',
                'Electrical Tools',
                'Plumbing Tools',
                'Safety Equipment',
            ],

            'other' => [
                'Miscellaneous Products',
                'Office Supplies',
                'Stationery',
                'Gift Items',
                'Travel Accessories',
            ],
        ];

        $categoryTable = $this->db->table('ajobmart_categories');
        $subcategoryTable = $this->db->table('ajobmart_subcategories');

        $now = date('Y-m-d H:i:s');
        $inserted = 0;
        $skipped = 0;

        foreach ($subcategories as $categorySlug => $names) {
            // Find the real category ID using its slug.
            $category = $categoryTable
                ->select('id, name, slug')
                ->where('slug', $categorySlug)
                ->get()
                ->getRowArray();

            if (!$category) {
                echo "Skipped: category '{$categorySlug}' was not found.\n";
                $skipped += count($names);
                continue;
            }

            foreach ($names as $index => $name) {
                // Generate a URL-friendly subcategory slug.
                $slug = strtolower($name);
                $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
                $slug = trim($slug, '-');

                // Avoid duplicate entries when the seeder runs again.
                $exists = $subcategoryTable
                    ->where('category_id', $category['id'])
                    ->where('slug', $slug)
                    ->countAllResults();

                if ($exists > 0) {
                    $skipped++;
                    continue;
                }

                $subcategoryTable->insert([
                    'category_id' => $category['id'],
                    'name'        => $name,
                    'slug'        => $slug,
                    'description' => null,
                    'status'      => 1,
                    'sort_order'  => $index + 1,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);

                $inserted++;
            }
        }

        echo "Subcategories inserted: {$inserted}\n";
        echo "Existing or skipped entries: {$skipped}\n";
    }
}
