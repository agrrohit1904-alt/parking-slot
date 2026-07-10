document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('#bookings-table tbody');
    
    const loadAdminData = async () => {
        try {
            const res = await fetch('api/admin-bookings.php');
            const data = await res.json();
            
            if (data.error) {
                alert(data.error);
                return;
            }
            
            renderTable(data);
            updateStats(data);
        } catch (e) {
            console.error(e);
        }
    };

    const updateStats = (slots) => {
        const total = slots.length;
        const booked = slots.filter(s => s.status === 'booked').length;
        const avail = total - booked;
        
        document.getElementById('stat-total').textContent = total;
        document.getElementById('stat-booked').textContent = booked;
        document.getElementById('stat-avail').textContent = avail;
    };

    const renderTable = (slots) => {
        tbody.innerHTML = '';
        slots.forEach(slot => {
            const tr = document.createElement('tr');
            
            let actionBtn = '';
            if (slot.status === 'booked') {
                actionBtn = `<button class="btn btn-secondary btn-small" onclick="freeSlot(${slot.id})">Free Slot</button>`;
            } else {
                actionBtn = `<span style="color: var(--text-muted)">-</span>`;
            }

            const timeStr = slot.booking_time ? new Date(slot.booking_time).toLocaleString() : '-';

            tr.innerHTML = `
                <td><strong>${slot.slot_number}</strong></td>
                <td><span class="badge ${slot.status}">${slot.status.toUpperCase()}</span></td>
                <td>${slot.booked_by || '-'}</td>
                <td>${slot.license_plate || '-'}</td>
                <td>${timeStr}</td>
                <td>${actionBtn}</td>
            `;
            tbody.appendChild(tr);
        });
    };

    window.freeSlot = async (slotId) => {
        if (!confirm('Are you sure you want to free this slot?')) return;
        
        try {
            const res = await fetch('api/admin-free-slot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ slot_id: slotId })
            });
            const result = await res.json();
            
            if (result.success) {
                loadAdminData();
            } else {
                alert(result.message || 'Failed to free slot');
            }
        } catch (e) {
            console.error(e);
            alert('Error connecting to server.');
        }
    };

    loadAdminData();
});
