<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_book}}`.
 */
class m240709_143418_create_author_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author_book}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);

        // Create index for columns `author_id` and `book_id`
        $this->createIndex(
            'idx-author_book-author_id',
            '{{%author_book}}',
            'author_id'
        );

        $this->createIndex(
            'idx-author_book-book_id',
            '{{%author_book}}',
            'book_id'
        );

        // Add foreign key constraints
        $this->addForeignKey(
            'fk-author_book-author_id',
            '{{%author_book}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-author_book-book_id',
            '{{%author_book}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-author_book-book_id', '{{%author_book}}');
        $this->dropForeignKey('fk-author_book-author_id', '{{%author_book}}');

        $this->dropIndex('idx-author_book-book_id', '{{%author_book}}');
        $this->dropIndex('idx-author_book-author_id', '{{%author_book}}');

        $this->dropTable('{{%author_book}}');
    }
}
