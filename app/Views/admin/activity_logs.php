<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-history me-2"></i>Log Aktivitas Super Admin</h3>
            <p class="text-muted mb-0">Semua aktivitas admin tercatat dan tidak bisa dihapus oleh siapa pun.</p>
        </div>
        <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admin</th>
                            <th>Aktivitas</th>
                            <th>Entitas</th>
                            <th>Deskripsi</th>
                            <th>Waktu</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)) : ?>
                            <?php foreach ($logs as $index => $log) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($log['admin_name'] ?? '-') ?></strong><br>
                                        <small class="text-muted">ID: <?= esc($log['user_id'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= esc($log['action'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td><?= esc($log['entity_type'] ?? '-') ?>#<?= esc($log['entity_id'] ?? '-') ?></td>
                                    <td><?= esc($log['description'] ?? '-') ?></td>
                                    <td><?= esc($log['created_at'] ?? '-') ?></td>
                                    <td><?= esc($log['ip_address'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada log aktivitas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
