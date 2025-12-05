<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Kyc Details</title>
    <style>
        /* Global Styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* --- Breadcrumb Styles --- */
        .breadcrumb {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }
        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb .icon {
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin-right: 5px;
        }
        
        /* --- Content Box Styles --- */
        .content-box {
            background-color: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .box-header {
            display: flex;
            align-items: center;
            background-color: #cce5ff; /* Light blue from image */
            border-bottom: 1px solid #b8daff;
            padding: 12px 15px;
            font-size: 16px;
            font-weight: 600;
            color: #004085; /* Darker blue text */
        }
        .box-header .icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }
        
        /* --- Filter Bar Styles --- */
        .filter-bar {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background-color: #fcfcfc;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .filter-bar label {
            font-size: 14px;
            font-weight: 500;
        }
        .filter-bar select,
        .filter-bar button {
            padding: 6px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .filter-bar button {
            background-color: #f0f0f0;
            cursor: pointer;
        }
        .filter-bar button:hover {
            background-color: #e2e2e2;
        }

        /* --- Table Styles --- */
        .table-responsive {
            width: 100%;
            overflow-x: auto; /* For small screens */
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            white-space: nowrap; /* Prevents text from wrapping */
        }
        .data-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
            border-top: 1px solid #eee; /* Matches header style */
        }
        .data-table tr:hover {
            background-color: #f5f5f5;
        }

        /* --- Status & Action Styles --- */
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 10px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            margin-right: 5px;
            transition: opacity 0.2s ease;
        }
        .action-btn .icon {
            width: 16px;
            height: 16px;
            margin-right: 5px;
        }
        .action-btn:hover {
            opacity: 0.8;
        }
        
        .btn-view {
            background-color: #007bff;
            color: white;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="breadcrumb">
        <a href="#">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Home
        </a>
        <span>&nbsp;&gt;&nbsp;</span>
        <span>Member Kyc Details</span>
    </nav>

    <div class="content-box">
        
        <div class="box-header">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            Member Kyc Details
        </div>

        <div class="filter-bar">
            <label for="status-filter">Status:</label>
            <select id="status-filter">
                <option value="pending" selected>Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <button type="button">Search</button>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Srl</th>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>MEM101</td>
                        <td>Anthony Alveriko</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td>2025-11-10</td>
                        <td>
                            <a href="#" class="action-btn btn-view">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </a>
                        </td>
                        <td>
                            <a href="#" class="action-btn btn-approve">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </a>
                            <a href="#" class="action-btn btn-reject">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>2</td>
                        <td>MEM102</td>
                        <td>Jane Doe</td>
                        <td><span class="status-badge status-approved">Approved</span></td>
                        <td>2025-11-09</td>
                        <td>
                            <a href="#" class="action-btn btn-view">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </a>
                        </td>
                        <td>-</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>MEM103</td>
                        <td>John Smith</td>
                        <td><span class="status-badge status-rejected">Rejected</span></td>
                        <td>2025-11-08</td>
                        <td>
                            <a href="#" class="action-btn btn-view">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </a>
                        </td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>