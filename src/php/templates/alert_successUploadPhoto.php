<?php if (isset($_SESSION['alert']) && isset($_SESSION['message'])) : ?>
    <div class="mt-1 alert alert-<?php echo htmlspecialchars($_SESSION['alert']); ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    // Clear the message after displaying it
    unset($_SESSION['alert']);
    unset($_SESSION['message']);
    ?>
<?php endif; ?>