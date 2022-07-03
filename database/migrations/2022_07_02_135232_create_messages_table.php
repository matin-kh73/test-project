<?php

use App\Models\Message;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->nullable();
            $table->string('sender')->nullable();
            $table->string('receptor');
            $table->string('message');
            $table->tinyInteger('status')->default(Message::STATUS['in_queue']);
            $table->smallInteger('cost')->default(0);
            $table->dateTime('publish_time')->default(now());
            $table->timestamps();

            $table->index('status', 'messages_status_ik');
            $table->index('receptor', 'messages_receptor_ik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
