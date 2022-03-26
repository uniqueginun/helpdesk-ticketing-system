<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedInteger('ticket_type');
            $table->string('other_type_text')->nullable();
            $table->text('details');
            $table->string('employee_name');
            $table->foreignId('department_id')->references('id')->on('departments');
            $table->enum('priority', ['normal', 'urgent', 'super-argent'])->default('normal');
            $table->enum('status', ['new', 'assigned', 'closed', 'saved'])->default('new');
            $table->foreignId('technician_id')->references('id')->on('users')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
