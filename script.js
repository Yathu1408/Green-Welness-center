function showForm(formId) {
    document.querySelectorAll(".form_box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}

// Example async function for saving a message
async function saveMessage(subject, message) {
    const response = await fetch("http://localhost/greenlife/saveMessage.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ subject, message })
    });
    return response.json();
}

function showService(serviceClass) {
    // Hide all services by adding .service-hidden
    document.querySelectorAll('.Service1, .Service2, .Service3, .Service4')
        .forEach(s => s.classList.add('service-hidden'));

    // Show only the selected one
    const selectedService = document.querySelector(`.${serviceClass}`);
    if (selectedService) {
        selectedService.classList.remove('service-hidden');
        selectedService.scrollIntoView({ behavior: 'smooth' });
    }
}
function submitBooking(formId, service) {
    const form = document.getElementById(formId);
    const date = form.querySelector('select[name="booking_date"]').value;
    const time = form.querySelector('select[name="booking_time"]').value;

    if(!date || !time) {
        alert("Please select both date and time.");
        return;
    }

    const formData = new FormData();
    formData.append('service', service);
    formData.append('booking_date', date);
    formData.append('booking_time', time);

    fetch('save_booking.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status === 'success') {
            form.reset();
            form.parentElement.classList.add('hidden');
        }
    });
}
function showBookingSuccess() {
    document.getElementById('bookingSuccessModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('bookingSuccessModal').style.display = 'none';
}

