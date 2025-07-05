<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitchus.ai | The Future of Startup Investing</title>
    <link rel="stylesheet" href="style.css">
    <!-- Firebase SDKs -->
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.1/firebase-firestore-compat.js"></script>
    <!-- Tailwind for profile dropdown only -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false, // Disable default styles
            }
        }
    </script>
    <style>
        /* Profile dropdown styles only */
        .profile-container {
            position: relative;
            display: inline-block;
        }
        .profile-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 250px;
            z-index: 100;
            display: none;
            margin-top: 10px;
        }
        .profile-dropdown.active {
            display: block;
        }
        .profile-header {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        .profile-body {
            padding: 8px 0;
        }
        .profile-item {
            padding: 8px 16px;
            display: flex;
            align-items: center;
        }
        .profile-item:hover {
            background-color: #f9fafb;
        }
        .profile-footer {
            padding: 12px 16px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        .profile-icon {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">Pitchus<span>.ai</span></div>
        
        <nav class="nav-links">
            <a href="index.php" style="text-decoration: none;"><div class="nav-item active">Home</div></a>
            <a href="mes.php" style="text-decoration: none;"><div class="nav-item ">Message</div></a>
            <a href="news.php" style="text-decoration: none;"><div class="nav-item ">News</div></a>
            <a href="jobs.php" style="text-decoration: none;"><div class="nav-item ">Jobs</div></a>
            <a href="ai.php" style="text-decoration: none;"><div class="nav-item ">AI</div></a>
            <a href="doc.php" style="text-decoration: none;"><div class="nav-item ">Documents</div></a>
        </nav>
        
        <div class="user-controls">
            <div class="search-bar">
                <div class="search-icon">🔍</div>
                <input type="text" placeholder="Search startups...">
            </div>
            
            <!-- Profile Container -->
            <div class="profile-container">
                <div class="user-avatar" id="profileBtn">PD</div>
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-header">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span id="profileAvatar" class="text-blue-600 font-medium">PD</span>
                            </div>
                            <div>
                                <div id="profileName" class="font-medium text-gray-900">Loading...</div>
                                <div id="profileRole" class="text-sm text-gray-500">Loading...</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-body">
                        <div class="profile-item">
                            <div class="profile-icon">📧</div>
                            <div>
                                <div class="text-sm text-gray-500">Email</div>
                                <div id="profileEmail" class="font-medium">user@example.com</div>
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-icon">👤</div>
                            <div>
                                <div class="text-sm text-gray-500">Status</div>
                                <div id="profileStatus" class="font-medium">Active</div>
                            </div>
                        </div>
                        <div class="profile-item">
                            <div class="profile-icon">📅</div>
                            <div>
                                <div class="text-sm text-gray-500">Member Since</div>
                                <div id="profileCreated" class="font-medium">Jan 1, 2023</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-footer">
                        <button id="signOutBtn" class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition">
                            Sign Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Featured Pitch -->
            <div class="featured-pitch">
                <div class="featured-badge">LIVE NOW</div>
                <div class="featured-tag">AI Technology</div>
                <h2 class="featured-title">Join Live Call</h2>
                <p class="featured-desc">Pitch revolutionary idea interface technology that allows direct communication between the human brain and computers.</p>
                
                <div class="featured-meta">
                    <div class="featured-founder">
                        <div class="founder-avatar">EP</div>
                        <div class="founder-name">Elon Parker</div>
                    </div>
                    <div class="featured-stats">
                        <div class="stat">👁 1.2K</div>
                        <div class="stat">💬 84</div>
                        <div class="stat">💰 $2.5M</div>
                    </div>
                </div>
                
                <div class="featured-actions">
                    <button class="action-btn primary-btn">Join Pitch</button>
                    <button class="action-btn secondary-btn">+ Follow</button>
                </div>
            </div>

            <!-- Trending Pitches -->
            <h2 class="section-title">
                <div class="icon">🔥</div>
                Investors
            </h2>
            
            <div class="pitches-grid">
                <?php
                $result = $conn->query("SELECT * FROM investors ORDER BY created_at DESC");
                while($row = $result->fetch_assoc()) {
                    $initials = strtoupper(substr($row['name'], 0, 2));
                
                    echo "<div class='pitch-card'>";
                        echo "<div class='pitch-image'>";
                            echo "<img src='assets/uploads/investors/{$row['photo']}' height='150' style='width:100%; object-fit:cover; border-radius:10px;'>";
                            echo "<div class='pitch-badge'>INVESTOR</div>";
                        echo "</div>";
                
                        echo "<div class='pitch-content'>";
                            echo "<h3 class='pitch-title'>" . htmlspecialchars($row['name']) . "</h3>";
                            echo "<p class='pitch-desc'>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                
                            echo "<div class='pitch-meta'>";
                                echo "<div class='pitch-founder'>";
                                    echo "<div class='pitch-founder-avatar'>$initials</div>";
                                    echo "<div>" . htmlspecialchars($row['company']) . "</div>";
                                echo "</div>";
                                echo "<div class='pitch-stats'>";
                                    echo "<div class='pitch-stat'>📞 " . htmlspecialchars($row['contact']) . "</div>";
                                echo "</div>";
                            echo "</div>";
                
                        echo "</div>";
                    echo "</div>";
                }
                ?>
                </div>

            <!-- For You Section -->
            <h2 class="section-title">
                <div class="icon">✨</div>
                Trending Pitches
            </h2>
            
            <div class="pitches-grid">
                <?php
                $result = $conn->query("SELECT s.*, i.name as investor_name FROM startups s LEFT JOIN investors i ON s.investor_id = i.id ORDER BY s.created_at DESC");
                while($row = $result->fetch_assoc()) {
                    $progress = ($row['fund_raised'] / $row['pitch_amount']) * 100;
                    $progress = min(100, round($progress, 2));
                    $initials = strtoupper(substr($row['name'], 0, 2));
                    $status_badge = $progress >= 100 ? "FUNDED" : ($progress >= 50 ? "LIVE" : "UPCOMING");
                
                    echo "<div class='pitch-card'>";
                        echo "<div class='pitch-image'>";
                            echo "<div class='pitch-badge'>$status_badge</div>";
                            echo "<img src='assets/uploads/startups/{$row['product_photo']}' height='150' style='width:100%; object-fit:cover; border-radius:10px;'>";
                        echo "</div>";
                
                        echo "<div class='pitch-content'>";
                            echo "<h3 class='pitch-title'>" . htmlspecialchars($row['name']) . "</h3>";
                            echo "<p class='pitch-desc'>" . nl2br(htmlspecialchars($row['idea'])) . "</p>";
                
                            echo "<div class='pitch-meta'>";
                                echo "<div class='pitch-founder'>";
                                    echo "<div class='pitch-founder-avatar'>$initials</div>";
                                    echo "<div>" . htmlspecialchars($row['investor_name']) . "</div>";
                                echo "</div>";
                                echo "<div class='pitch-stats'>";
                                    echo "<div class='pitch-stat'>💰 {$row['fund_raised']} / {$row['pitch_amount']} ETH</div>";
                                    echo "<div class='pitch-stat'>📈 {$progress}%</div>";
                                echo "</div>";
                            echo "</div>";
                
                            echo "<progress value='$progress' max='100' style='width: 100%; height: 10px;'></progress>";
                            echo "<br><button onclick=\"fundStartup('{$row['wallet_address']}', {$row['id']}, {$row['pitch_amount']})\">💰 Fund This Startup</button>";
                
                            if (!empty($row['funding_tx'])) {
                                echo "<details><summary>Funding Logs</summary><pre>" . htmlspecialchars($row['funding_tx']) . "</pre></details>";
                            }
                        echo "</div>";
                    echo "</div>";
                }
                ?>
                </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- AI Assistant -->
    

            <!-- Crowdfunding Widget -->
            <div class="crowdfunding-widget">
                <h3>Join Now </h3>
                
                <button class="cf-btn" >List Yourself as Investor</button>
                <br>
                <br>
                <button class="cf-btn">Pitch Startup Idea</button>
            </div>

            <!-- Resources Widget -->
            <div class="resources-widget">
                <h3>Resources</h3>
                <div class="resource-item">
                    <div class="resource-icon">📚</div>
                    <div>
                        <div class="resource-title">Pitch Deck Guide</div>
                        <div class="resource-desc">How to create winning decks</div>
                    </div>
                </div>
                <div class="resource-item">
                    <div class="resource-icon">🎥</div>
                    <div>
                        <div class="resource-title">Pitch Videos</div>
                        <div class="resource-desc">Learn from the best</div>
                    </div>
                </div>
                <div class="resource-item">
                    <div class="resource-icon">💼</div>
                    <div>
                        <div class="resource-title">Investor Database</div>
                        <div class="resource-desc">Find perfect matches</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBmvS148YEpJaqdArwg83zyz7qkkgjSEzA",
            authDomain: "web3hack-7cc7e.firebaseapp.com",
            projectId: "web3hack-7cc7e",
            storageBucket: "web3hack-7cc7e.firebasestorage.app",
            messagingSenderId: "30048481947",
            appId: "1:30048481947:web:2ae2cde286b66a97e38c3e",
            measurementId: "G-W5ERQ9GR3B"
        };
        
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();
        const db = firebase.firestore();
        
        // DOM Elements
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const signOutBtn = document.getElementById('signOutBtn');
        const profileName = document.getElementById('profileName');
        const profileRole = document.getElementById('profileRole');
        const profileEmail = document.getElementById('profileEmail');
        const profileStatus = document.getElementById('profileStatus');
        const profileCreated = document.getElementById('profileCreated');
        const profileAvatar = document.getElementById('profileAvatar');
        
        // Toggle profile dropdown
        profileBtn.addEventListener('click', () => {
            profileDropdown.classList.toggle('active');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
        });
        
        // Sign out functionality
        signOutBtn.addEventListener('click', () => {
            auth.signOut().then(() => {
                window.location.href = 'login.html'; // Redirect to login page
            }).catch((error) => {
                console.error('Sign out error:', error);
                alert('Error signing out: ' + error.message);
            });
        });
        
        // Check auth state and load user data
        auth.onAuthStateChanged(user => {
            if (user) {
                // User is signed in
                console.log('User signed in:', user.uid);
                
                // Fetch user data from Firestore
                db.collection('users').doc(user.uid).get().then(doc => {
                    if (doc.exists) {
                        const userData = doc.data();
                        console.log('User data:', userData);
                        
                        // Update profile information
                        const fullName = `${userData.firstName} ${userData.lastName}`;
                        const initials = `${userData.firstName.charAt(0)}${userData.lastName.charAt(0)}`;
                        
                        profileName.textContent = fullName;
                        profileRole.textContent = userData.role;
                        profileEmail.textContent = user.email || userData.email;
                        profileStatus.textContent = userData.status || 'Active';
                        profileAvatar.textContent = initials;
                        
                        // Format and display creation date
                        if (userData.createdAt) {
                            const createdAt = userData.createdAt.toDate();
                            const options = { year: 'numeric', month: 'short', day: 'numeric' };
                            profileCreated.textContent = createdAt.toLocaleDateString(undefined, options);
                        }
                        
                        // Update avatar in header
                        profileBtn.textContent = initials;
                    } else {
                        console.log('No user data found');
                        profileName.textContent = user.displayName || 'User';
                        profileEmail.textContent = user.email || 'No email';
                    }
                }).catch(error => {
                    console.error('Error getting user data:', error);
                });
            } else {
                // User is signed out
                console.log('User not signed in');
                // Redirect to login page if not already there
                if (!window.location.href.includes('login.html')) {
                    window.location.href = 'login.html';
                }
            }
        });
        
        // Funding function remains the same
        async function fundStartup(wallet, startupId, target) {
            if (typeof window.ethereum === 'undefined') {
                alert('Please install MetaMask.');
                return;
            }
        
            const [account] = await ethereum.request({ method: 'eth_requestAccounts' });
            const amount = prompt("Enter amount to fund in ETH:");
            if (!amount || isNaN(amount) || parseFloat(amount) <= 0) {
                alert("Invalid amount.");
                return;
            }
        
            const weiAmount = (parseFloat(amount) * 1e18).toString();
            const txParams = {
                to: wallet,
                from: account,
                value: '0x' + parseInt(weiAmount).toString(16)
            };
        
            try {
                const txHash = await ethereum.request({ method: 'eth_sendTransaction', params: [txParams] });
                const form = new FormData();
                form.append("startup_id", startupId);
                form.append("amount", amount);
                form.append("tx_hash", txHash);
        
                await fetch("record_funding.php", { method: "POST", body: form });
                alert("Transaction successful: " + txHash);
                location.reload();
            } catch (err) {
                alert("Transaction failed: " + err.message);
            }
        }
    </script>
</body>
</html>