<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comentario}}`.
 */
class m240630_232851_create_comentario_table extends Migration
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
        
        $this->createTable('{{%comentario}}', [
            'id'            => $this->primaryKey(),
            'nombre'        => $this->string(150)->notNull(),
            'correo'        => $this->string(100),
            'web'           => $this->string(100),
            'rel'           => $this->string(20),
            'comentario'    => $this->text()->notNull(),
            'fecha'         => $this->dateTime()->notNull(),
            'articulo_id'    => $this->integer()->notNull(),
            'estado'        => $this->boolean()->defaultValue(false)->notNull(),
            'ip'            => $this->string(15),
            'puerto'        => $this->string(5)
        ], $tableOptions);
        $this->addForeignKey(
            'articulocomentario', 'comentario', 'articulo_id', 'articulo', 'id', 'no action', 'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('articulocomentario', 'comentario');
        $this->dropTable('{{%comentario}}');
    }
}
