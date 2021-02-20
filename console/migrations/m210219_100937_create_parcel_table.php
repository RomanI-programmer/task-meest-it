<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel}}`.
 */
class m210219_100937_create_parcel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%parcel}}',
            [
                'id' => $this->primaryKey(),
                'created_at' => $this->dateTime()->defaultValue(null),
                'updated_at' => $this->dateTime()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
                'weight' => $this->decimal(12, 2),
                'size' => $this->string(50),
                'category_id' => $this->integer()->notNull(),
                'price' => $this->decimal(12, 2),
                'status' => 'ENUM("sent", "received")',
                'user_id' => $this->integer()->notNull(),
            ]
        );

        // Creates index for column `category_id`
        $this->createIndex(
            'idx-post-category_id',
            'parcel',
            'category_id',
        );

        // Add foreign key for table `category`
        $this->addForeignKey(
            'fk-parcel-category_id',
            'parcel',
            'category_id',
            'category',
            'id',
        );

        // Creates index for column `user_id`
        $this->createIndex(
            'idx-post-user_id',
            'parcel',
            'user_id',
        );

        // Add foreign key for table `user`
        $this->addForeignKey(
            'fk-parcel-user_id',
            'parcel',
            'user_id',
            'user',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key for table `category`
        $this->dropForeignKey(
            'fk-parcel-category_id',
            'parcel',
        );

        // Drop index for column `category_id`
        $this->dropIndex(
            'idx-post-category_id',
            'parcel',
        );

        // Drop foreign key for table `user`
        $this->dropForeignKey(
            'fk-parcel-user_id',
            'parcel',
        );

        // Drop index for column `user_id`
        $this->dropIndex(
            'idx-post-user_id',
            'parcel',
        );

        $this->dropTable('{{%parcel}}');
    }
}
