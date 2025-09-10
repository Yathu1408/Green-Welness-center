<?php
session_start();
require 'db.php';

// ✅ Allow only admin or therapist
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','therapist'])) {
    header("Location: index.php");
    exit;
}

// Fetch only inquiries without response
$stmt = $pdo->query("SELECT i.*, u.name AS customer_name 
                     FROM inquiries i 
                     JOIN users u ON i.customer_id = u.id 
                     WHERE i.response IS NULL
                     ORDER BY i.created_at DESC");
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get distinct types for filter
$types = array_unique(array_column($inquiries, 'type'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Inquiries</title>
<style>
/* ======= Container ======= */
.container {
    max-width: 900px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

/* ======= Filter & Search ======= */
.controls {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.controls input, .controls select {
    padding: 8px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* ======= Inquiry Card ======= */
.inquiry-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f9f9f9;
}

.inquiry-card p {
    margin: 5px 0;
}

.inquiry-card textarea {
    width: 100%;
    padding: 6px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.inquiry-card button {
    padding: 6px 12px;
    background-color: #ff6f00ff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.inquiry-card button:hover {
    background-color: #218838;
}

.hidden {
    display: none;
}
</style>
</head>
<body>
<div class="container">
<h2>Customer Inquiries (Pending Responses)</h2>

<!-- ===== Search & Filter ===== -->
<div class="controls">
    <input type="text" id="searchInput" placeholder="Search by customer or subject...">
    <select id="typeFilter">
        <option value="">All Types</option>
        <?php foreach ($types as $typeOption): ?>
            <option value="<?= htmlspecialchars($typeOption) ?>"><?= htmlspecialchars($typeOption) ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- ===== Inquiries ===== -->
<div id="inquiriesContainer">
<?php foreach ($inquiries as $inq): ?>
  <div class="inquiry-card" data-customer="<?= htmlspecialchars(strtolower($inq['customer_name'])) ?>" data-subject="<?= htmlspecialchars(strtolower($inq['subject'])) ?>" data-type="<?= htmlspecialchars($inq['type']) ?>">
    <p><strong><?= htmlspecialchars($inq['customer_name']) ?></strong></p>
    <p><b>Type:</b> <?= htmlspecialchars($inq['type']) ?></p>
    <p><b>Subject:</b> <?= htmlspecialchars($inq['subject']) ?></p>
    <p><b>Message:</b> <?= nl2br(htmlspecialchars($inq['message'])) ?></p>

    <form method="post" action="respond_inquiry.php">
        <input type="hidden" name="id" value="<?= $inq['id'] ?>">
        <textarea name="response" rows="3" required></textarea><br>
        <button type="submit">Send Response</button>
    </form>
  </div>
<?php endforeach; ?>
</div>
</div>

<script>
// ====== Live Search & Filter ======
const searchInput = document.getElementById('searchInput');
const typeFilter = document.getElementById('typeFilter');
const inquiries = document.querySelectorAll('.inquiry-card');

function filterInquiries() {
    const searchText = searchInput.value.toLowerCase();
    const selectedType = typeFilter.value;

    inquiries.forEach(card => {
        const customer = card.dataset.customer;
        const subject = card.dataset.subject;
        const type = card.dataset.type;

        const matchesSearch = customer.includes(searchText) || subject.includes(searchText);
        const matchesType = !selectedType || type === selectedType;

        card.style.display = (matchesSearch && matchesType) ? 'block' : 'none';
    });
}

searchInput.addEventListener('input', filterInquiries);
typeFilter.addEventListener('change', filterInquiries);
</script>

</body>
</html>
