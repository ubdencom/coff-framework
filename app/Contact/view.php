<?php
// Coff PHP Framework
// Created by Ubden Community
// GitHub: https://github.com/ubden/coff-framework
// Contributors: https://github.com/ck-cankurt
// License: GNU GENERAL PUBLIC LICENSE
// Framework Website: https://coff.dev
// Sponsored Website: https://ubden.com
// Version: ubden/coff-framework/version.txt
// Release Date: 2024

// Include the header file
require __DIR__ . '/../includes/header.php'; 

// Handler nesnesi yaratılır ve handle metodu çağrılır
require_once __DIR__ . '/Handler.php'; // Handler dosyanızın yolu doğru olmalı
$handler = new \App\Contact\Handler();
$handler->handle();

// Mesajlar ve mesaj tipleri Handler sınıfından alınır
$message = $handler->getMessage();
$messageType = $handler->getMessageType();
?>

<div class="container mt-5">
    <h1><?php echo $head; ?></h1>
    <p>If you have any questions, feel free to contact us by filling out the form below.</p>
    
    <?php if (!empty($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($messageType); ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <form action="/?path=Contact" method="post" class="mt-4">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group mt-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mt-3">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="form-group mt-3">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Send Message</button>
    </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

