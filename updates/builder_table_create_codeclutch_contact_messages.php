<?php namespace Codeclutch\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodeclutchContactMessages extends Migration
{
    public function up()
    {
        Schema::create('codeclutch_contact_messages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('custom_fields')->nullable();
            $table->text('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codeclutch_contact_messages');
    }
}
