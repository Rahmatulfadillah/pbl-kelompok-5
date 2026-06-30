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
            <h3 class="mb-1"><i class="fas fa-user-plus me-2"></i>Tambah Admin</h3>
            <p class="text-muted mb-0">Form ini hanya bisa diakses oleh superadmin.</p>
        </div>
        <a href="<?= base_url('/admin/users') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('/admin/users/simpan') ?>" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin_super" <?= old('role') == 'admin_super' ? 'selected' : '' ?>>Super Admin</option>
                            <option value="admin_sekolah" <?= old('role') == 'admin_sekolah' ? 'selected' : '' ?>>Admin Sekolah</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="schoolContainer">
                        <label class="form-label">Sekolah</label>
                        <select name="school_id" class="form-select">
                            <option value="">-- Pilih Sekolah --</option>
                            <?php foreach ($sekolah as $s): ?>
                                <option value="<?= $s['id'] ?>" <?= old('school_id') == $s['id'] ? 'selected' : '' ?>><?= esc($s['nama_sekolah']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const schoolContainer = document.getElementById('schoolContainer');

    function toggleSchoolField() {
        schoolContainer.style.display = roleSelect.value === 'admin_sekolah' ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleSchoolField);
    toggleSchoolField();
</script>
</body>
</html>
