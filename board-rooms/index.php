<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reception Display | Main Premises</title>
    <link rel="icon" type="image/x-icon" href="./images/logo without bg1.png">


    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --surface: #ffffff;
            --background: #f1f5f9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--background);
            color: #1e293b;
        }

        .sidebar {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            width: 380px;
        }

        .sidebar.closed {
            transform: translateX(-100%);
            margin-left: -380px;
        }

        /* Modern White Card */
        .event-card {
            background: var(--surface);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .event-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        /* Interactive Elements */
        .hide-btn {
            opacity: 0;
            transition: all 0.2s ease;
        }

        .event-card:hover .hide-btn {
            opacity: 1;
        }

        .progress-container {
            height: 6px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        /* Calendar UI Tweaks */
        .fc .fc-toolbar-title {
            font-size: 1rem !important;
            font-weight: 800;
            color: #475569;
        }

        .fc .fc-button-primary {
            background-color: white;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        .fc .fc-button-primary:hover {
            background-color: #f8fafc;
            color: #1e293b;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade {
            animation: fadeIn 0.4s ease-out forwards;
        }

        #eventList {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(./images/bg.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }


        #datepicker {
            width: 100%;
            margin-bottom: 1.5rem;
        }

        .fc-view-harness {
            background: transparent !important;
        }

        .fc .fc-scroller {
            overflow: hidden !important;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.2);

            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        #digitalClock {
            min-width: 220px;
            justify-content: flex-end;
            display: flex;
            align-items: baseline;
            font-variant-numeric: tabular-nums;
        }
        #musicBtn.playing {
            color: #2563eb;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.2);
            border-color: #bfdbfe;
        }   
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        .animate-marquee {
            display: inline-block;
            animation: marquee 150s linear infinite; /*  change speed */
        }

   
        #tickerContent div {
            display: inline-flex; 
            vertical-align: middle;
        }

        #tickerContent {
            display: inline-block;
            white-space: nowrap; 
        }
.welcome-text {
    background: linear-gradient(
        to right, 
        #1e293b 20%, 
        #2563eb 40%, 
        #60a5fa 60%, 
        #1e293b 80%
    );
    background-size: 200% auto;
    color: #000;
    background-clip: text;
    text-fill-color: transparent;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shine 4s linear infinite, fadeInUp 0.8s ease-out forwards;
}

@keyframes shine {
    to { background-position: 200% center; }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

        
    </style>
</head>

<body class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="sidebar bg-white border-r border-slate-200 flex flex-col p-8 z-30 shadow-xl closed h-screen overflow-y-auto custom-scrollbar">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-[10px] font-black tracking-[0.2em] text-slate-400">CONTROL PANEL</h2>
            <button onclick="toggleSidebar()" class="text-slate-300 hover:text-red-500 transition">✕</button>
        </div>

        <div class="mb-10 shrink-0">
            <div id="datepicker" class="bg-slate-50 p-2 rounded-2xl border border-slate-100 text-sm shadow-sm"></div>
        </div>

        <div class="flex flex-col mb-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Hidden Bin</h3>
                <span id="hiddenCount" class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-md font-bold border border-slate-200">0</span>
            </div>
            <div id="hiddenBin" class="space-y-2">
                <p class="text-xs text-slate-300 italic text-center py-4">No events hidden</p>
            </div>
        </div>

        <div class="mt-auto shrink-0 pb-4">
            <button onclick="toggleFullScreen()" class="w-full py-4 bg-slate-900 text-white rounded-xl font-bold text-[10px] tracking-widest hover:bg-blue-600 transition-all uppercase">
                Fullscreen
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0">

        <!-- <div class="bg-blue-900 text-white py-1 overflow-hidden border-b border-white/10 relative z-50">
            <div class="flex items-center gap-4 px-10">
             
                
                <div class="flex-1 overflow-hidden relative h-[35px]">
                    <div id="tickerContent" class="absolute text-center w-full text-3xl font-bold tracking-wide text-slate-300 transition-all duration-500 transform translate-y-0">
                        
                    Welcome to PGIM Academic Centre - Please check your room number before heading to the floors.
                    </div>
                </div>
            </div>
        </div> -->


        <header class="px-10 py-2 flex justify-between items-center bg-white border-b border-slate-200 z-20">
            <div class="flex items-center gap-6">
                <button onclick="toggleSidebar()" class="p-3 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition shadow-sm">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <div class="flex gap-5">
                    <img class="h-[70px] w-auto" src="./images/logo without bg1.png" alt="">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">PGIM Main Premises - Board Rooms</h1>
                        <p id="displayDate" class="text-sm font-semibold text-slate-400"></p>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="welcome-text text-5xl font-extrabold tracking-tighter">
                    Welcome!
                </h3>
            </div>
            <div class="flex items-center gap-10">
                <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                    <button id="musicBtn" onclick="toggleMusic()" class="w-10 h-10 flex items-center justify-center bg-white rounded-lg shadow-sm hover:text-blue-600 transition-all text-slate-400">
                        <svg id="playIcon" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <svg id="pauseIcon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                    </button>
                    <audio id="bgMusic" loop>
                        <source src="../background-music/background-music-1.mp3" type="audio/mpeg">
                    </audio>
                </div>
                <div class="text-right">
                    <div id="digitalClock" class=" font-black tracking-tight text-slate-800 flex items-baseline justify-end">00:00</div>
                    <div id="paginationStatus" class="text-[12px] font-bold text-blue-600 uppercase tracking-widest mt-2">PAGE 1 OF 1</div>
                </div>
            </div>
        </header>


        </div>

        <section id="eventList" class="py-2  px-[150px] flex-1 grid gap-4 content-start overflow-hidden relative ">
        </section>

        <div class="bg-white  border-t border-slate-100">
            <div class="max-w-7xl mx-auto flex items-center gap-6">
                <span class="text-[12px] font-black text-black uppercase tracking-widest">NEXT PAGE </span>
                <div class="flex-1 progress-container">
                    <div id="progressTimer" class="h-full bg-red-600 w-0"></div>
                </div>
            </div>
        </div>
            <div class="bg-blue-900  text-white py-2 overflow-hidden border-b border-white/10 relative z-50 flex items-center">
                <div class="bg-red-600 text-[20px] font-black uppercase tracking-tighter px-3 py-1 rounded-r-lg shrink-0 z-10 shadow-lg">
                    Special Notice
                </div>
                
                <div class="flex-1 overflow-hidden whitespace-nowrap relative">
                    <div id="tickerContent" class="inline-block h-[35px] pl-[100%] animate-marquee text-3xl font-bold tracking-wide text-slate-300">
                        </div>
                </div>
            </div>

    </main>


    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        let allEvents = [];
        let hiddenIds = new Set();
        let currentPage = 1;
        const itemsPerPage = 6;
        let rotationInterval;
        const ROTATION_TIME = 10000;

        const toggleSidebar = () => document.getElementById('sidebar').classList.toggle('closed');
        const toggleFullScreen = () => {
            if (!document.fullscreenElement) document.documentElement.requestFullscreen();
            else document.exitFullscreen();
        };

        // 12-Hour Digital Clock with Toggleable Seconds
        function updateClock() {
            const now = new Date();
            
            const showSeconds = true; 
            
            const options = { 
                hour: '2-digit', 
                minute: '2-digit', 
                hour12: true 
            };
            
            if (showSeconds) options.second = '2-digit';

            const timeString = now.toLocaleTimeString('en-GB', options);

            const [time, ampm] = timeString.split(' ');

            document.getElementById('digitalClock').innerHTML = `
                <span class="text-5xl font-black tabular-nums">${time}</span>
                <span class="text-2xl font-bold text-blue-600 ml-1 uppercase">${ampm}</span>
            `;
        }

        // Update every second
        setInterval(updateClock, 1000);
        updateClock();


        // Background Music
            const music = document.getElementById('bgMusic');
            const playIcon = document.getElementById('playIcon');
            const pauseIcon = document.getElementById('pauseIcon');

            function toggleMusic() {
                if (music.paused) {
                    music.play().catch(error => {
                        console.log("Browser blocked autoplay. User must click play manually.");
                    });
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    music.pause();
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                }
            }

        async function loadData(date) {
            const list = document.getElementById('eventList');
            document.getElementById('displayDate').innerText = new Date(date).toLocaleDateString('en-GB', {
                dateStyle: 'full'
            });

            try {
                const res = await fetch(`fetch_events.php?date=${date}`);
                const data = await res.json();

                if (data.error) {
                    showErrorState(data.error);
                    return;
                }

                allEvents = data;
                currentPage = 1;
                render();
                resetRotation();
            } catch (e) {
                showErrorState("Server Unreachable");
            }
        }

        function showErrorState(message) {
            const list = document.getElementById('eventList');
            list.innerHTML = `
        <div class="flex flex-col items-center justify-center mt-20 animate-fade">
            <div class="bg-red-50 p-8 rounded-[40px] border border-red-100 flex flex-col items-center max-w-lg shadow-xl shadow-red-100/50">
                <div class="w-20 h-20 bg-red-500 rounded-3xl flex items-center justify-center mb-6 shadow-lg shadow-red-200">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-red-900 uppercase tracking-tight mb-2">Service Interruption</h2>
                <p class="text-red-600 font-medium text-center">We are currently unable to sync with the  database. ${message}</p>
                <button onclick="location.reload()" class="mt-6 px-6 py-2 bg-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-red-700 transition shadow-md">
                    Retry Connection
                </button>
            </div>
        </div>
    `;
        }

        function hideEvent(id) {
            hiddenIds.add(id.toString());
            render();
        }

        function restoreEvent(id) {
            hiddenIds.delete(id.toString());
            render();
        }

        function render() {
            const visible = allEvents.filter(e => !hiddenIds.has(e.id.toString()));
            const hidden = allEvents.filter(e => hiddenIds.has(e.id.toString()));

            // Update Bin
            const bin = document.getElementById('hiddenBin');
            document.getElementById('hiddenCount').innerText = hidden.length;
            bin.innerHTML = hidden.length ? '' : '<p class="text-xs text-slate-300 italic text-center py-4">No events hidden</p>';
            hidden.forEach(e => {
                bin.innerHTML += `
                    <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg border border-slate-100 text-[11px] font-bold">
                        <span class="truncate text-slate-600">${e.event_name}</span>
                        <button onclick="restoreEvent('${e.id}')" class="text-blue-600 hover:text-blue-800">SHOW</button>
                    </div>`;
            });

            const totalPages = Math.ceil(visible.length / itemsPerPage) || 1;
            if (currentPage > totalPages) currentPage = 1;
            document.getElementById('paginationStatus').innerText = `PAGE ${currentPage} OF ${totalPages}`;

            const list = document.getElementById('eventList');
            const start = (currentPage - 1) * itemsPerPage;
            const pageData = visible.slice(start, start + itemsPerPage);


            list.innerHTML = pageData.length ? '' : `
            <div class=" glass-box p-10 flex flex-col rounded-2xl items-center justify-center mt-24 animate-fade">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-blue-100 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                    <svg class="relative w-32 h-32 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                
                <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2 uppercase italic">Quiet Day Ahead</h2>
                <p class=" text-xl tracking-wide">There are no confirmed sessions scheduled for this date.</p>
                
                <div class="mt-8 flex gap-2">
                    <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                    <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                </div>
            </div>
        `;

            pageData.forEach((e, idx) => {
                const isExternal = e.event_type === 'E';
                const nowTs = Math.floor(Date.now() / 1000);
                const isMultiDay = (parseInt(e.raw_end) - parseInt(e.raw_start)) > 86400; 
                const isOngoing = (nowTs >= parseInt(e.raw_start) && nowTs <= parseInt(e.raw_end));

                const multiDayBadge = isMultiDay ? 
                    `<span class="ml-2 text-[10px] font-black uppercase tracking-widest bg-amber-500 text-white px-2 py-1 rounded shadow-lg animate-pulse">Multi-Day</span>` : '';

                
                const cardBg = isExternal ? 'bg-blue-50 border-blue-200 shadow-blue-200/50' : 'glass-box shadow-lg';
                
                const arrowBg = isExternal ? 'bg-blue-600' : 'bg-blue-50';
                const arrowIconColor = isExternal ? 'text-white' : 'text-blue-600';

                const titleColor = isExternal ? 'text-blue-900 font-black' : 'text-white';
                const roomInfoColor = isExternal ? 'text-blue-700' : 'text-white';

                const timeBg = isExternal ? 'bg-blue-600 text-white border-blue-400' : 'bg-white border-slate-100 text-black';
                const timeIconColor = isExternal ? 'text-blue-100' : 'text-[#1b850b]';

                const externalTag = isExternal ?
                    `<span class="ml-2 text-[9px] font-black uppercase tracking-widest bg-blue-700 text-white px-2 py-0.5 rounded shadow-sm">External</span>` :
                    '';

                list.innerHTML += `
                    <div class="${cardBg} px-4 py-2 rounded-2xl event-card flex justify-between items-center animate-fade relative border transition-all duration-300" style="animation-delay: ${idx * 0.25}s">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-3">
                                <div class="${arrowBg} p-1.5 rounded-lg shadow-sm">
                                    <svg class="w-6 h-6 ${arrowIconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-2 ">
                                <h3 class="text-[42px] font-bold ${titleColor} tracking-tight truncate max-w-[800px]">
                                    ${e.event_name} 
                                    ${multiDayBadge}
                                </h3>    
                                <div class="text-right">
                                    <span class="flex w-[350px] gap-5 items-center font-['Orbitron'] text-xl font-bold ${timeBg} px-4 py-1 rounded-xl border">
                                        <svg class="w-6 h-6 ${timeIconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        ${e.start_time} - ${e.end_time}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-8">
                            <button onclick="hideEvent('${e.id}')" class="hide-btn p-3 ${isExternal ? 'bg-blue-500 text-blue-100 hover:bg-red-500' : 'bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-500'} rounded-xl transition-all border ${isExternal ? 'border-blue-400/30' : 'border-slate-100'}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>

                            <div class="flex flex-col items-end ">
                                <div class="flex gap-2 items-center">
                                    <span class="text-2xl font-bold">
                                        ${externalTag} 
                                    </span>
                                    <span class="text-3xl font-bold ${roomInfoColor}">
                                    ${e.room_name} -
                                    </span>
                                    <span class="text-3xl font-black uppercase tracking-widest bg-[#a87f18] text-blue-100 border-black px-2 py-0.5 rounded border">
                                        ${e.floor_num}
                                    </span>
                                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });
        }

        function resetRotation() {
            if (adActive) return;
            clearInterval(rotationInterval);
            const bar = document.getElementById('progressTimer');
            const step = () => {
                const visible = allEvents.filter(e => !hiddenIds.has(e.id.toString()));
                const totalPages = Math.ceil(visible.length / itemsPerPage);
                if (totalPages > 1) {
                    currentPage = (currentPage % totalPages) + 1;
                    render();
                }
                animateBar();
            };
            const animateBar = () => {
                bar.style.transition = 'none';
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = `width ${ROTATION_TIME}ms linear`;
                    bar.style.width = '100%';
                }, 50);
            };
            rotationInterval = setInterval(step, ROTATION_TIME);
            animateBar();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cal = new FullCalendar.Calendar(document.getElementById('datepicker'), {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                contentHeight: 'auto',
                handleWindowResize: true,
                expandRows: true,
                stickyHeaderDates: false,
                dateClick: (info) => loadData(info.dateStr)
            });
            cal.render();
            loadData(new Date().toISOString().split('T')[0]);
        });


        let adActive = false;
        let currentAdIndex = 0; // Tracks which Notice to show next
        const NOTICE_DURATION = 10; // Seconds to show the Notice
        const NOTICE_INTERVAL = 60000; // 1 minute interval

        // Array of your 4 separate Notice images
        const NoticeImg = [
            './images/notice1.png',
            './images/notice2.png',
            './images/notice1.png',
            './images/notice2.png'
        ];

        function triggerSponsorAd() {
            if (adActive) return;
            
            adActive = true;
            const overlay = document.getElementById('sponsorOverlay');
            const noticeImage = document.getElementById('adContent');
            const timerElement = document.getElementById('adTimer');
            
            // Set the image source based on the current index
            noticeImage.src = NoticeImg[currentAdIndex];
            
            // Move to the next ad for the next minute, reset to 0 if at the end
            currentAdIndex = (currentAdIndex + 1) % NoticeImg.length;

            let timeLeft = NOTICE_DURATION;
            timerElement.innerText = timeLeft;

            // Show overlay
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');

            const countdown = setInterval(() => {
                timeLeft--;
                timerElement.innerText = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    closeAd();
                }
            }, 1000);
        }

        function closeAd() {
            const overlay = document.getElementById('sponsorOverlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            adActive = false;
            resetRotation(); 
        }

        // Start the 1-minute cycle
        setInterval(triggerSponsorAd, NOTICE_INTERVAL);

/*
        const notices = [
            "Welcome to PGIM Academic Centre - Please check your room number before heading to the floors.",
            "Wi-Fi : PGIM NET  |  Password : accesspgim",
            "Cafeteria is Now Open on the 3rd Floor for All Participants.Place Your Lunch Orders before 10.00 AM",
            "Please Maintain Silence Near the Examination Halls." ,
            "Library Hours: Weekdays from 08:30 AM to 07:00 PM  | Saturdays 08:30 AM to 05:00 PM",
            "IT Support : Visit the IT Service Center on the 3rd Floor from 12.00 PM to 02.00 PM.",
            "Emergency Exit: Please follow the green illuminated signs in case of fire."
        ];

        let currentNoticeIndex = 0;

        function rotateNotices() {
            const ticker = document.getElementById('tickerContent');
            
            // 1. Slide the current text out (up)
            ticker.style.opacity = "0";
            ticker.style.transform = "translateY(-20px)";

            setTimeout(() => {
                // 2. Change the text
                currentNoticeIndex = (currentNoticeIndex + 1) % notices.length;
                ticker.innerText = notices[currentNoticeIndex];

                // 3. Move the ticker back to the bottom without animation
                ticker.style.transition = "none";
                ticker.style.transform = "translateY(20px)";

                // 4. Slide the new text in (up to center)
                setTimeout(() => {
                    ticker.style.transition = "all 0.5s ease-out";
                    ticker.style.opacity = "1";
                    ticker.style.transform = "translateY(0)";
                }, 50);
            }, 500);
        }

        // Rotate every 5 seconds
        setInterval(rotateNotices, 5000);

*/
        const notices = [
       "Welcome to PGIM Academic Centre - Please check your room number before heading to the floors.",
            "Wi-Fi Access: Connect to 'PGIMNET' with Password : accesspgim",
            "Cafeteria is Now Open on the 3rd Floor for All Participants.Place Your Lunch Orders before 10.00 AM",
            "Please Maintain Silence Near the Examination Halls." ,
            "Library Hours: Weekdays from 08:30 AM to 07:00 PM  | Saturdays 08:30 AM to 05:00 PM",
            "IT Support : Visit the IT Service Center on the 3rd Floor from 12.00 PM to 02.00 PM.",
            "Emergency Exit: Please follow the green illuminated signs in case of fire."
        ];

        // r separator icon as a string
        const separator = `
            <div class="inline-block bg-blue-50 p-1 rounded-md ml-40 mr-5 shadow-sm align-middle">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </div>
        `;

        // Join notices using the separator
        const longNoticeString = notices.join(separator);

        const ticker = document.getElementById('tickerContent');
        ticker.innerHTML = longNoticeString + separator + longNoticeString;

    </script>

        <div id="sponsorOverlay" class="fixed inset-0 z-[100] bg-black/10 backdrop-blur-md hidden flex-col items-center justify-center animate-fade">
            <div class="absolute top-10 right-10">
                Skip in <span id="adTimer" class="text-black font-mono text-3xl border-2 border-white/20 px-6 py-2 rounded-full tabular-nums">10</span>
            </div>
            <div class="w-full h-full flex items-center justify-center p-12">
                <img id="adContent" src="" class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl border-8 border-white/5 object-contain">
            </div>
            <div class="absolute bottom-10 flex flex-col items-center gap-2">
             <p class="text-blue-400 tracking-[0.4em] uppercase text-[10px] font-black">Special Notice</p>
        <div class="h-1 w-20 bg-blue-600 rounded-full"></div>
    </div>
</div>
</body>

</html>