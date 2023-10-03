<?php

use App\Models\Location;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->boolean('active')->default(true);

            $table->timestamps();
        });

        $locations = [
            'Home',
            'Web Design',
            'eCommerce Design',
            'Web Applications',
            'Shopify',
            'Laravel',
            'Custom ERP Solutions',
        ];

        foreach ($locations as $location) {
            Location::create([
                'name' => $location,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
