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
            <h3 class="mb-1"><i class="fas fa-users-cog me-2"></i>Manajemen Admin</h3>
            <p class="text-muted mb-0">Halaman ini hanya bisa diakses oleh superadmin.</p>
        </div>
        <div>
            <a href="<?= base_url('/admin/users/tambah') ?>" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Tambah Admin
            </a>
            <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)) : ?>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($user['nama_lengkap'] ?? '-') ?></td>
                                    <td><?= esc($user['username'] ?? '-') ?></td>
                                    <td><?= esc($user['email'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge bg-<?= ($user['role'] === 'admin_super') ? 'danger' : 'primary' ?>">
                                            <?= esc($user['role'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= (!empty($user['is_active'])) ? 'success' : 'secondary' ?>">
                                            <?= !empty($user['is_active']) ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($user['role'] !== 'admin_super') : ?>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <a href="<?= base_url('/admin/users/reset/' . $user['id']) ?>" class="btn btn-sm btn-warning" onclick="return confirm('Reset password akun ini menjadi password123?')">
                                                    <i class="fas fa-key me-1"></i>Reset Password
                                                </a>
                                                <a href="<?= base_url('/admin/users/hapus/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus akun admin ini?')">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data admin.</td>
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
