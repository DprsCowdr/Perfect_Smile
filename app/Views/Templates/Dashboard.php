<?= view('templates/header') ?>

<div class="dashboard-container">
    <h2>Dashboard</h2>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    
    <div class="user-info">
        <h3>Welcome, <?= $user['username'] ?>!</h3>
        <p><strong>Email:</strong> <?= $user['email'] ?></p>
        <p><strong>Login Status:</strong> Successfully logged in</p>
    </div>
    
    <div class="dashboard-actions">
        <a href="/logout" class="btn btn-danger">Logout</a>
    </div>
</div>

<?= view('templates/footer') ?>
