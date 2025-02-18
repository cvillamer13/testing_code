<?php

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

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('secondary_unit')->nullable();
            $table->string('type_of_asset');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });



        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type_of_asset');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });

        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('category_id_d');
            $table->string('type_of_asset');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();

            // $table->foreignId('category_id_d')->constrained('categories')->onDelete('cascade')->name('fk_category_sub');
        });


        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('type_of_asset');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });


        Schema::create('asset_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status')->unique(); // Example: Available, In Use, Damaged, etc.
            $table->string('type_of_asset');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });


        Schema::create('asset', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('name');
            $table->text('asset_description')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('model_no');
            $table->string('unit_price')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('sub_category')->nullable();
            $table->string('image_path')->nullable();
            $table->string('reciept_path')->nullable();
            $table->string('date_of_purchase')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('assign_employee_id')->nullable();
            $table->unsignedBigInteger('asset_status_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('type_of_asset');
            $table->text('note')->nullable();
            $table->string('os_details')->nullable();
            $table->string('processor_model')->nullable();
            $table->string('desk_details')->nullable();
            $table->string('ram_details')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('accounting_code')->nullable();

            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();





            $table->foreign('unit_id')->constrained('units')->onDelete('cascade')->name('fk_unit_id');
            $table->foreign('category')->constrained('categories')->onDelete('cascade')->name('fk_category');
            $table->foreign('sub_category')->constrained('sub_categories')->onDelete('cascade')->name('fk_sub_category');
            $table->foreign('supplier_id')->constrained('suppliers')->onDelete('cascade')->name('fk_supplier_id');
            $table->foreign('assign_employee_id')->constrained('employees')->onDelete('cascade')->name('fk_assign_employee_id');
            $table->foreign('asset_status_id')->constrained('asset_statuses')->onDelete('cascade')->name('fk_asset_status_id');
            $table->foreign('company_id')->constrained('company')->onDelete('cascade')->name('fk_company_id');
            $table->foreign('department_id')->constrained('department')->onDelete('cascade')->name('fk_department_id');
            $table->foreign('location_id')->constrained('location')->onDelete('cascade')->name('fk_location_id');


            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('asset_statuses');
        Schema::dropIfExists('asset');
    }
};
