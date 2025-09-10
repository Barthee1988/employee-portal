<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	
	<!-- DataTables core -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

	<!-- Bootstrap 5 integration -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .logo {
            height: 40px;
            width: auto;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .logo.collapsed {
            height: 30px;
        }

        .company-name {
            font-size: 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .company-name.collapsed {
            font-size: 1.2rem;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            margin-right: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .menu-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        .header-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-photo {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .notification-icon, .logout-icon {
            position: relative;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .notification-icon:hover, .logout-icon:hover {
            background: rgba(255,255,255,0.1);
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transform: translateX(0);
            transition: transform 0.3s ease;
            z-index: 1020;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #eee;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
        }

        .sidebar-menu i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--header-height));
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .card-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
            margin-bottom: 20px;
        }

        .stat-card.primary { background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); }
        .stat-card.success { background: linear-gradient(135deg, var(--success-color), #2ecc71); }
        .stat-card.warning { background: linear-gradient(135deg, var(--warning-color), #e67e22); }
        .stat-card.danger { background: linear-gradient(135deg, var(--accent-color), #c0392b); }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Forms */
        .form-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        /* Buttons */
        .btn-custom {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }

        /* Attendance Calendar */
        .attendance-calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            background: white;
            border-radius: 10px;
            padding: 20px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .calendar-day:hover {
            transform: scale(1.1);
            z-index: 10;
        }

        .calendar-header {
            font-weight: 600;
            background: var(--primary-color);
            color: white;
        }

        /* Attendance Color Codes */
        .time-915-930 { background-color: #27ae60; }
        .time-930-1000 { background-color: #f39c12; }
        .time-after-1000 { background-color: #e74c3c; color: white; }
        .present { background-color: #2ecc71; color: white; }
        .holiday { background-color: #9b59b6; color: white; }
        .on-duty { background-color: #3498db; color: white; }
        .wfh { background-color: #1abc9c; color: white; }
        .maternity { background-color: #e91e63; color: white; }
        .week-off { background-color: #95a5a6; color: white; }
        .leave { background-color: #f39c12; color: white; }
        .absent { background-color: #e74c3c; color: white; }

        /* Legend */
        .legend {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }

        /* DataTables Customization */
        .dataTables_wrapper {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                padding: 0 15px;
            }

            .company-name {
                display: none;
            }

            .stat-card {
                margin-bottom: 15px;
            }

            .attendance-calendar {
                font-size: 0.7rem;
            }

            .dashboard-card {
                padding: 20px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .header-right {
                gap: 10px;
            }

            .user-profile {
                gap: 5px;
            }

            .profile-photo {
                width: 30px;
                height: 30px;
            }

            .legend {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Animations */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .slide-in-right { animation: slideInRight 0.5s ease-out; }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }

        /* Modal Customizations */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .file-upload-button:hover {
            border-color: var(--secondary-color);
            background: rgba(52, 152, 219, 0.1);
        }

        .file-upload-button i {
            font-size: 2rem;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        /* Status Badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d1edff; color: #0c5460; }
        .status-rejected { background: #f8d7da; color: #721c24; }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner-border {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="logo-section">
            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23fff'/%3E%3Ctext x='50' y='60' text-anchor='middle' font-size='40' font-weight='bold' fill='%232c3e50'%3EEP%3C/text%3E%3C/svg%3E" 
                 alt="Company Logo" class="logo" id="companyLogo">
            <span class="company-name" id="companyName">Employee Portal</span>
        </div>

        <div class="header-right">
            <div class="notification-icon" onclick="showNotifications()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
            
            <div class="user-profile">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23ddd'/%3E%3Ccircle cx='50' cy='35' r='15' fill='%23666'/%3E%3Cpath d='M20 85 Q20 65 50 65 Q80 65 80 85 Z' fill='%23666'/%3E%3C/svg%3E" 
                     alt="Profile Photo" class="profile-photo">
            </div>
            
            <div class="logout-icon" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="#" class="menu-item active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a></li>
            <li><a href="#" class="menu-item" data-section="profile">
                <i class="fas fa-user"></i> My Profile
            </a></li>
            <li><a href="#" class="menu-item" data-section="payroll">
                <i class="fas fa-money-bill-wave"></i> Payroll
            </a></li>
            <li><a href="#" class="menu-item" data-section="attendance">
                <i class="fas fa-calendar-check"></i> Attendance
            </a></li>
            <li><a href="#" class="menu-item" data-section="leave">
                <i class="fas fa-calendar-times"></i> Leave Management
            </a></li>
            <li><a href="#" class="menu-item" data-section="loan">
                <i class="fas fa-hand-holding-usd"></i> Loan Management
            </a></li>
            <li><a href="#" class="menu-item" data-section="feedback">
                <i class="fas fa-comments"></i> Feedback
            </a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Dashboard Section -->
        <section id="dashboard" class="content-section fade-in-up">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card primary">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Total Leave Days</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card warning">
                        <div class="stat-number">2</div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card success">
                        <div class="stat-number">₹15,000</div>
                        <div class="stat-label">Pending EMI</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card danger">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Attendance Rate</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i>
                                Recent Activity
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="recentActivityTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2025-09-05</td>
                                        <td>Leave Request - Sick Leave</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>2025-09-03</td>
                                        <td>Salary Certificate Request</td>
                                        <td><span class="status-badge status-approved">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td>2025-09-01</td>
                                        <td>Profile Update - Address</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bell"></i>
                                Notifications
                            </h3>
                        </div>
                        <div class="notification-list">
                            <div class="notification-item mb-3 p-3 border rounded">
                                <strong>Leave Approved</strong>
                                <p class="mb-1 text-muted">Your medical leave has been approved.</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                            <div class="notification-item mb-3 p-3 border rounded">
                                <strong>Salary Slip Available</strong>
                                <p class="mb-1 text-muted">September salary slip is now available.</p>
                                <small class="text-muted">1 day ago</small>
                            </div>
                            <div class="notification-item p-3 border rounded">
                                <strong>Profile Update Required</strong>
                                <p class="mb-1 text-muted">Please update your emergency contact.</p>
                                <small class="text-muted">3 days ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Profile Section -->
        <section id="profile" class="content-section" style="">
            <div class="form-section">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        My Profile
                    </h3>
                </div>
                
                <div class="row">
                    <div class="col-lg-3 text-center">
                        <div class="profile-photo-section mb-4">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='90' fill='%23ddd'/%3E%3Ccircle cx='100' cy='70' r='30' fill='%23666'/%3E%3Cpath d='M40 170 Q40 130 100 130 Q160 130 160 170 Z' fill='%23666'/%3E%3C/svg%3E" 
                                 class="rounded-circle mb-3" width="150" height="150" alt="Profile Photo">
                            <div>
                                <button class="btn btn-custom btn-sm" onclick="uploadPhoto()">
                                    <i class="fas fa-camera"></i> Change Photo
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-9">
                        <form id="profileForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" value="EMP001" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" value="John Doe">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="john.doe@company.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" value="+91 9876543210">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Department</label>
                                        <select class="form-control">
                                            <option>Information Technology</option>
                                            <option>Human Resources</option>
                                            <option>Finance</option>
                                            <option>Marketing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Designation</label>
                                        <input type="text" class="form-control" value="Senior Developer">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Permanent Address</label>
                                        <textarea class="form-control" rows="3">123 Main Street, City, State - 123456</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Temporary Address</label>
                                        <textarea class="form-control" rows="3">Same as permanent address</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-custom">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Payroll Section -->
        <section id="payroll" class="content-section" style="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice-dollar"></i>
                                Salary Slips
                            </h3>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table" id="salarySlipsTable">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Gross Salary</th>
                                        <th>Net Salary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>September</td>
                                        <td>2025</td>
                                        <td>₹75,000</td>
                                        <td>₹65,500</td>
                                        <td><button class="btn btn-sm btn-custom-danger" onclick="downloadSalarySlip('2025-09')">
                                            <i class="fas fa-download"></i> Download
                                        </button></td>
                                    </tr>
                                    <tr>
                                        <td>August</td>
                                        <td>2025</td>
                                        <td>₹75,000</td>
                                        <td>₹65,500</td>
                                        <td><button class="btn btn-sm btn-custom" onclick="downloadSalarySlip('2025-08')">
                                            <i class="fas fa-download"></i> Download
                                        </button></td>
                                    </tr>
                                    <tr>
                                        <td>July</td>
                                        <td>2025</td>
                                        <td>₹75,000</td>
                                        <td>₹65,500</td>
                                        <td><button class="btn btn-sm btn-custom" onclick="downloadSalarySlip('2025-07')">
                                            <i class="fas fa-download"></i> Download
                                        </button></td>
                                    </tr>
                                    <tr>
                                        <td>June</td>
                                        <td>2025</td>
                                        <td>₹75,000</td>
                                        <td>₹65,500</td>
                                        <td><button class="btn btn-sm btn-custom" onclick="downloadSalarySlip('2025-06')">
                                            <i class="fas fa-download"></i> Download
                                        </button></td>
                                    </tr>
                                    <tr>
                                        <td>May</td>
                                        <td>2025</td>
                                        <td>₹75,000</td>
                                        <td>₹65,500</td>
                                        <td><button class="btn btn-sm btn-custom" onclick="downloadSalarySlip('2025-05')">
                                            <i class="fas fa-download"></i> Download
                                        </button></td>
                                    </tr>
                                    <tr>
                                        <td>April</td>
                                        <td>2025</td>
                                        <td>₹75,000</td>
                                        <td>₹65,500</td>
                                        <td><button class="btn btn-sm btn-custom" onclick="downloadSalarySlip('2025-04')">
                                            <i class="fas fa-download"></i> Download
                                        </button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calculator"></i>
                                Current Salary Structure
                            </h3>
                        </div>
                        
                        <div class="salary-breakdown">
                            <div class="row mb-3">
                                <div class="col-6"><strong>Basic Salary:</strong></div>
                                <div class="col-6 text-end">₹35,000</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>HRA:</strong></div>
                                <div class="col-6 text-end">₹14,000</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Conveyance:</strong></div>
                                <div class="col-6 text-end">₹1,600</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Medical:</strong></div>
                                <div class="col-6 text-end">₹1,250</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Special Allowance:</strong></div>
                                <div class="col-6 text-end">₹23,150</div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Gross Salary:</strong></div>
                                <div class="col-6 text-end"><strong>₹75,000</strong></div>
                            </div>
                            <hr>
                            <div class="row mb-3 text-danger">
                                <div class="col-6">PF Contribution:</div>
                                <div class="col-6 text-end">-₹4,200</div>
                            </div>
                            <div class="row mb-3 text-danger">
                                <div class="col-6">Professional Tax:</div>
                                <div class="col-6 text-end">-₹200</div>
                            </div>
                            <div class="row mb-3 text-danger">
                                <div class="col-6">Income Tax:</div>
                                <div class="col-6 text-end">-₹5,100</div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-6"><strong>Net Salary:</strong></div>
                                <div class="col-6 text-end"><strong class="text-success">₹65,500</strong></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-certificate"></i>
                                Salary Certificate
                            </h3>
                        </div>
                        
                        <form id="certificateRequestForm">
                            <div class="form-group">
                                <label class="form-label">Purpose</label>
                                <select class="form-control" required>
                                    <option value="">Select Purpose</option>
                                    <option value="loan">Loan Application</option>
                                    <option value="visa">Visa Application</option>
                                    <option value="rent">House Rent</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Additional Details</label>
                                <textarea class="form-control" rows="3" placeholder="Please specify any additional requirements..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-custom w-100">
                                <i class="fas fa-paper-plane"></i> Request Certificate
                            </button>
                        </form>
                        
                        <div class="mt-4">
                            <h6>Recent Requests:</h6>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Loan Application</strong>
                                        <br><small class="text-muted">Requested: 2025-09-01</small>
                                    </div>
                                    <span class="status-badge status-approved">Ready</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Visa Application</strong>
                                        <br><small class="text-muted">Requested: 2025-08-28</small>
                                    </div>
                                    <span class="status-badge status-pending">Processing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Attendance Section -->
        <section id="attendance" class="content-section" style="">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check"></i>
                        Attendance - September 2025
                    </h3>
                    <div class="attendance-navigation">
                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="previousMonth()">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="nextMonth()">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                
                <div class="attendance-calendar" id="attendanceCalendar">
                    <!-- Calendar headers -->
                    <div class="calendar-day calendar-header">Sun</div>
                    <div class="calendar-day calendar-header">Mon</div>
                    <div class="calendar-day calendar-header">Tue</div>
                    <div class="calendar-day calendar-header">Wed</div>
                    <div class="calendar-day calendar-header">Thu</div>
                    <div class="calendar-day calendar-header">Fri</div>
                    <div class="calendar-day calendar-header">Sat</div>
                    
                    <!-- Calendar days will be populated by JavaScript -->
                </div>
                
                <!-- Legend -->
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color time-915-930"></div>
                        <span>On Time (9:15-9:30 AM)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color time-930-1000"></div>
                        <span>Late (9:30-10:00 AM)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color time-after-1000"></div>
                        <span>Very Late (After 10:00 AM)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color present"></div>
                        <span>P - Present</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color holiday"></div>
                        <span>H - Holiday</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color on-duty"></div>
                        <span>O - On Duty</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color wfh"></div>
                        <span>W - Work From Home</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color maternity"></div>
                        <span>M - Maternity Leave</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color week-off"></div>
                        <span>WO - Week Off</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color leave"></div>
                        <span>L - Leave</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color absent"></div>
                        <span>A - Absent</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Leave Management Section -->
        <section id="leave" class="content-section" style="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-times"></i>
                                My Leave Requests
                            </h3>
                            <button class="btn btn-custom" onclick="showLeaveRequestModal()">
                                <i class="fas fa-plus"></i> New Request
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table" id="leaveRequestsTable">
                                <thead>
                                    <tr>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Days</th>
                                        <th>Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2025-09-10</td>
                                        <td>2025-09-12</td>
                                        <td>3</td>
                                        <td>Sick Leave</td>
                                        <td>Medical Treatment</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editLeaveRequest(1)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="cancelLeaveRequest(1)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2025-08-25</td>
                                        <td>2025-08-27</td>
                                        <td>3</td>
                                        <td>Casual Leave</td>
                                        <td>Personal Work</td>
                                        <td><span class="status-badge status-approved">Approved</span></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>2025-08-15</td>
                                        <td>2025-08-15</td>
                                        <td>0.5</td>
                                        <td>Casual Leave</td>
                                        <td>Doctor Appointment</td>
                                        <td><span class="status-badge status-approved">Approved</span></td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie"></i>
                                Leave Balance
                            </h3>
                        </div>
                        
                        <div class="leave-balance">
                            <div class="row mb-3">
                                <div class="col-8">Casual Leave:</div>
                                <div class="col-4 text-end"><strong>8/12</strong></div>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 66.67%"></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-8">Sick Leave:</div>
                                <div class="col-4 text-end"><strong>5/12</strong></div>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 41.67%"></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-8">Personal Leave:</div>
                                <div class="col-4 text-end"><strong>15/12</strong></div>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: 83.33%"></div>
                            </div>
							
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-secondary" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i>
                                Team Leave Status
                            </h3>
                        </div>
                        
                        <div class="team-leave-status">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Jane Smith</span>
                                <span class="badge bg-warning">On Leave</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Mike Johnson</span>
                                <span class="badge bg-success">Available</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Sarah Wilson</span>
                                <span class="badge bg-info">Work From Home</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>David Brown</span>
                                <span class="badge bg-success">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Loan Management Section -->
        <section id="loan" class="content-section" style="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-hand-holding-usd"></i>
                                My Loan Requests
                            </h3>
                            <button class="btn btn-custom" onclick="showLoanRequestModal()">
                                <i class="fas fa-plus"></i> New Loan Request
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table" id="loanRequestsTable">
                                <thead>
                                    <tr>
                                        <th>Request Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Installments</th>
                                        <th>EMI</th>
                                        <th>Status</th>
                                        <th>Remaining</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2024-06-15</td>
                                        <td>Medical</td>
                                        <td>₹50,000</td>
                                        <td>10</td>
                                        <td>₹5,000</td>
                                        <td><span class="status-badge status-approved">Active</span></td>
                                        <td>3 EMIs</td>
                                    </tr>
                                    <tr>
                                        <td>2023-12-10</td>
                                        <td>Education</td>
                                        <td>₹30,000</td>
                                        <td>12</td>
                                        <td>₹2,500</td>
                                        <td><span class="status-badge status-approved">Completed</span></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>2025-08-28</td>
                                        <td>Medical</td>
                                        <td>₹25,000</td>
                                        <td>8</td>
                                        <td>₹3,125</td>
                                        <td><span class="status-badge status-pending">Under Review</span></td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i>
                                EMI Schedule
                            </h3>
                        </div>
                        
                        <div class="emi-schedule">
                            <div class="alert alert-info">
                                <strong>Current Active Loan:</strong><br>
                                Medical Loan - ₹50,000<br>
                                <strong>Monthly EMI:</strong> ₹5,000<br>
                                <strong>Remaining:</strong> 3 installments
                            </div>
                            
                            <h6>Upcoming EMIs:</h6>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>October 2025</span>
                                    <strong>₹5,000</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>November 2025</span>
                                    <strong>₹5,000</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>December 2025</span>
                                    <strong>₹5,000</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i>
                                Loan Eligibility
                            </h3>
                        </div>
                        
                        <div class="loan-eligibility">
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <strong>You are eligible for loans!</strong><br>
                                <small>Completed 1+ years of service</small>
                            </div>
                            
                            <div class="eligibility-details">
                                <div class="row mb-2">
                                    <div class="col-8">Service Period:</div>
                                    <div class="col-4 text-end"><strong>2.5 years</strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">Max Loan Amount:</div>
                                    <div class="col-4 text-end"><strong>₹2,00,000</strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">Current Utilization:</div>
                                    <div class="col-4 text-end"><strong>₹15,000</strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">Available Amount:</div>
                                    <div class="col-4 text-end"><strong class="text-success">₹1,85,000</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feedback Section -->
        <section id="feedback" class="content-section" style="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-comments"></i>
                                My Feedback & Requests
                            </h3>
                            <button class="btn btn-custom" onclick="showFeedbackModal()">
                                <i class="fas fa-plus"></i> Submit Feedback
                            </button>
                        </div>
                        
                        <div class="feedback-list">
                            <div class="feedback-item mb-4 p-4 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">Request for Flexible Working Hours</h6>
                                        <small class="text-muted">Submitted: 2025-09-01 | Category: Policy</small>
                                    </div>
                                    <span class="status-badge status-approved">Responded</span>
                                </div>
                                <p class="mb-3">I would like to request for flexible working hours due to my child's school timings. I can work from 10 AM to 7 PM instead of the current 9 AM to 6 PM schedule.</p>
                                
                                <div class="hr-response bg-light p-3 rounded">
                                    <strong>HR Response:</strong><br>
                                    <p class="mb-0">Thank you for your request. We have reviewed your case and approved flexible working hours as requested. Please coordinate with your team lead for smooth transition. This will be effective from September 15, 2025.</p>
                                    <small class="text-muted">Responded on: 2025-09-03</small>
                                </div>
                            </div>
                            
                            <div class="feedback-item mb-4 p-4 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">Suggestion for Team Building Activities</h6>
                                        <small class="text-muted">Submitted: 2025-08-28 | Category: Engagement</small>
                                    </div>
                                    <span class="status-badge status-pending">Under Review</span>
                                </div>
                                <p class="mb-0">I suggest organizing monthly team building activities to improve collaboration and team spirit. This could include outdoor activities, workshops, or team lunches.</p>
                            </div>
                            
                            <div class="feedback-item mb-4 p-4 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">Issue with Cafeteria Food Quality</h6>
                                        <small class="text-muted">Submitted: 2025-08-20 | Category: Facilities</small>
                                    </div>
                                    <span class="status-badge status-approved">Resolved</span>
                                </div>
                                <p class="mb-3">The food quality in the cafeteria has been declining recently. Several employees have complained about the taste and hygiene standards.</p>
                                
                                <div class="hr-response bg-light p-3 rounded">
                                    <strong>HR Response:</strong><br>
                                    <p class="mb-0">Thank you for bringing this to our attention. We have discussed this with the cafeteria vendor and implemented new quality control measures. We have also changed to a new vendor with better standards. Please let us know if you notice any further issues.</p>
                                    <small class="text-muted">Responded on: 2025-08-25</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar"></i>
                                Feedback Statistics
                            </h3>
                        </div>
                        
                        <div class="feedback-stats">
                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Total Submitted:</span>
                                    <span class="badge bg-primary">12</span>
                                </div>
                            </div>
                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Responded:</span>
                                    <span class="badge bg-success">8</span>
                                </div>
                            </div>
                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Under Review:</span>
                                    <span class="badge bg-warning">3</span>
                                </div>
                            </div>
                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Resolved:</span>
                                    <span class="badge bg-info">1</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h6>Response Time:</h6>
                            <p class="text-muted">Average response time: <strong>2.3 days</strong></p>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                            <small class="text-muted">85% responses within 3 days</small>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-lightbulb"></i>
                                Quick Feedback
                            </h3>
                        </div>
                        
                        <div class="quick-feedback">
                            <p>Have a quick suggestion or concern? Use these shortcuts:</p>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="quickFeedback('IT Support')">
                                    <i class="fas fa-laptop"></i> IT Support Issue
                                </button>
                                <button class="btn btn-outline-success btn-sm" onclick="quickFeedback('Facilities')">
                                    <i class="fas fa-building"></i> Facility Request
                                </button>
                                <button class="btn btn-outline-warning btn-sm" onclick="quickFeedback('Policy')">
                                    <i class="fas fa-file-alt"></i> Policy Query
                                </button>
                                <button class="btn btn-outline-info btn-sm" onclick="quickFeedback('General')">
                                    <i class="fas fa-comment"></i> General Feedback
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modals -->
    
    <!-- Leave Request Modal -->
    <div class="modal fade" id="leaveRequestModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus"></i> New Leave Request
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="leaveRequestForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Leave Type</label>
                                    <select class="form-control" required>
                                        <option value="">Select Leave Type</option>
                                        <option value="casual">Casual Leave</option>
                                        <option value="sick">Sick Leave</option>
                                        <option value="earned">Earned Leave</option>
                                        <option value="maternity">Maternity Leave</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Leave Duration</label>
                                    <select class="form-control" onchange="toggleDateFields(this.value)">
                                        <option value="full">Full Day</option>
                                        <option value="half">Half Day</option>
                                        <option value="multiple">Multiple Days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">From Date</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="toDateField">
                                    <label class="form-label">To Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" id="halfDayField" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Half Day Period</label>
                                    <select class="form-control">
                                        <option value="forenoon">Forenoon (First Half)</option>
                                        <option value="afternoon">Afternoon (Second Half)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Substitute Employee</label>
                                    <select class="form-control">
                                        <option value="">Select Substitute</option>
                                        <option value="jane">Jane Smith</option>
                                        <option value="mike">Mike Johnson</option>
                                        <option value="sarah">Sarah Wilson</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" placeholder="Please provide reason for leave..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12" id="medicalUploadField" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Medical Certificate (PDF only)</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" class="file-upload-input" accept=".pdf">
                                        <div class="file-upload-button">
                                            <div class="text-center">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <div>Click to upload medical certificate</div>
                                                <small class="text-muted">PDF files only, max 5MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" onclick="submitLeaveRequest()">
                        <i class="fas fa-paper-plane"></i> Submit Request
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Request Modal -->
    <div class="modal fade" id="loanRequestModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-hand-holding-usd"></i> New Loan Request
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loanRequestForm">
                        <div class="form-group">
                            <label class="form-label">Loan Type</label>
                            <select class="form-control" required>
                                <option value="">Select Loan Type</option>
                                <option value="medical">Medical</option>
                                <option value="education">Education</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Loan Amount (₹)</label>
                            <input type="number" class="form-control" placeholder="Enter amount" 
                                   min="1000" max="200000" onchange="calculateEMI()" required>
                            <small class="text-muted">Maximum: ₹2,00,000 (Available: ₹1,85,000)</small>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Number of Installments</label>
                            <select class="form-control" onchange="calculateEMI()" required>
                                <option value="">Select Installments</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months</option>
                                <option value="18">18 Months</option>
                                <option value="24">24 Months</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Monthly EMI</label>
                            <input type="text" class="form-control" id="emiAmount" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Reason</label>
                            <textarea class="form-control" rows="3" placeholder="Please provide reason for loan..." required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" onclick="submitLoanRequest()">
                        <i class="fas fa-paper-plane"></i> Submit Request
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-comment-alt"></i> Submit Feedback
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="feedbackForm">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="policy">Policy</option>
                                <option value="facilities">Facilities</option>
                                <option value="it_support">IT Support</option>
                                <option value="hr_services">HR Services</option>
                                <option value="engagement">Employee Engagement</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" placeholder="Brief subject line..." required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="feedback">Feedback</option>
                                <option value="suggestion">Suggestion</option>
                                <option value="complaint">Complaint</option>
                                <option value="request">Request</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Please provide detailed feedback..." required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Priority</label>
                            <select class="form-control" required>
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" onclick="submitFeedback()">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="spinner-border mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>Processing...</div>
                </div>
            </div>
        </div>
    </div>
	<!-- jQuery (required by DataTables) -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

	<!-- DataTables core -->
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

	<!-- Bootstrap 5 integration -->
	<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Global variables
        let currentMonth = 9; // September
        let currentYear = 2025;
        let sidebarCollapsed = false;

        // Initialize application
        $(document).ready(function() {
            initializeDataTables();
            generateAttendanceCalendar();
            setupEventListeners();
            
            // Check for mobile device
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        });

        // Initialize DataTables
        function initializeDataTables() {
            $('#recentActivityTable').DataTable({
                responsive: true,
                pageLength: 5,
                lengthChange: false,
                searching: false,
                info: false
            });

            $('#salarySlipsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[1, 'desc']]
            });

            $('#leaveRequestsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']]
            });

            $('#loanRequestsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']]
            });
        }

        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const logo = document.getElementById('companyLogo');
            const companyName = document.getElementById('companyName');
            
            sidebarCollapsed = !sidebarCollapsed;
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
            
            // Animate logo and company name
            if (sidebarCollapsed) {
                logo.classList.add('collapsed');
                companyName.classList.add('collapsed');
            } else {
                logo.classList.remove('collapsed');
                companyName.classList.remove('collapsed');
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Menu navigation
            $('.menu-item').click(function(e) {
                e.preventDefault();
                
                // Update active menu
                $('.menu-item').removeClass('active');
                $(this).addClass('active');
                
                // Show corresponding section
                const section = $(this).data('section');
                $('.content-section').hide();
                $(`#${section}`).show().addClass('fade-in-up');
                
                // Close sidebar on mobile
                if (window.innerWidth <= 768) {
                    $('#sidebar').removeClass('mobile-open');
                }
            });

            // Profile form submission
            $('#profileForm').submit(function(e) {
                e.preventDefault();
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    showAlert('Profile updated successfully! Changes are pending HR approval.', 'success');
                }, 1500);
            });

            // Certificate request form
            $('#certificateRequestForm').submit(function(e) {
                e.preventDefault();
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    showAlert('Salary certificate request submitted successfully!', 'success');
                    this.reset();
                }, 1500);
            });

            // Handle leave type change for medical certificate upload
            $(document).on('change', 'select[name="leave_type"]', function() {
                const medicalUpload = $('#medicalUploadField');
                if ($(this).val() === 'sick') {
                    medicalUpload.show();
                } else {
                    medicalUpload.hide();
                }
            });

            // Handle window resize
            $(window).resize(function() {
                if (window.innerWidth > 768 && $('#sidebar').hasClass('mobile-open')) {
                    $('#sidebar').removeClass('mobile-open');
                }
            });
        }

        // Generate attendance calendar
        function generateAttendanceCalendar() {
            const calendar = document.getElementById('attendanceCalendar');
            const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
            const firstDay = new Date(currentYear, currentMonth - 1, 1).getDay();
            
            // Clear existing calendar days (keep headers)
            const existingDays = calendar.querySelectorAll('.calendar-day:not(.calendar-header)');
            existingDays.forEach(day => day.remove());
            
            // Add empty cells for days before month start
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day';
                calendar.appendChild(emptyDay);
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                
                const dayNumber = document.createElement('div');
                dayNumber.textContent = day;
                
                const status = document.createElement('div');
                const attendanceData = getAttendanceData(day);
                status.textContent = attendanceData.status;
                status.className = attendanceData.class;
                
                const timeInfo = document.createElement('small');
                if (attendanceData.inTime) {
                    timeInfo.textContent = attendanceData.inTime;
                }
                
                dayElement.appendChild(dayNumber);
                dayElement.appendChild(status);
                if (attendanceData.inTime) {
                    dayElement.appendChild(timeInfo);
                }
                
                dayElement.title = `${day}/${currentMonth}/${currentYear} - ${attendanceData.status}${attendanceData.inTime ? ` (In: ${attendanceData.inTime})` : ''}`;
                
                calendar.appendChild(dayElement);
            }
        }

        // Get sample attendance data
        function getAttendanceData(day) {
            const today = new Date().getDate();
            const currentMonthToday = new Date().getMonth() + 1;
            
            // Future dates
            if (currentMonth === currentMonthToday && day > today) {
                return { status: '', class: '', inTime: null };
            }
            
            // Sample data - in real app, this would come from API
            const sampleData = {
                1: { status: 'P', class: 'time-915-930', inTime: '9:20' },
                2: { status: 'P', class: 'time-930-1000', inTime: '9:45' },
                3: { status: 'P', class: 'time-after-1000', inTime: '10:15' },
                4: { status: 'L', class: 'leave', inTime: null },
                5: { status: 'P', class: 'time-915-930', inTime: '9:10' },
                7: { status: 'WO', class: 'week-off', inTime: null },
                8: { status: 'WO', class: 'week-off', inTime: null },
                9: { status: 'H', class: 'holiday', inTime: null },
                10: { status: 'P', class: 'time-930-1000', inTime: '9:35' },
                // Add more sample data...
            };
            
            return sampleData[day] || { status: 'P', class: 'time-915-930', inTime: '9:15' };
        }

        // Navigate to previous month
        function previousMonth() {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            updateCalendarHeader();
            generateAttendanceCalendar();
        }

        // Navigate to next month
        function nextMonth() {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            updateCalendarHeader();
            generateAttendanceCalendar();
        }

        // Update calendar header
        function updateCalendarHeader() {
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            const headerTitle = document.querySelector('#attendance .card-title');
            headerTitle.innerHTML = `<i class="fas fa-calendar-check"></i> Attendance - ${monthNames[currentMonth - 1]} ${currentYear}`;
        }

        // Show leave request modal
        function showLeaveRequestModal() {
            $('#leaveRequestModal').modal('show');
        }

        // Toggle date fields based on duration selection
        function toggleDateFields(duration) {
            const toDateField = document.getElementById('toDateField');
            const halfDayField = document.getElementById('halfDayField');
            
            if (duration === 'multiple') {
                toDateField.style.display = 'block';
                halfDayField.style.display = 'none';
            } else if (duration === 'half') {
                toDateField.style.display = 'none';
                halfDayField.style.display = 'block';
            } else {
                toDateField.style.display = 'none';
                halfDayField.style.display = 'none';
            }
        }

        // Submit leave request
        function submitLeaveRequest() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                $('#leaveRequestModal').modal('hide');
                showAlert('Leave request submitted successfully!', 'success');
                // In real app, refresh the leave requests table
            }, 1500);
        }

        // Edit leave request
        function editLeaveRequest(id) {
            // In real app, populate form with existing data
            showLeaveRequestModal();
        }

        // Cancel leave request
        function cancelLeaveRequest(id) {
            if (confirm('Are you sure you want to cancel this leave request?')) {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    showAlert('Leave request cancelled successfully!', 'success');
                    // In real app, refresh the table
                }, 1000);
            }
        }

        // Show loan request modal
        function showLoanRequestModal() {
            $('#loanRequestModal').modal('show');
        }

        // Calculate EMI
        function calculateEMI() {
            const amount = parseFloat($('#loanRequestModal input[type="number"]').val());
            const installments = parseInt($('#loanRequestModal select[onchange="calculateEMI()"]').val());
            
            if (amount && installments) {
                const emi = amount / installments;
                $('#emiAmount').val(`₹${emi.toLocaleString('en-IN')}`);
            }
        }

        // Submit loan request
        function submitLoanRequest() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                $('#loanRequestModal').modal('hide');
                showAlert('Loan request submitted successfully!', 'success');
                // In real app, refresh the loan requests table
            }, 1500);
        }

        // Show feedback modal
        function showFeedbackModal() {
            $('#feedbackModal').modal('show');
        }

        // Quick feedback
        function quickFeedback(category) {
            $('#feedbackModal').modal('show');
            $('#feedbackModal select[required]').val(category.toLowerCase().replace(' ', '_'));
        }

        // Submit feedback
        function submitFeedback() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                $('#feedbackModal').modal('hide');
                showAlert('Feedback submitted successfully!', 'success');
                // In real app, refresh the feedback list
            }, 1500);
        }

        // Download salary slip
        function downloadSalarySlip(month) {
            showLoading();
            setTimeout(() => {
                hideLoading();
                showAlert(`Salary slip for ${month} downloaded successfully!`, 'success');
                // In real app, trigger actual download
            }, 1000);
        }

        // Upload photo
        function uploadPhoto() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    showLoading();
                    setTimeout(() => {
                        hideLoading();
                        showAlert('Profile photo uploaded successfully! Changes are pending HR approval.', 'success');
                        // In real app, update the photo preview
                    }, 1500);
                }
            };
            input.click();
        }

        // Show notifications
        function showNotifications() {
            showAlert('You have 3 new notifications. Check the dashboard for details.', 'info');
        }

        // Logout
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    showAlert('Logged out successfully!', 'success');
                    // In real app, redirect to login page
                }, 1000);
            }
        }

        // Utility functions
        function showLoading() {
            $('#loadingModal').modal('show');
        }

        function hideLoading() {
            $('#loadingModal').modal('hide');
        }

        function showAlert(message, type = 'info') {
            const alertClass = type === 'success' ? 'alert-success' : 
                              type === 'error' ? 'alert-danger' : 
                              type === 'warning' ? 'alert-warning' : 'alert-info';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 90px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            $('body').append(alertHtml);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }

        // Handle file uploads
        $(document).on('change', '.file-upload-input', function() {
            const file = this.files[0];
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                $(this).siblings('.file-upload-button').html(`
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-danger"></i>
                        <div>${fileName}</div>
                        <small class="text-muted">${fileSize} MB</small>
                    </div>
                `);
            }
        });
    </script>
</body>
</html>