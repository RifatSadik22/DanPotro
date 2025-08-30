@if (Auth::user()->is_admin)
    <x-nav-link :href="route('admin.reports.donations')" :active="request()->routeIs('admin.reports.donations')">
        {{ __('Donation Reports') }}
    </x-nav-link>
@endif