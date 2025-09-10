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