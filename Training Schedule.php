<?php
// THIS MUST BE THE FIRST LINE
include_once 'includes/config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training & Schedule - PaySure</title>
    <style>
        /* CSS variables and base styles */
        :root {
            --primary: #1a3a8f;
            --secondary: #00a2e8;
            --accent: #ff6b00;
            --light: #f8f9fa;
            --dark: #212529;
            --zoom: #2D8CFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }
        
        .hero {
            background: linear-gradient(rgba(26, 58, 143, 0.8), rgba(0, 162, 232, 0.8)), url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
            animation: fadeInUp 1s ease 0.3s both;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #e55a00;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .section {
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--accent);
        }
        
        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .schedule-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            border-bottom: 1px solid #ddd;
            flex-wrap: wrap;
        }
        
        .tab-btn {
            background: none;
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .tab-btn.active {
            color: var(--primary);
        }
        
        .tab-btn.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary);
        }
        
        .tab-btn:hover {
            color: var(--primary);
        }
        
        .schedule-content {
            display: none;
        }
        
        .schedule-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        .schedule-day {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .day-title {
            color: var(--primary);
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .day-title:before {
            content: '';
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: var(--accent);
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .event-list {
            list-style: none;
        }
        
        .event-item {
            padding: 20px;
            border-left: 4px solid var(--accent);
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #eee;
            border-left-width: 4px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .event-item:hover {
            background-color: #f0f5ff;
            transform: translateX(5px);
        }
        
        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .event-time {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }
        
        .event-time:before {
            content: '⏰';
            margin-right: 8px;
        }
        
        .event-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .event-description {
            color: #666;
            margin-bottom: 10px;
        }
        
        .trainer-info {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            font-weight: 600;
            background: #f0f5ff;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .zoom-btn {
            display: inline-flex;
            align-items: center;
            background-color: var(--zoom);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
            font-size: 0.9rem;
        }

        .zoom-btn:hover {
            background-color: #1a6ad4;
        }

        .zoom-btn span {
            margin-left: 8px;
        }
        
        .calendar-section {
            background-color: #f0f5ff;
            padding: 80px 0;
        }
        
        .calendar {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .calendar-header {
            background-color: var(--primary);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .calendar-header h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #eee;
        }
        
        .calendar-day {
            background-color: white;
            padding: 15px 10px;
            text-align: center;
            font-weight: 600;
            color: var(--primary);
        }
        
        .calendar-date {
            background-color: white;
            padding: 10px 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        
        .calendar-date:hover {
            background-color: #f0f5ff;
        }
        
        .cal-event-text {
            font-size: 0.7rem;
            background-color: var(--accent);
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
            margin-top: 4px;
            width: 90%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .calendar-date.active .date-num {
            background-color: var(--primary);
            color: white;
            padding: 2px 6px;
            border-radius: 50%;
        }
        
        .calendar-date.other-month {
            color: #ccc;
            background-color: #f9f9f9;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .event-header { flex-direction: column; }
            .zoom-btn { width: 100%; justify-content: center; margin-top: 10px; }
            .calendar-grid { font-size: 0.8rem; }
            .calendar-date { min-height: 70px; padding: 10px 5px; }
            .cal-event-text { font-size: 0.6rem; }
        }
    </style>
</head>
<body>
<?php
include 'includes/header.php';
?>

    <section class="hero">
        <div class="container">
            <h1>Event Schedule</h1>
            <p>Stay updated with our upcoming events, training sessions, and important dates</p>
            <a href="#schedule" class="btn">View Schedule</a>
        </div>
    </section>

    <section class="section" id="schedule">
        <div class="container">
            <div class="section-title">
                <h2>Upcoming Events</h2>
                <p>Join our events to learn more about financial planning and opportunities with PaySure</p>
            </div>
            
            <div class="schedule-tabs">
                <button class="tab-btn active" data-tab="week">Upcoming</button>
            </div>
            
            <div class="schedule-content active" id="week-tab">
                <?php
                // FETCH UPCOMING EVENTS FROM DATABASE
                $sql = "SELECT * FROM training_events WHERE event_date >= CURDATE() AND status='Active' ORDER BY event_date ASC LIMIT 5";
                
                // Using the $conn that was created in config.php
                if(isset($conn)) {
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $eventDate = date('l, F d', strtotime($row['event_date']));
                            $startTime = date('h:i A', strtotime($row['start_time']));
                            $endTime = date('h:i A', strtotime($row['end_time']));
                    ?>
                    <div class="schedule-day">
                        <h3 class="day-title"><?php echo $eventDate; ?></h3>
                        <ul class="event-list">
                            <li class="event-item">
                                <div class="event-header">
                                    <div>
                                        <div class="event-time"><?php echo $startTime . ' - ' . $endTime; ?></div>
                                        <h4 class="event-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                                        <?php if(!empty($row['trainer_name'])): ?>
                                            <div class="trainer-info">👨‍🏫 Trainer: <?php echo htmlspecialchars($row['trainer_name']); ?></div>
                                        <?php endif; ?>
                                        <p class="event-description"><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                    <?php if(!empty($row['meeting_link'])): ?>
                                    <a href="<?php echo $row['meeting_link']; ?>" target="_blank" class="zoom-btn">
                                        <i class="fas fa-video"></i> <span>Join Meeting</span>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php 
                        } 
                    } else {
                        echo '<p style="text-align:center; color:#666;">No upcoming events scheduled at the moment.</p>';
                    }
                } else {
                    echo '<p style="text-align:center; color:red;">Database connection error. Please check config.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <section class="calendar-section">
        <div class="container">
            <div class="section-title">
                <h2>Event Calendar</h2>
                <p>Browse through our calendar to find events that match your schedule</p>
            </div>
            
            <div class="calendar">
                <?php
                    $currentYear = date('Y');
                    $currentMonth = date('m');
                    $currentMonthName = date('F');
                    $daysInMonth = date('t'); 
                    $firstDayOfWeek = date('w', strtotime("$currentYear-$currentMonth-01"));
                    
                    // FETCH EVENTS FOR CALENDAR
                    $eventsByDay = [];
                    if(isset($conn)) {
                        $calSql = "SELECT DAY(event_date) as day_num, title FROM training_events 
                                   WHERE MONTH(event_date) = '$currentMonth' 
                                   AND YEAR(event_date) = '$currentYear' 
                                   AND status = 'Active'";
                        $calResult = $conn->query($calSql);
                        if($calResult) {
                            while($cRow = $calResult->fetch_assoc()) {
                                $eventsByDay[$cRow['day_num']][] = $cRow['title'];
                            }
                        }
                    }
                ?>

                <div class="calendar-header">
                    <h3><?php echo "$currentMonthName $currentYear"; ?></h3>
                    <p>Training & Events Schedule</p>
                </div>

                <div class="calendar-grid">
                    <div class="calendar-day">Sun</div>
                    <div class="calendar-day">Mon</div>
                    <div class="calendar-day">Tue</div>
                    <div class="calendar-day">Wed</div>
                    <div class="calendar-day">Thu</div>
                    <div class="calendar-day">Fri</div>
                    <div class="calendar-day">Sat</div>
                    
                    <?php
                    // 1. Previous Month Filler
                    $prevMonthTotalDays = date('t', strtotime("-1 month"));
                    $startFiller = $prevMonthTotalDays - $firstDayOfWeek + 1;

                    for ($i = 0; $i < $firstDayOfWeek; $i++) {
                        echo '<div class="calendar-date other-month">' . ($startFiller + $i) . '</div>';
                    }

                    // 2. Current Month Dates Loop
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $classes = 'calendar-date';
                        
                        if ($day == date('d')) {
                            $classes .= ' active';
                        }
                        
                        echo '<div class="'.$classes.'" onclick="showEventAlert('.$day.')">';
                        echo '<span class="date-num">' . $day . '</span>';
                        
                        if (isset($eventsByDay[$day])) {
                            foreach($eventsByDay[$day] as $evtTitle) {
                                echo '<div class="cal-event-text" title="'.htmlspecialchars($evtTitle).'">' . htmlspecialchars($evtTitle) . '</div>';
                            }
                        }
                        
                        echo '</div>';
                    }

                    // 3. Next Month Filler
                    $totalSlotsFilled = $firstDayOfWeek + $daysInMonth;
                    $remainingSlots = 7 - ($totalSlotsFilled % 7);
                    
                    if ($remainingSlots < 7) {
                        for ($i = 1; $i <= $remainingSlots; $i++) {
                            echo '<div class="calendar-date other-month">' . $i . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

<?php
include 'includes/footer.php';
?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.schedule-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });
        });
        
        function showEventAlert(day) {
           // Alert removed as requested
        }
    </script>
</body>
</html>