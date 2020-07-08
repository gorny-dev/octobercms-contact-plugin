<?php namespace Codeclutch\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodeclutchContactMessages extends Migration
{
    public function up()
    {
        Schema::table('codeclutch_contact_messages', function($table)
        {
            $table->boolean('is_read')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('codeclutch_contact_messages', function($table)
        {
            $table->dropColumn('is_read');
        });
    }
}
