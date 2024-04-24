<?php

namespace Mvdnbrk\Gtin\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class BlueprintMacroTest extends TestCase
{
    /** @test */
    public function it_can_add_the_gtin_column()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->gtin();
        });

        $this->assertTrue(in_array(Schema::getColumnType('products', 'gtin'), ['string', 'varchar']));
    }

    /** @test */
    public function it_is_chainable()
    {
        $table = new Blueprint('products');

        $this->assertInstanceOf(Fluent::class, $table->gtin());
    }

    /** @test */
    public function it_can_add_the_gtin_column_with_a_custom_name()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->gtin('ean13');
        });

        $this->assertEquals([
            'ean13',
        ], Schema::getColumnListing('products'));
    }

    /** @test */
    public function it_can_drop_the_gtin_column()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->gtin();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropGtin();
        });

        $this->assertEquals([
            'id',
        ], Schema::getColumnListing('products'));
    }

    /** @test */
    public function it_can_drop_the_gtin_column_with_a_custom_name()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->gtin('ean13');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropGtin('ean13');
        });

        $this->assertEquals([
            'id',
        ], Schema::getColumnListing('products'));
    }
}
