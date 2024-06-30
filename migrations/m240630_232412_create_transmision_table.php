<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transmision}}`.
 */
class m240630_232412_create_transmision_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%transmision}}', [
            'id'                => $this->primaryKey(),
            'titulo'            => $this->string(100)->notNull(),
            'descripcion'       => $this->text()->notNull(),
            'video'             => $this->string(255),
            'inicio'            => $this->dateTime()->notNull(),
            'fin'               => $this->dateTime()->notNull(),
            'usuario_crea'      => $this->integer()->notNull(),
            'fecha_crea'        => $this->dateTime()->notNull(),
            'usuario_modifica'  => $this->integer()->notNull(),
            'fecha_modifica'    => $this->dateTime()->notNull(),
        ], $tableOptions);
        
        $this->addForeignKey(
            'usuariocreatransmision', 'transmision', 'usuario_crea', 'user', 'id', 'no action', 'no action'
        );
        
        $this->addForeignKey(
            'usuariomodificatransmision', 'transmision', 'usuario_modifica', 'user', 'id', 'no action', 'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('usuariocreatransmision', 'transmision');
        $this->dropForeignKey('usuariomodificatransmision', 'transmision');
        $this->dropTable('{{%transmision}}');
    }
}
