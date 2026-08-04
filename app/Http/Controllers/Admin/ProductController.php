<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ProductImage;
use Cloudinary\Cloudinary;

class ProductController extends Controller
{
    private function uploadToCloudinary($file, $folder)
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'iakgm3cm'),
                'api_key' => env('CLOUDINARY_API_KEY', '554665847951332'),
                'api_secret' => env('CLOUDINARY_API_SECRET', 'V9mBa7pL7IFZ6e2G9J9kmOJa_1E'),
            ],
        ]);

        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
        ]);

        return $result['secure_url'];
    }

    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|max:2048',
        ]);

        foreach ($request->file('images') as $index => $file) {
            $url = $this->uploadToCloudinary($file, 'products/gallery');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $url,
                'sort_order' => $index,
            ]);
        }

        return back()->with('success', 'Images uploaded successfully!');
    }

    public function deleteImage(ProductImage $image)
    {
        if (!str_starts_with($image->image_path, 'http')) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_new'] = $request->boolean('is_new');
        $validated['in_stock'] = $request->boolean('in_stock', true);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $this->uploadToCloudinary($request->file('image'), 'products');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateData($request);
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_new'] = $request->boolean('is_new');
        $validated['in_stock'] = $request->boolean('in_stock');

        if ($request->hasFile('image')) {
            if ($product->image_url && !str_starts_with($product->image_url, 'http')) {
                Storage::disk('public')->delete($product->image_url);
            }
            $validated['image_url'] = $this->uploadToCloudinary($request->file('image'), 'products');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

    public function generateDescription(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'specs' => 'nullable|string',
        ]);

        $response = Http::withHeaders([
            'x-api-key' => env('ANTHROPIC_API_KEY'),
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => 'claude-sonnet-4-5',
            'max_tokens' => 300,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Write a compelling, professional 2-3 sentence e-commerce product description for a toy store called TrackForge (RC cars, die-cast, metal toy cars).

Product Name: {$request->name}
Specs/Details: {$request->specs}

Keep it exciting, highlight key features, and make it sound appealing to buyers. Return ONLY the description text, no preamble, no quotes."
                ]
            ],
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'AI request failed. Check API key.'], 500);
        }

        $data = $response->json();
        $description = $data['content'][0]['text'] ?? 'Could not generate description.';

        return response()->json(['description' => trim($description)]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:200',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|integer|min:0',
            'old_price' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'emoji' => 'nullable|string|max:10',
            'badge' => 'required|in:none,NEW,HOT,SALE',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
    }
}