<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Report - {{ now()->format('d/m/Y H:i') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #6f42c1;
        }

        .header h1 {
            color: #6f42c1;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header .info {
            color: #666;
            font-size: 14px;
        }

        .filters {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .filter-item {
            margin: 5px 0;
        }

        .filter-item strong {
            color: #6f42c1;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 25px;
            text-align: center;
        }

        .stat-box {
            background: #6f42c1;
            color: white;
            padding: 15px;
            border-radius: 8px;
            min-width: 120px;
        }

        .stat-box .number {
            font-size: 24px;
            font-weight: bold;
        }

        .stat-box .label {
            font-size: 11px;
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #6f42c1;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 10px;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }

        .badge.new { background: #28a745; }
        .badge.contacted { background: #007bff; }
        .badge.qualified { background: #17a2b8; }
        .badge.converted { background: #ffc107; color: #333; }
        .badge.closed { background: #6c757d; }

        .source-badge {
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
        }

        .source-homepage { background: #007bff; color: white; }
        .source-contact_page { background: #17a2b8; color: white; }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 11px;
        }

        @media print {
            body {
                margin: 0;
                font-size: 10px;
            }
            
            .header {
                margin-bottom: 20px;
            }
            
            .header h1 {
                font-size: 18px;
            }
            
            table {
                font-size: 9px;
            }
            
            th, td {
                padding: 4px;
            }
            
            .stats {
                margin-bottom: 15px;
            }
            
            .stat-box {
                padding: 8px;
                margin: 0 5px;
            }
            
            .stat-box .number {
                font-size: 16px;
            }
        }

        @page {
            margin: 20mm;
            size: A4;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Leads Report</h1>
        <div class="info">
            Generated on {{ now()->format('F d, Y \a\t H:i') }}
            @if($leads->total() > 0)
                • Total: {{ $leads->total() }} leads
            @endif
        </div>
    </div>

    @if(!empty($filters) && array_filter($filters))
    <div class="filters">
        <div>
            @if(!empty($filters['search']))
                <div class="filter-item"><strong>Search:</strong> {{ $filters['search'] }}</div>
            @endif
            @if(!empty($filters['status']))
                <div class="filter-item"><strong>Status:</strong> {{ ucfirst($filters['status']) }}</div>
            @endif
        </div>
        <div>
            @if(!empty($filters['source']))
                <div class="filter-item"><strong>Source:</strong> {{ ucfirst($filters['source']) }}</div>
            @endif
            @if(!empty($filters['start_date']) || !empty($filters['end_date']))
                <div class="filter-item">
                    <strong>Date Range:</strong> 
                    {{ $filters['start_date'] ?? 'Any' }} - {{ $filters['end_date'] ?? 'Any' }}
                </div>
            @endif
        </div>
    </div>
    @endif

    <div class="stats">
        @php
            $leadsCollection = $leads->getCollection();
            $statusCounts = $leadsCollection->groupBy('status')->map->count();
            $sourceCounts = $leadsCollection->groupBy('source')->map->count();
        @endphp
        
        <div class="stat-box">
            <div class="number">{{ $leads->total() }}</div>
            <div class="label">Total Leads</div>
        </div>
        
        <div class="stat-box">
            <div class="number">{{ $statusCounts->get('new', 0) }}</div>
            <div class="label">New</div>
        </div>
        
        <div class="stat-box">
            <div class="number">{{ $statusCounts->get('contacted', 0) }}</div>
            <div class="label">Contacted</div>
        </div>
        
        <div class="stat-box">
            <div class="number">{{ $statusCounts->get('qualified', 0) }}</div>
            <div class="label">Qualified</div>
        </div>
        
        <div class="stat-box">
            <div class="number">{{ $statusCounts->get('converted', 0) }}</div>
            <div class="label">Converted</div>
        </div>
    </div>

    @if($leads->isEmpty())
        <div style="text-align: center; padding: 40px; color: #666;">
            <h3>No leads found</h3>
            <p>No leads match the selected criteria.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">ID</th>
                    <th style="width: 150px;">Name</th>
                    <th style="width: 180px;">Email</th>
                    <th style="width: 120px;">Phone</th>
                    <th style="width: 80px;">Source</th>
                    <th style="width: 80px;">Status</th>
                    <th style="width: 80px;">Date</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $lead)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td><strong>{{ $lead->name }}</strong></td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->full_phone }}</td>
                        <td>
                            <span class="source-badge source-{{ $lead->source }}">
                                {{ ucfirst($lead->source) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $lead->status }}">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>
                        <td>{{ $lead->created_at->format('d/m/Y') }}</td>
                        <td>{{ $lead->message ? \Illuminate\Support\Str::limit($lead->message, 100) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Generated by PixelPro3 Admin Panel • {{ config('app.name') }}</p>
        <p>Total records: {{ $leads->total() }} • Page generated at {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            // Small delay to ensure page is fully rendered
            setTimeout(function() {
                window.print();
            }, 500);
        };

        // Handle print dialog close - you can customize this behavior
        window.onafterprint = function() {
            // Optionally close the window after printing
            // window.close();
        };
    </script>
</body>
</html> 