<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar-link.active { background-color: #ec4899; color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body>

    <div class="lg:hidden flex items-center justify-between bg-white p-4 shadow-md">
        <span class="text-xl font-bold text-pink-600">Elegance Salon</span>
        <button id="mobileMenuBtn" class="text-gray-600"><i class="fas fa-bars fa-lg"></i></button>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-pink-600 tracking-tight">ELEGANCE</h1>
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-8">Management Suite</p>
                
                <nav class="space-y-1">
                    <a href="#" onclick="showTab('dashboard')" class="sidebar-link active flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-chart-line w-6"></i> Dashboard
                    </a>
                    <a href="#" onclick="showTab('appointments')" class="sidebar-link flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-calendar-alt w-6"></i> Appointments
                    </a>
                    <a href="#" onclick="showTab('clients')" class="sidebar-link flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-users w-6"></i> Clients
                    </a>
                    <a href="#" onclick="showTab('inventory')" class="sidebar-link flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-boxes w-6"></i> Inventory
                    </a>
                    <a href="#" onclick="showTab('staff')" class="sidebar-link flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-cut w-6"></i> Staff
                    </a>
                    <a href="#" onclick="showTab('payments')" class="sidebar-link flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-file-invoice-dollar w-6"></i> Payments
                    </a>
                    <hr class="my-4">
                    <a href="#" onclick="showTab('feedback')" class="sidebar-link flex items-center p-3 text-gray-600 rounded-lg hover:bg-pink-50 transition">
                        <i class="fas fa-comment-dots w-6"></i> Feedback
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-y-auto">
            
            <header class="bg-white border-b p-4 flex justify-between items-center px-8">
                <h2 id="pageTitle" class="text-xl font-semibold text-gray-800">Dashboard</h2>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-400 cursor-pointer"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full px-1">3</span>
                    </div>
                    <div class="flex items-center gap-2 border-l pl-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium">Admin User</p>
                            <p class="text-xs text-gray-500">Receptionist Role</p>
                        </div>
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center text-pink-600 font-bold">A</div>
                    </div>
                </div>
            </header>

            <div class="p-8">
                
                <section id="dashboard" class="tab-content active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-500">Today's Bookings</p>
                            <h3 class="text-2xl font-bold">12</h3>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-500">Revenue (MTD)</p>
                            <h3 class="text-2xl font-bold">$4,250</h3>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-sm text-pink-500 font-semibold"><i class="fas fa-exclamation-triangle mr-1"></i> Low Stock</p>
                            <h3 class="text-2xl font-bold text-pink-600">4 Items</h3>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-500">Active Stylists</p>
                            <h3 class="text-2xl font-bold">6</h3>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h4 class="font-semibold mb-4">Upcoming Appointments Today</h4>
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-4 py-3">Time</th>
                                    <th class="px-4 py-3">Client</th>
                                    <th class="px-4 py-3">Service</th>
                                    <th class="px-4 py-3">Stylist</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr>
                                    <td class="px-4 py-3 font-medium text-pink-600">10:00 AM</td>
                                    <td class="px-4 py-3">Sarah Jenkins</td>
                                    <td class="px-4 py-3">Hair Balayage</td>
                                    <td class="px-4 py-3">Elena R.</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-medium text-pink-600">11:30 AM</td>
                                    <td class="px-4 py-3">Michael Scott</td>
                                    <td class="px-4 py-3">Men's Trim</td>
                                    <td class="px-4 py-3">John D.</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="inventory" class="tab-content">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold">Stock & Inventory Management</h3>
                        <button class="bg-pink-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-pink-700"><i class="fas fa-plus mr-2"></i>Add Product</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-500">
                            <p class="text-xs text-gray-500">Shampoo - Volumizing</p>
                            <p class="text-lg font-bold">Stock: 2 Units</p>
                            <span class="text-[10px] bg-red-100 text-red-600 p-1">AUTO-ORDER SENT</span>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                            <p class="text-xs text-gray-500">Hair Wax - Matte</p>
                            <p class="text-lg font-bold">Stock: 45 Units</p>
                        </div>
                    </div>
                </section>

                <section id="staff" class="tab-content">
                    <h3 class="text-xl font-semibold mb-6">Staff Scheduling & Commissions</h3>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
                        <div class="p-4 bg-gray-50 border-b flex justify-between">
                            <span class="font-bold">Weekly Schedule</span>
                            <span class="text-sm text-gray-500">April 4 - April 10</span>
                        </div>
                        <div class="p-6 text-center text-gray-400">
                            <i class="fas fa-calendar-check fa-3x mb-4 opacity-20"></i>
                            <p>Staff shift calendar integration loading...</p>
                        </div>
                    </div>
                </section>

                <section id="feedback" class="tab-content">
                    <h3 class="text-xl font-semibold mb-6">Submit Application Feedback</h3>
                    <div class="max-w-lg bg-white p-8 rounded-xl shadow-md">
                        <form>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Issue Category</label>
                                <select class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-500 outline-none">
                                    <option>UI/UX Improvement</option>
                                    <option>Bug Report</option>
                                    <option>New Feature Request</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Description</label>
                                <textarea rows="4" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-500 outline-none" placeholder="How can we improve Elegance Salon Manager?"></textarea>
                            </div>
                            <button class="w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-black transition">Submit Feedback</button>
                        </form>
                    </div>
                </section>

            </div>

            <footer class="mt-auto p-6 bg-gray-100 border-t flex flex-col md:flex-row justify-between text-xs text-gray-500 gap-4">
                <div>
                    <strong>Developer Contact:</strong> DevTeam Solutions | support@devteam.com | +1 234-567-890
                </div>
                <div>
                    &copy; 2026 Elegance Salon App. All Rights Reserved.
                </div>
            </footer>
        </main>
    </div>

    <script>
        // Tab Management
        function showTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            // Deactivate all links
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabId).classList.add('active');
            
            // Update Title
            document.getElementById('pageTitle').innerText = tabId.charAt(0).toUpperCase() + tabId.slice(1);
            
            // Highlight Link (using event or lookup)
            event.currentTarget.classList.add('active');

            // Close mobile menu on click
            if (window.innerWidth < 1024) {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }

        // Mobile Menu Toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>