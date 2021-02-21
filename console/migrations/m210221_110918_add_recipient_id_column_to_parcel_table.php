<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%parcel}}`.
 */
class m210221_110918_add_recipient_id_column_to_parcel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('parcel','recipient_id', $this->integer()->notNull());

        // Creates index for column recipient_id`
        $this->createIndex(
        'idx-post-recipient_id',
        'parcel',
    'recipient_id',
        );

        // Add foreign key for table `user`
        $this->addForeignKey(
        'fk-parcel-recipient_id',
        'parcel',
        'recipient_id',
        'user',
        'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key for table `user`
        $this->dropForeignKey(
        'fk-parcel-recipient_id',
        'parcel',
        );

        // Drop index for column `user_id`
        $this->dropIndex(
        'idx-post-recipient_id',
        'parcel',
        );
    }
}
