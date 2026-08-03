@extends('layouts.admin')

@section('title', 'Settings')

@section('content')

<style>
    .settings-wrap {
        max-width: 700px;
    }
    .settings-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .settings-row:last-of-type {
        border-bottom: none;
    }
    .settings-row .label-col {
        flex: 0 0 260px;
    }
    .settings-row .label-col .title {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    .settings-row .label-col .hint {
        color: #888;
        font-size: .8rem;
    }
    .settings-row .input-col {
        flex: 1;
    }
    .settings-row .form-control {
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(212,175,55,.3);
        color: #fff;
        border-radius: 0;
        padding: .5rem .25rem;
        font-size: 1.05rem;
        text-align: right;
    }
    .settings-row .form-control:focus {
        background: transparent;
        border-bottom-color: #D4AF37;
        box-shadow: none;
        color: #fff;
    }
    .btn-save-settings {
        background: #b3122e;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: .75rem 2.5rem;
        border-radius: 6px;
        transition: background .2s ease;
    }
    .btn-save-settings:hover {
        background: #d70c2e;
        color: #fff;
    }
</style>

<h3 class="fw-bold text-white mb-1">⚙️ Store Settings</h3>
<p class="mb-4" style="color:#888;">Manage your store's core configuration</p>

<div class="settings-wrap">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="settings-row">
            <div class="label-col">
                <div class="title">Store Name</div>
                <div class="hint">Displayed across your storefront</div>
            </div>
            <div class="input-col">
                <input type="text" name="store_name" class="form-control" value="{{ $settings->store_name }}">
            </div>
        </div>

        <div class="settings-row">
            <div class="label-col">
                <div class="title">WhatsApp Number</div>
                <div class="hint">Include country code, e.g. 92300...</div>
            </div>
            <div class="input-col">
                <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings->whatsapp_number }}">
            </div>
        </div>

        <div class="settings-row">
            <div class="label-col">
                <div class="title">Free Delivery Threshold</div>
                <div class="hint">Minimum order amount for free delivery (PKR)</div>
            </div>
            <div class="input-col">
                <input type="number" name="free_delivery_threshold" class="form-control" value="{{ $settings->free_delivery_threshold }}">
            </div>
        </div>

        <div class="settings-row">
            <div class="label-col">
                <div class="title">Delivery Charge</div>
                <div class="hint">Standard delivery fee (PKR)</div>
            </div>
            <div class="input-col">
                <input type="number" name="delivery_charge" class="form-control" value="{{ $settings->delivery_charge }}">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-save-settings">💾 Save Settings</button>
        </div>
    </form>
</div>

@endsection