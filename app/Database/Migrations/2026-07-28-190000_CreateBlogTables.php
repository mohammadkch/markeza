<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'excerpt' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'banner' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'meta_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'meta_description' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'default' => 1,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'default' => 0,
            ],
            'updated_at' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'default' => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('user_id');
        $this->forge->addKey(['is_active', 'sort_order', 'created_at']);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('blog_post');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'post_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'block_type' => [
                'type' => 'ENUM',
                'constraint' => ['text', 'heading', 'image', 'quote'],
            ],
            'content' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'caption' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'heading_level' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'default' => 2,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'default' => 0,
            ],
            'updated_at' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'default' => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['post_id', 'sort_order']);
        $this->forge->addForeignKey('post_id', 'blog_post', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('blog_post_block');
    }

    public function down()
    {
        $this->forge->dropTable('blog_post_block', true);
        $this->forge->dropTable('blog_post', true);
    }
}
