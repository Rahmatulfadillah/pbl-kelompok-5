<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ==================== ROUTES ====================

// Halaman Umum (Tidak Perlu Login)
$routes->get('/', 'Home::index');
$routes->get('/peta', 'Sekolah::index');
$routes->get('/peta/fullmap', 'Sekolah::fullmap');
$routes->get('/about', 'About::index');
$routes->get('/kontak', 'Kontak::index');

// Auth Routes (Khusus Admin)
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/doLogin', 'Auth::doLogin');
$routes->get('/auth/logout', 'Auth::logout');

// ======================================================
// ADMIN ROUTES (Hanya Admin yang Bisa Akses)
// ======================================================
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    
    // ========== DASHBOARD ==========
    $routes->get('dashboard', 'Admin::dashboard');
    
    // ========== CRUD SEKOLAH ==========
    $routes->get('sekolah', 'Admin::sekolah');
    $routes->get('sekolah/tambah', 'Admin::tambah');
    $routes->post('sekolah/simpan', 'Admin::simpan');
    $routes->get('sekolah/edit/(:num)', 'Admin::edit/$1');
    $routes->post('sekolah/update/(:num)', 'Admin::update/$1');
    $routes->get('sekolah/hapus/(:num)', 'Admin::hapus/$1');
    
    // ========== MANAJEMEN USER (Super Admin) ==========
    $routes->get('users', 'Admin::users');
    $routes->get('users/tambah', 'Admin::tambahAdmin');
    $routes->post('users/simpan', 'Admin::simpanAdmin');
    $routes->get('users/reset/(:num)', 'Admin::resetPassword/$1');
    $routes->get('users/hapus/(:num)', 'Admin::hapusAdmin/$1');
    $routes->get('activity-logs', 'Admin::activityLogs');
    
    // ========== GEOJSON ==========
    $routes->get('geojson', 'Geojson::index');
    $routes->get('geojson/tambah', 'Geojson::tambah');
    $routes->post('geojson/simpan', 'Geojson::simpan');
    $routes->get('geojson/edit/(:num)', 'Geojson::edit/$1');
    $routes->post('geojson/update/(:num)', 'Geojson::update/$1');
    $routes->get('geojson/hapus/(:num)', 'Geojson::hapus/$1');
    
    // ========== PROFIL ==========
    $routes->get('profil', 'Admin::profil');
    $routes->get('edit_profil', 'Admin::editProfil');
    $routes->post('updateProfil', 'Admin::updateProfil');
    $routes->get('ganti_password', 'Admin::gantiPassword');
    $routes->post('updatePassword', 'Admin::updatePassword');
    $routes->post('uploadFoto', 'Admin::uploadFoto');
});