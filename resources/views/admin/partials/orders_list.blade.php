@php
    $statuses = ['Placed order', 'Pending', 'Served'];
    $ordersByStatus = collect($orders)->groupBy('status');
@endphp

@foreach ($statuses as $statusKey)
    @if (isset($ordersByStatus[$statusKey]))
        <h5 class="text-white mt-4">{{ $statusKey }}</h5>
        <hr style="border-color: rgba(255,255,255,0.2);">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach ($ordersByStatus[$statusKey] as $order)
                <div class="col">
                    <div class="order-card">

                        {{-- Display REF --}}
                        <div class="order-header d-flex justify-content-between">
                            <span class="fw-bold small">
                                REF #{{ $order['reference_number'] }}
                                <br>
                                <span style="font-weight: normal; font-size: 0.75rem; opacity: 0.7;">
                                    {{ \Carbon\Carbon::parse($order['items']->first()->reserved_at)->format('h A') }}
                                </span>
                            </span>
                            @php
                                $dotClass = match ($statusKey) {
                                    'Placed order' => 'dot-placed',
                                    'Pending' => 'dot-pending',
                                    'Served' => 'dot-served',
                                    default => 'dot-placed',
                                };
                            @endphp
                            <span class="small"><i class="status-dot {{ $dotClass }}"></i>
                                {{ $statusKey }}</span>
                        </div>

                        {{-- Items --}}
                        <div class="item-list">
                            {{-- Main items --}}
                            @foreach ($order['items']->whereNull('is_add_ons_menu') as $item)
                                <div class="mb-1">
                                    {{ $item->quantity }}x {{ $item->menu_name }}
                                    @if ($item->rice_name)
                                        w/ {{ $item->rice_name }}
                                    @endif
                                </div>
                            @endforeach

                            {{-- Add-ons --}}
                            @php
                                $addOns = $order['items']->filter(fn($i) => !is_null($i->is_add_ons_menu));
                            @endphp
                            @foreach ($addOns as $addon)
                                <div class="mb-1">
                                    {{ $addon->quantity }}x {{ $addon->menu_name }}
                                    @if ($addon->rice_name)
                                        <br>w/ {{ $addon->rice_name }}
                                    @endif
                                    <br>
                                    {{ $addon->size }} [Add-on - <span
                                        style="color:red; font-weight:bold;">₱{{ number_format($addon->price, 2) }}</span>]
                                </div>
                            @endforeach
                        </div>

                        {{-- Action button --}}
                        <div class="mt-3">
                            @if ($statusKey == 'Placed order')
                                <button class="btn btn-danger btn-action fw-bold"
                                    onclick="updateStatus(this, '{{ $order['reference_number'] }}')">ACCEPT
                                    ORDER</button>
                            @elseif($statusKey == 'Pending')
                                <button class="btn btn-warning btn-action fw-bold text-dark"
                                    onclick="openServeModal('{{ $order['reference_number'] }}')">
                                    SERVED
                                </button>
                            @else
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endforeach
