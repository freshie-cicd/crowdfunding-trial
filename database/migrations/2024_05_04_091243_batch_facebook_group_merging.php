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
        Schema::table('project_batches', function (Blueprint $table) {
            $table->string('fb_group_url')->nullable()->after('cover');
        });

        $groups = DB::table('facebook_groups')->get();

        foreach($groups as $group){
            $check = DB::table('project_batches')->where('id', $group->batch_id)->update(['fb_group_url' => $group->url]);
        }

        if($check){
            Schema::dropIfExists('facebook_groups');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('facebook_groups', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');
            $table->string('url');
            $table->string('note')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        $groups = DB::table('project_batches')->get();

        foreach($groups as $group){
           $check = DB::table('facebook_groups')->insert([
                'batch_id' => $group->id,
                'url' => $group->fb_group_url,
            ]);
        }

        if($check){
            Schema::table('project_batches', function (Blueprint $table) {
                $table->dropColumn('fb_group_url');
            });
        }

    }
};
