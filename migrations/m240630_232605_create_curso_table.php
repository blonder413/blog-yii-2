<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%curso}}`.
 */
class m240630_232605_create_curso_table extends Migration
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
        
        $this->createTable('{{%curso}}', [
            'id'                => $this->primaryKey(),
            'curso'             => $this->string(100)->unique()->notNull(),
            'slug'              => $this->string(100)->unique()->notNull(),
            'descripcion'       => $this->text()->notNull(),
            'imagen'            => $this->string(50)->notNull(),
            'usuario_crea'      => $this->integer()->notNull(),
            'fecha_crea'        => $this->dateTime()->notNull(),
            'usuario_modifica'  => $this->integer()->notNull(),
            'fecha_modifica'    => $this->dateTime()->notNull(),
        ], $tableOptions);
        
        $this->addForeignKey(
            'usuariocreacurso', 'curso', 'usuario_crea', 'user', 'id', 'no action', 'no action'
        );
        
        $this->addForeignKey(
            'usuariomodificacurso', 'curso', 'usuario_modifica', 'user', 'id', 'no action', 'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('usuariocreacurso', 'curso');
        $this->dropForeignKey('usuariomodificacurso', 'curso');
        $this->dropTable('{{%curso}}');
    }
}
