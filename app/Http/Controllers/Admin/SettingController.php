<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::current();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:100',
            'whatsapp_number' => 'required|string|max:20',
            'free_delivery_threshold' => 'required|integer|min:0',
            'delivery_charge' => 'required|integer|min:0',
            'announcement' => 'nullable|string|max:255',
        ]);

        Setting::current()->update($validated);

        return back()->with('success', 'Settings updated successfully!');
    }
}
