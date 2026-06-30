<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGeojsonConfigTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'warna' => [
                'type' => 'VARCHAR',
                'constraint' => '7',
                'default' => '#2563eb',
            ],
            'fill_opacity' => [
                'type' => 'FLOAT',
                'default' => 0.5,
            ],
            'stroke_color' => [
                'type' => 'VARCHAR',
                'constraint' => '7',
                'default' => '#1e293b',
            ],
            'stroke_width' => [
                'type' => 'INT',
                'constraint' => 2,
                'default' => 2,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('geojson_config');
    }

    public function down()
    {
        $this->forge->dropTable('geojson_config');
    }
}
