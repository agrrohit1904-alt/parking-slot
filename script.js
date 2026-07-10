document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('parking-grid');
    const modalOverlay = document.getElementById('booking-modal');
    const cancelBtn = document.getElementById('cancel-btn');
    const bookingForm = document.getElementById('booking-form');
    const slotIdInput = document.getElementById('slot-id');
    const selectedSlotNumSpan = document.getElementById('selected-slot-num');
    
    let selectedSlot = null;

    // Fetch slots from API
    const loadSlots = async () => {
        try {
            const response = await fetch('api/slots.php');
            const data = await response.json();
            
            if (data.error) {
                grid.innerHTML = `<p style="color:red; grid-column: 1/-1">${data.error}</p>`;
                return;
            }

            renderSlots(data);
        } catch (error) {
            console.error('Error fetching slots:', error);
            grid.innerHTML = '<p style="color:red; grid-column: 1/-1">Failed to load parking slots.</p>';
        }
    };

    // Render slots in the grid
    const renderSlots = (slots) => {
        grid.innerHTML = '';
        slots.forEach(slot => {
            const el = document.createElement('div');
            el.className = `slot ${slot.status}`;
            el.dataset.id = slot.id;
            el.dataset.num = slot.slot_number;
            
            // Allow booking if available
            if (slot.status === 'available') {
                el.addEventListener('click', () => selectSlot(el, slot));
            }

            el.innerHTML = `
                <span>${slot.slot_number}</span>
            `;
            grid.appendChild(el);
        });
    };

    // Handle slot selection
    const selectSlot = (el, slot) => {
        // Deselect previous
        if (selectedSlot) {
            selectedSlot.classList.remove('selected');
        }
        
        // Select new
        selectedSlot = el;
        selectedSlot.classList.add('selected');
        
        // Open Modal
        slotIdInput.value = slot.id;
        selectedSlotNumSpan.textContent = slot.slot_number;
        modalOverlay.classList.add('active');
        document.getElementById('name').focus();
    };

    // Close Modal
    const closeModal = () => {
        modalOverlay.classList.remove('active');
        bookingForm.reset();
        if (selectedSlot) {
            selectedSlot.classList.remove('selected');
            selectedSlot = null;
        }
    };

    cancelBtn.addEventListener('click', closeModal);

    // Handle form submission
    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const submitBtn = document.getElementById('confirm-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Booking...';

        const payload = {
            slot_id: slotIdInput.value,
            name: document.getElementById('name').value,
            plate: document.getElementById('plate').value
        };

        try {
            const response = await fetch('api/book.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                closeModal();
                loadSlots(); // Reload grid
            } else {
                alert(result.message || 'Booking failed.');
            }
        } catch (error) {
            console.error('Error booking slot:', error);
            alert('An error occurred during booking.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Confirm Booking';
        }
    });

    // Initial load
    loadSlots();
});
