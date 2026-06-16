<?php
session_start();

// Initialize session variables if not set
if (!isset($_SESSION['current_page'])) $_SESSION['current_page'] = 'home';
if (!isset($_SESSION['is_logged_in'])) $_SESSION['is_logged_in'] = false;
if (!isset($_SESSION['selected_tool'])) $_SESSION['selected_tool'] = null;
if (!isset($_SESSION['uploaded_file'])) $_SESSION['uploaded_file'] = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['set_page'])) {
        $_SESSION['current_page'] = $_POST['set_page'];
    }
    if (isset($_POST['login'])) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['current_page'] = 'home';
    }
    if (isset($_POST['logout'])) {
        $_SESSION['is_logged_in'] = false;
        $_SESSION['current_page'] = 'home';
    }
    if (isset($_POST['set_tool'])) {
        $_SESSION['selected_tool'] = json_decode($_POST['set_tool'], true);
        $_SESSION['current_page'] = 'tool-detail';
    }
}

// Tools data
$tools = [
    ['id' => 1, 'name' => 'Merge PDF', 'icon' => '🔗', 'desc' => 'Combine multiple PDFs in order', 'color' => 'from-blue-400 to-blue-600'],
    ['id' => 2, 'name' => 'Split PDF', 'icon' => '✂️', 'desc' => 'Separate pages from PDFs', 'color' => 'from-purple-400 to-purple-600'],
    ['id' => 3, 'name' => 'Compress PDF', 'icon' => '📉', 'desc' => 'Reduce file size maintaining quality', 'color' => 'from-pink-400 to-pink-600'],
    ['id' => 4, 'name' => 'PDF to Word', 'icon' => '📄', 'desc' => 'Convert PDF to editable documents', 'color' => 'from-green-400 to-green-600'],
    ['id' => 5, 'name' => 'Word to PDF', 'icon' => '📝', 'desc' => 'Convert documents to PDF', 'color' => 'from-yellow-400 to-yellow-600'],
    ['id' => 6, 'name' => 'PDF to Image', 'icon' => '🖼️', 'desc' => 'Extract pages as images', 'color' => 'from-indigo-400 to-indigo-600'],
    ['id' => 7, 'name' => 'Protect PDF', 'icon' => '🔐', 'desc' => 'Add password protection', 'color' => 'from-red-400 to-red-600'],
    ['id' => 8, 'name' => 'Unlock PDF', 'icon' => '🔓', 'desc' => 'Remove password security', 'color' => 'from-cyan-400 to-cyan-600'],
    ['id' => 9, 'name' => 'Edit PDF', 'icon' => '✍️', 'desc' => 'Add text and annotations', 'color' => 'from-orange-400 to-orange-600'],
    ['id' => 10, 'name' => 'Rotate PDF', 'icon' => '🔄', 'desc' => 'Rotate pages easily', 'color' => 'from-teal-400 to-teal-600'],
    ['id' => 11, 'name' => 'Add Watermark', 'icon' => '💧', 'desc' => 'Stamp text on pages', 'color' => 'from-violet-400 to-violet-600'],
    ['id' => 12, 'name' => 'OCR PDF', 'icon' => '🔍', 'desc' => 'Scan to searchable PDF', 'color' => 'from-fuchsia-400 to-fuchsia-600'],
];

// Features data
$features = [
    ['icon' => '🔒', 'title' => '100% Secure', 'desc' => 'Your files are encrypted and deleted after processing'],
    ['icon' => '⚡', 'title' => 'Lightning Fast', 'desc' => 'Cloud-powered technology for instant results'],
    ['icon' => '📱', 'title' => 'Works Anywhere', 'desc' => 'No installation needed. Works on all devices'],
    ['icon' => '🆓', 'title' => '100% Free', 'desc' => 'All basic tools are completely free forever'],
    ['icon' => '🚀', 'title' => 'No Limits', 'desc' => 'Process unlimited files with no restrictions'],
    ['icon' => '🌍', 'title' => 'Multi-language', 'desc' => 'Available in 25+ languages worldwide'],
];

// Pricing plans
$plans = [
    ['name' => 'Free', 'price' => '$0', 'features' => ['5 files/day', 'Basic tools', 'Community support', 'Standard quality']],
    ['name' => 'Pro', 'price' => '$9.99', 'features' => ['Unlimited files', 'All tools', 'Priority support', 'High quality', 'Batch processing'], 'best' => true],
    ['name' => 'Business', 'price' => '$29.99', 'features' => ['Everything in Pro', 'Team collaboration', 'API access', 'Custom workflows', 'Dedicated support']],
];

// Stats data
$stats = [
    ['stat' => '10M+', 'label' => 'Users Worldwide'],
    ['stat' => '500M+', 'label' => 'Files Processed'],
    ['stat' => '99.9%', 'label' => 'Uptime'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocMaster - PDF Tools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <form method="POST" class="inline">
                <input type="hidden" name="set_page" value="home">
                <button type="submit" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent cursor-pointer">
                    📄 DocMaster
                </button>
            </form>
            
            <div class="hidden md:flex items-center gap-8">
                <?php 
                $nav_items = ['home', 'tools', 'pricing', 'about'];
                foreach ($nav_items as $item): 
                ?>
                <form method="POST" class="inline">
                    <input type="hidden" name="set_page" value="<?php echo $item; ?>">
                    <button type="submit" class="transition <?php echo $_SESSION['current_page'] === $item ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">
                        <?php echo ucfirst($item); ?>
                    </button>
                </form>
                <?php endforeach; ?>
            </div>

            <div class="hidden md:flex gap-3">
                <?php if (!$_SESSION['is_logged_in']): ?>
                <form method="POST" class="inline">
                    <input type="hidden" name="set_page" value="login">
                    <button type="submit" class="px-4 py-2 <?php echo $_SESSION['current_page'] === 'login' ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">
                        Login
                    </button>
                </form>
                <form method="POST" class="inline">
                    <input type="hidden" name="set_page" value="signup">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Sign Up
                    </button>
                </form>
                <?php else: ?>
                <form method="POST" class="inline">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                <?php endif; ?>
            </div>

            <button class="md:hidden text-2xl" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </nav>

        <div id="mobileMenu" class="md:hidden bg-gray-50 border-t hidden">
            <?php foreach ($nav_items as $item): ?>
            <form method="POST" class="block">
                <input type="hidden" name="set_page" value="<?php echo $item; ?>">
                <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-blue-50 <?php echo $_SESSION['current_page'] === $item ? 'text-blue-600 font-bold bg-blue-50' : ''; ?>">
                    <?php echo ucfirst($item); ?>
                </button>
            </form>
            <?php endforeach; ?>
            
            <?php if (!$_SESSION['is_logged_in']): ?>
            <form method="POST" class="block">
                <input type="hidden" name="set_page" value="login">
                <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-blue-50 <?php echo $_SESSION['current_page'] === 'login' ? 'text-blue-600 font-bold bg-blue-50' : ''; ?>">
                    Login
                </button>
            </form>
            <form method="POST" class="block">
                <input type="hidden" name="set_page" value="signup">
                <button type="submit" class="block w-full text-left px-4 py-3 text-blue-600 font-bold hover:bg-blue-50">
                    Sign Up
                </button>
            </form>
            <?php else: ?>
            <form method="POST" class="block">
                <input type="hidden" name="logout" value="1">
                <button type="submit" class="block w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">
                    Logout
                </button>
            </form>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <?php if ($_SESSION['current_page'] === 'home'): ?>
        <!-- Home Page -->
        <div>
            <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20 px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">Master Your Documents</h1>
                    <p class="text-xl md:text-2xl mb-8 opacity-90">Professional PDF tools for everyone. Merge, split, compress, and convert PDFs with ease. All tools are 100% FREE!</p>
                    <form method="POST">
                        <input type="hidden" name="set_page" value="tools">
                        <button type="submit" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105">
                            Get Started Now
                        </button>
                    </form>
                </div>
            </section>

            <section class="py-16 px-4 bg-gray-50">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-4xl font-bold text-center mb-12">Why Choose DocMaster?</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <?php foreach ($features as $feature): ?>
                        <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                            <div class="text-5xl mb-4"><?php echo $feature['icon']; ?></div>
                            <h3 class="text-xl font-bold mb-3"><?php echo $feature['title']; ?></h3>
                            <p class="text-gray-600"><?php echo $feature['desc']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-16 px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-4xl font-bold mb-4">Ready to get started?</h2>
                    <p class="text-xl mb-8">Join millions of users who trust DocMaster with their documents</p>
                    <form method="POST">
                        <input type="hidden" name="set_page" value="tools">
                        <button type="submit" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition">
                            Explore All Tools
                        </button>
                    </form>
                </div>
            </section>
        </div>

        <?php elseif ($_SESSION['current_page'] === 'tools'): ?>
        <!-- Tools Page -->
        <div class="py-16 px-4">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-4xl font-bold text-center mb-4">All PDF Tools</h1>
                <p class="text-center text-gray-600 mb-12 text-lg">Choose a tool to get started</p>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($tools as $tool): ?>
                    <form method="POST">
                        <input type="hidden" name="set_tool" value='<?php echo json_encode($tool); ?>'>
                        <button type="submit" class="bg-gradient-to-br <?php echo $tool['color']; ?> text-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105 w-full">
                            <div class="text-5xl mb-4"><?php echo $tool['icon']; ?></div>
                            <h3 class="text-2xl font-bold mb-2"><?php echo $tool['name']; ?></h3>
                            <p class="text-white opacity-90 mb-4"><?php echo $tool['desc']; ?></p>
                            <div class="flex items-center justify-center gap-2">
                                Start Now <i class="fas fa-chevron-right"></i>
                            </div>
                        </button>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php elseif ($_SESSION['current_page'] === 'tool-detail'): ?>
        <!-- Tool Detail Page -->
        <div class="py-16 px-4">
            <div class="max-w-4xl mx-auto">
                <form method="POST">
                    <input type="hidden" name="set_page" value="tools">
                    <button type="submit" class="text-blue-600 mb-8 flex items-center gap-2 hover:underline">
                        <i class="fas fa-arrow-left"></i> Back to Tools
                    </button>
                </form>
                
                <?php if ($_SESSION['selected_tool']): ?>
                <div class="bg-gradient-to-br <?php echo $_SESSION['selected_tool']['color']; ?> text-white p-12 rounded-lg mb-8">
                    <div class="text-7xl mb-4"><?php echo $_SESSION['selected_tool']['icon']; ?></div>
                    <h1 class="text-4xl font-bold mb-4"><?php echo $_SESSION['selected_tool']['name']; ?></h1>
                    <p class="text-xl opacity-90"><?php echo $_SESSION['selected_tool']['desc']; ?></p>
                </div>

                <?php if (!$_SESSION['is_logged_in']): ?>
                <div class="bg-blue-50 border-2 border-blue-200 p-8 rounded-lg text-center">
                    <p class="text-lg mb-4">Please login to use this tool</p>
                    <form method="POST">
                        <input type="hidden" name="set_page" value="login">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                            Login Now
                        </button>
                    </form>
                </div>
                <?php else: ?>
                <div class="bg-white border-2 border-gray-200 p-12 rounded-lg">
                    <form method="POST" enctype="multipart/form-data" class="border-2 border-dashed border-blue-300 rounded-lg p-12 text-center cursor-pointer hover:border-blue-500 transition">
                        <i class="fas fa-upload text-5xl mx-auto text-blue-600 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Drop your file here</h3>
                        <p class="text-gray-600 mb-4">or click to select</p>
                        <input type="file" accept=".pdf" name="pdf_file" id="file-upload" class="hidden">
                        <label for="file-upload" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 cursor-pointer inline-block">
                            Choose File
                        </label>
                        <?php if ($_SESSION['uploaded_file']): ?>
                        <div class="mt-4 text-green-600 font-bold">
                            ✓ <?php echo $_SESSION['uploaded_file']; ?> selected
                        </div>
                        <?php endif; ?>
                    </form>
                    
                    <?php if ($_SESSION['uploaded_file']): ?>
                    <button class="w-full bg-green-600 text-white py-3 rounded-lg font-bold mt-6 hover:bg-green-700 transition">
                        Process <?php echo $_SESSION['selected_tool']['name']; ?>
                    </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="text-center">
                    <h1 class="text-2xl font-bold mb-4">No tool selected</h1>
                    <form method="POST">
                        <input type="hidden" name="set_page" value="tools">
                        <button type="submit" class="text-blue-600 hover:underline">
                            ← Back to Tools
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php elseif ($_SESSION['current_page'] === 'pricing'): ?>
        <!-- Pricing Page -->
        <div class="py-16 px-4">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-4xl font-bold text-center mb-4">Simple, Transparent Pricing</h1>
                <p class="text-center text-gray-600 mb-12 text-lg">Choose the plan that fits your needs</p>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <?php foreach ($plans as $plan): ?>
                    <div class="rounded-lg p-8 <?php echo isset($plan['best']) && $plan['best'] ? 'bg-gradient-to-br from-blue-600 to-blue-800 text-white shadow-2xl transform scale-105' : 'bg-white border-2 border-gray-200'; ?>">
                        <h3 class="text-2xl font-bold mb-2"><?php echo $plan['name']; ?></h3>
                        <div class="text-4xl font-bold mb-6"><?php echo $plan['price']; ?><span class="text-lg opacity-75">/mo</span></div>
                        <ul class="space-y-3 mb-8">
                            <?php foreach ($plan['features'] as $feature): ?>
                            <li class="flex items-center gap-2">
                                <span class="text-green-400">✓</span> <?php echo $feature; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <form method="POST">
                            <input type="hidden" name="set_page" value="signup">
                            <button type="submit" class="w-full py-3 rounded-lg font-bold transition <?php echo isset($plan['best']) && $plan['best'] ? 'bg-white text-blue-600 hover:bg-gray-100' : 'bg-blue-600 text-white hover:bg-blue-700'; ?>">
                                Get <?php echo $plan['name']; ?>
                            </button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php elseif ($_SESSION['current_page'] === 'about'): ?>
        <!-- About Page -->
        <div class="py-16 px-4">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl font-bold mb-8">About DocMaster</h1>
                
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-8 rounded-lg mb-8">
                    <h2 class="text-2xl font-bold mb-4">Our Mission</h2>
                    <p class="text-lg text-gray-700">DocMaster is dedicated to making PDF processing simple, fast, and accessible to everyone. We believe documents should work for you, not against you.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    <?php foreach ($stats as $stat): ?>
                    <div class="text-center p-8 bg-gray-50 rounded-lg">
                        <div class="text-4xl font-bold text-blue-600 mb-2"><?php echo $stat['stat']; ?></div>
                        <div class="text-gray-700"><?php echo $stat['label']; ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-white border-2 border-gray-200 p-8 rounded-lg">
                    <h2 class="text-2xl font-bold mb-4">Why We're Different</h2>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex gap-3"><span class="text-green-600 font-bold">✓</span> Built by document experts with 20+ years experience</li>
                        <li class="flex gap-3"><span class="text-green-600 font-bold">✓</span> Enterprise-grade security with 256-bit encryption</li>
                        <li class="flex gap-3"><span class="text-green-600 font-bold">✓</span> 24/7 customer support in 25 languages</li>
                        <li class="flex gap-3"><span class="text-green-600 font-bold">✓</span> 100% money-back guarantee</li>
                    </ul>
                </div>
            </div>
        </div>

        <?php elseif ($_SESSION['current_page'] === 'login'): ?>
        <!-- Login Page -->
        <div class="py-16 px-4 min-h-screen flex items-center">
            <div class="max-w-md mx-auto w-full bg-white border-2 border-gray-200 p-8 rounded-lg">
                <h1 class="text-3xl font-bold mb-8 text-center">Welcome Back</h1>
                
                <form method="POST">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" placeholder="your@email.com" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-600" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" placeholder="••••••••" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-600" required>
                        </div>

                        <input type="hidden" name="login" value="1">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                            Login
                        </button>

                        <p class="text-center text-gray-600">
                            Don't have an account? 
                            <button type="submit" form="signupForm" class="text-blue-600 font-bold ml-1 hover:underline">
                                Sign up here
                            </button>
                        </p>
                    </div>
                </form>
                
                <form id="signupForm" method="POST" class="hidden">
                    <input type="hidden" name="set_page" value="signup">
                </form>
            </div>
        </div>

        <?php elseif ($_SESSION['current_page'] === 'signup'): ?>
        <!-- Signup Page -->
        <div class="py-16 px-4 min-h-screen flex items-center">
            <div class="max-w-md mx-auto w-full bg-white border-2 border-gray-200 p-8 rounded-lg">
                <h1 class="text-3xl font-bold mb-8 text-center">Create Account</h1>
                
                <form method="POST">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Full Name</label>
                            <input type="text" name="fullname" placeholder="John Doe" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-600" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" placeholder="your@email.com" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-600" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" placeholder="••••••••" class="w-full border-2 border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-600" required>
                        </div>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="w-4 h-4" required>
                            <span class="text-sm text-gray-600">I agree to the Terms & Conditions</span>
                        </label>

                        <input type="hidden" name="login" value="1">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                            Create Account
                        </button>

                        <p class="text-center text-gray-600">
                            Already have an account? 
                            <button type="submit" form="loginForm" class="text-blue-600 font-bold ml-1 hover:underline">
                                Login here
                            </button>
                        </p>
                    </div>
                </form>
                
                <form id="loginForm" method="POST" class="hidden">
                    <input type="hidden" name="set_page" value="login">
                </form>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 px-4 mt-16">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">Product</h3>
                    <ul class="space-y-2">
                        <li>
                            <form method="POST" class="inline">
                                <input type="hidden" name="set_page" value="tools">
                                <button type="submit" class="hover:text-white transition">Tools</button>
                            </form>
                        </li>
                        <li>
                            <form method="POST" class="inline">
                                <input type="hidden" name="set_page" value="pricing">
                                <button type="submit" class="hover:text-white transition">Pricing</button>
                            </form>
                        </li>
                        <li><a href="#" class="hover:text-white transition">Features</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li>
                            <form method="POST" class="inline">
                                <input type="hidden" name="set_page" value="about">
                                <button type="submit" class="hover:text-white transition">About Us</button>
                            </form>
                        </li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Follow Us</h3>
                    <div class="space-y-2">
                        <p>📘 Facebook</p>
                        <p>🐦 Twitter</p>
                        <p>💼 LinkedIn</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p>&copy; 2024 DocMaster. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Handle file upload display
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file-upload');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        alert('File selected: ' + e.target.files[0].name + '\nNote: This is a demo. In a real application, this would upload the file.');
                    }
                });
            }
        });
    </script>
</body>
</html>