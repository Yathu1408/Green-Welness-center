function showForm(formId) {
    document.querySelectorAll("form_box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}

//Message
const response = await fetch("http://localhost/greenlife/saveMessage.php", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({ subject, message })
});


