<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rank Income Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .logo {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            background-color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .table-container {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        
        table {
            margin-bottom: 0;
        }
        
        thead {
            background-color: var(--light-bg);
        }
        
        th {
            font-weight: 600;
            padding: 15px 12px;
            border-bottom: 2px solid #dee2e6;
        }
        
        td {
            padding: 12px;
            vertical-align: middle;
        }
        
        .badge-rank {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .income-amount {
            font-weight: 600;
            color: var(--accent-color);
        }
        
        .filter-section {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        }
        
        .stats-card.primary {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
        }
        
        .stats-card.success {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }
        
        .stats-card.warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }
        
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .stats-card .value {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stats-card .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block">
                <div class="logo">
                    <h3><i class="fas fa-chart-line"></i> MLM System</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i> Members
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-money-bill-wave"></i> Income Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="header">
                    <h2><i class="fas fa-money-bill-wave me-2"></i> Rank Income Details</h2>
                    <div class="user-info">
                        <span class="me-2">Welcome, Admin</span>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=3498db&color=fff" class="rounded-circle" width="40" alt="User">
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-card primary">
                            <i class="fas fa-wallet"></i>
                            <div class="value">$12,580</div>
                            <div class="label">Total Rank Income</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card success">
                            <i class="fas fa-user-tie"></i>
                            <div class="value">24</div>
                            <div class="label">Diamond Members</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card warning">
                            <i class="fas fa-users"></i>
                            <div class="value">156</div>
                            <div class="label">Gold Members</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card primary">
                            <i class="fas fa-calendar-alt"></i>
                            <div class="value">Oct 2023</div>
                            <div class="label">Current Period</div>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dateRange" class="form-label">Date Range</label>
                                <input type="text" class="form-control" id="dateRange" placeholder="Select Date Range">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="memberCode" class="form-label">Member Code</label>
                                <input type="text" class="form-control" id="memberCode" placeholder="Enter Member Code">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="rankName" class="form-label">Rank Name</label>
                                <select class="form-select" id="rankName">
                                    <option value="">All Ranks</option>
                                    <option value="Bronze">Bronze</option>
                                    <option value="Silver">Silver</option>
                                    <option value="Gold">Gold</option>
                                    <option value="Platinum">Platinum</option>
                                    <option value="Diamond">Diamond</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i> Apply Filters</button>
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Member Code</th>
                                <th>Full Name</th>
                                <th>Self Business</th>
                                <th>Left Team Business</th>
                                <th>Right Team Business</th>
                                <th>Rank Name</th>
                                <th>Rank Income</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MLM001</td>
                                <td>John Smith</td>
                                <td>$5,250</td>
                                <td>$12,500</td>
                                <td>$10,800</td>
                                <td><span class="badge-rank">Diamond</span></td>
                                <td class="income-amount">$1,250</td>
                                <td>2023-10-15</td>
                            </tr>
                            <tr>
                                <td>MLM002</td>
                                <td>Sarah Johnson</td>
                                <td>$3,800</td>
                                <td>$8,200</td>
                                <td>$7,500</td>
                                <td><span class="badge-rank">Platinum</span></td>
                                <td class="income-amount">$850</td>
                                <td>2023-10-14</td>
                            </tr>
                            <tr>
                                <td>MLM003</td>
                                <td>Michael Brown</td>
                                <td>$2,500</td>
                                <td>$6,800</td>
                                <td>$5,200</td>
                                <td><span class="badge-rank">Gold</span></td>
                                <td class="income-amount">$520</td>
                                <td>2023-10-13</td>
                            </tr>
                            <tr>
                                <td>MLM004</td>
                                <td>Emily Davis</td>
                                <td>$4,200</td>
                                <td>$9,500</td>
                                <td>$8,800</td>
                                <td><span class="badge-rank">Platinum</span></td>
                                <td class="income-amount">$950</td>
                                <td>2023-10-12</td>
                            </tr>
                            <tr>
                                <td>MLM005</td>
                                <td>Robert Wilson</td>
                                <td>$1,800</td>
                                <td>$4,500</td>
                                <td>$3,800</td>
                                <td><span class="badge-rank">Silver</span></td>
                                <td class="income-amount">$320</td>
                                <td>2023-10-11</td>
                            </tr>
                            <tr>
                                <td>MLM006</td>
                                <td>Jennifer Lee</td>
                                <td>$6,500</td>
                                <td>$15,200</td>
                                <td>$14,500</td>
                                <td><span class="badge-rank">Diamond</span></td>
                                <td class="income-amount">$1,550</td>
                                <td>2023-10-10</td>
                            </tr>
                            <tr>
                                <td>MLM007</td>
                                <td>David Miller</td>
                                <td>$2,200</td>
                                <td>$5,800</td>
                                <td>$4,500</td>
                                <td><span class="badge-rank">Gold</span></td>
                                <td class="income-amount">$480</td>
                                <td>2023-10-09</td>
                            </tr>
                            <tr>
                                <td>MLM008</td>
                                <td>Lisa Anderson</td>
                                <td>$3,500</td>
                                <td>$7,800</td>
                                <td>$6,900</td>
                                <td><span class="badge-rank">Gold</span></td>
                                <td class="income-amount">$620</td>
                                <td>2023-10-08</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="showing-text">
                        Showing 1 to 8 of 42 entries
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script to highlight active sidebar link
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.href;
            const menuItems = document.querySelectorAll('.nav-link');
            
            menuItems.forEach(item => {
                if(item.href === currentLocation) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>