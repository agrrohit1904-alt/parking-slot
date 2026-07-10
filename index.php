<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Parking Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="logo">ParkFlow</div>
        <p class="subtitle">Seamless Parking Experience</p>
    </header>

    <main>
        <section class="parking-container">
            <h2>Select a Slot</h2>
            <div id="parking-grid" class="parking-grid">
                <!-- Slots will be injected here by JS -->
            </div>
            
            <div class="legend">
                <div class="legend-item"><span class="box available"></span> Available</div>
                <div class="legend-item"><span class="box booked"></span> Booked</div>
                <div class="legend-item"><span class="box selected"></span> Selected</div>
            </div>
        </section>
    </main>

    <!-- Booking Modal -->
    <div id="booking-modal" class="modal-overlay">
        <div class="modal">
            <h3>Book Slot <span id="selected-slot-num"></span></h3>
            <form id="booking-form">
                <input type="hidden" id="slot-id">
                
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" required placeholder="John Doe">
                </div>
                
                <div class="input-group">
                    <label for="plate">License Plate</label>
                    <input type="text" id="plate" required placeholder="ABC-1234">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirm-btn">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
