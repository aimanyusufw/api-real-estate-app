<?php

use App\Models\Property;
use App\Models\PropertyTypeSale;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_types', function (Blueprint $table) {
            $table->id('property_type_id');
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('property_locations', function (Blueprint $table) {
            $table->id('property_location_id');
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('sale_types', function (Blueprint $table) {
            $table->id('sale_type_id');
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('agents', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            $table->string('name');
            $table->string('phone');
            $table->string('profile_picture');
            $table->json('social_media_links');
            $table->dateTime('joined_date');
            $table->string('description');
            $table->integer('total_property');
            $table->integer('total_sold_property');
            $table->string('price_range_property');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('property_sale_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PropertyTypeSale::class);
            $table->foreignIdFor(Property::class);
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id('property_id');
            $table->string('title');
            $table->string('slug');
            $table->string('short_description');
            $table->double('price');
            $table->json('specification');
            $table->text('description');
            $table->string('thumbnail');
            $table->json('galleries');
            $table->foreignUuid('agent_id')->constrained('agents', 'id')->onDelete('cascade');
            $table->foreignId('property_location_id')->constrained('property_locations', 'property_location_id')->onDelete('cascade');
            $table->foreignId('property_type_id')->constrained('property_types', 'property_type_id')->onDelete('cascade');
            $table->string('description_title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
        Schema::dropIfExists('agents');
        Schema::dropIfExists('property_types');
        Schema::dropIfExists('property_sale_types');
        Schema::dropIfExists('property_locations');
    }
};
