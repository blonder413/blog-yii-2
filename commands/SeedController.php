<?php
namespace app\commands;

use Yii;
use yii\db\Expression;
use yii\helpers\Console;
use app\models\Seguridad;
use yii\console\ExitCode;
use yii\console\Controller;

/**
 * Cream registros de prueba
 */
class SeedController extends Controller
{
    public function actionIndex()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->actionUser();
            $this->actionCategoria();
            $this->actionCurso();
            $this->actionArticulo();
            $this->actionComentario();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return ExitCode::OK;
    }

    /**
     * Seeder para la tabla user
     */
    public function actionUser()
    {
        $faker = \Faker\Factory::create('es_ES');
        $this->stdout("insertando registros en la tabla user \n", Console::FG_YELLOW);

        Yii::$app->db->createCommand()->batchInsert(
            'user',
            [
                'name', 'username', 'auth_key', 'email', 'photo', 'status', 'verification_token',
                'password_hash', 'password_reset_token', 'created_at', 'updated_at'
            ],
            [
                [
                    'Jill Valentine',
                    'jvalentine',
                    $faker->word,
                    'jvalentine@bsaa.org',
                    // $faker->image('web/img/users', 400, 300, false, true),
                    'jvalentine.jpg',
                    10,
                    null,
                    Yii::$app->security->generatePasswordHash('Admin123456'),
                    null,
                    $faker->numberBetween(100000000, 999999999),
                    $faker->numberBetween(100000000, 999999999),
                ],
            ]
        )->execute();

        for ($i = 0; $i < 49; $i++) {
            Yii::$app->db->createCommand()->batchInsert(
                'user',
                [
                    'name', 'username', 'auth_key', 'email', 'photo', 'status', 'verification_token',
                    'password_hash', 'password_reset_token', 'created_at', 'updated_at'
                ],
                [
                    [
                        $faker->firstName,
                        $faker->userName,
                        $faker->word,
                        $faker->freeEmail,
                        //$faker->image('web/img/users', 400, 300, false, true),
                        'users/user-' . $i . '.jpg',
                        10,
                        null,
                        Yii::$app->security->generatePasswordHash('Admin123456'),
                        null,
                        $faker->numberBetween(100000000, 999999999),
                        $faker->numberBetween(100000000, 999999999),
                    ],
                ]
            )->execute();
        }

        $this->stdout("Registros insertados en la tabla user\n", Console::FG_GREEN);
    }

    /**
     * seeder para la tabla categoría
     */
    public function actionCategoria()
    {
        $faker = \Faker\Factory::create('es_ES');

        $this->stdout("insertando registros en la tabla categoría\n", Console::FG_YELLOW);
        for ($i = 0; $i < 50; $i++) {
            Yii::$app->db->createCommand()->batchInsert(
                'categoria',
                [
                    'categoria', 'slug', 'imagen', 'descripcion',
                    'usuario_crea', 'fecha_crea', 'usuario_modifica', 'fecha_modifica'
                ],
                [
                    [
                        $faker->unique()->word,
                        $faker->unique()->slug,
                        //$faker->image('web/img/categorias', 400, 300, false, true),
                        'categorias/categora-' . $i . '.png',
                        $faker->text(200),
                        $faker->numberBetween(1, 50),
                        new Expression('NOW()'),
                        $faker->numberBetween(1, 50),
                        new Expression('NOW()'),
                    ],
                ]
            )->execute();
        }

        $this->stdout("Registros insertados en la tabla categoría\n", Console::FG_GREEN);
    }

    /**
     * seeder para la tabla curso
     */
    public function actionCurso()
    {
        $faker = \Faker\Factory::create('es_ES');

        $this->stdout("insertando registros en la tabla curso\n", Console::FG_YELLOW);
        for ($i = 0; $i < 10; $i++) {
            Yii::$app->db->createCommand()->batchInsert(
                'curso',
                [
                    'curso', 'slug', 'descripcion', 'imagen',
                    'usuario_crea', 'fecha_crea', 'usuario_modifica', 'fecha_modifica'
                ],
                [
                    [
                        $faker->unique()->word,
                        $faker->unique()->slug,
                        $faker->text(200),
                        //$faker->image('web/img/cursos', 400, 300, false, true),
                        'cursos/curso-' . $i . '.png',
                        $faker->numberBetween(1, 50),
                        new Expression('NOW()'),
                        $faker->numberBetween(1, 50),
                        new Expression('NOW()')
                    ],
                ]
            )->execute();
        }

        $this->stdout("Registros insertados en la tabla curso\n", Console::FG_GREEN);
    }

    /**
     * seeder para la tabla entrada
     */
    public function actionArticulo()
    {
        $faker = \Faker\Factory::create('es_ES');

        $this->stdout("insertando registros en la tabla articulo\n", Console::FG_YELLOW);
        $video = '<div style="position: relative;"><iframe title="Instalación de openSUSE con UEFI" width="100%" height="100%" src="https://video.hardlimit.com/videos/embed/5c80f500-717c-40e2-acd3-b718686af480"></iframe></div>';
        for ($i = 0; $i < 500; $i++) {
            Yii::$app->db->createCommand()->batchInsert(
                'articulo',
                [
                    'numero', 'titulo', 'slug', 'tema', 'detalle', 'resumen',
                    'video', 'descarga', 'categoria_id', 'etiquetas', 'estado',
                    'vistas', 'descargas', 'curso_id',
                    'usuario_crea', 'fecha_crea', 'usuario_modifica', 'fecha_modifica'
                ],
                [
                    [
                        $faker->numberBetween(1, 10),
                        $faker->unique()->text(100),
                        $faker->unique()->slug,
                        $faker->text(100),
                        $faker->text(300),
                        $faker->text(200),
                        $video,
                        $faker->text(100),
                        $faker->numberBetween(1, 50),
                        $faker->text(20),
                        random_int(0, 1),
                        random_int(0, 10000),
                        random_int(0, 100),
                        $faker->numberBetween(1, 10),
                        $faker->numberBetween(1, 50),
                        new Expression('NOW()'),
                        $faker->numberBetween(1, 50),
                        new Expression('NOW()')
                    ],
                ]
            )->execute();
        }

        $this->stdout("Registros insertados en la tabla articulo\n", Console::FG_GREEN);
    }

    /**
     * seeder para la tabla comentario
     */
    public function actionComentario()
    {
        $faker = \Faker\Factory::create('es_ES');

        $this->stdout("insertando registros en la tabla comentario\n", Console::FG_YELLOW);
        for ($i = 0; $i < 100; $i++) {
            Yii::$app->db->createCommand()->batchInsert(
                'comentario',
                [
                    'nombre', 'correo', 'web', 'rel', 'comentario', 'fecha',
                    'articulo_id', 'estado', 'ip', 'puerto'
                ],
                [
                    [
                        $faker->firstName,
                        Seguridad::encriptar($faker->freeEmail),
                        $faker->word,
                        'no follow',
                        $faker->text(200),
                        new Expression('NOW()'),
                        $faker->numberBetween(1, 500),
                        $faker->numberBetween(0, 1),
                        $faker->word,
                        '413'
                    ],
                ]
            )->execute();
        }

        $this->stdout("Registros insertados en la tabla comentario\n", Console::FG_GREEN);
    }
}
