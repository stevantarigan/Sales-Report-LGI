<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transactions Report</title>
    <style>
        /* Professional PDF Styles */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        .report-info {
            font-size: 12px;
            color: #888;
        }

        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            flex: 1;
            margin: 0 5px;
            min-width: 120px;
        }

        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }

        .filters-section {
            background: #f1f5f9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 11px;
        }

        .filters-title {
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 8px;
        }

        .filter-item {
            margin-bottom: 3px;
        }

        .table-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table-container th {
            background: #4f46e5;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            border: 1px solid #3730a3;
        }

        .table-container td {
            padding: 10px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            vertical-align: top;
        }

        .table-container tr:nth-child(even) {
            background: #f8fafc;
        }

        .table-container tr:hover {
            background: #f1f5f9;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .payment-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
        }

        .payment-paid {
            background: #dcfce7;
            color: #166534;
        }

        .payment-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .payment-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .price {
            font-weight: bold;
            color: #059669;
        }

        .customer-info {
            font-weight: 600;
            color: #1e293b;
        }

        .customer-email {
            font-size: 9px;
            color: #64748b;
        }

        .product-list {
            font-size: 9px;
        }

        .product-item {
            margin-bottom: 3px;
            padding-bottom: 3px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .product-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .page-number:before {
            content: "Page " counter(page);
        }

        /* Column widths */
        .col-transaction {
            width: 12%;
        }

        .col-customer {
            width: 15%;
        }

        .col-products {
            width: 25%;
        }

        .col-quantity {
            width: 8%;
        }

        .col-price {
            width: 10%;
        }

        .col-status {
            width: 8%;
        }

        .col-payment {
            width: 8%;
        }

        .col-date {
            width: 14%;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <div class="company-name">BUSINESS MANAGEMENT SYSTEM</div>
        <div class="report-title">TRANSACTIONS REPORT</div>
        <div class="report-info">
            Generated on: {{ now()->format('F j, Y \a\t H:i') }}<br>
            Generated by: {{ auth()->user()->name }} ({{ auth()->user()->role }})
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-value">{{ $totalTransactions }}</div>
            <div class="summary-label">Total Transactions</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $completedTransactions }}</div>
            <div class="summary-label">Completed</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $pendingTransactions }}</div>
            <div class="summary-label">Pending</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $cancelledTransactions }}</div>
            <div class="summary-label">Cancelled</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="summary-label">Total Revenue</div>
        </div>
    </div>

    <!-- Filters Applied -->
    @if ($request->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
        <div class="filters-section">
            <div class="filters-title">FILTERS APPLIED:</div>
            @if ($request->search)
                <div class="filter-item"><strong>Search:</strong> "{{ $request->search }}"</div>
            @endif
            @if ($request->status)
                <div class="filter-item"><strong>Status:</strong> {{ ucfirst($request->status) }}</div>
            @endif
            @if ($request->payment_status)
                <div class="filter-item"><strong>Payment Status:</strong> {{ ucfirst($request->payment_status) }}</div>
            @endif
            @if ($request->date_from)
                <div class="filter-item"><strong>From Date:</strong>
                    {{ \Carbon\Carbon::parse($request->date_from)->format('M j, Y') }}</div>
            @endif
            @if ($request->date_to)
                <div class="filter-item"><strong>To Date:</strong>
                    {{ \Carbon\Carbon::parse($request->date_to)->format('M j, Y') }}</div>
            @endif
        </div>
    @endif

    <!-- Transactions Table -->
    <table class="table-container">
        <thead>
            <tr>
                <th class="col-transaction">Transaction ID</th>
                <th class="col-customer">Customer</th>
                <th class="col-products">Products</th>
                <th class="col-quantity">Qty</th>
                <th class="col-price">Total Price</th>
                <th class="col-status">Status</th>
                <th class="col-payment">Payment</th>
                <th class="col-date">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>
                        <strong>TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                        <small>by {{ $transaction->user->name ?? 'N/A' }}</small>
                    </td>
                    <td>
                        <div class="customer-info">{{ $transaction->customer->name ?? 'N/A' }}</div>
                        <div class="customer-email">{{ $transaction->customer->email ?? '' }}</div>
                    </td>
                    <td>
                        <div class="product-list">
                            @php
                                $products = $transaction->getAllProducts();
                            @endphp
                            @if ($products->count() > 0)
                                @foreach ($products as $productItem)
                                    @php
                                        $product = \App\Models\Product::find($productItem->product_id);
                                    @endphp
                                    <div class="product-item">
                                        <strong>{{ $product->name ?? 'Product Not Found' }}</strong><br>
                                        {{ $productItem->quantity }} pcs × Rp
                                        {{ number_format($productItem->price, 0, ',', '.') }}
                                    </div>
                                @endforeach
                            @else
                                <div class="product-item">
                                    <strong>{{ $transaction->product->name ?? 'N/A' }}</strong><br>
                                    {{ $transaction->quantity }} pcs × Rp
                                    {{ number_format($transaction->price, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <strong>{{ $transaction->getTotalQuantityAttribute() }}</strong>
                    </td>
                    <td class="price">
                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="status-badge status-{{ $transaction->status }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="payment-badge payment-{{ $transaction->payment_status }}">
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('M j, Y') }}<br>
                        <small>{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}</small>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div>© {{ date('Y') }} Business Management System. All rights reserved.</div>
        <div class="page-number"></div>
    </div>
</body>

</html>
