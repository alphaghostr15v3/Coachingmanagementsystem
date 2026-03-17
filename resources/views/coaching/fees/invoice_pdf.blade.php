<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($fee->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            color: #1a1c1e; 
            line-height: 1.5; 
            font-size: 11px; 
            margin: 0; 
            padding: 0; 
            background: #fff; 
        }
        
        /* Layout Helpers */
        .clearfix::after { content: ""; clear: both; display: table; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .fw-black { font-weight: 900; }
        .text-muted { color: #6c757d; }
        .text-uppercase { text-transform: uppercase; }

        /* Header Section */
        .header { 
            background: #1a1c1e; 
            color: white; 
            padding: 35px 50px; 
        }
        .header-left { float: left; width: 50%; }
        .header-right { float: right; width: 45%; text-align: right; }
        
        .invoice-title { 
            font-size: 40px; 
            font-weight: 900; 
            margin: 0; 
            letter-spacing: -1px; 
            line-height: 1; 
        }
        .invoice-number { 
            font-size: 12px; 
            opacity: 0.8; 
            margin-top: 5px; 
        }
        
        .coaching-info { line-height: 1.4; }
        .coaching-name { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
        .header-meta { font-size: 10px; opacity: 0.8; margin-bottom: 2px; }
        
        .status-badge { 
            display: inline-block; 
            background: #198754; 
            color: white; 
            padding: 2px 8px; 
            border-radius: 3px; 
            font-size: 9px; 
            font-weight: bold; 
            text-transform: uppercase; 
            margin-top: 5px; 
        }
        .status-unpaid { background: #dc3545; }

        .container { padding: 40px 50px; }

        /* Details Section */
        .details-section { margin-bottom: 35px; width: 100%; border-collapse: collapse; }
        .details-col { vertical-align: top; width: 50%; }
        .details-label { 
            font-size: 9px; 
            font-weight: bold; 
            color: #6c757d; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
            margin-bottom: 8px; 
        }
        .details-value-main { font-size: 16px; font-weight: bold; margin: 0 0 4px 0; color: #1a1c1e; }
        .details-text { font-size: 10px; margin: 2px 0; color: #6c757d; }
        
        .gst-badge {
            background: #198754;
            color: white;
            padding: 1px 6px;
            border-radius: 2px;
            font-size: 9px;
            font-weight: bold;
        }
        .gst-badge-inter { background: #ffc107; color: #212529; }

        /* Main Table Styling */
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th { 
            border-bottom: 1px solid #dee2e6; 
            padding: 10px; 
            text-align: left; 
            font-size: 9px; 
            font-weight: bold; 
            color: #6c757d; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        .main-table td { padding: 15px 10px; border-bottom: 1px solid #f8f9fa; vertical-align: middle; }
        
        .item-name { font-weight: bold; font-size: 12px; color: #1a1c1e; margin-bottom: 2px; }
        .item-desc { font-size: 10px; color: #6c757d; }
        .item-price { font-size: 14px; font-weight: bold; color: #1a1c1e; }

        /* Bottom Section - Table based to prevent overlap */
        .bottom-section { width: 100%; margin-top: 30px; border-collapse: collapse; }
        .bottom-col { vertical-align: top; }
        
        .terms-list { 
            padding-left: 15px; 
            margin: 8px 0 0 0; 
            color: #6c757d; 
            font-size: 9px; 
            line-height: 1.5; 
        }
        .terms-list li { margin-bottom: 4px; }

        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-row td { padding: 4px 0; font-size: 11px; }
        .summary-label { color: #6c757d; text-align: left; width: 60%; }
        .summary-value { text-align: right; font-weight: bold; width: 40%; color: #1a1c1e; }
        .summary-value-light { font-weight: normal; color: #6c757d; }
        
        .total-row td { 
            border-top: 1px solid #dee2e6; 
            padding-top: 12px; 
            margin-top: 10px;
        }
        .total-label { font-size: 20px; font-weight: bold; text-align: left; vertical-align: bottom; }
        .total-value { font-size: 28px; font-weight: bold; color: #2563eb; text-align: right; vertical-align: bottom; }

        /* Footer */
        .footer { 
            position: fixed;
            bottom: 40px;
            left: 0;
            right: 0;
            text-align: center; 
            color: #adb5bd; 
            font-size: 10px; 
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="header-left">
            <h1 class="invoice-title">INVOICE</h1>
            <div class="invoice-number">#INV-{{ str_pad($fee->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div class="header-right">
            <div class="coaching-info">
                <div class="coaching-name">{{ auth()->user()->coaching->coaching_name ?? 'Coaching System' }}</div>
                @php
                    $coaching = auth()->user()->coaching;
                    $displayGst = $coaching ? $coaching->gst_number : $fee->institute_gst_number;
                @endphp
                @if(!empty(trim($displayGst)))
                    <div class="header-meta">GSTIN: <strong>{{ $displayGst }}</strong></div>
                @endif
                <div class="header-meta">Date: {{ \Carbon\Carbon::parse($fee->date)->format('d M, Y') }}</div>
                <div class="header-meta" style="margin-top: 5px;">
                    <table style="width: auto; margin-left: auto; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 0; vertical-align: middle; color: white; opacity: 0.8; font-weight: bold; font-size: 10px; padding-right: 5px;">Status:</td>
                            <td style="padding: 0; vertical-align: middle;">
                                <span class="status-badge {{ $fee->status !== 'paid' ? 'status-unpaid' : '' }}" style="margin: 0; padding: 3px 8px;">{{ $fee->status }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Using table for details to ensure alignment in Dompdf -->
        <table class="details-section">
            <tr>
                <td class="details-col">
                    <div class="details-label">Invoice To:</div>
                    <div class="details-value-main">{{ $fee->student->name }}</div>
                    <div class="details-text">Student ID: #STU{{ str_pad($fee->student_id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="details-text">Email: {{ $fee->student->email ?? 'N/A' }}</div>
                    @if($fee->student_state)
                        <div class="details-text">State: <span style="color: #1a1c1e; font-weight: 500;">{{ $fee->student_state }}</span></div>
                    @endif
                </td>
                <td class="details-col text-right">
                    <div class="details-label">Payment Details:</div>
                    <div class="details-text">Payment Method: <span style="color: #1a1c1e; font-weight: 500;">Offline/Cash</span></div>
                    <div class="details-text">Currency: <span style="color: #1a1c1e; font-weight: bold;">INR (&#8377;)</span></div>
                    @php
                        $hasTax = ($fee->cgst_amount + $fee->sgst_amount + $fee->igst_amount) > 0;
                    @endphp
                    @if($hasTax && $fee->gst_type)
                        <div class="details-text" style="margin-top: 5px;">
                             GST Type: 
                            <span class="gst-badge {{ $fee->gst_type == 'inter' ? 'gst-badge-inter' : '' }}">
                                {{ $fee->gst_type == 'intra' ? 'Intra-State (CGST+SGST)' : 'Inter-State (IGST)' }}
                            </span>
                            @php
                                $coaching = auth()->user()->coaching;
                                $displayState = $coaching ? $coaching->state : $fee->institute_state;
                            @endphp
                            @if($displayState) <span style="margin-left: 5px;">| Inst: <strong>{{ $displayState }}</strong></span> @endif
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 55%;">Description</th>
                    <th class="text-center" style="width: 20%;">HSN/SAC</th>
                    <th class="text-right" style="width: 25%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="item-name">Coaching / Tuition Fee</div>
                        <div class="item-desc">Course: {{ $fee->student->course->name ?? 'Active Course' }}</div>
                    </td>
                    <td class="text-center text-muted">999293</td>
                    <td class="text-right">
                        <div class="item-price">&#8377;{{ number_format($fee->amount, 2) }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Using table for bottom section to strictly prevent overlaps -->
        <table class="bottom-section">
            <tr>
                <td class="bottom-col" style="width: 55%;">
                    <div class="details-label">Terms & Conditions</div>
                    <ul class="terms-list">
                        <li>Fees once paid are non-refundable and non-transferable.</li>
                        <li>Please keep this invoice for future reference.</li>
                    </ul>


                </td>
                <td class="bottom-col" style="width: 40%; padding-left: 5%;">
                    <table class="summary-table">
                        <tr class="summary-row">
                            <td class="summary-label">Subtotal (Base):</td>
                            <td class="summary-value">&#8377;{{ number_format($fee->amount, 2) }}</td>
                        </tr>

                        @if($fee->cgst_amount > 0)
                        <tr class="summary-row">
                            <td class="summary-label">CGST ({{ number_format($fee->cgst_rate, 2) }}%):</td>
                            <td class="summary-value summary-value-light">&#8377;{{ number_format($fee->cgst_amount, 2) }}</td>
                        </tr>
                        @endif

                        @if($fee->sgst_amount > 0)
                        <tr class="summary-row">
                            <td class="summary-label">SGST ({{ number_format($fee->sgst_rate, 2) }}%):</td>
                            <td class="summary-value summary-value-light">&#8377;{{ number_format($fee->sgst_amount, 2) }}</td>
                        </tr>
                        @endif

                        @if($fee->igst_amount > 0)
                        <tr class="summary-row">
                            <td class="summary-label">IGST ({{ number_format($fee->igst_rate, 2) }}%):</td>
                            <td class="summary-value summary-value-light">&#8377;{{ number_format($fee->igst_amount, 2) }}</td>
                        </tr>
                        @endif

                        <tr class="total-row">
                            <td class="total-label">Total:</td>
                            <td class="total-value">&#8377;{{ number_format($fee->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for choosing our services.</p>
        </div>
    </div>
</body>
</html>
