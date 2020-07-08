<?php namespace Codeclutch\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodeclutchContactMessages2 extends Migration
{
    public function up()
    {
        Schema::table('codeclutch_contact_messages', function($table)
        {
            $table->string('receiver')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('codeclutch_contact_messages', function($table)
        {
            $table->dropColumn('receiver');
        });
    }
}
