<?php
// Ensure events exist
$events = isset($instance['events']) && is_array($instance['events']) ? $instance['events'] : [];
$timeline_title = isset($instance['title']) && !empty($instance['title']) ? esc_html($instance['title']) : 'Spatial AI Challenge 2024 Timeline';

if (empty($events)) {
    echo "<p style='color: red;'>Warning: No events found!</p>";
    return;
}
?>

<!-- Timeline Title (User Configurable) -->
<h1 id="timeline-title" style="text-align:center;"><?php echo $timeline_title; ?></h1>

<!-- Timeline Container -->
<div class="timeline" id="timeline"></div>

<!-- Timeline Styles -->
<style>
    /* Timeline container */
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 40px auto;
        padding: 20px 0;
    }

    /* Vertical timeline line */
    .timeline::after {
        content: '';
        position: absolute;
        width: 4px;
        background-color: #ddd;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -2px;
    }

    /* Timeline event items */
    .timeline-item {
        padding: 10px 30px;
        position: relative;
        background: #f9f9f9;
        border-radius: 6px;
        width: 45%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin: 20px 0;
    }

    /* Left items */
    .timeline-item.left {
        left: 0;
    }

    /* Right items */
    .timeline-item.right {
        left: 55%;
    }

    /* Circles for events */
    .timeline-item::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #fff;
        border: 4px solid #FF9F55;
        top: 15px;
        z-index: 1;
    }

    .timeline-item.left::before {
        right: -10px;
    }

    .timeline-item.right::before {
        left: -10px;
    }

    /* Status classes */
    .completed::before {
        border-color: green;
    }

    .upcoming::before {
        border-color: red;
    }

    .today::before {
        border-color: blue;
    }

    /* Event date styling */
    .date {
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>

<!-- Timeline JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("Debug: JavaScript Loaded");

    function normalizeDate(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    function getPacificTimeNow() {
        const now = new Date();
        return new Date(now.toLocaleString("en-US", { timeZone: "America/Los_Angeles" }));
    }

    // ✅ Convert PHP events array to JavaScript
    const events = <?php echo json_encode($events, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    console.log("Debug: Events Received", events);

    if (!events || events.length === 0) {
        console.warn("No timeline events found.");
        return;
    }

    // ✅ Get today's date in PT
    const pacificTimeNow = getPacificTimeNow();
    const normalizedToday = normalizeDate(pacificTimeNow);

    // ✅ Add "Today" event if missing
    const todayExists = events.some(event => event.title === "Today");

    if (!todayExists) {
        const todayStr = pacificTimeNow.toISOString().split('T')[0]; // YYYY-MM-DD
        events.push({ date: todayStr, title: 'Today', description: 'Current day' });
    }

    // ✅ Sort events by date
    events.sort((a, b) => new Date(a.date) - new Date(b.date));

    // ✅ Find the timeline container
    const timelineContainer = document.getElementById("timeline");

    if (!timelineContainer) {
        console.error("Timeline container not found.");
        return;
    }

    timelineContainer.innerHTML = ""; // Clear previous content

    // ✅ Render timeline items
    events.forEach((event, index) => {
        const eventDateStr = event.date; // Keep the exact input date
        const eventDate = new Date(eventDateStr);
        let statusClass = "";

        if (event.title === "Today") {
            statusClass = "today";
        } else {
            const normalizedEventDate = normalizeDate(eventDate);
            if (normalizedToday.getTime() === normalizedEventDate.getTime()) {
                statusClass = "today";
            } else if (normalizedToday.getTime() > normalizedEventDate.getTime()) {
                statusClass = "completed";
            } else {
                statusClass = "upcoming";
            }
        }

        const side = index % 2 === 0 ? "left" : "right";

        const eventDiv = document.createElement("div");
        eventDiv.classList.add("timeline-item", side, statusClass);
        eventDiv.innerHTML = `
            <div class="date" style="font-size:13px;">${eventDateStr}</div>
            <h4>${event.title}</h4>
            <p style="font-size:13px;">${event.description}</p>
        `;
        timelineContainer.appendChild(eventDiv);
    });
});


</script>
