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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id', 20);
            $table->string('teacher_name', 120);
            $table->string('teacher_subject', 120);
            $table->string('teacher_email', 190);
            $table->string('slot_time', 10);
            $table->string('parent_name', 120);
            $table->string('student_name', 120);
            $table->string('parent_email', 190);
            $table->string('topic', 255)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->timestamps();
            
            $table->unique(['teacher_id', 'slot_time'], 'uq_teacher_slot');
            $table->index(['teacher_id', 'slot_time'], 'idx_teacher_time');
            $table->index('status', 'idx_status');
        });

        Schema::create('teacher_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('display_name', 120)->nullable();
            $table->enum('notifications', ['on', 'off'])->default('on');
            $table->string('language_code', 10)->default('sq');
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_user_id');
            $table->string('student_name', 120);
            $table->string('subject', 120);
            $table->string('grade_value', 10);
            $table->string('comment_text', 255)->nullable();
            $table->boolean('is_published')->default(0);
            $table->timestamps();
            
            $table->index('student_name', 'idx_student');
            $table->index('is_published', 'idx_published');
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->text('content');
            $table->enum('audience', ['all', 'parents', 'students', 'teachers'])->default('all');
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('created_at', 'idx_created_at');
        });

        Schema::create('safeguarding_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_name', 120)->nullable();
            $table->string('reporter_email', 190)->nullable();
            $table->boolean('is_anonymous')->default(1);
            $table->enum('category', ['bullying', 'violence', 'wellbeing', 'other']);
            $table->text('message_text');
            $table->enum('status', ['new', 'in_review', 'resolved'])->default('new');
            $table->unsignedBigInteger('assigned_to_user_id')->nullable();
            $table->timestamps();
            
            $table->index('status', 'idx_status');
            $table->index('created_at', 'idx_created_at');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email', 190);
            $table->string('token_hash', 255);
            $table->datetime('expires_at');
            $table->datetime('used_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('email', 'idx_email');
            $table->index('expires_at', 'idx_expires');
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_user_id')->nullable();
            $table->string('action_name', 120);
            $table->string('target_type', 80)->nullable();
            $table->string('target_id', 80)->nullable();
            $table->text('details_json')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('actor_user_id', 'idx_actor');
            $table->index('action_name', 'idx_action');
            $table->index('created_at', 'idx_created_at');
        });

        Schema::create('scheduled_posts', function (Blueprint $table) {
            $table->id();
            $table->text('source_prompt')->nullable();
            $table->string('title', 180);
            $table->text('content');
            $table->enum('audience', ['all', 'parents', 'students', 'teachers'])->default('all');
            $table->enum('status', ['scheduled', 'published', 'cancelled'])->default('scheduled');
            $table->datetime('publish_at');
            $table->datetime('published_at')->nullable();
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('publish_at', 'idx_publish_at');
            $table->index('status', 'idx_status');
        });

        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('category', 100)->default('general');
            $table->string('file_path', 255);
            $table->unsignedBigInteger('uploaded_by_user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('category', 'idx_category');
            $table->index('uploaded_by_user_id', 'idx_uploaded_by');
            $table->index('created_at', 'idx_created_at');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->string('category', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('teacher_settings');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('safeguarding_reports');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('scheduled_posts');
        Schema::dropIfExists('resources');
        Schema::dropIfExists('events');
    }
};
