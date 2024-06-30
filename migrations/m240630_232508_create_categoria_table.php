<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categoria}}`.
 */
class m240630_232508_create_categoria_table extends Migration
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
        
        $this->createTable('{{%categoria}}', [
            'id'                => $this->primaryKey(),
            'categoria'         => $this->string(100)->unique()->notNull(),
            'slug'              => $this->string(100)->unique()->notNull(),
            'imagen'            => $this->string(50),
            'descripcion'       => $this->string(255),
            'usuario_crea'      => $this->integer()->notNull(),
            'fecha_crea'        => $this->dateTime()->notNull(),
            'usuario_modifica'  => $this->integer()->notNull(),
            'fecha_modifica'    => $this->dateTime()->notNull(),
        ], $tableOptions);
        
        $this->addForeignKey(
            'usuariocreacategoria', 'categoria', 'usuario_crea', 'user', 'id', 'no action', 'no action'
        );
        
        $this->addForeignKey(
            'usuariomodificacategoria', 'categoria', 'usuario_modifica', 'user', 'id', 'no action', 'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('usuariocreacategoria', 'categoria');
        $this->dropForeignKey('usuariomodificacategoria', 'categoria');
        $this->dropTable('{{%categoria}}');
    }
}
