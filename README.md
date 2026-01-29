# FrontDesk-MRBS-Display


A modern, high-performance digital signage dashboard designed specifically for the **Meeting Room Booking System (MRBS)**. This project transforms standard MRBS data into a professional, automated reception display, perfect for academic centres, libraries, or corporate lobbies.



## 🚀 Key Features

- **Modern Clean UI:** A minimalist light-themed design built with Tailwind CSS and Plus Jakarta Sans.
- **Live Sync Engine:** Automatically fetches approved bookings from the database every 5 minutes without page reloads.
- **Dynamic Pagination:** Automatically loops through schedules (7 items per page) every 30 seconds with a visual progress timer.
- **Internal vs External Logic:** - Admin-approved events only (`status = 0`).
  - Automatic blue color-coding and "External" tagging for events marked as type 'E'.
- **Interactive Control Center:**
  - **Date Picker:** Select any date using a fully integrated FullCalendar instance.
  - **Hidden Bin:** Hover over sensitive or private events to move them to a hidden queue in the sidebar.
- **Kiosk Mode Optimized:** Built-in digital clock and fullscreen API support for dedicated terminal PCs.

## 🛠️ Tech Stack

- **Frontend:** HTML5, Tailwind CSS, JavaScript (ES6+)
- **Backend:** PHP (PDO)
- **Database:** MySQL / MariaDB (MRBS Schema)
- **Icons & Fonts:** FullCalendar, Plus Jakarta Sans, JetBrains Mono

## 📋 Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Dushan-456/FrontDesk-MRBS-Display.git
   
2. **Database Setup:**

   ```bash
   $host = 'localhost';
   $db   = 'academic_centre';
   $user = 'your_username';
   $pass = 'your_password';
   ```