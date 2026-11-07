<?php

namespace Tests\Unit;

use App\Models\ProductModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

final class ProductDimensionsTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->db = db_connect('tests');
        $this->db->query('CREATE TABLE db_collection (id INTEGER PRIMARY KEY, title TEXT, is_active INTEGER)');
        $this->db->query('CREATE TABLE db_product (id INTEGER PRIMARY KEY, collection_id INTEGER, title TEXT, slug TEXT, thumbnail TEXT, description TEXT, meta_title TEXT, meta_description TEXT, dimensions_text TEXT, dimensions_img TEXT, dimensions_img_2 TEXT, is_active INTEGER, sort_order INTEGER, created_at INTEGER, updated_at INTEGER)');
        $this->db->table('collection')->insert(['id' => 1, 'title' => 'Test collection', 'is_active' => 1]);
        $this->db->table('product')->insert(['id' => 1, 'collection_id' => 1, 'title' => 'Test product', 'slug' => 'test-product', 'dimensions_img' => 'first.webp', 'dimensions_img_2' => 'second.webp', 'is_active' => 1, 'sort_order' => 0]);
    }

    protected function tearDown(): void
    {
        $this->db->query('DROP TABLE db_product');
        $this->db->query('DROP TABLE db_collection');
        parent::tearDown();
    }

    private function save(array $extra = []): void
    {
        $data = array_merge(['collection_id' => '1', 'title' => 'Edited product', 'slug' => 'test-product', 'is_active' => '1', 'sort_order' => '0'], $extra);
        $this->withSession(['userID' => 1])->post('admin/product/edit/1/handle', $data)->assertRedirect();
    }

    public function testRemovingFirstImagePreservesSecond(): void
    {
        $this->save(['remove_dimensions_img' => '1']);
        $row = (new ProductModel())->find(1);
        $this->assertNull($row['dimensions_img']);
        $this->assertSame('second.webp', $row['dimensions_img_2']);
    }

    public function testRemovingSecondImagePreservesFirst(): void
    {
        $this->save(['remove_dimensions_img_2' => '1']);
        $row = (new ProductModel())->find(1);
        $this->assertSame('first.webp', $row['dimensions_img']);
        $this->assertNull($row['dimensions_img_2']);
    }

    public function testRemovingBothImages(): void
    {
        $this->save(['remove_dimensions_img' => '1', 'remove_dimensions_img_2' => '1']);
        $row = (new ProductModel())->find(1);
        $this->assertNull($row['dimensions_img']);
        $this->assertNull($row['dimensions_img_2']);
    }

    public function testUnmarkedImagesArePreservedOnEdit(): void
    {
        $this->save();
        $row = (new ProductModel())->find(1);
        $this->assertSame('first.webp', $row['dimensions_img']);
        $this->assertSame('second.webp', $row['dimensions_img_2']);
    }
}
