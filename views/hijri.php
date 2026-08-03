<?php $page_title = 'التقويم الهجري'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">التقويم الهجري</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            تتبع الأيام والشهور الهجرية ومعرفة المناسبات الإسلامية
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center">
                <div class="card border-0 shadow-md rounded-4 overflow-hidden" style="background: linear-gradient(135deg, var(--bs-primary) 0%, #ff6a00 100%); color: white;" data-aos="zoom-in">
                    <div class="card-body p-5">
                        <h4 class="mb-3 text-white-50">اليوم</h4>
                        <h2 class="display-4 fw-bold mb-3" id="todayHijriDate">--</h2>
                        <p class="fs-5 mb-0" id="todayGregorianDate">--</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button class="btn btn-outline-primary rounded-circle" id="prevMonth"><i data-lucide="chevron-right"></i></button>
                        <h3 class="fw-bold mb-0" id="currentMonthYear">--</h3>
                        <button class="btn btn-outline-primary rounded-circle" id="nextMonth"><i data-lucide="chevron-left"></i></button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle" style="table-layout: fixed;">
                            <thead class="bg-light-primary">
                                <tr>
                                    <th class="py-3">الأحد</th>
                                    <th class="py-3">الإثنين</th>
                                    <th class="py-3">الثلاثاء</th>
                                    <th class="py-3">الأربعاء</th>
                                    <th class="py-3">الخميس</th>
                                    <th class="py-3">الجمعة</th>
                                    <th class="py-3">السبت</th>
                                </tr>
                            </thead>
                            <tbody id="calendarBody">
                                <!-- Rendered via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <i data-lucide="calendar" class="text-primary me-2"></i> مناسبات الشهر
                    </h4>
                    <div id="eventsContainer" class="d-flex flex-column gap-3">
                        <div class="text-center text-muted py-5">
                            لا توجد مناسبات في هذا الشهر
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<style>
.cal-day {
    height: 80px;
    padding: 10px;
    vertical-align: top;
    text-align: right;
    transition: var(--transition);
}
.cal-day:hover {
    background-color: rgba(255,138,0,0.05);
}
.cal-day.today {
    background-color: rgba(255,138,0,0.1);
    border: 2px solid var(--bs-primary);
}
.hijri-num {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--text-primary);
}
.greg-num {
    font-size: 0.8rem;
    color: var(--text-secondary);
    display: block;
}
.event-dot {
    width: 6px; height: 6px;
    background-color: var(--bs-primary);
    border-radius: 50%;
    display: inline-block;
    margin-top: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let currentDate = new Date();
    
    // Function to load month
    function loadCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth() + 1;
        
        fetch(`https://api.aladhan.com/v1/gToHCalendar/\${month}/\${year}`)
            .then(r => r.json())
            .then(data => {
                renderCalendar(data.data, date);
            });
    }

    function renderCalendar(daysData, currentReqDate) {
        // Set Today Header (only if showing current month)
        const today = new Date();
        const todayData = daysData.find(d => parseInt(d.gregorian.day) === today.getDate() && parseInt(d.gregorian.month.number) === (today.getMonth() + 1));
        
        if (todayData && today.getFullYear() === currentReqDate.getFullYear() && today.getMonth() === currentReqDate.getMonth()) {
            document.getElementById('todayHijriDate').textContent = `\${todayData.hijri.day} \${todayData.hijri.month.ar} \${todayData.hijri.year}`;
            document.getElementById('todayGregorianDate').textContent = `\${todayData.gregorian.day} \${todayData.gregorian.month.en} \${todayData.gregorian.year}`;
        }

        // Title
        const firstDayHijri = daysData[0].hijri;
        document.getElementById('currentMonthYear').textContent = `\${firstDayHijri.month.ar} \${firstDayHijri.year} / \${daysData[0].gregorian.month.en} \${daysData[0].gregorian.year}`;

        const tbody = document.getElementById('calendarBody');
        tbody.innerHTML = '';
        
        // Find what day of the week the 1st of the Gregorian month is (0 = Sun, 1 = Mon...)
        const firstDay = new Date(currentReqDate.getFullYear(), currentReqDate.getMonth(), 1).getDay();
        
        let html = '<tr>';
        
        // Empty cells before start
        for (let i = 0; i < firstDay; i++) {
            html += '<td class="cal-day bg-light"></td>';
        }
        
        let events = [];
        
        daysData.forEach((day, index) => {
            const dateObj = new Date(day.gregorian.date); // DD-MM-YYYY format issue in JS, let's just use grid index
            const isToday = today.getDate() === parseInt(day.gregorian.day) && today.getMonth() === currentReqDate.getMonth() && today.getFullYear() === currentReqDate.getFullYear();
            
            // Check for holidays
            const holidays = day.hijri.holidays;
            if (holidays.length > 0) {
                events.push({
                    day: day.hijri.day,
                    month: day.hijri.month.ar,
                    title: holidays.join(', ')
                });
            }
            
            html += `
                <td class="cal-day \${isToday ? 'today' : ''}">
                    <div class="hijri-num">\${day.hijri.day}</div>
                    <div class="greg-num">\${day.gregorian.day}</div>
                    \${holidays.length > 0 ? '<div class="event-dot"></div>' : ''}
                </td>
            `;
            
            if ((firstDay + index + 1) % 7 === 0) {
                html += '</tr><tr>';
            }
        });
        
        // Fill remaining empty cells
        const remainingCells = (7 - ((firstDay + daysData.length) % 7)) % 7;
        for (let i = 0; i < remainingCells; i++) {
            html += '<td class="cal-day bg-light"></td>';
        }
        
        html += '</tr>';
        tbody.innerHTML = html;
        
        // Render events
        const eventsContainer = document.getElementById('eventsContainer');
        if (events.length > 0) {
            eventsContainer.innerHTML = events.map(e => `
                <div class="p-3 bg-light-primary rounded-3 border-start border-4 border-primary">
                    <h5 class="fw-bold mb-1">\${e.title}</h5>
                    <small class="text-muted">\${e.day} \${e.month}</small>
                </div>
            `).join('');
        } else {
            eventsContainer.innerHTML = '<div class="text-center text-muted py-5">لا توجد مناسبات مسجلة في هذا الشهر</div>';
        }
    }

    loadCalendar(currentDate);

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        loadCalendar(currentDate);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        loadCalendar(currentDate);
    });
});
</script>
