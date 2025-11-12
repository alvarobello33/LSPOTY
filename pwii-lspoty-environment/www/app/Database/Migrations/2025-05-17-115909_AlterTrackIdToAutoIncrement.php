<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTracksTableAddApiIdAndAutoIncrement extends Migration
{
    public function up()
    {
        // 1. Quitar la primary key
        $this->forge->dropPrimaryKey('tracks');

        // 2. Establecer id como INT (estaba como VARCHAR)
        $this->forge->modifyColumn('tracks', [
            'id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        // 3. Establecer id como primary key
        $this->forge->addKey('id', true);
        $this->forge->processIndexes('tracks');

        // 4. Establecer id como AUTO_INCREMENT
        $this->forge->modifyColumn('tracks', [
            'id' => [
                'type'            => 'INT',
                'unsigned'        => true,
                'null'            => false,
                'auto_increment'  => true,
            ],
        ]);

        // 5. Crear columna api_id
        $this->forge->addColumn('tracks', [
            'api_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);
    }

    public function down()
    {
        // Revertir cambios
        $this->forge->dropColumn('tracks', 'api_id');
        $this->forge->dropPrimaryKey('tracks');

        $this->forge->modifyColumn('tracks', [
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->processIndexes('tracks');
    }
}
