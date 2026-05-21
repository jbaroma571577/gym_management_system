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
            Schema::create('workout_plans', function (Blueprint $table) {

                $table->id();

                // MEMBER RELATION
                $table->foreignId('member_id')
                    ->constrained('members')
                    ->onDelete('cascade');

                // WORKOUT DETAILS
                $table->string('title');

                $table->string('program_type');

                $table->text('description')->nullable();

                $table->string('goal')->nullable();

                // DATES
                $table->date('start_date')->nullable();

                $table->date('end_date')->nullable();

                // TIMESTAMPS
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('workout_plans');
        }
    };