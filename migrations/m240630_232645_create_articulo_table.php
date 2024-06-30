<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articulo}}`.
 */
class m240630_232645_create_articulo_table extends Migration
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
        
        $this->createTable('{{%articulo}}', [
            'id'                => $this->primaryKey(),
            'numero'            => $this->smallInteger(),
            'titulo'            => $this->string(150)->unique()->notNull(),
            'slug'              => $this->string(150)->unique()->notNull(),
            'tema'              => $this->string(100),
            'detalle'           => $this->text()->notNull(),
            'resumen'           => $this->string(300)->notNull(),
            'video'             => $this->string(255),
            'descarga'          => $this->string(100),
            'categoria_id'      => $this->integer()->notNull(),
            'etiquetas'         => $this->string(255)->notNull(),
            'estado'            => $this->boolean()->notNull(),
            'vistas'            => $this->integer()->defaultValue(0)->notNull(),
            'descargas'         => $this->integer()->defaultValue(0)->notNull(),
            'curso_id'          => $this->integer(),
//            'version'           => $this->bigInteger()->defaultValue(0),  // OptimisticLock
            'usuario_crea'      => $this->integer()->notNull(),
            'fecha_crea'        => $this->dateTime()->notNull(),
            'usuario_modifica'  => $this->integer()->notNull(),
            'fecha_modifica'    => $this->dateTime()->notNull(),
        ], $tableOptions);
        
        $this->createIndex('idx-articulo-titulo', 'articulo', 'titulo');
        
        $this->addForeignKey(
            'categoriaarticulo', 'articulo', 'categoria_id', 'categoria', 'id', 'no action', 'no action'
        );
        
        $this->addForeignKey(
            'cursoarticulo', 'articulo', 'curso_id', 'curso', 'id', 'no action', 'no action'
        );
        
        $this->addForeignKey(
            'usuariocreaarticulo', 'articulo', 'usuario_crea', 'user', 'id', 'no action', 'no action'
        );
        
        $this->addForeignKey(
            'usuariomodificaearticulo', 'articulo', 'usuario_modifica', 'user', 'id', 'no action', 'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('categoriaarticulo', 'articulo');
        $this->dropForeignKey('cursoarticulo', 'articulo');
        $this->dropForeignKey('usuariocreaarticulo', 'articulo');
        $this->dropForeignKey('usuariomodificaarticulo', 'articulo');
        $this->dropTable('{{%articulo}}');
    }
}
