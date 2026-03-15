<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_card_photo_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('militant_id')->constrained('militants')->cascadeOnDelete();
            $table->foreignId('member_card_campaign_id')->constrained('member_card_campaigns')->cascadeOnDelete();
            $table->string('photo_path');
            $table->enum('status', ['pending', 'approved', 'revision_requested'])->default('pending');
            $table->text('admin_comment')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['militant_id', 'member_card_campaign_id'], 'member_card_submission_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_card_photo_submissions');
    }
};