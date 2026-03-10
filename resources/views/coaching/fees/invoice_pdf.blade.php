<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($fee->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1f2937; line-height: 1.6; font-size: 13px; margin: 0; padding: 0; background: #fff; }
        
        /* Header Section */
        .header { background: #1a1c1e; color: white; padding: 45px 50px; }
        .header-left { float: left; width: 50%; }
        .header-right { float: right; width: 45%; text-align: right; }
        .invoice-title { font-size: 48px; font-weight: 900; margin: 0; letter-spacing: -2px; line-height: 1; }
        .invoice-number { font-size: 14px; opacity: 0.8; margin-top: 8px; font-family: monospace; }
        .coaching-name { font-size: 18px; font-weight: bold; margin: 0; }
        .header-meta { font-size: 12px; margin-top: 5px; opacity: 0.8; }
        .status-badge { display: inline-block; background: #10b981; color: white; padding: 3px 12px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; margin-top: 8px; }
        .status-unpaid { background: #ef4444; }

        .container { padding: 50px; }
        .details-row { margin-bottom: 50px; overflow: hidden; }
        .details-col-left { float: left; width: 50%; }
        .details-col-right { float: right; width: 45%; text-align: right; }
        
        .label { font-size: 10px; font-weight: bold; color: #6b7280; text-transform: uppercase; margin-bottom: 12px; display: block; letter-spacing: 1px; }
        .value-bold { font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 5px 0; }
        .value-text { font-size: 12px; color: #4b5563; margin: 2px 0; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { border-bottom: 1px solid #e5e7eb; padding: 15px 10px; text-align: left; font-size: 10px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 25px 10px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        
        .item-name { font-weight: bold; font-size: 14px; color: #111827; margin-bottom: 4px; }
        .item-desc { font-size: 11px; color: #6b7280; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Summary Section */
        .summary-wrapper { margin-top: 50px; overflow: hidden; }
        .summary-left { float: left; width: 55%; }
        .summary-right { float: right; width: 40%; }
        
        .summary-row { margin-bottom: 12px; overflow: hidden; }
        .summary-label { float: left; width: 60%; color: #6b7280; font-size: 12px; text-align: left; }
        .summary-value { float: right; width: 38%; font-weight: bold; color: #111827; text-align: right; }
        .summary-value-light { font-weight: normal; color: #4b5563; }
        
        .grand-total-row { border-top: 1px solid #e5e7eb; margin-top: 20px; padding-top: 25px; overflow: hidden; }
        .grand-total-label { float: left; width: 35%; font-size: 24px; font-weight: bold; color: #111827; }
        .grand-total-value { float: right; width: 63%; font-size: 36px; font-weight: 900; color: #2563eb; text-align: right; }

        /* Footer */
        .footer { text-align: center; color: #9ca3af; font-size: 11px; margin-top: 100px; padding-top: 20px; border-top: 1px solid #f3f4f6; }
        
        /* Helpers */
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="header-left">
            <h1 class="invoice-title">INVOICE</h1>
            <div class="invoice-number">#INV-{{ str_pad($fee->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div class="header-right">
            <div class="coaching-name">{{ auth()->user()->coaching->coaching_name ?? 'Coaching System' }}</div>
            <div class="header-meta">State: {{ $fee->institute_state ?? 'N/A' }}</div>
            @if($fee->institute_gst_number)
                <div class="header-meta">GSTIN: {{ $fee->institute_gst_number }}</div>
            @endif
            <div class="header-meta">Date: {{ \Carbon\Carbon::parse($fee->date)->format('d M, Y') }}</div>
            <div class="status-badge {{ $fee->status !== 'paid' ? 'status-unpaid' : '' }}">{{ $fee->status }}</div>
        </div>
    </div>

    <div class="container">
        <div class="details-row clearfix">
            <div class="details-col-left">
                <span class="label">Invoice To:</span>
                <p class="value-bold">{{ $fee->student->name }}</p>
                <p class="value-text">State: {{ $fee->student_state ?? 'N/A' }}</p>
                <p class="value-text">Student ID: #STU{{ str_pad($fee->student_id, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="value-text">Email: {{ $fee->student->email ?? 'N/A' }}</p>
            </div>
            <div class="details-col-right">
                <span class="label">Payment Details:</span>
                <p class="value-text">Payment Method: <strong>Offline/Cash</strong></p>
                <p class="value-text">Currency: <strong>INR (&#8377;)</strong></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 60%;">Description</th>
                    <th class="text-center">HSN/SAC</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="item-name">Coaching / Tuition Fee</div>
                        <div class="item-desc">Course: {{ $fee->student->course->name ?? 'Active Course' }}</div>
                    </td>
                    <td class="text-center" style="color: #6b7280;">9992</td>
                    <td class="text-right" style="font-weight: bold; font-size: 15px; color: #111827;">&#8377;{{ number_format($fee->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-wrapper clearfix">
            <div class="summary-left">
                <span class="label">Terms & Conditions</span>
                <ul style="padding-left: 15px; margin-top: 15px; color: #6b7280; font-size: 11px; line-height: 1.8;">
                    <li>Fees once paid are non-refundable and non-transferable.</li>
                    <li>This is a computer-generated invoice and doesn't require a signature.</li>
                    <li>Please keep this invoice for future reference.</li>
                </ul>
            </div>
            <div class="summary-right">
                <div class="summary-row">
                    <span class="summary-label">Subtotal (Base):</span>
                    <span class="summary-value">&#8377;{{ number_format($fee->amount, 2) }}</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">GST Type:</span>
                    <span class="summary-value summary-value-light" style="text-transform: capitalize;">{{ $fee->gst_type == 'intra' ? 'Intra-State (CGST + SGST)' : 'Inter-State (IGST)' }}</span>
                </div>

                @if($fee->cgst_amount > 0)
                <div class="summary-row">
                    <span class="summary-label">CGST ({{ number_format($fee->cgst_rate, 2) }}%):</span>
                    <span class="summary-value summary-value-light">&#8377;{{ number_format($fee->cgst_amount, 2) }}</span>
                </div>
                @endif

                @if($fee->sgst_amount > 0)
                <div class="summary-row">
                    <span class="summary-label">SGST ({{ number_format($fee->sgst_rate, 2) }}%):</span>
                    <span class="summary-value summary-value-light">&#8377;{{ number_format($fee->sgst_amount, 2) }}</span>
                </div>
                @endif

                @if($fee->igst_amount > 0)
                <div class="summary-row">
                    <span class="summary-label">IGST ({{ number_format($fee->igst_rate, 2) }}%):</span>
                    <span class="summary-value summary-value-light">&#8377;{{ number_format($fee->igst_amount, 2) }}</span>
                </div>
                @endif

                <div class="grand-total-row">
                    <span class="grand-total-label">Total:</span>
                    <span class="grand-total-value">&#8377;{{ number_format($fee->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            Thank you for choosing our services.
        </div>
    </div>
</body>
</html>
