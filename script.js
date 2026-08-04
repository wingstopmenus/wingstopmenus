const seoData = {
    'home': {
        title: "Wingstop Menu 2026 – Updated Prices & Calories Guide | WingstopMenus.us",
        desc: "Complete Wingstop menu with current prices, calories, and nutrition info. Explore wings, tenders, sandwiches, sides, and flavors.",
        breadcrumb: "WingStop Menu 2026",
        keywords: ["wingstop menu", "wingstop prices", "wingstop calories", "2026 menu"]
    },
    'deals': {
        title: "🔥 Wingstop Coupons & Deals 2026 – Exclusive Promo Codes & Discounts",
        desc: "Get the latest Wingstop coupons, promo codes, and discounts for 2026. Save on wings, combos, family packs with our exclusive deals and offers. Updated daily!",
        breadcrumb: "Deals & Coupons",
        keywords: ["wingstop coupons", "wingstop promo codes", "wingstop deals", "wingstop discounts", "save money wingstop", "free delivery wingstop"]
    },
    'wings': {
        title: "Wingstop Wings Menu: Flavors, Bone-In & Boneless Prices 2026",
        desc: "Explore 12 Wingstop signature flavors plus limited-time flavors including Lemon Pepper and Atomic. View updated 2026 prices for bone-in, boneless, and mix & match wing combos.",
        breadcrumb: "Wings Menu",
        keywords: ["wingstop flavors", "bone-in wings", "boneless wings", "lemon pepper", "atomic wings"]
    },
    'menu': {
        title: "Wingstop Full Menu 2026: Tenders, Sandwiches, Sides & Prices",
        desc: "View the complete Wingstop menu beyond wings. Updated prices for Chicken Sandwiches, Crispy Tenders, Voodoo Fries, dips, drinks, and desserts.",
        breadcrumb: "Full Menu",
        keywords: ["wingstop tenders", "wingstop sandwiches", "voodoo fries", "wingstop sides", "chicken sandwich"]
    },
    'nutrition': {
        title: "Wingstop Nutrition Guide 2026: Calories, Carbs & Allergens",
        desc: "Detailed nutritional information for Wingstop. Find calorie counts for wings, flavors, and sides. Discover Keto-friendly and low-calorie options.",
        breadcrumb: "Nutrition Guide",
        keywords: ["wingstop calories", "wingstop nutrition", "wingstop carbs", "keto wingstop", "allergen information"]
    },
    'contact': {
        title: "Wingstop Locations & Contact: Phone Number, Hours & Ordering",
        desc: "Find Wingstop store locations, customer service numbers, and hours of operation. Learn how to order online for delivery or pickup.",
        breadcrumb: "Contact & Information",
        keywords: ["wingstop locations", "wingstop near me", "wingstop phone number", "wingstop hours", "order wingstop online"]
    }
};

    // 2. FUNCTION TO UPDATE META TAGS DYNAMICALLY
    function updateMetaTags(page) {
        const data = seoData[page];
        if (data) {
            // Update Browser Tab Title
            document.title = data.title;

            // Update Breadcrumb Text
            const breadcrumbEl = document.getElementById('currentPage');
            if (breadcrumbEl) breadcrumbEl.textContent = data.breadcrumb;

            // Update Meta Description
            const metaDesc = document.querySelector('meta[name="description"]');
            if (metaDesc) metaDesc.setAttribute("content", data.desc);

            // Update Open Graph Tags (Facebook/Socials)
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) ogTitle.setAttribute("content", data.title);

            const ogDesc = document.querySelector('meta[property="og:description"]');
            if (ogDesc) ogDesc.setAttribute("content", data.desc);
            
            const ogUrl = document.querySelector('meta[property="og:url"]');
            if (ogUrl) ogUrl.setAttribute("content", "https://wingstopmenus.us/#" + page);

            // Update Canonical Link (Google SEO)
            const canonical = document.querySelector('link[rel="canonical"]');
            if (canonical) canonical.setAttribute("href", "https://wingstopmenus.us/#" + page);
        }
    }

    // 3. MAIN PAGE NAVIGATION FUNCTION (Modified for SEO)
    function showPage(page, updateHistory = true) {
        // Check if page exists (error handling)
        const targetPage = document.getElementById('page-' + page);
        if (!targetPage) return;

        // Hide all pages
        document.querySelectorAll('[id^="page-"]').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('active-page');
        });
        
        // Show selected page
        targetPage.classList.remove('hidden');
        targetPage.classList.add('active-page');
        
        // --- NEW SEO UPDATE CALL ---
        updateMetaTags(page);
        // ---------------------------
        
        // Update History API (Changes URL without reload)
        if (updateHistory) {
            // Use the title from our data object
            const pageTitle = seoData[page] ? seoData[page].title : 'WingStop Menu';
            history.pushState({page: page}, pageTitle, "#" + page);
        }
        
        // Scroll to top
        window.scrollTo(0, 0);
        
        // Update active nav link
        document.querySelectorAll('nav a').forEach(link => {
            link.classList.remove('active-tab');
        });
        
        // Find the nav link corresponding to this page and activate it
        const activeLink = document.querySelector(`nav a[href="#${page}"]`);
        if(activeLink) activeLink.classList.add('active-tab');
        
        // Close mobile menu if open
        const mainNav = document.getElementById('mainNav');
        if (mainNav) mainNav.classList.remove('show', 'active');
    }

    // 4. INITIAL LOAD & EVENT LISTENERS
    window.addEventListener('DOMContentLoaded', (event) => {
        // Get hash from URL (e.g., #nutrition)
        const hash = window.location.hash.replace('#', '');
        if (hash && seoData[hash]) {
            showPage(hash, false); 
        }
        
        // Lazy loading implementation
        const lazyElements = document.querySelectorAll('.lazy-load');
        const lazyLoad = function() {
            lazyElements.forEach(element => {
                if (element.getBoundingClientRect().top <= window.innerHeight && element.getBoundingClientRect().bottom >= 0) {
                    element.classList.add('loaded');
                }
            });
        };
        lazyLoad();
        window.addEventListener('scroll', lazyLoad);
    });

    // Handle Browser Back/Forward Buttons
    window.addEventListener('popstate', (event) => {
        const page = (event.state && event.state.page) ? event.state.page : 'home';
        showPage(page, false);
    });

    // Click Handler Wrapper
    function handleClick(event, pageId) {
        event.preventDefault();
        showPage(pageId, true);
    }
    
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNav = document.getElementById('mainNav');
    if (mobileMenuBtn && mainNav) {
        mobileMenuBtn.addEventListener('click', function() {
            const isOpen = mainNav.classList.toggle('show');
            mainNav.classList.toggle('active', isOpen);
            mobileMenuBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }
    
    // FAQ accordion functionality
    function toggleFAQ(element) {
        const answer = element.nextElementSibling;
        const isOpen = answer.style.display === 'block';
        const icon = element.querySelector('span');
        
        document.querySelectorAll('.faq-answer').forEach(ans => {
            ans.style.display = 'none';
        });
        document.querySelectorAll('.faq-question').forEach(q => {
            q.setAttribute('aria-expanded', 'false');
            const qIcon = q.querySelector('span');
            if (qIcon) qIcon.textContent = '+';
        });
        
        if (!isOpen) {
            answer.style.display = 'block';
            if (icon) icon.textContent = '-';
            element.setAttribute('aria-expanded', 'true');
        }
    }
    
    // Back to top button functionality
    const backToTopButton = document.getElementById('backToTop');
    
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Newsletter form submissions
    const handleNewsletter = (e) => {
        e.preventDefault();
        alert('Thank you for subscribing to our newsletter!');
        e.target.reset();
    };

    ['newsletterForm', 'newsletterForm2', 'newsletterForm3', 'newsletterForm4', 'newsletterForm5'].forEach(id => {
        const form = document.getElementById(id);
        if (form) form.addEventListener('submit', handleNewsletter);
    });
    
    // JavaScript functions for interactivity
function voteFlavor(flavor) {
    // Simple voting system - can be enhanced with backend
    const votes = JSON.parse(localStorage.getItem('wingstopVotes') || '{}');
    votes[flavor] = (votes[flavor] || 0) + 1;
    localStorage.setItem('wingstopVotes', JSON.stringify(votes));
    
    // Show thank you message
    alert(`Thanks for voting for ${flavor.replace('-', ' ').toUpperCase()}! 🎉\n\nCurrent results will be displayed soon.`);
    
    // Update button color
    const buttons = document.querySelectorAll('.poll-btn');
    buttons.forEach(btn => {
        if (btn.textContent.toLowerCase().includes(flavor)) {
            btn.style.background = '#28a745';
            btn.style.color = 'white';
            btn.style.borderColor = '#28a745';
            btn.disabled = true;
        }
    });
}

// Social sharing functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('WingStop Menu & Prices 2026 - Complete Guide');
    const image = encodeURIComponent('https://wingstopmenus.us/img/wingstop-menu-prices.jpg');
    
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}&picture=${image}`, '_blank');
    trackShare('facebook');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('Check out this complete WingStop menu guide for 2026 with prices, nutrition, and coupons! 🍗');
    const hashtags = encodeURIComponent('WingStop,ChickenWings,FoodGuide');
    
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}&hashtags=${hashtags}`, '_blank');
    trackShare('twitter');
}

function shareOnPinterest() {
    const url = encodeURIComponent(window.location.href);
    const media = encodeURIComponent('https://wingstopmenus.us/img/wingstop-menu-prices.jpg');
    const description = encodeURIComponent('WingStop Menu 2026 - Complete Guide with Prices & Nutrition | Save with coupons!');
    
    window.open(`https://pinterest.com/pin/create/button/?url=${url}&media=${media}&description=${description}`, '_blank');
    trackShare('pinterest');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('Check out this WingStop menu guide! 🍗\n\n' + window.location.href);
    
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        window.open(`whatsapp://send?text=${text}`, '_blank');
    } else {
        window.open(`https://web.whatsapp.com/send?text=${text}`, '_blank');
    }
    trackShare('whatsapp');
}

function shareOnReddit() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('WingStop Menu & Prices 2026 - Complete Guide with Nutrition & Coupons');
    
    window.open(`https://reddit.com/submit?url=${url}&title=${title}`, '_blank');
    trackShare('reddit');
}

function shareViaEmail() {
    const subject = encodeURIComponent('WingStop Menu & Prices 2026 - Complete Guide');
    const body = encodeURIComponent(`Hey! I found this awesome WingStop guide:\n\n${window.location.href}\n\nIt has:\n✅ Updated 2026 prices\n✅ Nutrition facts & calories\n✅ Exclusive coupons & deals\n✅ 12 signature flavors + limited-time flavors\n✅ Ordering tips\n\nCheck it out! 🍗`);
    
    window.location.href = `mailto:?subject=${subject}&body=${body}`;
    trackShare('email');
}

// Copy page link to clipboard
function copyPageLink() {
    const url = window.location.href;
    const tempInput = document.createElement('input');
    tempInput.value = url;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    
    // Show success notification
    showShareSuccess('✅ Link copied to clipboard!');
    
    // Update share count
    trackShare('copy');
}

// Track shares
function trackShare(platform) {
    // Get today's date
    const today = new Date().toDateString();
    
    // Get or initialize share data
    let shareData = JSON.parse(localStorage.getItem('shareData') || '{}');
    
    // Initialize today's data if needed
    if (!shareData[today]) {
        shareData[today] = {
            facebook: 0,
            twitter: 0,
            pinterest: 0,
            whatsapp: 0,
            reddit: 0,
            email: 0,
            copy: 0,
            total: 0
        };
    }
    
    // Increment platform count
    shareData[today][platform]++;
    shareData[today].total++;
    
    // Save back to localStorage
    localStorage.setItem('shareData', JSON.stringify(shareData));
    
    // Update display
    updateShareCount();
    
    // Optional: Send to analytics
    console.log(`Shared via ${platform}: ${shareData[today].total} total shares today`);
}

// Update share count display
function updateShareCount() {
    const today = new Date().toDateString();
    const shareData = JSON.parse(localStorage.getItem('shareData') || '{}');
    
    if (shareData[today]) {
        const totalShares = shareData[today].total;
        const countEl = document.getElementById('shareCount');
        if (!countEl) return;
        countEl.textContent = totalShares;
        
        // Add animation if shares increase
        countEl.style.transform = 'scale(1.2)';
        setTimeout(() => {
            countEl.style.transform = 'scale(1)';
        }, 300);
    }
}

// Show success notification
function showShareSuccess(message) {
    const successEl = document.getElementById('shareSuccess');
    if (!successEl) return;
    successEl.textContent = message;
    successEl.style.display = 'block';
    
    // Hide after 3 seconds
    setTimeout(() => {
        successEl.style.display = 'none';
    }, 3000);
}

// Initialize share count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateShareCount();
    
    // Add share buttons to print
    const printShareBtn = document.createElement('button');
    printShareBtn.textContent = '🖨️ Print This Guide';
    printShareBtn.className = 'share-btn';
    printShareBtn.style.background = 'linear-gradient(135deg, #ff9800 0%, #f57c00 100%)';
    printShareBtn.style.border = '2px solid #f57c00';
    printShareBtn.onclick = () => window.print();
    
    // Add to share buttons container
    const shareButtons = document.querySelector('.share-buttons');
    if (shareButtons) {
        shareButtons.appendChild(printShareBtn);
    }
    
    // Add QR code generation for mobile sharing
    if (window.innerWidth <= 768) {
        const qrShareBtn = document.createElement('button');
        qrShareBtn.textContent = '📱 QR Code';
        qrShareBtn.className = 'share-btn';
        qrShareBtn.style.background = 'linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%)';
        qrShareBtn.style.border = '2px solid #7b1fa2';
        qrShareBtn.onclick = generateQRCode;
        
        if (shareButtons) {
            shareButtons.appendChild(qrShareBtn);
        }
    }
});

// Generate QR Code (simplified version)
function generateQRCode() {
    const url = window.location.href;
    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(url)}`;
    
    // Show QR code in modal
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
    `;
    
    modal.innerHTML = `
        <div style="background: white; padding: 30px; border-radius: 15px; text-align: center;">
            <h3 style="margin-bottom: 20px;">📱 Scan QR Code</h3>
            <img src="${qrUrl}" alt="QR Code" style="width: 200px; height: 200px;">
            <p style="margin: 20px 0; color: #666;">Scan this QR code with your phone to open this guide</p>
            <button onclick="this.parentElement.parentElement.remove()" style="padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Close
            </button>
        </div>
    `;
    
    document.body.appendChild(modal);
    trackShare('qr_code');
}

// Keyboard shortcuts for sharing
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key.toLowerCase()) {
            case 'c':
                if (e.shiftKey) {
                    e.preventDefault();
                    copyPageLink();
                }
                break;
            case 'f':
                if (e.shiftKey) {
                    e.preventDefault();
                    shareOnFacebook();
                }
                break;
            case 't':
                if (e.shiftKey) {
                    e.preventDefault();
                    shareOnTwitter();
                }
                break;
        }
    }
});


// Add structured data for SEO
document.addEventListener('DOMContentLoaded', function() {
    // Add JSON-LD structured data
    const script = document.createElement('script');
    script.type = 'application/ld+json';
    script.textContent = JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "WingStop Menu & Prices 2026 - Complete Guide with Nutrition & Calories",
        "description": "Complete WingStop menu with updated prices, nutrition facts, calorie counts, secret menu items, and coupons for 2026.",
        "datePublished": "2026-01-01",
        "dateModified": new Date().toISOString().split('T')[0],
        "author": {
            "@type": "Organization",
            "name": "WingStop Menus",
            "url": "https://wingstopmenus.us"
        },
        "publisher": {
            "@type": "Organization",
            "name": "WingStop Menus",
            "logo": {
                "@type": "ImageObject",
                "url": "https://wingstopmenus.us/logo.png"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://wingstopmenus.us/"
        },
        "image": "https://wingstopmenus.us/img/wingstop-menu-prices.jpg"
    });
    document.head.appendChild(script);
    
    // Track page views (simplified)
    const pageViews = parseInt(localStorage.getItem('pageViews') || '0') + 1;
    localStorage.setItem('pageViews', pageViews.toString());
    
    // Show poll results if available
    const votes = JSON.parse(localStorage.getItem('wingstopVotes') || '{}');
    if (Object.keys(votes).length > 0) {
        const totalVotes = Object.values(votes).reduce((a, b) => a + b, 0);
        const pollNote = document.querySelector('.poll-note');
        if (pollNote) {
            const topFlavor = Object.keys(votes).reduce((a, b) => votes[a] > votes[b] ? a : b);
            pollNote.innerHTML = `Current leader: <strong>${topFlavor.replace('-', ' ').toUpperCase()}</strong> (${votes[topFlavor]} votes)`;
        }
    }
});

// INTEGRATION WITH EXISTING FOOTER
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
    const isHomepage = currentPath === '/' || currentPath === '/index.html';
    if (!isHomepage) return;
    const footer = document.querySelector('footer');
    if (!footer) return;
    
    // Create counter section
    const counterSection = document.createElement('div');
    counterSection.className = 'footer-counter';
    counterSection.style.cssText = `
        
        color: white;
        padding: 20px;
        text-align: center;
        
        border-radius: 10px 10px 0 0;
    `;
    
    // Calculate stats
    let totalViews = parseInt(localStorage.getItem('totalViews') || '0');
    totalViews++;
    localStorage.setItem('totalViews', totalViews.toString());
    
    // Get daily views
    const today = new Date().toDateString();
    let dailyViews = parseInt(localStorage.getItem('dailyViews') || '0');
    const lastVisit = localStorage.getItem('lastVisit');
    
    if (lastVisit !== today) {
        dailyViews = 1;
        localStorage.setItem('lastVisit', today);
    } else {
        dailyViews++;
    }
    localStorage.setItem('dailyViews', dailyViews.toString());
    
    // Create counter HTML
    counterSection.innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; max-width: 800px; margin: 0 auto;">
            <div>
                <div style="font-size: 24px; font-weight: bold;">${dailyViews.toLocaleString()}</div>
                <div style="font-size: 14px; opacity: 0.9;">Visitors Today</div>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: bold;">${totalViews.toLocaleString()}</div>
                <div style="font-size: 14px; opacity: 0.9;">Total Page Views</div>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: bold;">${getAverageDailyViews().toLocaleString()}</div>
                <div style="font-size: 14px; opacity: 0.9;">Avg. Daily Visitors</div>
            </div>
        </div>
        <div style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
            <span style="background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 15px; margin: 0 5px;">
                📍 Real-time Counter
            </span>
            <span style="background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 15px; margin: 0 5px;">
                🔒 Privacy Safe
            </span>
        </div>
    `;
    
    // Insert at the top of footer
    footer.insertBefore(counterSection, footer.firstChild);
    
    // Function to calculate average daily views
    function getAverageDailyViews() {
        const firstVisit = localStorage.getItem('firstVisitDate') || new Date().toISOString();
        const firstDate = new Date(firstVisit);
        const today = new Date();
        const daysDiff = Math.ceil((today - firstDate) / (1000 * 60 * 60 * 24));
        return daysDiff > 0 ? Math.round(totalViews / daysDiff) : totalViews;
    }
});
