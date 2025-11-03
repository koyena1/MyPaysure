<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - PaySure</title>
    <style>
        /* CSS variables and base styles */
        :root {
            --primary: #1a3a8f;
            --secondary: #00a2e8;
            --accent: #ff6b00;
            --light: #f8f9fa;
            --dark: #212529;
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
            padding: 100px 0;
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
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
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
            border-left: 3px solid var(--secondary);
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }
        
        .event-item:hover {
            background-color: #f0f5ff;
            transform: translateX(5px);
        }
        
        .event-time {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
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
        
        .event-location {
            color: #777;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .event-location:before {
            content: '📍';
            margin-right: 5px;
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
            padding: 15px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .calendar-date:hover {
            background-color: #f0f5ff;
        }
        
        .calendar-date.has-event:after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background-color: var(--accent);
            border-radius: 50%;
        }
        
        .calendar-date.active {
            background-color: var(--primary);
            color: white;
        }
        
        .calendar-date.other-month {
            color: #ccc;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .schedule-tabs {
                flex-direction: column;
                align-items: center;
            }
            
            .tab-btn {
                width: 100%;
                text-align: center;
                border-bottom: 1px solid #eee;
            }
            
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr);
                font-size: 0.8rem;
            }
            
            .calendar-date, .calendar-day {
                padding: 10px 5px;
            }
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
                <button class="tab-btn active" data-tab="week">This Week</button>
                <button class="tab-btn" data-tab="month">This Month</button>
                <button class="tab-btn" data-tab="quarter">Next Quarter</button>
            </div>
            
            <div class="schedule-content active" id="week-tab">
                <div class="schedule-day">
                    <h3 class="day-title">Monday, November 20</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">10:00 AM - 12:00 PM</div>
                            <h4 class="event-title">Financial Planning Workshop</h4>
                            <p class="event-description">Learn the basics of financial planning and how to secure your future with our ACE plans.</p>
                            <div class="event-location">PaySure Head Office, Conference Room A</div>
                        </li>
                        <li class="event-item">
                            <div class="event-time">2:00 PM - 4:00 PM</div>
                            <h4 class="event-title">New Distributor Orientation</h4>
                            <p class="event-description">Introduction session for new distributors to understand the PaySure opportunity.</p>
                            <div class="event-location">Online - Zoom Meeting</div>
                        </li>
                    </ul>
                </div>
                
                <div class="schedule-day">
                    <h3 class="day-title">Wednesday, November 22</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">11:00 AM - 1:00 PM</div>
                            <h4 class="event-title">Advanced Sales Techniques</h4>
                            <p class="event-description">Master advanced sales strategies to boost your performance as a PaySure distributor.</p>
                            <div class="event-location">PaySure Training Center</div>
                        </li>
                    </ul>
                </div>
                
                <div class="schedule-day">
                    <h3 class="day-title">Friday, November 24</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">9:00 AM - 5:00 PM</div>
                            <h4 class="event-title">Regional Distributor Meet</h4>
                            <p class="event-description">Quarterly meeting for regional distributors to discuss performance and strategies.</p>
                            <div class="event-location">Grand Hotel Convention Center</div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="schedule-content" id="month-tab">
                <div class="schedule-day">
                    <h3 class="day-title">Monday, November 27</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">3:00 PM - 5:00 PM</div>
                            <h4 class="event-title">Digital Marketing for Distributors</h4>
                            <p class="event-description">Learn how to leverage digital platforms to expand your client base.</p>
                            <div class="event-location">Online - Webinar</div>
                        </li>
                    </ul>
                </div>
                
                <div class="schedule-day">
                    <h3 class="day-title">Thursday, November 30</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">10:00 AM - 12:00 PM</div>
                            <h4 class="event-title">Monthly Performance Review</h4>
                            <p class="event-description">Review of monthly performance and goal setting for the upcoming month.</p>
                            <div class="event-location">PaySure Head Office</div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="schedule-content" id="quarter-tab">
                <div class="schedule-day">
                    <h3 class="day-title">Monday, December 4</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">All Day</div>
                            <h4 class="event-title">Quarterly Leadership Conference</h4>
                            <p class="event-description">Exclusive conference for top-performing distributors and team leaders.</p>
                            <div class="event-location">Resort Paradise, Goa</div>
                        </li>
                    </ul>
                </div>
                
                <div class="schedule-day">
                    <h3 class="day-title">Friday, December 15</h3>
                    <ul class="event-list">
                        <li class="event-item">
                            <div class="event-time">10:00 AM - 4:00 PM</div>
                            <h4 class="event-title">Annual Business Planning Workshop</h4>
                            <p class="event-description">Strategic planning session for the upcoming year with goal setting and strategy development.</p>
                            <div class="event-location">PaySure Corporate Office</div>
                        </li>
                    </ul>
                </div>
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
                <div class="calendar-header">
                    <h3>November 2023</h3>
                    <p>Upcoming Events at PaySure</p>
                </div>
                <div class="calendar-grid">
                    <div class="calendar-day">Sun</div>
                    <div class="calendar-day">Mon</div>
                    <div class="calendar-day">Tue</div>
                    <div class="calendar-day">Wed</div>
                    <div class="calendar-day">Thu</div>
                    <div class="calendar-day">Fri</div>
                    <div class="calendar-day">Sat</div>
                    
                    <!-- Previous month dates -->
                    <div class="calendar-date other-month">29</div>
                    <div class="calendar-date other-month">30</div>
                    <div class="calendar-date other-month">31</div>
                    <div class="calendar-date">1</div>
                    <div class="calendar-date">2</div>
                    <div class="calendar-date">3</div>
                    <div class="calendar-date">4</div>
                    
                    <!-- Current month dates -->
                    <div class="calendar-date">5</div>
                    <div class="calendar-date">6</div>
                    <div class="calendar-date">7</div>
                    <div class="calendar-date">8</div>
                    <div class="calendar-date">9</div>
                    <div class="calendar-date">10</div>
                    <div class="calendar-date">11</div>
                    
                    <div class="calendar-date">12</div>
                    <div class="calendar-date">13</div>
                    <div class="calendar-date">14</div>
                    <div class="calendar-date">15</div>
                    <div class="calendar-date">16</div>
                    <div class="calendar-date">17</div>
                    <div class="calendar-date">18</div>
                    
                    <div class="calendar-date">19</div>
                    <div class="calendar-date has-event active">20</div>
                    <div class="calendar-date">21</div>
                    <div class="calendar-date has-event">22</div>
                    <div class="calendar-date">23</div>
                    <div class="calendar-date has-event">24</div>
                    <div class="calendar-date">25</div>
                    
                    <div class="calendar-date">26</div>
                    <div class="calendar-date has-event">27</div>
                    <div class="calendar-date">28</div>
                    <div class="calendar-date">29</div>
                    <div class="calendar-date has-event">30</div>
                    <!-- Next month dates -->
                    <div class="calendar-date other-month">1</div>
                    <div class="calendar-date other-month">2</div>
                </div>
            </div>
        </div>
    </section>

<?php
include 'includes/footer.php';
?>

    <script>
        // Schedule Tabs Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.schedule-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Show corresponding content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });
            
            // Calendar date click functionality
            const calendarDates = document.querySelectorAll('.calendar-date:not(.other-month)');
            calendarDates.forEach(date => {
                date.addEventListener('click', function() {
                    calendarDates.forEach(d => d.classList.remove('active'));
                    this.classList.add('active');
                    
                    // In a real application, you would show events for the selected date
                    alert('Showing events for ' + this.textContent + ' November 2023');
                });
            });
        });
    </script>
</body>
</html>